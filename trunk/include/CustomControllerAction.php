<?php
class CustomControllerAction extends Zend_Controller_Action
{
	public $db;
	
	public function init()
	{
		//set db from registry
		$this->db = Zend_Registry::get('db');
//		$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
		//set isLoggedIn
		$auth = Zend_Auth::getInstance();
		$this->view->isLoggedIs = false;
		if($auth->hasIdentity())		
		{
			$this->view->name = $auth->getIdentity()->username;	
			$this->view->isLoggedIn = true;		
		}
		else
			$this->view->name ="guest";
	}
}
?>