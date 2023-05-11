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
$categoryList2 = buildCategoryOptionsmy2134($ccatId,$catId);
$numCategory2     = count($categoryList2);


?> 

<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct"><?php echo $errorMessage; ?>
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr>
      <td colspan="2" class="hdbg">Add Product Master</td>
    </tr>
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
   <td class="content"> <input name="txtid" type="text" class="box" id="txtid" size="50" maxlength="100"></td>
  </tr>
 
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="90" maxlength="100"></td>
  </tr>
 <tr> 
   <td width="150" class="label">Product SKU</td>
   <td class="content"> <input name="txtprodsku" type="text" id="txtprodsku" class="box"> 
    </td>
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
   <td width="150" class="label">Stock Unit</td>
   <td class="content"> <input name="txtstockunit" type="text" id="txtstockunit" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);">
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"> <input name="fleImage" type="file" id="fleImage" class="box"> 
    </td>
  </tr>
  
  <?
 // 29 may bacool updated
 ?>
 
  
  
  
    
  <tr><td colspan="2" align="center">
  <input name="btnAddProduct" type="submit" id="btnAddProduct" value="Add Product" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="javascript:history.go(-1)" class="box">  
</td></tr>
 </table>
 
</form>