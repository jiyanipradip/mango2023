<?php

if (!defined('SAVANI_FARM'))
{
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
$parentId = (isset($_GET['parentId']) && $_GET['parentId'] > 0) ? $_GET['parentId'] : 0;
?> 
<form action="processCategory.php?action=add" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <?php echo $errorMessage; ?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
<tr>
<td colspan="2" class="hdbg">Add Category
</td>
</tr>
<tr> 
   <td width="150" class="label">Category id</td>
   <td class="content"> <input name="txtaddid" type="text" class="box" id="txtaddid" size="30" maxlength="50"></td>
</tr>
<tr> 
   <td width="150" class="label">Category Name</td>
   <td class="content"> <textarea name="txtName" cols="50" rows="2" class="box" id="txtName"></textarea></td>
</tr>
    <input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
<tr>
   <td colspan="2" align="center">
    <input name="btnAddCategory" type="button" id="btnAddCategory" value="Add Category" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=0&catId=<?php echo $parentId; ?>';">  
   </td>
</tr>
</table>
</form>