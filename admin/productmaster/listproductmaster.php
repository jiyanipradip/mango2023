<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

$catId = $_REQUEST['catId'];
$ccatId = $_REQUEST['ccatId'];
if (isset($catId) && isset($ccatId)) {
	$sql = "SELECT *
        FROM productmast
		WHERE Categorymain  = '$ccatId' AND CatagoryId  = '$catId'
		ORDER BY PordId";
		$queryString = "catId='$catId'";
} else
{
	$sql = "SELECT *
        FROM productmast p WHERE Categorymain  = 'wrer' AND CatagoryId  = 'werewr'
		ORDER BY PordId";
		$queryString = '';
}

//echo $sql."<br>";
//die;
// for paging
// how many rows to show per page
$rowsPerPage = 100;


$result     = dbQuery($sql);
//$data1=mysql_fetch_assoc($result);
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
if(isset($catId))
{
	$parentId =$_GET['catId'];
}
else
{
$parentId = 0;
}
if (isset($_GET['ccatId']) && $_GET['ccatId']) {
	$ccatId = $_GET['ccatId'];
	
} else {
	$ccatId = 0;
	
}
if (isset($_GET['catId']) && $_GET['catId']) {
	$catId = $_GET['catId'];
	
} else {
	$catId = 0;
	
}

//categoryList is define for list of Category
$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);

//categoryList2 is define for list of subCategory when change category
$categoryList2 = buildCategoryOptionsmy2134($ccatId,$catId);
$numCategory2     = count($categoryList2);



//$categoryList = buildCategoryOptions($ccatId,$catId);
//$categoryList2 = buildCategoryOptions2($ccatId);
//$categoryList = buildCategoryOptionsnew($ccatId);


?> 

<script language="javascript">
function getclear()
{
	document.frmListProduct.patsearch.value="";
	document.frmListProduct.patsearch.focus();	
}


function productsearch()
{
	var content='searchpage';
	location.href="index.php?view="+content;	
}


</script>

<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post"  name="frmListProduct" id="frmListProduct">
 <center>
   Product Master List
 </center>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder" align="center">
<tr>
	<td colspan="9" align="right">    	
        <input type="button" value="Search Product" id="searchbtn" name="searchbtn" onclick="productsearch()" class="blueboxred"/>
    </td>
</tr>



<tr><td class="hdbg"> CATEGORY:   
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
   </td><td class="hdbg">SUB CATEGORY:   
   <select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct1();")>
   
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
                    <option value="<? echo $code; ?>" <?php if ($code == $catId){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
   
   
   </td></tr>
   </table>
   
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center" id="listTableHeader"> 
    <td class="hdbg">Product ID</td>
    <td class="hdbg">Product Name</td>
    <td class="hdbg">Product SKU(Barcode)</td>
    <td class="hdbg">Price</td>
    <td class="hdbg">Qty In Stock</td>
    <td class="hdbg">Stock Unit</td>
    <td class="hdbg" width="75">Image</td>   
    <td class="hdbg" width="40">Modify</td>
    <td class="hdbg" width="40">Delete</td>
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
<td><?php echo $ProdSKU; ?>&nbsp;</td>
<td><?php echo $PucrPrice; ?>&nbsp;</td>
<td><?php echo $TotBuyQty; ?>&nbsp;</td>
<td><?php echo $StockUnit; ?>&nbsp;</td>


<td width="75" align="center"><img src="<?php echo $pd_thumbnail; ?>"></td>

<td width="40" align="center"><a href="javascript:modifyProduct('<?php echo stripslashes($PordId); ?>','<?php echo stripslashes($Categorymain);?>','<?php echo stripslashes($CatagoryId); ?>');">Modify</a></td>
<td width="40" align="center"><a href="javascript:deleteProduct('<?php echo stripslashes($PordId); ?>','<?php echo stripslashes($Categorymain);?>','<?php echo stripslashes($CatagoryId); ?>');">Delete</a></td>

</tr>   
  
  
  <?php
	} // end while
?>
	

  <tr> 
   <td colspan="9" align="center">
   <?php 
//echo $pagingLink;
   ?></td>
  </tr>
<?php	
} else {
?>
  <tr> 
   <td colspan="9" align="center">No Products Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="9">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="9" align="right">
   
   <input name="btnAddProduct" type="submit" class="box" id="btnAddProduct" value="Add Product" onClick="addProduct('<?php echo $ccatId; ?>','<?php echo $catId; ?>')">
   <input type="button" value="Search Product" id="searchbtn" name="searchbtn" onclick="productsearch()" class="blueboxred"/>
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>