<?php
class AdminController extends CustomControllerAction 
{
	public function indexAction()
	{
		// create array of structured data
	    $data = array(
	      array('city' => 'London',  'sales' => '47283', 'mktshare' => '14'),
	      array('city' => 'Paris',   'sales' => '74042', 'mktshare' => '24'),
	      array('city' => 'Madrid',  'sales' => '67483', 'mktshare' => '6'),
	      array('city' => 'Hamburg', 'sales' => '65130', 'mktshare' => '57'),
	    );
	    // create new datagrid
	    $dg = new Structures_DataGrid();
	    
	    // bind datagrid using array driver   
	    $dg->bind($data, array(), 'Array');
	    
	    // render datagrid as HTML table
	    $this->view->datagrid = $dg->getOutput();//render();
	}
	
	
}
?>