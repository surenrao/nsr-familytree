<?php
require_once('Model/UserDao.php');
require_once('Model/User.php');
class AccountController extends CustomControllerAction 
{
	//
	var $error = array();
	
	public function init()
	{
		parent::init();
		$this->view->title = "My Account";	
	}
	
	//restricted access
	public function indexAction()
	{		
		$auth = Zend_Auth::getInstance();//get session on namespace Zend_Auth			
		$userDao = new UserDao();
		$user = new User();
		$user = $userDao->getUserInfo($auth->getIdentity()->username);
		$userInfo = $userDao->getUserProfile($auth->getIdentity()->user_id);		
		$this->view->user = $user;
		$this->view->userInfo = $userInfo;
	}	
	
	//guest can access
	public function loginAction()
	{		
		$this->view->title = "Login Page";
		
		$auth = Zend_Auth::getInstance();
		
		if ($auth->hasIdentity())
			$this->_redirect('/account');
			
		$request = $this->getRequest();
		
		$redirect = $request->getParam('redirect');
		if (strlen($redirect) == 0)
			$redirect = $request->getServer('REQUEST_URI');
		if (strlen($redirect) == 0)//if its still not set
			$redirect = '/account';
			
		if ($request->isPost()) //$this->_request->isPost()
		{			
            $formData = $this->_getAllParams();        
        	$this->validateLoginForm($formData);
        	
			if(count($this->error)==0)
			{
				$adapter = new Zend_Auth_Adapter_DbTable($this->db);
				$adapter->setTableName('users')
						->setIdentityColumn('username')
						->setCredentialColumn('password')
						->setCredentialTreatment('MD5(?)');
						
				$adapter->setIdentity($formData['username']);
				$adapter->setCredential($formData['password']);
							
				// try and authenticate the user
				$result = $auth->authenticate($adapter);
				
				if ($result->isValid()) 
				{						
					$userData = $adapter->getResultRowObject(array('user_id',
					'username','user_type','ts_created','ts_last_login'));
					$userDao = new UserDao();
					$userDao->updateLastLogin($userData->user_id);						
							
					$auth->getStorage()->write($userData);//save in session on namespace Zend_Auth
					$this->_redirect($redirect);
				}
				$this->error['User'] = 'Your login details were invalid<br>\n'. $result->getMessages() ;
			}        	
            //echo $this->_request->getMethod();			           
		}		
		$this->view->redirect = $redirect;
		$this->view->error = $this->error;
	}
	
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();		
		$this->_redirect('/index');
	}
	
	//guest can access
	public function fetchpasswordAction(){}
	//guest can access
	public function registerAction()
	{		
		$this->view->title = "Register Page";
		$request = $this->getRequest();		
		//$captcha_phrase = $_SESSION['captcha']['captcha_phrase'];
		$session = new Zend_Session_Namespace('captcha');
		if ($request->isPost())
		{
			//$this->_helper->viewRenderer->setNoRender();
			echo "<pre>";
			var_dump($this->_getAllParams());
			var_dump($session);
			echo "</pre>";
			$formData = $this->_getAllParams();
			$this->validateRegisterForm($formData);
			if(count($this->error)==0) //if(!$this->error)
			{
				$user = new User();
				$user->username = $formData['username'];
				$user->password = $formData['password'];
				$user->userType = 'memeber';
				
				$userPrfil = new UserProfile();
				$userPrfil->firstName = $formData['firstname'];
				$userPrfil->lastName = $formData['lastname'];
				$userPrfil->email = $formData['email'];
				$userPrfil->dateOfBirth = new Zend_Date(
				array('year'=>$formData['dobYear'],'month'=>$formData['dobMonth'],'day'=>$formData['dobDay']));
				$userDao = new UserDao();
				$userDao->addUser($user,$userPrfil);			
				unset($session->captcha_phrase);
				$this->_redirect('/account/registercomplete');
			}
			
			$this->view->dob = $formData['dobYear']. '-'. $formData['dobMonth'] . '-'.$formData['dobDay'];			
		}	
	}
	//guest can access
	public function registercompleteAction(){}
	
	public function activateAction(){}

	private function validateRegisterForm(&$formData)
	{		
		$validatorUser = new Zend_Validate();
		
        $validatorUser->addValidator(new Zend_Validate_StringLength(3))
        ->addValidator(new Zend_Validate_Alnum());
        if(!$validatorUser->isValid($formData['username']))
        {
            // username is invalid; print the reasons
            $i=0;            
		    foreach ($validatorUser->getMessages() as $messageId => $message) {
		        $this->error['username'][$i++] ="$message\n";
		    }	
        }
        else
        {
            // Create a filter chain and add filters to the chain
			$filterChain = new Zend_Filter();
			$filterChain->addFilter(new Zend_Filter_Alnum())
		            ->addFilter(new Zend_Filter_StringToLower());
		
			// Filter the username
			$formData['username'] = $filterChain->filter($formData['username']);
        }           
            
		$validatorPaswd = new Zend_Validate();
		$validatorPaswd->addValidator(new Zend_Validate_StringLength(6));
			
        if(!$validatorPaswd->isValid($formData['password']))
        {
        	$i=0;
	    	// password is invalid; print the reasons
			foreach ($validatorPaswd->getMessages() as $messageId => $message) 
			{	if($messageId==0)
					$this->error['password'][$i++] ="Password should be atleast 6 characters long\n";
				else
					$this->error['password'][$i++] ="$messageId $message\n";
			}			
        } 
        
        if($formData['password']!=$formData['confirmpassword'])
        {
        	$this->error['confirmpassword'][0] = "Password mismatch";
        }
        
        $validatorFName = new Zend_Validate();
        $validatorFName->addValidator(new Zend_Validate_NotEmpty())
        ->addValidator(new Zend_Validate_Alpha(true));
        if(!$validatorFName->isValid($formData['firstname']))
        {
            // username is invalid; print the reasons
            $i=0;            
		    foreach ($validatorFName->getMessages() as $messageId => $message) {
		        $this->error['firstname'][$i++] ="$message\n";
		    }	
        }
        else
        {
            // Create a filter chain and add filters to the chain
			$filterChain = new Zend_Filter();
			$filterChain->addFilter(new Zend_Filter_Alnum())
		            ->addFilter(new Zend_Filter_StringToLower());
		
			// Filter the username
			$formData['firstname'] = $filterChain->filter($formData['firstname']);
        }           
        
        $validatorLName = new Zend_Validate();
        $validatorLName->addValidator(new Zend_Validate_NotEmpty())
        ->addValidator(new Zend_Validate_Alpha(true));
        if(!$validatorLName->isValid($formData['lastname']))
        {
            // username is invalid; print the reasons
            $i=0;            
		    foreach ($validatorLName->getMessages() as $messageId => $message) {
		        $this->error['lastname'][$i++] ="$message\n";
		    }	
        }
        else
        {
            // Create a filter chain and add filters to the chain
			$filterChain = new Zend_Filter();
			$filterChain->addFilter(new Zend_Filter_Alnum())
		            ->addFilter(new Zend_Filter_StringToLower());
		
			// Filter the username
			$formData['lastname'] = $filterChain->filter($formData['lastname']);
        }           
        
        $validatorEmail = new Zend_Validate();
        $validatorEmail->addValidator(new Zend_Validate_NotEmpty())
        ->addValidator(new Zend_Validate_EmailAddress());
        if(!$validatorEmail->isValid($formData['email']))
        {
            // username is invalid; print the reasons
            $i=0;            
		    foreach ($validatorEmail->getMessages() as $messageId => $message) {
		        $this->error['email'][$i++] ="$message\n";
		    }	
        }
        else
        {
            // Create a filter chain and add filters to the chain
			$filterChain = new Zend_Filter();
			$filterChain->addFilter(new Zend_Filter_Alnum())
		            ->addFilter(new Zend_Filter_StringToLower());
		
			// Filter the username
			$formData['email'] = $filterChain->filter($formData['email']);
        }   

        $age = $this->getAge($formData['dobYear'],$formData['dobMonth'],$formData['dobDay']);
				
        if( $age <= 13)
        {
        	$this->error['dob'][0] = "Age should be greater than or equal to 13, its $age" ;
        }       
        $session = new Zend_Session_Namespace('captcha'); 
		if($formData['captcha']!=$session->captcha_phrase)//$_SESSION['captcha']['captcha_phrase']
		{
			$this->error['captcha'][0] ="Not Valid phrase\n";
		}
		
        $this->view->error = $this->error;
		$this->view->formData = $formData;        
	}


	private function validateLoginForm(&$formData)
	{		
		$validatorUser = new Zend_Validate();
		
        $validatorUser->addValidator(new Zend_Validate_StringLength(3))
        ->addValidator(new Zend_Validate_Alnum());
        if(!$validatorUser->isValid($formData['username']))
        {
            // username is invalid; print the reasons
            $i=0;            
		    foreach ($validatorUser->getMessages() as $messageId => $message) {
		        $this->error['User'][$i++] ="'$messageId': $message\n";
		    }	
//		    if($i>0)
//		    	$this->view->error = $error['User'];
        }
        else
        {
            // Create a filter chain and add filters to the chain
			$filterChain = new Zend_Filter();
			$filterChain->addFilter(new Zend_Filter_Alnum())
		            ->addFilter(new Zend_Filter_StringToLower());
		
			// Filter the username
			$formData['username'] = $filterChain->filter($formData['username']);
        }           
            
		$validatorPaswd = new Zend_Validate();
		$validatorPaswd->addValidator(new Zend_Validate_StringLength(6))
			->addValidator(new Zend_Validate_Alnum());
        if(!$validatorPaswd->isValid($formData['password']))
        {
        	$i=0;
	    	// password is invalid; print the reasons
			foreach ($validatorPaswd->getMessages() as $messageId => $message) {
				$this->error['Paswd'][$i++] ="'$messageId': $message\n";
			}			
        } 
        $this->view->error = $this->error;
        $this->view->formData = $formData;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param array array('year' => 2006, 'month' => 4, 'day' => 18);
	 */
	private function getAge($year1,$month1,$day1)
	{		
		$year_diff  = (int)date("Y") - (int)$year1;		
	    $month_diff = (int)date("m") - (int)$month1;	       
	    $day_diff   = (int)date("d") - (int)$day1;	    
	    
	    if ($month_diff < 0) 
	    	$year_diff--;
	    elseif (($month_diff==0) && ($day_diff < 0)) 
	    	$year_diff--;
	    	
	    return $year_diff;
		
	}
}
?>