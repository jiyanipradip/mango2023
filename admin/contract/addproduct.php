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
if(isset($ccatId) && isset($catId) && isset($prodid))
{
$sql = "SELECT *
					FROM productmast  where Categorymain = $ccatId and CatagoryId = $catId
					ORDER BY PordId";
$result = mysql_query($sql) or die(mysql_error());;
$row=mysql_fetch_assoc($result);
$k=1;
}
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
$categoryList3 = buildCategoryOptionsmyproduct($ccatId,$catId);
$numCategory3     = count($categoryList3);
$sqlcont="select * from custmast where custid = $custId";
$resultcont = mysql_query($sqlcont);
$rowcont=mysql_fetch_assoc($resultcont);

?> 

<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct"><?php echo $errorMessage; ?> <input type="hidden" name="custId" id="custId" value="<? echo $custId; ?>"> 

  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr>
      <td colspan="2" class="hdbg">Contract For : <? echo $rowcont['name']; ?></td>
    </tr>
    <tr><td colspan="1" align="left"> Category </td><td>
    <select name="cboCategory2" class="box" id="cboCategory2" onChange="viewProductadd('<? echo $custId; ?>');")>
   
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
    <select name="cboCategory" class="box" id="cboCategory"  onChange="viewProductaddd('<? echo $custId; ?>');")>
   
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
   <td class="content">
   <select name="cboCategory3" class="box" id="cboCategory3" onChange="viewProductadddd('<? echo $custId; ?>');")>
   
                <?
                    if ($numCategory3 > 0)
                    {
                        $i = 0;
                        ?>
                                    <option>-- Select Category --</option>
                        
                        <?
                        
                        for ($i; $i < $numCategory3; $i++)
                        {
                            extract ($categoryList3[$i]);
                ?>
                    <option value="<? echo $code; ?>" <?php if(isset($prodid)) { if ($prodid==$code){echo "selected";} }?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
     </tr>
 
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="90" maxlength="100" <? if(isset($k)) { ?>
   value="<? echo $row['ProdName']; ?>" <? } ?>></td>
  </tr>
   <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" id="txtPrice" size="10" maxlength="7" class="box" <? if(isset($k)) { ?>
   value="<? echo $row['SellPrice']; ?>" <? } ?>> </td>
  </tr>
 
  <?
 // 29 may bacool updated
 ?>
 
  
  
    
  <tr><td colspan="2" align="center">
  <input name="btnAddProduct" type="button" id="btnAddProduct" value="Add Contract" onClick="checkAddProductForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="javascript:history.go(-1)">  
</td></tr>
 </table>
 
</form>