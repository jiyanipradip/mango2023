<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'listcontract.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Product';
		break;

	case 'add' :
		$content 	= 'addcontract.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Add Product';
		break;

	case 'modify' :
		$content 	= 'modifyproduct.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Product';
		break;
	case 'searchmodify' :
		$content 	= 'modifyproduct_search.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Product';
		break;
	case 'detail' :
		$content    = 'detailproduct.php';
		$pageTitle  = 'Shop Admin Control Panel - View Product Detail';
		break;
	case 'searchpage' :
		$content    = 'listproductmastersearch.php';
		$pageTitle  = 'Shop Admin Control Panel - View Product Detail';
		break;
		
	default :
		$content 	= 'listcontract.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Contract';
}




$script    = array('product.js');

require_once '../include/template.php';
?>
