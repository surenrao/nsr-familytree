<?php
class UtilityController extends CustomControllerAction
{
	public function captchaAction()
	{
		// check for existing phrase in session
		$session = new Zend_Session_Namespace('captcha');
		$phrase = null;
//		commented to change phrase 
//		if (isset($session->phrase) && strlen($session->phrase) > 0)
//			$phrase = $session->phrase;
		
		$captcha = Text_CAPTCHA::factory('Image');
		$opts = array('font_size' => 20,
			'font_path' => Zend_Registry::get('config')->paths->data,
			'font_file' => 'VeraBd.ttf',
			'text_color'       => '#DDFF99',
    		'lines_color'      => '#CCEEDD',
    		'background_color' => '#555555');
		
		$captcha->init(120, 60, $phrase, $opts);
		// write the phrase to session
		$session->captcha_phrase = $captcha->getPhrase();
//		$_SESSION['captcha']['captcha_phrase'] = $captcha->getPhrase();
		// disable auto-rendering since we're outputting an image
		$this->_helper->viewRenderer->setNoRender();
		header('Content-type: image/png');
		echo $captcha->getCAPTCHAAsPng();
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
		if(!$sidx) $sidx =1; 
				
		$result = $this->db->fetchCol("SELECT COUNT(*) AS count FROM users_profile");
		
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
		$SQL = "SELECT * from users_profile ORDER BY $sidx $sord LIMIT $start , $limit"; 
		
		$result = $this->db->fetchAll( $SQL ) ; 
		// constructing a JSON 
		$responce->page = $page; 
		$responce->total = $total_pages; 
		$responce->records = $count; 
		$i=0; 

		while($i<$count)
		{ 
			$responce->rows[$i]['id']=$result[$i]->id; 
			$responce->rows[$i]['cell']=array($result[$i]->id,$result[$i]->user_id,$result[$i]->profile_key,$result[$i]->profile_value);
			$i++; 			
		} 	
		$this->_helper->viewRenderer->setNoRender();
		// return the formated data 
		echo $json->encode($responce);
	}
}
?>