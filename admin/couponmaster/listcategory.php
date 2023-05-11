<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
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
$sql 			= "SELECT *
           	   	   FROM couponmaster 
		           ORDER BY Coupon_code";
$result 		=  mysql_query($sql) or die(mysql_error());
//$pagingLink = getPagingLink($sql, $rowsPerPage);
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?>
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processCategory.php?flag=0&action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <CENTER>
   Coupon Master
 </CENTER>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ddepot-blueborder">
  <tr align="center"> 
   <td class="hdbg">Coupon Code</td>
   <td class="hdbg">Description</td>
   <td class="hdbg">From Date</td>
   <td class="hdbg">To Date</td>
   <td class="hdbg">Min Qty</td>
   <td class="hdbg">Disc %</td>
   <td class="hdbg">Disc Amt</td>
   <td class="hdbg" width="75">Modify</td>
   <td class="hdbg" width="75">Delete</td>
  </tr>
  <?php
  //  FOLLOW IS THE CODE FOR PAGE NEVIGATION 
$cat_parent_id = 0;
if (dbNumRows($result) > 0)
 {
	$i = 0;
	while($row = dbFetchAssoc($result))
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
			$cat_name = "<a href=\"index.php?catId=$Coupon_code\">$Desc</a>";
		}
		
// PAGE NEVIGATION COMPLETES HERE ..		
?>
  <tr class="<?php echo $class; ?>"> 
  <td align="right"><?php echo  stripslashes($Coupon_code); ?></td>
  <td align="right"><?php echo stripslashes($Desc); ?></td>
  <td align="right"><?php echo  stripslashes($From_Date); ?></td>
  <td align="right"><?php echo stripslashes($To_Date); ?></td>
  <td align="right"><?php echo  stripslashes($Min_Qty); ?></td>
  <td align="right"><?php echo stripslashes($Disc_perc); ?></td>
  <td align="right"><?php echo  stripslashes($Disc_Amt); ?></td>
  <td width="75" align="center"><a href="javascript:modifycoupon('<? echo $Coupon_code; ?>');">Modify</a></td>
  <td width="75" align="center"><a href="javascript:deleteCategory('<? echo $Coupon_code; ?>');">Delete</a></td>
  <?php
	} // end while
?>
  </tr>
<?php	
} 
else
{
?>
  <tr> 
   <td colspan="9" align="center">No Coupon Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
  <td colspan="9"><?php 
		//echo $pagingLink;
   ?>
   </td>
  	</tr>
  	<tr> 
   <td colspan="9" align="right"> <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Coupon" onClick="addCategory('<?php echo $catId; ?>')"> 
   </td>
  </tr>
 </table>
</form>