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
	$sql	 = "SELECT *  
				FROM custmast  
				WHERE custid = '$Userid'";
	$result  = dbQuery($sql);
	$row 	 = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modify&Userid=<?php echo $custid; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg" align="right">Edit Customer
</td></tr>
 
  <tr> 
   <td width="459" class="label" align="right">First Name</td>
   <td class="content"> <input type="text" name="fname" class="box" id="fname" value="<?php  echo $fname; ?>" size="60" maxlength="60">
   <input type="hidden" name="custid" class="box" id="custid" value="<?php  echo $custid; ?>" size="60" maxlength="60">
   </td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Last Name</td>
   <td class="content"> <input type="text" name="lname" class="box" id="lname" value="<?php  echo $lname; ?>"  size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Address 1</td>
   <td width="517" class="content"><input type="text" name="bill_st1" class="box" id="bill_st1" value="<?php echo $bill_st1; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right"> Address 2</td>
   <td class="content"> <input type="text" name="bill_st2" class="box" id="bill_st2" value="<?php  echo $bill_st2; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">City</td>
   <td class="content"> <input type="text" name="bill_city" class="box" id="bill_city" value="<?php  echo $bill_city; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">State</td>
   <td class="content"> <input type="text" name="bill_state" class="box" id="bill_state" value="<?php  echo $bill_state; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Zip</td>
   <td class="content"> <input type="text" name="bill_zip"  class="box" id="bill_zip" value="<?php echo $bill_zip; ?>"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Country</td>
   <td class="content"> <input type="text" name="bill_country"  class="box" id="bill_country" value="<?php echo $bill_country; ?>"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Phone</td>
   <td class="content"> <input type="text" name="bill_phone"  class="box" id="bill_phone" value="<?php echo $bill_phone; ?>"></td>
 </tr>
 <tr> 
   <td width="459" class="label" align="right">Fax</td>
   <td class="content"> <input type="text" name="bill_fax"  class="box" id="bill_fax" value="<?php echo $bill_fax; ?>"></td>
 </tr>
 <tr> 
   <td width="459" class="label" align="right">Email</td>
   <td class="content"> <input type="text" name="bill_email"  class="box" id="bill_email" value="<?php echo $bill_email; ?>"></td>
 </tr>
  
 <tr><td colspan="2" align="center">
  <input name="btnModify" type="submit" id="btnModify" value="Save Modification">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="history.go(-1)">
 </td></tr>
 <tr>
   <td colspan="2" align="center">&nbsp;</td>
 </tr>
</table>
</form>