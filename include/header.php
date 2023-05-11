<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// set the default page title
$pageTitle = 'My Online Shop';

// if a product id is set add the product name
// to the page title but if the product id is not
// present check if a category id exist in the query string
// and add the category name to the page title
if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
	$pdId = (int)$_GET['p'];
	$sql = "SELECT ProdName
			FROM productmast
			WHERE PordId = $pdId";
	
	$result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['ProdName'];
	
} else if (isset($_GET['c']) && (int)$_GET['c'] > 0) {
	$catId = (int)$_GET['c'];
	$sql = "SELECT CatagoryName
	        FROM catgmaster
			WHERE CatagoryId = $catId";

    $result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['CatagoryName'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="include/shop.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="library/common.js"></script>
</head>
<body>