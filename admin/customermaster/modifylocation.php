<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// make sure a category id exists
if (isset($_GET['catId']) && $_GET['catId'])
{
		$catId = $_GET['catId'];
}
else
{
		header('Location:index.php?flag=1');
}	
	
$sql 	= "select * from custloc where location_Id = '$catId'";
$result =  mysql_query($sql) or die(mysql_error());
$data1	=  mysql_fetch_assoc($result);
//$ccat 	=  $data1['CatagoryId'];
//$categoryList = buildCategoryOptions1($ccat);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modifylocation&catId=<?php echo $catId; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Edit Location</td></tr>
  <tr> 
   <td width="150" class="label">Location ID</td>
   <td class="content"><input name="txtlocid" type="text" class="box" id="txtlocid" value="<?php echo $data1['location_Id']; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Location Name </td>
   <td class="content"> <textarea name="txtName" cols="50" rows="4" class="box" id="txtName"><?php  echo $data1['Location']; ?></textarea></td>
  </tr>
  
 
 </table>
 <p align="center"> 
  <input name="btnModify" type="button" id="btnModify" value="Save Modification" onClick="checkCategoryForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=1';" class="box">
 </p>
</form>
