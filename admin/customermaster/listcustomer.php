<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
if (isset($_GET['Userid']) && $_GET['Userid'] >= 0)
 {
	$Userid = $_GET['Userid'];
	$queryString = "&Userid=$Userid";
 }
else 
 {
	$Userid = 0;
	$queryString = '';
 }
// for paging
// how many rows to show per page
$rowsPerPage = 20;
$sql 			= "SELECT * 
           	   	   FROM custmast  
		           ORDER BY custid";
//$result 		=  mysql_query($sql) or die(mysql_error());
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));

//$pagingLink = getPagingLink($sql, $rowsPerPage);
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?>
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processCategory.php?flag=0&action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <center>
   Customer Master
 </center>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center" id="listTableHeader"> 
   <td width="79" class="hdbg">ID</td>
   <td width="79" class="hdbg">CUSTOMER ID</td>
   <td width="316" class="hdbg">CUSTOMER NAME</td>
   <td width="132" class="hdbg">CUSTOMER EMAIL</td>
   <td width="154" class="hdbg">CUSTOMER PHONE</td>
   <td width="132" class="hdbg">CUSTOMER FAX</td>
   <td width="62" class="hdbg">MODIFY</td>
   <td width="56" class="hdbg">DELETE</td>
  </tr>
  <?php
  //  FOLLOW IS THE CODE FOR PAGE NEVIGATION 
$cat_parent_id = 0;
if (dbNumRows($result) > 0)
 {
	$i = 0;
	$snum = 1;
	while($row = dbFetchAssoc($result)) {
		extract($row);
		
		if ($i%2) {
			$class = 'row1';
		}
		else
		{
			$class = 'row2';
		}
		
		$i += 1;
		
		if ($cat_parent_id == 0)
		{
			$cat_name = "<a href=\"index.php?Userid=$custid\">$custid</a>";
		}
		
// PAGE NEVIGATION COMPLETES HERE ..		
?>
  <tr class="<?php echo $class; ?>"> 
  <td><?php echo $snum; $snum++; ?>&nbsp;</td>
  <td><?php echo $custid; ?>&nbsp;</td>
  <td><?php echo $lname.' '.$fname; ?>&nbsp;</td>
  <td><?php echo $bill_email; ?>&nbsp;</td>
  <td><?php echo $bill_phone; ?>&nbsp;</td>
  <td><?php echo $bill_fax; ?>&nbsp;</td>  
  <td width="62" align="center"><a href="javascript:modifycustomermaster('<? echo $custid; ?>');">Modify</a></td>
  <td width="56" align="center"><a href="javascript:deleteCategorymaster('<? echo $custid; ?>');">Delete</a></td>
  </tr>
  <?php
	} // end while
?>
  <tr> 
   <td colspan="7" align="center">
   <?php 
  echo $pagingLink;
   ?></td>
  </tr>
<?php	
} 
else
{
?>
  <tr> 
   <td colspan="8" align="center">No Customers Yet</td>
  </tr>
  <?php
}
?><tr> 
   <td colspan="8" align="center" class="hdbg"><a href="index.php?view=add">Add Customer</a>
   </td></tr>
  <tr>
</table>
 <p>&nbsp;</p>
</form>