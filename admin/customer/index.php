<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'listcustomer.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Customer';
		break;

	case 'add' :
		$content 	= 'addcustomer.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Add Customer';
		break;

	case 'modify' :
		$content 	= 'modifycustomer.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Customer';
		break;
		
	case 'modifylocation' :
	   $content   ='modifylocation.php';
	   $pageTitle = 'Shop Admin Control Panel - Modify Location';	
		break;
   case 'addsubcatagory' :
        $content ='addlocation.php';
		$pageTitle = 'hiiiiii its implemented';
		break;
	default :
	if(isset($flag)){
		$content 	= 'list1.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Location';
		}
		else
		
		{
		
		$content 	= 'listcustomer.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Customer';
		}
}


$script    = array('category.js');

require_once '../include/template.php';
?>
