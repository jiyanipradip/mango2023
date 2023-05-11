<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'listproduct.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Product';
		break;

	case 'add' :
		$content 	= 'addproduct.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Add Product';
		break;

	case 'modify' :
		$content 	= 'modifyproduct.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Product';
		break;

	case 'detail' :
		$content    = 'detailproduct.php';
		$pageTitle  = 'Shop Admin Control Panel - View Product Detail';
		break;
		
	default :
		$content 	= 'listproduct.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Product';
}




$script    = array('product.js');

require_once '../include/template.php';
?>
