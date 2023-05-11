<?php
if (!defined('SAVANI_FARM')) {
	exit;
}


if (isset($_GET['catId']) && $_GET['catId']) {
	$catId = $_GET['catId'];
	$sql2 = " AND p.CatagoryId = '$catId'";
	$queryString = "catId='$catId'";
} else {
	$catId = 0;
	$sql2  = '';
	$queryString = '';
}

// for paging
// how many rows to show per page
$rowsPerPage = 5;

$sql = "SELECT p.PordId, c.SubCatId,SubCatName,p.ProdName,p.pd_thumbnail
        FROM productmast p, subcatgmaster c
		WHERE p.CatagoryId = c.SubCatId $sql2
		ORDER BY ProdName";
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
//$data1=mysql_fetch_assoc($result);
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
if (isset($_GET['ccatId']) && $_GET['ccatId']) {
	$ccatId = $_GET['ccatId'];
	
} else {
	$ccatId = 0;
	
}
$categoryList = buildCategoryOptions($ccatId);
$categoryList2 = buildCategoryOptions2($ccatId);
?> 
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post"  name="frmListProduct" id="frmListProduct">
 <p align="center" class="formTitle">Product</p>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
<tr><td> CATEGORY:<select name="cboCategory2" class="box" id="cboCategory2" onChange="viewProduct();">
     <option selected>All Category</option>
	<?php echo $categoryList2; ?>
   </select></td><td>SUB CATEGORY:<select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct1();">
     <option selected>All Category</option>
	<?php echo $categoryList; ?>
   </select></td></tr></table>
   <br>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
  <td>Product ID</td>
   <td>Product Name</td>
   <td width="75">Image</td>
   
   <td width="70">Modify</td>
   <td width="70">Delete</td>
  </tr>
  <?php
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
		
		if ($pd_thumbnail) {
			$pd_thumbnail = SAVANI_FARM . 'images/product/' . $pd_thumbnail;
		} else {
			$pd_thumbnail = SAVANI_FARM . 'images/no-image-small.png';
		}	
		
		
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
  <td><?php echo $PordId; ?></td>
   <td><a href="index.php?view=detail&productId=<?php echo $PordId; ?>"><?php echo $ProdName; ?></a></td>
   <td width="75" align="center"><img src="<?php echo $pd_thumbnail; ?>"></td>
   
   <td width="70" align="center"><a href="javascript:modifyProduct('<?php echo $PordId; ?>');">Modify</a></td>
   <td width="70" align="center"><a href="javascript:deleteProduct('<?php echo $PordId; ?>', '<?php echo $SubCatId; ?>');">Delete</a></td>
  </tr>
  <?php
	} // end while
?>
  <tr> 
   <td colspan="5" align="center">
   <?php 
echo $pagingLink;
   ?></td>
  </tr>
<?php	
} else {
?>
  <tr> 
   <td colspan="5" align="center">No Products Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"><input name="btnAddProduct" type="button" id="btnAddProduct" value="Add Product" class="box" onClick="addProduct('<?php echo $catId; ?>')"></td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>