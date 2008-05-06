<?php
require_once 'Model/UserDao.php';
class AdminController extends CustomControllerAction 
{
	public function indexAction()
	{
		$this->view->title ='Admin';		
	}
	
	public function jsgridAction()
	{
		$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
		// create a JSON service 
		$json = new Zend_JSON();
		// to the url parameter are added 4 parameter 
		// we shuld get these parameter to construct the needed query 
		//
		// get the requested page 
		$page = @$_GET['page']|1; 
		// get how many rows we want to have into the grid 
		// rowNum parameter in the grid 
		$limit = @$_GET['rows']|10; 
		// get index row - i.e. user click to sort 
		// at first time sortname parameter - after that the index from colModel 
		$sidx = @$_GET['sidx']; 
		// sorting order - at first time sortorder 
		$sord = @$_GET['sord']; 
		// if we not pass at first time index use the first column for the index 
		if(!$sidx) 
			$sidx =1; 
		
		$from_where_clause ="FROM users";
						
		$result = $this->db->fetchCol("SELECT COUNT(*) AS count $from_where_clause");
		
		$count = $result[0]; 
		// calculation of total pages for the query 
		if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
		// if for some reasons the requested page is greater than the total 
		// set the requested page to total page 
		if ($page > $total_pages) $page=$total_pages; 
		// calculate the starting position of the rows 
		$start = $limit*$page - $limit; // do not put $limit*($page - 1) 
		// if for some reasons start position is negative set it to 0 
		// typical case is that the user type 0 for the requested page 
		if($start <0) $start = 0; 
		// the actual query for the grid data 

		$SQL = "SELECT * $from_where_clause ORDER BY $sidx $sord LIMIT $start , $limit";
		
		$result = $this->db->fetchAll( $SQL ) ; 
		
		// constructing a JSON 
		$responce->page = $page; 
		$responce->total = $total_pages; 
		$responce->records = $count; 
		$i=0; 

		while($i<$count)
		{		
			$responce->rows[$i]['id']=$result[$i]->user_id; 
			$responce->rows[$i]['cell']=array($result[$i]->firstname,$result[$i]->lastname, $result[$i]->username,
				$result[$i]->password,$result[$i]->user_type,$result[$i]->ts_created,$result[$i]->ts_last_login,
				$result[$i]->active,$result[$i]->activation_code);
			$i++; 			
		} 	
		$this->_helper->viewRenderer->setNoRender();
		// return the formated data 
		echo $json->encode($responce);		
	}
}
?>