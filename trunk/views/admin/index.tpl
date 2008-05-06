{include file='header.tpl'}
<div id="content"><!-- Start Editing --> 
{literal}

<link rel="stylesheet" type="text/css" media="screen" href="/themes/jqGrid/sand/grid.css" />
<script src="/js/jquery-1.2.3.js" type="text/javascript"></script>
<script	src="/js/jqGrid/jquery.jqGrid.js" type="text/javascript"></script>	
<script	type="text/javascript">
// We use a document ready jquery function. 
jQuery(document).ready(function(){ 
	jQuery("#list2").jqGrid({ 
	// the url parameter tells from where to get the data from server 
	// adding ?nd='+new Date().getTime() prevent IE caching 
	url:'/admin/jsgrid?nd='+new Date().getTime(), 
	// datatype parameter defines the format of data returned from the server 
	// in this case we use a JSON data 
	datatype: "json", 
	// colNames parameter is a array in which we describe the names 
	// in the columns. This is the text that apper in the head of the grid. 
	colNames:['FirstName','LastName','Username', 'Password', 'UserType','CreatedTime','LastLoginTime','Active','ActivationCode'], 
	// colModel array describes the model of the column. 
	// name is the name of the column, 
	// index is the name passed to the server to sort data 
	// note that we can pass here nubers too. 
	// width is the width of the column 
	// align is the align of the column (default is left) 
	// sortable defines if this column can be sorted (default true) 
	colModel:[ 
		{name:'firstname',index:'firstname', width:100}, 
		{name:'lastname',index:'lastname', width:100},
		{name:'username',index:'username', width:70,sortable:false}, 
		{name:'password',index:'password', width:225,sortable:false},
		{name:'user_type',index:'user_type', width:80},
		{name:'ts_created',index:'ts_created', width:125},
		{name:'ts_last_login',index:'ts_last_login', width:125},
		{name:'active',index:'active', width:45},
		{name:'activation_code',index:'activation_code', width:50,sortable:false}				
		], 
		// pager parameter define that we want to use a pager bar 
		// in this case this must be a valid html element. 
		// note that the pager can have a position where you want 
		pager: jQuery('#pager2'), 
		// rowNum parameter describes how many records we want to 
		// view in the grid. We use this in example.php to return 
		// the needed data. 
		rowNum:10, 
		// rowList parameter construct a select box element in the pager 
		//in wich we can change the number of the visible rows 
		rowList:[10,20,30], 
		imgpath: '/themes/jqGrid/sand/images',
		// sortname sets the initial sorting column. Can be a name or number. 
		// this parameter is added to the url 
		sortname: 'username', 
		//viewrecords defines the view the total records from the query in the pager 
		//bar. The related tag is: records in xml or json definitions. 
		viewrecords: true, 
		//sets the sorting order. Default is asc. This parameter is added to the url 		 
		caption: "Users", 
		}); 
	}); 
</script>{/literal}	
<h1>Admin</h1>
<ul id="admin_list">
	<li><a href="/admin/">Create User</a></li>
	<li><a href="/admin/">List Users</a></li>
	<li><a href="/admin/">Update UserType</a></li>
</ul>
<!-- the grid definition in html is a table tag with class 'scroll' --> 
<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table> 
<!-- pager definition. class scroll tels that we want to use the same theme as grid --> 
<div id="pager2" class="scroll" style="text-align:center;"></div>

http://trirand.com/jqgrid/jqgrid.html#
<br />
<br />
<br />

<!-- Stop Editing  --></div>
{include file='menu.tpl'} {include file='footer.tpl'}
