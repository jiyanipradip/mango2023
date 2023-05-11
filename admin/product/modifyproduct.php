<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
// make sure a product id exists

if (isset($_GET['productId']) && $_GET['productId']) {
	
		$productId = urlencode($productId);
		
		}
 else {
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
	/*
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
} */
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
	$catId  = $_GET['catId'];
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
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
////$categoryList2 = buildCategoryOptions1($ccatId);
//$categoryList2 = buildCategoryOptions1($parentId);
//$categoryList = buildCategoryOptionsforsubcategory($parentId,$ChildId);

//categoryList is define for list of Category
$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);

//categoryList2 is define for list of subCategory when change category
$categoryList2 = buildCategoryOptionsmy2134($ccatId,$catId);
$numCategory2     = count($categoryList2);



?> 
<form action="processProduct.php?action=modifyProduct&productId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Modify Product</td></tr>
  
   <tr><td colspan="1" align="left"> Category </td><td>    
    <select name="cboCategory2" class="box" id="cboCategory2" onChange="viewProductmastmodify('<? echo $productId; ?>');")>
   
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
                    <option value="<? echo $code; ?>" <?php if ($ccatId==$code){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
    
    
    </td>
	
	<tr> 
   <td width="150" class="label">Product ID</td>
   <td class="content"> <input name="txtid" type="text" class="box" id="txtid" size="50" maxlength="100" value="<?php echo stripslashes($PordId); ?>">	<input type="hidden" name="cboCategory2hidden" id="cboCategory2hidden" value="<? echo $Categorymain; ?>">
<input type="hidden" name="cboCategoryhidden" id="cboCategoryhidden" value="<? echo $SubCatId; ?>"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" value="<?php echo stripslashes($ProdName); ?>" size="90" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="70" rows="4" class="box" id="mtxDescription"><?php echo stripslashes($ProdDesc); ?></textarea></td>
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
  <tr> 
   <td width="150" class="label">BrandName</td>
   <td class="content"> <input name="txtbname" type="text" id="bname" class="box" value="<?php echo stripslashes($BrandName); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">GenericName</td>
   <td class="content"> <input name="txtgname" type="text" id="gname" class="box" value="<?php echo stripslashes($GenericName); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
 <tr> 
   <td width="150" class="label">p page</td>
   <td class="content"><input name="txtppage" type="text" id="txtppage" class="box" value="<?php echo stripslashes($ProdPage); ?>" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product SKU</td>
   <td class="content"> <input name="txtprodsku" type="text" id="txtprodsku" class="box" value="<?php echo stripslashes($ProdSKU); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">SearchWord</td>
   <td class="content"> <input name="txtseachword" type="text" id="txtseachword" class="box" value="<?php echo stripslashes($SearchWord); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Search Description</td>
   <td class="content"> <input name="txtsearchdesc" type="text" id="txtsearchdesc" class="box" value="<?php echo stripslashes($SearchDesc); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Owner</td>
   <td class="content"> <input name="txtprodowener" type="text" id="txtprodowener" class="box" value="<?php echo stripslashes($ProdOwner); ?>" size="50" maxlength="100"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Stock Unit</td>
   <td class="content"> <input name="txtstockunit" type="text" id="txtstockunit" value="<?php echo $StockUnit; ?>" size="50" maxlength="100" class="box">
    </td>
  </tr>
    <tr> 
   <td width="150" class="label">Alt Unit</td>
   <td class="content"><input name="txtaltunit" type="text" id="txtaltunit" value="<?php echo $AltUnit; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Bil Unit</td>
   <td class="content"><input name="txtbunit" type="text" id="txtbunit" value="<?php echo $BillUnit; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Decimal Point</td>
   <td class="content"><input name="txtdeci" type="text" id="txtdeci" value="<?php echo $Deci; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Current Stock</td>
   <td class="content"><input name="txtcurrstock" type="text" id="txtcurrstock" value="<?php echo $CurStock; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr> <tr> 
   <td width="150" class="label">Minimum Stock</td>
   <td class="content"><input name="txtminstock" type="text" id="txtminstock" value="<?php echo $MinStock; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Maximum Stock</td>
   <td class="content"><input name="txtmaxstock" type="text" id="txtmaxstock" value="<?php echo $MaxStock; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  
  <tr> 
   <td width="150" class="label">Out of Stock</td>
   <td class="content"><input name="txtoutstock" type="text" id="txtoutstock" value="<?php echo $OutStock; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Total Sell Quantity</td>
   <td class="content"><input name="txttoselqty" type="text" id="txttoselqty" value="<?php echo $TotSelQty; ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Sell Price</td>
   <td class="content"><input name="txtsellprice" type="text" id="txtsellprice" value="<?php echo number_format($SellPrice, 2);?>" size="20" maxlength="40" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">On SalePrice</td>
   <td class="content"><input name="txtonsaleprice" type="text" id="txtonsaleprice" value="<?php echo number_format($OnSalePrice, 2); ?>" class="box" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity Pricing</td>
   <td class="content"><input name="txtQtypricing" type="text" id="txtQtypricing" value="<?php echo number_format($QtyPricing, 2); ?>" class="box" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Qty Pricing Comment</td>
   <td class="content"><input name="txtqtyPricecomment" type="text" value="<?php echo stripslashes($QtyPricingComment);?>" size="1" maxlength="1" id="txtqtyPricecomment" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Pricing Scheme</td>
   <td class="content"><input name="txtpricingscheme" type="text" value="<?php echo stripslashes($PricingScheme);?>" id="txtpricingscheme" size="1" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Taxable</td>
   <td class="content"><input name="txttaxable" type="text" id="txttaxable" value="<?php echo stripslashes($Taxable); ?>" class="box" size="50" maxlength="100"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Tax Code</td>
   <td class="content"><input name="txtcode" type="text" id="txtcode" size="50" maxlength="100" value="<?php echo stripslashes($TaxCode); ?>" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Promotion</td>
   <td class="content"><input name="txtpromotion" type="text" id="txtpromotion" value="<?php echo stripslashes($Promotion); ?>" class="box" size="50" maxlength="100"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Auction</td>
   <td class="content"><input name="txtauction" type="text" id="txtauction"  value="<?php echo stripslashes($Auction); ?>" class="box" size="50" maxlength="100"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Handling Charge</td>
   <td class="content"><input name="txthandaling" type="text" id="txthandaling" value="<?php echo stripslashes($HandlingCharge); ?>" class="box" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Shipping Charge</td>
   <td class="content"><input name="txtshippingcharge" type="text" id="txtshippingcharge" value="<?php echo stripslashes($ShippingCharge); ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Shipping Code</td>
   <td class="content"><input name="txtshippingcode" type="text" id="txtshippingcode" value="<?php echo stripslashes($ShippingCode); ?>" size="50" maxlength="100" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">ShippingUnit</td>
   <td class="content"><input name="txtshippingunit" type="text" id="txtshippingunit" value="<?php echo stripslashes($ShippingUnit); ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Box Dimensions</td>
   <td class="content"><input name="txtboxdimension" type="text" id="txtboxdimension" value="<?php echo stripslashes($BoxDimensions); ?>" size="20" maxlength="40" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">GrossWeight</td>
   <td class="content"><input name="txtgrossweight" type="text" id="txtgrossweight" value="<?php echo stripslashes($GrossWeight); ?>" class="box" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">NET WEIGT</td>
   <td class="content"><input name="txtnetweight" type="text" id="txtnetweight" value="<?php echo stripslashes($NetWeight); ?>" class="box" size="20" maxlength="40"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	ABCCode</td>
   <td class="content"><input name="txtabccode" type="text" id="txtabccode" value="<?php echo stripslashes($ABCCode); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">FSNCode</td>
   <td class="content"><input name="txtfsncode" type="text" id="txtfsncode" value="<?php echo stripslashes($FSNCode); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Location</td>
   <td class="content"><input name="txtlocation" type="text" id="txtlocation" value="<?php echo stripslashes($location); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle</td>
   <td class="content"><input name="txtfgoogle" type="text" id="txtfgoogle" value="<?php echo stripslashes($Froogle); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle Brand</td>
   <td class="content"><input name="txtfgooglebrand" type="text" id="txtfgooglebrand" value="<?php echo stripslashes($FroogleBrand); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle ProdType</td>
   <td class="content"><input name="txtfgoogleprodtype" type="text" id="txtfgoogleprodtype" value="<?php echo stripslashes($FroogleProdType); ?>" size="50" maxlength="100" class="box"> </td>
  </tr> 
  <tr> 
   <td width="150" class="label">Froogle Condition</td>
   <td class="content"><input name="txtfgooglecondition" type="text" id="txtfgooglecondition" value="<?php echo stripslashes($FroogleCondition); ?>" size="50" maxlength="100" class="box"> </td>
  </tr>
  <tr><td colspan="2" align="center">
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="checkAddProductForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';">  
 </td></tr>
 </table>
</form>