<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// make sure a category id exists
if (isset($_GET['Userid']) && $_GET['Userid'])
{
	$Userid = $_GET['Userid'];
}
else
{
	header('Location:index.php');
}	
	
	$sql	 = "SELECT user_id,user_name,Areacode,Email,Order_Email  
				FROM userlogin 
				WHERE user_id = '$Userid'";
	$result  = dbQuery($sql);
	$row 	 = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modify&Userid=<?php echo $Userid; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg" align="right">Edit Customer
</td></tr>
  <tr> 
   <td width="459" class="label" align="right">Customer ID</td>
   <td width="517" class="content"><input type="text" name="txtaddid" class="box" id="txtaddid" value="<?php echo $user_id; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Login Name</td>
   <td class="content"> <input type="text" name="txtName" class="box" id="txtName" value="<?php  echo $user_name; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Area Code,Phone and Extension</td>
   <td class="content"> <input type="text" name="txtarea" class="box" id="txtarea" value="<?php  echo $Areacode; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Contac Email Address </td>
   <td class="content"> <input type="text" name="txtemail" class="box" id="txtemail" value="<?php  echo $Email; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Order Confirmation Email Address</td>
   <td class="content"> <input type="text" name="txtorderemail"  class="box" id="txtorderemail" value="<?php echo $Order_Email; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Please Email Address Confirmation</td>
   <td class="content"> <input type="checkbox" name="txtorderemailchk"  class="box" id="txtorderemailchk" value="<?php echo $Order_Email; ?>"></td>
  </tr>
 <tr><td colspan="2" align="center">
  <input name="btnModify" type="submit" id="btnModify" value="Save Modification" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="history.go(-1)">
 </td></tr> </table>

</form>