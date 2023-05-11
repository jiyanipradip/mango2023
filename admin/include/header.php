<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php echo SAVANI_FARM;?>admin/library/common.js"></script>
<?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="' . SAVANI_FARM. 'admin/library/' . $script[$i]. '"></script>';
	}
}
?>
</head>

<body>
<br>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="1">
 <tr align="center"> 
  <td width="20%" class="nav"><a href="<?php echo SAVANI_FARM;?>admin/index.php" class="nav">HOME</a></td>
  <td width="20%" class="nav"><a href="<?php echo SAVANI_FARM;?>admin/category/index.php" class="nav">CATEGORY</a></td>
  <td width="20%" class="nav"><a href="<?php echo SAVANI_FARM;?>admin/product/index.php" class="nav">PRODUCT</a></td>
  <td width="20%" class="nav"><a href="<?php echo SAVANI_FARM;?>admin/orders/index.php" class="nav">ORDERS</a></td>
  <td width="20%" class="nav"><a href="<?php echo SAVANI_FARM;?>admin/shop/index.php" class="nav">SHOP CONFIG</a></td>  
 </tr>
</table>
<p>&nbsp;</p>