<?
$errorMessage = '&nbsp;';
require_once('functions.php');
if (isset($_POST['txtUserName']))
//if (isset($_POST['txtdocuserid'])) 
{
	$result = addUser();
	if ($result != '') {
		$errorMessage = $result;
		
	}
			header("Location: index.php");	

}

$msg="";
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>
<form action="processCategory.php?action=add" method="post" name="frmadd" id="frmadd"><?php echo $errorMessage; ?><? echo $msg;?>
          
          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg" align="right">Add Customer
</td></tr>
 
  <tr> 
   <td width="459" class="label" align="right"> Name</td>
   <td class="content"> <input type="text" name="name" class="box" id="name" size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Contac Person</td>
   <td class="content"> <input type="text" name="fname" class="box" id="fname"  size="60" maxlength="60"></td>
  </tr>
  
   <tr> 
   <td width="459" class="label" align="right">Address 1</td>
   <td width="517" class="content"><input type="text" name="bill_st1" class="box" id="bill_st1" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right"> Address 2</td>
   <td class="content"> <input type="text" name="bill_st2" class="box" id="bill_st2"  size="30" maxlength="50"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right"> Address 3</td>
   <td class="content"> <input type="text" name="bill_st3" class="box" id="bill_st3"  size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">City</td>
   <td class="content"> <input type="text" name="bill_city" class="box" id="bill_city"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">State</td>
   <td class="content"> <input type="text" name="bill_state" class="box" id="bill_state"></td>
  </tr>
  <tr> 
   <td width="459" class="label" align="right">Zip</td>
   <td class="content"> <input type="text" name="bill_zip"  class="box" id="bill_zip"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Country</td>
   <td class="content"> <input type="text" name="bill_country" class="box" id="bill_country"></td>
  </tr>
  
  <tr> 
   <td width="459" class="label" align="right">Phone</td>
   <td class="content"> <input type="text" name="bill_phone"  class="box" id="bill_phone"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Fax</td>
   <td class="content"> <input type="text" name="bill_fax"  class="box" id="bill_fax"></td>
  </tr>
   <tr> 
   <td width="459" class="label" align="right">Email</td>
   <td class="content"> <input type="text" name="bill_email"  class="box" id="bill_email"  size="60" maxlength="60"></td>
  </tr>
  
  
 <tr><td colspan="2" align="center">
  <input name="btnModify" type="submit" id="btnModify" value="Add">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="history.go(-1)">
 </td></tr>
 <tr>
   <td colspan="2" align="center">&nbsp;</td>
 </tr>
</table> 
		  </form>    