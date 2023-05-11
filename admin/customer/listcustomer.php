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
$rowsPerPage = 5;

$sql 			= "SELECT * 
           	   	   FROM userlogin 
		           ORDER BY user_id";
//$result 		=  mysql_query($sql) or die(mysql_error());
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));

//$pagingLink = getPagingLink($sql, $rowsPerPage);
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?>
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processCategory.php?flag=0&action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <center>Customer</center>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center" id="listTableHeader"> 
   <td class="hdbg">ID</td>
   <td class="hdbg">NAME</td>
   <td class="hdbg">PHONE</td>
   <td class="hdbg">EMAIL</td>
   <td width="75" class="hdbg">MODIFY</td>
   <td width="75" class="hdbg">DELETE</td>
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
			$cat_name = "<a href=\"index.php?Userid=$user_id\">$user_name</a>";
		}
		
// PAGE NEVIGATION COMPLETES HERE ..		
?>
  <tr class="<?php echo $class; ?>"> 
  <td><?php echo $snum; $snum++; ?>&nbsp;</td>
  <td><?php echo $user_name; ?>&nbsp;</td>
  <td><?php echo $phone; ?>&nbsp;</td>
  <td><?php echo $Email; ?>&nbsp;</td>
  <td width="75" align="center"><a href="javascript:modifycustomer('<? echo $user_id; ?>');">Modify</a></td>
  <td width="75" align="center"><a href="javascript:deleteCategory('<? echo $user_id; ?>');">Delete</a></td>
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
   <td colspan="7" align="center">No Customers Yet</td>
  </tr>
  <?php
}
?>

<tr> 
   <td colspan="7" align="center" class="hdbg"><a href="index.php?view=add">Add Customer</a>
   </td></tr>
  <tr> 
</table>
 <p>&nbsp;</p>
</form>