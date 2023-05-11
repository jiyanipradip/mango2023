<?php
require_once '../../library/config.php';
require_once '../library/functions.php';
error_reporting(0);
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
switch ($view) {
	case 'list' :
		$content 	= 'listcategory.php';		
		$pageTitle 	= 'SavaniFarms Admin Control Panel - View Category';
		break;

	case 'add' :
		$content 	= 'addcategory.php';		
		$pageTitle 	= 'SavaniFarms Admin Control Panel - Add Category';
		break;

	case 'modify' :
		$content 	= 'modifycategory.php';		
		$pageTitle 	= 'SavaniFarms Admin Control Panel - Modify Category';
		break;
	case 'modifysubCategory' :
	   $content   ='modifysubcategory.php';
	   $pageTitle = 'SavaniFarms Admin Control Panel - Modify Sub Category';	
		break;
   case 'addsubcatagory' :
        $content ='addsubcatagory.php';
		$pageTitle = 'Add Sub Category';
		break;
	default :
	if($flag==1){
		$content 	= 'list1.php';		
		$pageTitle 	= 'SavaniFarms Admin Control Panel - View SubCategory';
		}
		else
		{
		$content 	= 'listcategory.php';		
		$pageTitle 	= 'SavaniFarms Admin Control Panel - View Category';
		}
}
$script    = array('category.js');
require_once '../include/template.php';
?>