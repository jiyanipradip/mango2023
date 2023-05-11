<?
if($_POST['submit'])
{
require_once '../../../library/config.php';
$name= $_POST['name'];
$company	=	$_POST['txtShippingcomp'];
$fname	=		$_POST['txtShippingFirstName'];
$lname	=		$_POST['txtShippingLastName'];
$bill_st1	=	$_POST['txtShippingAddress1'];
$bill_st2	=	$_POST['txtShippingAddress2'];
$bill_city	=	$_POST['txtShippingCity'];
$bill_state	=	$_POST['txtShippingState'];
$bill_zip	=	$_POST['txtShippingPostalCode'];
$bill_phone	=	$_POST['txtShippingphone'];
$bill_fax	=	$_POST['txtShippingefax'];
$ship_st1	=	$_POST['txtbillingAddress1'];
$ship_st2	=	$_POST['txtbillingAddress2'];
$ship_city	=	$_POST['txtbillingCity'];
$ship_state	=	$_POST['txtbillingState'];
$ship_zip	=	$_POST['txtbillingPostalCode'];
$ship_phone	=	$_POST['txtbillingphone'];
$ship_fax	=	$_POST['txtbillingfax'];
$sql11="insert into custmast
(name,company,fname,lname,phone,fax,bill_st1,bill_st2,bill_city,
bill_state,bill_zip,bill_phone,bill_fax,ship_st1,ship_st2,
ship_city,ship_state,ship_zip,ship_phone,ship_fax)
values
('$name',
'$company',
'$fname',
'$lname',
'',
'',
'$bill_st1',
'$bill_st2',
'$bill_city',
'$bill_state',
'$bill_zip',
'$bill_phone',
'$bill_fax',
'$ship_st1',
'$ship_st2',
'$ship_city',
'$ship_state',
'$ship_zip',
'$ship_phone',
'$ship_fax'
)";
//echo $sql11;
$result = mysql_query($sql11);
//$data=mysql_fetch_assoc($result);
include("refresh_carecredit.php");
}
?>
<form name="form1" id="form1" method="post">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
     
       <tr> 
            <td width="150" class="label">Name</td>
            <td class="content"><input name="name" type="text" class="box" id="name" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="30" maxlength="50"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Company Name</td>
            <td class="content"><input name="txtShippingcomp" type="text" class="box" id="txtShippingcomp" size="30" maxlength="50"></td>
        </tr>
		
	<tr class="dp-prodboxbg01"> 
            <td colspan="2" align="center" class="hdbg">Shipping Information</td>
        </tr>	
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><input name="txtShippingAddress1" type="text" class="box" id="txtShippingAddress1" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"></td>
        </tr>
        
		 <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="30" maxlength="32" onBlur="checkName(this);"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Province / State</td>
            <td class="content"><input name="txtShippingState" type="text" class="box" id="txtShippingState" size="30" maxlength="32"></td>
        </tr>
       
        <tr> 
            <td width="150" class="label">Postal / Zip Code</td>
            <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10"></td>
        </tr>
		 
		<tr> 
            <td width="150" class="label">Phone</td>
            <td class="content"><input name="txtShippingphone" type="text" class="box" id="txtShippingphone" size="10" maxlength="10" onblur="Validatenum();"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Fax</td>
            <td class="content"><input name="txtShippingefax" type="text" class="box" id="txtShippingefaxl" size="50" maxlength="50"></td>
        </tr>
        
        <tr class="dp-prodboxbg01"> 
            <td colspan="2" align="center" class="hdbg">Billing Information</td>
        </tr>	
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><input name="txtbillingAddress1" type="text" class="box" id="txtbillingAddress1" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><input name="txtbillingAddress2" type="text" class="box" id="txtbillingAddress2" size="50" maxlength="100"></td>
        </tr>
        
		 <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><input name="txtbillingCity" type="text" class="box" id="txtbillingCity" size="30" maxlength="32" onBlur="checkName(this);"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Province / State</td>
            <td class="content"><input name="txtbillingState" type="text" class="box" id="txtbillingState" size="30" maxlength="32"></td>
        </tr>
       
        <tr> 
            <td width="150" class="label">Postal / Zip Code</td>
            <td class="content"><input name="txtbillingPostalCode" type="text" class="box" id="txtbillingPostalCode" size="10" maxlength="10"></td>
        </tr>
		 
		<tr> 
            <td width="150" class="label">Phone</td>
            <td class="content"><input name="txtbillingphone" type="text" class="box" id="txtbillingphone" size="10" maxlength="10" onblur="Validatenum();"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Fax</td>
            <td class="content"><input name="txtbillingfax" type="text" class="box" id="txtbillingfax" size="50" maxlength="50"></td>
        </tr>
 <tr><td colspan="2" align="center">
  <input name="submit" type="submit" id="submit" value="Add">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';">  
 </td></tr>
  </table>
     