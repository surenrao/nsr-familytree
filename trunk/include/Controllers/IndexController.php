<?php
class IndexController extends CustomControllerAction
{
	public function indexAction()
	{	
		$auth = Zend_Auth::getInstance();
//		$this->view->isLoggedIs = false;
//		if($auth->hasIdentity())		
//		{
//			$this->view->name = $auth->getIdentity()->username;	
//			$this->view->isLoggedIs = true;		
//		}
//		else
//			$this->view->name ="guest";
		
		$this->view->title = 'Family Tree';		
	}	
	
	public function displayAction()
	{
		$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
		$result = $this->db->fetchAll('select test from test');
		$this->view->name = $result[0]->test;		
	}
	
	public function noTemplateAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo 'Index article with noTemplate<br/>';
	}
}
?>
