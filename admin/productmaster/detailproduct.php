<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId']) {
	$productId = $_GET['productId'];
} else {
	// redirect to index.php if product id is not present
	header('Location: index.php');
}

$sql = "SELECT *
        FROM productmast pd, subcatgmaster cat
		WHERE pd.PordId = '$productId' AND pd.CatagoryId = cat.SubCatId";
		
		//echo $sql; die;
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

if ($image) {
	$image = SAVANI_FARM . 'images/product/' . $image;
} else {
	$image = SAVANI_FARM . 'images/no-image-large.png';
}
function createspace()
{
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
}
function createspace1()
{

createspace();createspace();createspace();createspace();createspace();createspace();createspace();createspace();createspace();

}
?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Sub Category</td>
   <td class="content"><?php echo $SubCatName; ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <?php echo stripslashes($ProdName); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"><?php echo nl2br($ProdDesc); ?> </td>
  </tr>
  <tr> 
   <td width="150" height="36" class="label">Price</td>
   <td class="content" align="right"><?php echo number_format($PucrPrice, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Qty In Stock</td>
   <td class="content" align="right"><?php echo number_format($TotBuyQty); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"><img src="<?php echo $image; ?>"></td>
  </tr>
  
  
  <tr> 
   <td width="150" class="label">BrandName</td>
   <td class="content"><?php echo stripslashes($BrandName); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">GenericName</td>
   <td class="content"> <?php echo stripslashes($GenericName); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">ProdPage</td>
   <td class="content"> <?php echo stripslashes($ProdPage); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">ProdSKU</td>
   <td class="content"> <?php echo stripslashes($ProdSKU); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">SearchWord</td>
   <td class="content"><?php echo stripslashes($SearchWord); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">SearchDesc</td>
   <td class="content"> <?php echo stripslashes($SearchDesc); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">ProdOwner</td>
   <td class="content"><?php echo stripslashes($ProdOwner); ?>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">StockUnit</td>
   <td class="content" align="right"><?php echo number_format($StockUnit,2); createspace1()?>
    </td>
  </tr>
    <tr> 
   <td width="150" class="label">AltUnit</td>
   <td class="content" align="right"><?php echo number_format($AltUnit, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">BillUnit</td>
   <td class="content" align="right"><?php echo number_format($BillUnit, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Deci</td>
   <td class="content" align="right"><?php echo number_format($Deci, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">CurStock</td>
   <td class="content" align="right"><?php echo number_format($CurStock, 2); createspace1()?> </td>
  </tr> <tr> 
   <td width="150" class="label">MinStock</td>
   <td class="content" align="right"><?php echo number_format($MinStock, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">MaxStock</td>
   <td class="content" align="right"><?php echo number_format($MaxStock, 2); createspace1()?></td>
  
  <tr> 
   <td width="150" class="label">OutStock</td>
   <td class="content" align="right"><?php echo number_format($OutStock, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">TotSelQty</td>
   <td class="content" align="right"><?php echo number_format($TotSelQty, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">SellPrice</td>
   <td class="content" align="right"><?php echo number_format($SellPrice, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">OnSalePrice</td>
   <td class="content"><?php createspace(); echo number_format($OnSalePrice, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">QtyPricing</td>
   <td class="content" align="right"><?php echo number_format($QtyPricing, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">QtyPricingComment</td>
   <td class="content"><?php echo $QtyPricingComment; createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">PricingScheme</td>
   <td class="content"><?php createspace(); echo $PricingScheme; createspace1()?> </td>
  </tr>
  
  
  
  
  
  
  <tr> 
   <td width="150" class="label">Taxable</td>
   <td class="content"><?php echo stripslashes($Taxable); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">TaxCode</td>
   <td class="content"><?php echo stripslashes($TaxCode); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Promotion</td>
   <td class="content"><?php echo stripslashes($Promotion); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Auction</td>
   <td class="content"><?php echo stripslashes($Auction); ?></td>
  </tr>
  
  
  
  <tr> 
   <td width="150" class="label">HandlingCharge</td>
   <td class="content" align="right"><?php echo number_format($HandlingCharge, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">ShippingCharge</td>
   <td class="content" align="right"><?php echo number_format($ShippingCharge, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">ShippingCode</td>
   <td class="content"><?php echo stripslashes($ShippingCode); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">ShippingUnit</td>
   <td class="content" align="right"><?php echo number_format($ShippingUnit, 2); createspace1()?> </td>
  </tr>
  
  
  
  <tr> 
   <td width="150" class="label">BoxDimensions</td>
   <td class="content" align="right"><?php echo number_format($BoxDimensions, 2); createspace1()?></td>
  </tr>
  <tr> 
   <td width="150" class="label">GrossWeight</td>
   <td class="content" align="right"><?php echo number_format($GrossWeight, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">NET Weight</td>
   <td class="content" align="right"><?php echo number_format($NetWeight, 2); createspace1()?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	ABCCode</td>
   <td class="content"><?php echo number_format($ABCCode, 2); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">FSNCode</td>
   <td class="content"><?php echo number_format($FSNCode, 2); ?> </td>
  </tr>
  
  
  <tr> 
   <td width="150" class="label">location</td>
   <td class="content"><?php echo stripslashes($location); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle</td>
   <td class="content"><?php echo stripslashes($Froogle); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">FroogleBrand</td>
   <td class="content"><?php echo stripslashes($FroogleBrand); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">FroogleProdType</td>
   <td class="content"><?php echo stripslashes($FroogleProdType); ?></td>
  </tr> 
  <tr> 
   <td width="150" class="label">FroogleCondition</td>
   <td class="content"><?php echo stripslashes($FroogleCondition); ?></td>
  </tr>
  </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="submit" id="btnModifyProduct" value="Modify Product" onClick="window.location.href='index.php?view=modify&productId=<?php echo $productId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>