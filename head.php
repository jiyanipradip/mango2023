<?php 
ob_start();
require_once 'library/config.php';
require_once 'library/category-functions.php';
require_once 'library/product-functions.php';
require_once 'library/cart-functions.php';
//session_destroy();
$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];
$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
$scatId  = (isset($_GET['cc']) && $_GET['cc'] != '1') ? $_GET['cc'] : 0;
$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
$cart   = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : 0;
$step   = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : 0;
$cartlist1   = (isset($_GET['cartlist']) && $_GET['cartlist'] != '') ? $_GET['cartlist'] : 0;
$location   = (isset($_GET['location']) && $_GET['location'] != '') ? $_GET['location'] : 0;
$shoppinglist = (isset($_GET['shoppinglist']) && $_GET['shoppinglist'] != '') ? $_GET['shoppinglist'] : 0;
$contract = (isset($_GET['contract']) && $_GET['contract'] != '') ? $_GET['contract'] : 0;
$modifycustomer = (isset($_GET['modifycustomer']) && $_GET['modifycustomer'] != '') ? $_GET['modifycustomer'] : 0;
$viewaccounts = (isset($_GET['viewaccounts']) && $_GET['viewaccounts'] != '') ? $_GET['viewaccounts'] : 0;
$viewreports = (isset($_GET['viewreports']) && $_GET['viewreports'] != '') ? $_GET['viewreports'] : 0;
$quickorder = (isset($_GET['quickorder']) && $_GET['quickorder'] != '') ? $_GET['quickorder'] : 0;
$fl = (isset($_GET['flag']) && $_GET['flag'] != '') ? $_GET['flag'] : 0;
$aboutus = (isset($_GET['aboutus']) && $_GET['aboutus'] != '') ? $_GET['aboutus'] : 0;
$terms = (isset($_GET['terms']) && $_GET['terms'] != '') ? $_GET['terms'] : 0;
$ship = (isset($_GET['ship']) && $_GET['ship'] != '') ? $_GET['ship'] : 0;
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 0;
$success = (isset($_GET['success']) && $_GET['success'] != '') ? $_GET['success'] : 0;
$pricingtype = (isset($_GET['pricingtype']) && $_GET['pricingtype'] != '') ? $_GET['pricingtype'] : 0;

if(isset($errorMessage))
{
	$errorMessage = $errorMessage;
}
else
{
	$errorMessage = "";
}
/*<div style="text-align:center; font-size:18px; padding:10px; color:red;">Dear Mango Lovers<br>
Due to COVID-19 we are uncertain about Indian Mango Import for 2020. We ask you to register your email and your order. We do not charge
your credit card until we ship the product. Will keep you posted on mango import for this season.</div> */
//require_once 'include/header.php';
?>