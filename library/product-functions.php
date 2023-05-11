<?php
require_once 'config.php';

/*********************************************************
*                 PRODUCT FUNCTIONS 
**********************************************************/


/*
	Get detail information of a product
*/
function getProductDetail($pdId, $catId)
{
	
	$_SESSION['shoppingReturnUrl'] = $_SERVER['REQUEST_URI'];
	
	// get the product information from database
	$sql = "SELECT *
			FROM productmast
			WHERE PordId = '$pdId'";
	$result = dbQuery($sql);

	$row    = dbFetchAssoc($result);
$am = mysql_num_rows($result);
//echo $am;
if($am == 1)
{

	extract($row);
	
	$row['ProdDesc'] = nl2br($row['ProdDesc']);
	
	if ($row['image']) {
		$row['image'] = SAVANI_FARM . 'images/product/' . $row['image'];
	} else {
		$row['image'] = SAVANI_FARM . 'images/no-image-large.png';
	}
	
	$row['cart_url'] = "cart.php?action=add&p=$pdId";
	$row['cart_list'] = "cart.php?action=list&p=$pdId";

	return $row;			
   
}
else
{
echo "This is not valid product Number";die;
}
}
?>