<script language="javascript">
function viewProduct1234()
{
//alert('hhhhh');
//alert(document.frmAddProduct.cboCategory2.value);
	with (window.document.frmAddProduct) {
		
			window.location.href = 'index.php?view=add&catId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
		
	}
}

</script>
<script language=javascript>
function alphanumeric(alphane)
{
//alert('hh');
var numaric = alphane.value;
//alert(numaric);
for(var j=0; j<numaric.length; j++)
{
var alphaa = numaric.charAt(j);
var hh = alphaa.charCodeAt(0);
if((hh > 47 && hh<58) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
{
}
else {
alert('BLANK SPACES ARE NOT ALLOWED');
return false;
}
}
return true;
}
</script>
<?php

if (!defined('SAVANI_FARM')) {
	exit;

}
if(isset($catId))
{
$parentId =$_GET['catId'];
}
else
{
$parentId = 0;
}
//**
if(isset($ccatId))
{
$ChildId =$_GET['ccatId'];
}
else
{
$ChildId = 0;
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
$catId = (isset($_GET['catId']) && $_GET['catId'] > 0) ? $_GET['catId'] : 0;
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

<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct"><?php echo $errorMessage; ?>
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr><td colspan="2" class="hdbg">Add Product</td></tr>
    <tr><td colspan="1" align="left"> Category </td><td>
    <select name="cboCategory2" class="box" id="cboCategory2" onChange="viewProductadd();")>
   
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
    <select name="cboCategory" class="box" id="cboCategory" >
   
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
   <td class="content"> <input name="txtid" type="text" class="box" id="txtid" size="50" maxlength="100" onblur="alphanumeric(this);"></td>
  </tr>
 
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="90" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="70" rows="2" class="box" id="mtxDescription"></textarea></td>
  </tr>
  <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" id="txtPrice" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity In Stock</td>
   <td class="content"><input name="txtQty" type="text" id="txtQty" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"> <input name="fleImage" type="file" id="fleImage" class="box"> 
    </td>
  </tr>
  
  <?
 // 29 may bacool updated
 ?>
 <tr> 
   <td width="150" class="label">Brand Name</td>
   <td class="content"> <input name="txtbname" type="text" id="bname" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Generic Name</td>
   <td class="content"> <input name="txtgname" type="text" id="gname" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Page</td>
   <td class="content"> <input name="txtppage" type="text" id="fleImage" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Product SKU</td>
   <td class="content"> <input name="txtprodsku" type="text" id="txtprodsku" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">SearchWord</td>
   <td class="content"> <input name="txtseachword" type="text" id="txtseachword" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Search Description</td>
   <td class="content"> <input name="txtsearchdesc" type="text" id="txtsearchdesc" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Owner</td>
   <td class="content"> <input name="txtprodowener" type="text" id="txtprodowener" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Stock Unit</td>
   <td class="content"> <input name="txtstockunit" type="text" id="txtstockunit" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);">
    </td>
  </tr>
    <tr> 
   <td width="150" class="label">Alt Unit</td>
   <td class="content"><input name="txtaltunit" type="text" id="txtaltunit" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Bill Unit</td>
   <td class="content"><input name="txtbunit" type="text" id="txtbunit" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Decimal Point</td>
   <td class="content"><input name="txtdeci" type="text" id="txtdeci" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Current Stock</td>
   <td class="content"><input name="txtcurrstock" type="text" id="txtcurrstock" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr> <tr> 
   <td width="150" class="label">Minimum Stock</td>
   <td class="content"><input name="txtminstock" type="text" id="txtminstock" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Maximum Stock</td>
   <td class="content"><input name="txtmaxstock" type="text" id="txtmaxstock" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  
  <tr> 
   <td width="150" class="label">Out Of Stock</td>
   <td class="content"><input name="txtoutstock" type="text" id="txtoutstock" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Total Sell Quantity</td>
   <td class="content"><input name="txttoselqty" type="text" id="txttoselqty" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Sell Price</td>
   <td class="content"><input name="txtsellprice" type="text" id="txtsellprice" size="10" maxlength="10" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">OnSale Price</td>
   <td class="content"><input name="txtonsaleprice" type="text" id="txtonsaleprice" size="10" maxlength="7" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity Pricing</td>
   <td class="content"><input name="txtQtypricing" type="text" id="txtQtypricing" size="10" maxlength="10" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity Pricing Comment</td>
   <td class="content"><input name="txtqtyPricecomment" type="text" id="txtqtyPricecomment" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Pricing Scheme</td>
   <td class="content"><input name="txtpricingscheme" type="text" id="txtpricingscheme" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Taxable</td>
   <td class="content"><input name="txttaxable" type="text" id="txttaxable" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Tax Code</td>
   <td class="content"><input name="txtcode" type="text" id="txtcode" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Promotion</td>
   <td class="content"><input name="txtpromotion" type="text" id="txtpromotion" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	Auction</td>
   <td class="content"><input name="txtauction" type="text" id="txtauction"  class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Handling Charge</td>
   <td class="content"><input name="txthandaling" type="text" id="txthandaling" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Shipping Charge</td>
   <td class="content"><input name="txtshippingcharge" type="text" id="txtshippingcharge" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Shipping Code</td>
   <td class="content"><input name="txtshippingcode" type="text" id="txtshippingcode" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Shipping Unit</td>
   <td class="content"><input name="txtshippingunit" type="text" id="txtshippingunit" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Box Dimensions</td>
   <td class="content"><input name="txtboxdimension" type="text" id="txtboxdimension" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">GrossWeight</td>
   <td class="content"><input name="txtgrossweight" type="text" id="txtgrossweight" class="box"> </td>
  </tr>
   <tr> 
   <td width="150" class="label">NET Weight</td>
   <td class="content"><input name="txtnetweight" type="text" id="txtnetweight" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">  	ABCCode</td>
   <td class="content"><input name="txtabccode" type="text" id="txtabccode" size="10" maxlength="7" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">FSNCode</td>
   <td class="content"><input name="txtfsncode" type="text" id="txtfsncode" size="10" maxlength="10" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Location</td>
   <td class="content"><input name="txtlocation" type="text" id="txtlocation" size="10" maxlength="7" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle</td>
   <td class="content"><input name="txtfgoogle" type="text" id="txtfgoogle" size="10" maxlength="10" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle Brand</td>
   <td class="content"><input name="txtfgooglebrand" type="text" id="txtfgooglebrand" size="10" maxlength="7" class="box"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Froogle Prod Type</td>
   <td class="content"><input name="txtfgoogleprodtype" type="text" id="txtfgoogleprodtype" size="10" maxlength="10" class="box"> </td>
  </tr> 
  <tr> 
   <td width="150" class="label">Froogle Condition</td>
   <td class="content"><input name="txtfgooglecondition" type="text" id="txtfgooglecondition" size="10" maxlength="7" class="box"></td>
  </tr>
  <tr><td colspan="2" align="center">
  <input name="btnAddProduct" type="button" id="btnAddProduct" value="Add Product" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
</td></tr>
 </table>
 
</form>