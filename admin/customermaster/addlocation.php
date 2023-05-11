<?php
if (!defined('SAVANI_FARM'))
{
	exit;
}
$Userid = (isset($_GET['Userid']) && $_GET['Userid'] > 0) ? $_GET['Userid'] : 0;
if (isset($_GET['catId']) && (int)$_GET['catId'] > 0)
{
	$catId  = (int)$_GET['Userid'];
	$sql2   = " AND p.user_id = $Userid";
	$queryString = "Userid=$Userid";
} else 
{
	$catId = 0;
	$sql2  = '';
	$queryString = '';
}

$sql = "SELECT p.user_id, c.user_id, c.user_name
        FROM userlogin p, custloc c
		WHERE p.user_id = c.user_id
		ORDER BY c.user_name";
$result = mysql_query($sql) or die(mysql_error());;
//$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$data1=mysql_fetch_assoc($result);

$categoryList = buildcustomer($catId);

?> 

<form action="processCategory.php?action=addsubcatagory" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Add Location</td></tr>
  <tr>
    <td width="488" class"label" align="right">Customer</td>
    <td width="488" class="content"><select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct();">
     <option selected>All Customer</option>
	<?php echo $categoryList; ?>
   </select></td>
  </tr>
  <tr> 
   <td width="488" class="label" align="right">Location ID </td>
   <td class="content"> <input name="txtsubcatid" type="text" class="box" id="txtsubcatid" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="488" class="label" align="right">Location</td>
   <td class="content">  <textarea name="txtName" cols="50" rows="2" class="box" id="txtName"></textarea></td>
  </tr>
  <input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $Userid; ?>">
 <tr><td colspan="2" align="center">
  <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Location" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="history.go(-1)">  
 </td></tr>
 </table>
 </form>