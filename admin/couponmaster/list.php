<td>
<?php
if (isset($_GET['catId']) && $_GET['catId'] >= 0)
{
	$catId = $_GET['catId'];
	$queryString = "&catId=$catId";
}
else 
{
	$catId = 0;
	$queryString = '';
}
// for paging
// how many rows to show per page
$rowsPerPage = 5;
$sql 			= "SELECT Doc_Id, CatagoryName
           	   	   FROM doc_master
		           ORDER BY First_Name";
$result 		=  mysql_query($sql) or die(mysql_error());
//$pagingLink = getPagingLink($sql, $rowsPerPage);
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?>
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processCategory.php?flag=0&action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <CENTER>Category</CENTER>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ddepot-blueborder">
  <tr align="center"> 
   <td class="hdbg">CategoryID</td>
   <td class="hdbg">Category Name</td>
  
   <td class="hdbg" width="75">Modify</td>
   <td class="hdbg" width="75">Delete</td>
  </tr>
  <?php
  //  FOLLOW IS THE CODE FOR PAGE NEVIGATION 
$cat_parent_id = 0;
if (mysql_num_rows($result) > 0)
 {
	$i = 0;
	while($row = mysql_fetch_assoc($result))
	{
		extract($row);
		if ($i%2)
		{
			$class = 'row1';
		}
		else
		{
			$class = 'row2';
		}
		$i += 1;
		if ($cat_parent_id == 0)
		{
			$cat_name = "<a href=\"index.php?catId=$CatagoryId\">$CatagoryName</a>";
		}
		
// PAGE NEVIGATION COMPLETES HERE ..		
?>
  <tr class="<?php echo $class; ?>"> 
  <td><?php echo  stripslashes($Doc_Id); ?></td>
  <td><?php echo stripslashes($First_Name); ?></td>
  <td width="75" align="center"><a href="javascript:modifyCategory('<? echo $Doc_Id; ?>');">Modify</a></td>
  <td width="75" align="center"><a href="javascript:deleteCategory('<? echo $Doc_Id; ?>');">Delete</a></td>
  </tr>
  <?php
	} // end while
?>
  <tr> 
  <td colspan="5" align="center">
   <?php 
 // echo $pagingLink;
   ?>
   </td>
  </tr>
<?php	
} 
else
{
?>
  <tr> 
   <td colspan="5" align="center">No Categories Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
  <td colspan="5"><?php 
		//echo $pagingLink;
   ?>
   </td>
  	</tr>
  	<tr> 
   <td colspan="5" align="right"> <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Category" onClick="addCategory('<?php echo $catId; ?>')"> 
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>
</td>