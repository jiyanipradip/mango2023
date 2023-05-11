<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Orders';
		break;

	case 'detail' :
		$content 	= 'detail.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Order Detail';
		break;
		
		case 'edit' :
		$content 	= 'edit.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Edit Detail';
		break;

	case 'modify' :
		//modifyStatus();
		$content 	= 'modify/modify.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Invoice';
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Orders';
}




$script    = array('invoice.js');

require_once '../include/template.php';
?>
