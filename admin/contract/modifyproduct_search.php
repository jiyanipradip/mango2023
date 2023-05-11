<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId']) {
	$productId = urlencode($productId);
} else {
	// redirect to index.php if product id is not present
	header('Location: index.php');
}
// get product info
$sql = "SELECT *
        FROM productmast pd, subcatgmaster cat
		WHERE pd.PordId = '$productId' AND pd.CatagoryId = cat.SubCatId";
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());
$row    = mysql_fetch_assoc($result);
extract($row);
$sql = "SELECT SubCatId,SubCatName
		FROM subcatgmaster
		ORDER BY SubCatId";
$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
$categories = array();
while($row = dbFetchArray($result)) {
		list($id,$name) = $row;
		{
			// we create a new array for each top level categories
			$categories[$id] = array('name' => $name, 'children' => array());
		} 
	}	
	// build combo box options
	$list = '';
	foreach ($categories as $key => $value) {
		$name     = $value['name'];
		$children = $value['children'];
		$list .= "<option value=\"$key\"";
		if ($key == $SubCatId)
		{
			$list.= " selected";
		}
			$list .= ">$name</option>\r\n";
		foreach ($children as $child)
		{
			$list .= "<option value=\"{$child['id']}\"";
			if ($child['id'] == $SubCatId)
			{
				$list.= " selected";
			}
				$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
		}
}
if(isset($catId))
{
$ChildId =$_GET['catId'];
}
else
{
$ChildId = 0;
}
//**
if(isset($ccatId))
{
$parentId =$_GET['ccatId'];
}
else
{
$parentId = 0;
}
//**

//
if (isset($_GET['catId']) && (int)$_GET['catId'] > 0)
{
	$catId  = (int)$_GET['catId'];
	$sql2   = " AND p.CatagoryId = $catId";
	$queryString = "catId=$catId";
} else 
{
	$catId = 0;
	$sql2  = '';
	$queryString = '';
}

$sql = "SELECT p.PordId, c.CatagoryId, CatagoryName,p.ProdName,p.pd_thumbnail
        FROM productmast p, catgmaster c
		WHERE p.CatagoryId = c.CatagoryId
		ORDER BY ProdName";
$result = mysql_query($sql) or die(mysql_error());;
//
//echo $parentId;
//$catId = (isset($_GET['catId']) && $_GET['catId'] > 0) ? $_GET['catId'] : 0;
$ccatId = (isset($_GET['ccatId']) && $_GET['ccatId'] > 0) ? $_GET['ccatId'] : 0;
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
////$categoryList2 = buildCategoryOptions1($ccatId);
//$categoryList2 = buildCategoryOptions1($parentId);
//$categoryList = buildCategoryOptionsforsubcategory($parentId,$ChildId);

//categoryList is define for list of Category
$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);

//categoryList2 is define for list of subCategory when change category
$categoryList2 = buildCategoryOptionsmy($ccatId,$catId);
$numCategory2     = count($categoryList2);



?> 

<script type="text/javascript">
function cancelclick(parentid,childid)
{
	window.location.href = 'index.php?view=searchpage&ccatId='+parentid+'&catId='+childid;
}
</script>
<form action="processProduct.php?action=modifyProduct2&productId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr>
   <td colspan="2" class="hdbg">Modify Product serch</td>
 </tr>
  
   <tr><td colspan="1" align="left"> Category </td><td>    
    <select name="cboCategory2" class="box" id="cboCategory2" onChange="viewProduct();")>
   
                <?
                    if ($numCategory > 0)
                    {
                        $i = 0;
                        ?>
                                    <option>-- Select Category --</option>
                        
                        <?
                        
                        for ($i; $i < $numCategory; $i++)
                        {
                            extract ($categoryList[$i]);
                ?>
                    <option value="<? echo $code; ?>" <?php if ($ccatId==$code){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
   </td></tr>
   
   <tr> 
   <td width="150" class="label">Sub Category</td>
   <td class="content"> 
    
    <select name="cboCategory" class="box" id="cboCategory">
   
                <?
                    if ($numCategory2 > 0)
                    {
                        $i = 0;
                        ?>
                                    <option>-- Select Category --</option>
                        
                        <?
                        
                        for ($i; $i < $numCategory2; $i++)
                        {
                            extract ($categoryList2[$i]);
                ?>
                    <option value="<? echo $code; ?>" <?php if ($catId==$code){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
    
    
    </td>
	
	<tr> 
   <td width="150" class="label">Product ID</td>
   <td class="content"> <input name="txtid" type="text" class="box" id="txtid" size="50" maxlength="100" value="<?php echo stripslashes($PordId); ?>"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" value="<?php echo stripslashes($ProdName); ?>" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product SKU</td>
   <td class="content"> <input name="txtprodsku" type="text" id="txtprodsku" class="box" value="<?php echo stripslashes($ProdSKU); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" class="box" id="txtPrice" value="<?php echo stripslashes($PucrPrice); ?>" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Qty In Stock</td>
   <td class="content"><input name="txtQty" type="text" class="box" id="txtQty" value="<?php echo stripslashes($TotBuyQty);  ?>" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Stock Unit</td>
   <td class="content"> <input name="txtstockunit" type="text" id="txtstockunit" value="<?php echo $StockUnit; ?>" size="50" maxlength="100" class="box">
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"> <input name="fleImage" type="file" id="fleImage">
<?php
	if ($pd_thumbnail != '') { 
?>
    <br>
    <img src="<?php echo SAVANI_FARM . PRODUCT_IMAGE_DIR . $pd_thumbnail; ?>"> &nbsp;&nbsp;<a href="javascript:deleteImage(<?php echo $productId; ?>);">Delete 
    Image</a> 
    <?php
	// echo $productId; die;
	}
?>    
    </td>
  </tr>
  
  
  
  
  
    
  <tr><td colspan="2" align="center">
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="checkAddProductForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="javascript:history.go(-1)">   
 </td></tr>
 </table>
</form>