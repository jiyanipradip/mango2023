<?php
if (!defined('SAVANI_FARM'))
 {
	exit;
 }

if (isset($_GET['Userid']) && $_GET['Userid'])
 {
	$Userid = $_GET['Userid'];
	$sql2 = " AND  p.user_id = '$Userid'";
	$queryString = "Userid='$Userid'";
 }
 else
 {
	$Userid = 0;
	$sql2  = '';
	$queryString = '';
 }

// for paging
// how many rows to show per page
$rowsPerPage = 15;

$sql = "SELECT *
        FROM custloc p, userlogin  c
		WHERE p.user_id = c.user_id $sql2 
		ORDER BY p.user_name";
	//echo $sql;die;	
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
//$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$categoryList = buildcustomer($Userid);
$errorMessage1 = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?>
<p class="errorMessage"><?php echo $errorMessage1; ?></p>

<form action="processCategory.php?action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
 <center>Location</center>
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder">
  <tr>
   <td align="left" class="hdbg">Select Customer  : 
     <select name="cboCategory" class="box" id="cboCategory" onChange="viewcustomer();">
     <option selected>All Customer</option>
	<?php echo $categoryList; ?>
   </select>
 </td>
 </tr>
</table>


 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
 
  <tr align="center" id="listTableHeader"> 
  <td class="hdbg">User ID</td>
   <td class="hdbg">User Name</td>
   <td class="hdbg">Location</td>
  
   <td class="hdbg" width="75">Modify</td>
   <td class="hdbg" width="75">Delete</td>
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
			$cat_name = "<a href=\"index.php?Userid=$user_id\">$user_name</a>";
		}
		
		
?>
  <tr class="<?php echo $class; ?>"> 
   <td><?php echo $user_id; ?></td>
   <td><?php echo $user_name; ?></td>
   <td><?php echo $Location; ?></td>
   
   <td width="75" align="center"><a href="javascript:modifyLocation('<? echo $location_Id ; ?>');">Modify</a></td>
   <td width="75" align="center"><a href="javascript:deletesubCategory('<? echo $location_Id ; ?>');">Delete</a></td>
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
   <td colspan="5" align="center">No Customer Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"> <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Location" onClick="addlocation('<?php echo $Userid; ?>')"> 
   </td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>
