<?php
if (!defined('SAVANI_FARM'))
 {
	exit;
 }

if (isset($_GET['catId']))
 {
	$catId = $_GET['catId'];
	$sql2 = " AND  p.CatagoryId = '$catId'";
	$queryString = "catId='$catId'";
 	
 }
 else
 {
	$catId = 0;
	$sql2  = '';
	$queryString = '';
 }

// for paging
// how many rows to show per page
$rowsPerPage = 100;

$sql = "SELECT *
        FROM catgmaster p, subcatgmaster c
		WHERE p.CatagoryId = c.CatagoryId $sql2 
		ORDER BY SubCatId ";
	//echo $sql;die;	
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
//$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$categoryList = buildCategoryOptions1($catId);
$errorMessage1 = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?>
<p class="errorMessage"><?php echo $errorMessage1; ?></p>

<form action="processCategory.php?action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <center>Sub Category</center>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder">
  <tr>
   <td align="left" class="hdbg">Select Category  : 
     <select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct();">
    <option value='' <?  if($catId==''){ ?>selected<?  }?>>All Category</option>
	 <option value='<?php echo stripslashes($categoryList); if(stripslashes($categoryList)==$catId){ echo "selected";}?>'><?php echo stripslashes($categoryList); ?>
     </option> 
     <option value='' <?  if($catId==''){ ?>selected<?  }?>>All Category</option>
   </select>
 </td>
 </tr>
</table>


 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
 
  <tr align="center" id="listTableHeader"> 
  <td class="hdbg">SUB Category ID</td>
   <td class="hdbg">SUB Category Name</td>
  
   <td width="75" class="hdbg">Modify</td>
   <td width="75" class="hdbg">Delete</td>
  </tr>
  <?php
  
//$cat_parent_id = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
		
		//if ($cat_parent_id == 0) 
		{
			$cat_name = "<a href=\"index.php?catId=$CatagoryId\">$SubCatName</a>";
		}
		
		
?>
  <tr class="<?php echo $class; ?>"> 
   <td><?php echo stripslashes($SubCatId); ?></td>
   <td><?php echo stripslashes($SubCatName); ?></td>
   
   <td width="75" align="center"><a href="javascript:modifysubCategory('<? echo $catId;?>','<? echo $SubCatId; ?>')">Modify</a></td>
   <td width="75" align="center"><a href="javascript:deletesubCategory('<? echo $catId;?>','<? echo $SubCatId; ?>');">Delete</a></td>
  </tr>
  <?php
	} // end while


?>
  <tr> 
   <td colspan="5" align="center">
   <?php 
  // echo $pagingLink;
   ?></td>
  </tr>
<?php	
} else {
?>
  <tr> 
   <td colspan="5" align="center">No Categories Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"> <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Sub Category" onClick="addsubCategory('<?php echo $catId; ?>')"> 
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>
