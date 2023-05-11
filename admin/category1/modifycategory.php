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
	header('Location:index.php');
}	
	
	$sql	 = "SELECT CatagoryId, CatagoryName,ADD_ID,EDIT_ID
				FROM catgmaster
				WHERE CatagoryId = '$catId'";
	$result  = dbQuery($sql);
	$row 	 = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modify&catId=<?php echo $catId; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Edit Category</td></tr> 
  <tr> 
   <td width="150" class="label">Category ID</td>
   <td class="content"><input name="txtaddid" type="text" class="box" id="txtaddid" value="<?php echo $CatagoryId; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Category Name</td>
   <td class="content"> <textarea name="txtName" cols="50" rows="4" class="box" id="txtName"><?php  echo stripslashes($CatagoryName); ?></textarea></td>
  </tr>
  
 
 </table>
 <p align="center"> 
  <input name="btnModify" type="button" id="btnModify" value="Save Modification" onClick="checkCategoryForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=0';" class="box">
 </p>
</form>