<?php 
require_once 'library/config.php';
require_once 'library/category-functions.php';
require_once 'library/product-functions.php';
require_once 'library/cart-functions.php';
require_once 'library/encrypt1.php';

error_reporting(E_ALL ^ E_NOTICE);
//echo $bill_state; die;
//print_r($_SESSION); exit;

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];
require_once('functions.php');
$errorMessage = '&nbsp;';

if(isset($_POST['changepass']))
{
	//echo "hii";
	$changeemail=$_POST['changeemail'];
	$currpass=$_POST['currpass'];
	$newpass=$_POST['newpass'];
	//echo $newpass; 
	$currpass1 = ENCRYPT_DECRYPT($currpass);
	$sqlcust="select * from custmast where bill_email = '$changeemail' and password='$currpass1'";
 	//echo $sqlcust; die;
	$resultcust=mysql_query($sqlcust);
 	if(mysql_num_rows($resultcust) == 0)
	{
		//echo "11";
		$errorMessage="Your Email Address And Password Didn't Match";
	}
	else
	{
	//echo "22";
		$newpass1 = ENCRYPT_DECRYPT($newpass);
		$sql    = "UPDATE `custmast` SET `password` = '$newpass1' where `bill_email` = '$changeemail'";
	
		//echo $sql; die;
	//echo "hi";die;
		$result=mysql_query($sql) or die(mysql_error());
		header('Location: placeanorder.php?step=4');
			exit;
	}

}

if(isset($_POST['forgotsubmit']))
{
	$bill_email=$_POST['forgotemail'];
	
	//echo $bill_email; die;
	
	$sqlcust="select * from custmast where bill_email ='$bill_email'";
 	//echo $sqlcust; die; 
	$resultcust=mysql_query($sqlcust);
 	if(mysql_num_rows($resultcust) == 0)
	{
		$errorMessage="THIS EMAIL ADDRESS IS NOT REGISTERED";
	}
	else
	{
		$temppasss=rand(5000000,9000000);
		//echo $temppasss; die;
		$temppass1 = ENCRYPT_DECRYPT($temppasss);
		$kmo= ENCRYPT_DECRYPT($temppass1);
		$sql    = "UPDATE `custmast` SET `password` = '$temppass1' where `bill_email` = '$bill_email'";
		$result=mysql_query($sql) or die(mysql_error());
		$from='savanifarms@dentaoffice.com';			
		$subject = 'SavaniFarms Your Temporary Password';
		$message = '<html><body><br>Dear Customer Your Temporary savanifarms password is <b>'.$kmo.'</b></body></html>';
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers .= "From: $from";
		mail($bill_email, $subject, $message, $headers);
		//mail('savanifarms@dentaoffice.com', $subject, $message, $headers);
		//mail('deepak.dentaweb@gmail.com', $subject, $message, $headers);
		header('Location: placeanorder.php?step=4&change=changepass&errorMessage=Your savanifarms temporary password is sent to your email address&showmsg=showmsg');
		exit;
	}

}
if(isset($_POST['bill_emailpassconfirm']))
{
$fname= $_POST['fname'];
$lname= $_POST['lname'];
$bill_st1= $_POST['bill_st1'];
$bill_st2= $_POST['bill_st2'];
//$bill_st3= $_POST['bill_st3'];
$bill_city= $_POST['bill_city'];
$bill_state= $_POST['bill_state'];
$bill_zip= $_POST['bill_zip'];
$bill_country= $_POST['bill_country'];
$bill_phone= $_POST['bill_phone'];
$bill_fax= $_POST['bill_fax'];
$bill_faxship=$_POST['bill_faxship'];
$bill_email= $_POST['bill_email'];
$bill_emailpass= $_POST['bill_emailpass'];
$bill_emailpass = ENCRYPT_DECRYPT($bill_emailpass);


$bill_emailpassconfirm= $_POST['bill_emailpassconfirm'];

 $sqlcust="select * from custmast where bill_email = '$bill_email'";
 $resultcust=mysql_query($sqlcust);
 if(mysql_num_rows($resultcust) == 0)

	{
	    				$sql    = "INSERT INTO `custmast` (

`fname` ,
`lname` ,
`bill_st1` ,
`bill_st2` ,
`bill_city` ,
`bill_state` ,
`bill_zip` ,
`bill_country` ,
`bill_phone` ,
`bill_email` , 
`password` , 
`shipfname` ,
`shiplname` ,
`ship_st1` ,
`ship_st2` ,
`ship_city` ,
`ship_state` ,
`ship_zip` ,
`ship_country` ,
`ship_phone` ,
`ship_email`,
`fax`,
`ship_fax`)
VALUES (
'".addslashes($fname)."', '".addslashes($lname)."', '".addslashes($bill_st1)."', '".addslashes($bill_st2)."', '".addslashes($bill_city)."',
 '".addslashes($bill_state)."', '".addslashes($bill_zip)."', '".addslashes($bill_country)."', '".addslashes($bill_phone)."', '".addslashes($bill_email)."','".addslashes($bill_emailpass)."','".addslashes($fnameship)."', '".addslashes($lnameship)."', '".addslashes($bill_st1ship)."', '".addslashes($bill_st2ship)."', '".addslashes($bill_cityship)."',
 '".addslashes($bill_stateship)."', '".addslashes($bill_zipship)."', '".addslashes($bill_countryship)."', '".addslashes($bill_phoneship)."', '".addslashes($bill_emailship)."','".addslashes($bill_fax)."','".addslashes($bill_faxship)."')";				  
								  


        				$result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    					//header('Location: index.php');  
						header('Location: placeanorder.php?step=1&loginid='.$bill_email);  
	}
	else
	{
		$errorMessage1= $bill_email." is already used !";
		$errorMessage = "$errorMessage1";
	}          

}

if (isset($_POST['txtuserid']))
{
	//echo "asmir"; die;
	$result = doLoginstepwise();
	//echo $result; die;
	if ($result != '')
	{
		$errorMessage = $result;
	}
}
$msg="";
?>
<?php if (!defined('SAVANI_FARM')
    || !isset($_GET['step']) || (int)$_GET['step'] != 4) {
	exit;
}
if(isset($_GET['validateuser']))
{
	$validateuser=$_GET['validateuser'];
}
if(isset($_GET['forgot']))
{
	$forgot=$_GET['forgot'];
}
if(isset($_GET['change']))
{
	$change=$_GET['change'];
}

?>
<?php /*if (!defined('SAVANI_FARM')
    || !isset($_GET['step']) || (int)$_GET['step'] != 4) {
	exit;
}*/
?>
<script>

/* START phone validation FUNCTION ONCHANGE */



/* END phone validation FUNCTION ONCHANGE */


function checkemail()
 {
 var v1= document.getElementById('bill_email').value;
 var v2= document.getElementById('bill_phone').value;
if(document.getElementById('fname').value=='')
{
	alert('Please Enter FirstName !');
	document.frmadd.fname.focus();
	return false;
}
else if(document.getElementById('lname').value=='')
{
	alert('Please Enter LastName');
	document.frmadd.lname.focus();
	return false;
}
else if(document.getElementById('bill_st1').value=='')
{
	alert('Please Enter Address 1');
	document.frmadd.bill_st1.focus();
	return false;
}
else if(document.getElementById('bill_city').value=='')
{
	alert('Please Enter City');
	document.frmadd.bill_city.focus();
	return false;
}
else if(document.getElementById('bill_state').value=='')
{
	alert('Please Enter State');
	document.frmadd.bill_state.focus();
	return false;
}
else if(document.getElementById('bill_zip').value=='')
{
	alert('Please Enter Postal Code');
	document.frmadd.bill_zip.focus();
	return false;
}
else if(document.getElementById('bill_country').value=='')
{
	alert('Please Enter Country');
	document.frmadd.bill_country.focus();
	return false;
}
else if(document.getElementById('bill_phone').value=='')
{
	alert('Please Enter Phone No. !');
	document.frmadd.bill_phone.focus();
	return false;
}
else if(document.getElementById('bill_email').value=='')
{
	alert('Please Enter Email Address !');
	document.frmadd.bill_email.focus();
	return false;
}
else if(document.getElementById('bill_email').value != document.getElementById('bill_emailconfirm').value)
{
	alert('Please Enter Confirm Email Address !');
	document.frmadd.bill_emailconfirm.focus();
	return false;
}

else if(document.getElementById('bill_emailpass').value=='')
{
	alert('Please Enter Password !');
	document.frmadd.bill_emailpass.focus();
	return false;
}
else if(document.getElementById('bill_emailpass').value != document.getElementById('bill_emailpassconfirm').value)
{
	alert('Please Confirm Password !');
	document.frmadd.bill_emailpassconfirm.focus();
	return false;
}
 else
 {
  echeck(v1);
 }
 }

function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}
		else
		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}
		else
		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}
		else	
		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		else
		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }
		else
		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		else
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		else
		{
		 document.frmadd.submit();
		}
	}
	function getchar(obj)	
	{	
		var mystring1 = document.frmadd.bill_phone.value;
		if(mystring1.length>11)
		{
			event.returnValue=false;
		}
			if ((mystring1.length==3)||(mystring1.length==7))
			{
				document.frmadd.bill_phone.value=mystring1+"-";
			}
		if((event.keyCode<48)||(event.keyCode>57))
		{
			if(event.keyCode!=46)
			{
				event.returnValue=false;
			}
		}
	}
	
	function funresgister()
	{
		window.location="placeanorder.php?step=4";
	}
	
	function setPaymentInfo(isChecked)
{
	with (window.document.frmadd) {
		if (isChecked) {
			fnameship.value  = fname.value;
			lnameship.value   = lname.value;
			bill_st1ship.value     		= bill_st1.value;
			bill_st2ship.value    		= bill_st2.value;
			bill_cityship.value  		= bill_city.value;
			bill_stateship.value  		= bill_state.value;
			bill_zipship.value      		= bill_zip.value;
			bill_countryship.value     		= bill_country.value;			
			bill_phoneship.value 		= bill_phone.value;
			bill_faxship.value   		= bill_fax.value;
			bill_emailship.value      		= bill_email.value;
						//fnameship.readOnly  = true;
			
		} else {
			
	
		}
	}
}

</script>
<center>
  <b><font color="#FF0000"><?php  if($errorMessage == $errorMessage1) { echo $errorMessage; ?>  <a href="login.php" <?php // onclick="return funresgister();"?>> Click here to go to Login Page</a><?php } else { ?><?php echo $errorMessage; ?><?php } ?></font></b>
</center>
<div class="fillup-form">
<div class="col-md-12">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="red" class="dp-blackbold">
          <tr>
            <td colspan="3" align="center" valign="top"><img src="../DENTADEPOT1/images/dp-spacer.gif" width="12" height="1" /></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="top"><img src="../DENTADEPOT1/images/dp-spacer.gif" width="1" height="10"/></td>
          </tr>

          <tr align="left">
            <td colspan="4" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="1">
              
        <tr>
                  <td align="left" valign="top" class="dp-blackbold"> 
                  <?php if(isset($_GET['validateuser'])) { ?><?php  echo $errorMessage; ?>
                      
<div class="col-md-8" style="margin:0 auto; display:table; float:inherit;">
<form action="" method="post" name="frmadd" id="frmadd">
<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr>
   <td colspan="2" class="hdone" align="left">Billing Information 
</td>
 </tr>
  <tr> 
   <td width="8%" align="right"><font color="#FF0000">*</font> First Name</td>
   <td align="left"> <input type="text" name="fname" class="box" id="fname" size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td  align="right"><font color="#FF0000">*</font> Last Name</td>
   <td align="left"> <input type="text" name="lname" class="box" id="lname"  size="60" maxlength="60"></td>
  </tr>
  
   <tr> 
   <td align="right"><font color="#FF0000">*</font> Address 1</td>
   <td align="left"><input type="text" name="bill_st1" class="box" id="bill_st1" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td align="right"> Address 2</td>
   <td align="left"> <input type="text" name="bill_st2" class="box" id="bill_st2"  size="30" maxlength="50"></td>
  </tr>
   
  <tr> 
   <td align="right"><font color="#FF0000">*</font> City</td>
   <td align="left"> <input type="text" name="bill_city" class="box" id="bill_city"></td>
  </tr>
  <tr> 
   <td align="right"><font color="#FF0000">*</font> State</td>
   <td align="left"> <input type="text" name="bill_state" class="box" id="bill_state"></td>
  </tr>
  <tr> 
   <td align="right"><font color="#FF0000">*</font> Zip</td>
   <td align="left"> <input type="text" name="bill_zip"  class="box" id="bill_zip"></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font> Country</td>
   <td align="left"> <input type="text" name="bill_country" class="box" id="bill_country"></td>
  </tr>
  
  <tr> 
   <td align="right"><font color="#FF0000">*</font> Phone</td>
   <td align="left"> <input type="text" name="bill_phone"  class="box" id="bill_phone" onkeypress="getchar(this)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off"></td>
  </tr>
   <tr> 
   <td align="right">Fax</td>
   <td align="left"> <input type="text" name="bill_fax"  class="box" id="bill_fax"></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font> Email</td>
   <td align="left"> <input type="text" name="bill_email"  class="box" id="bill_email"  size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font> Confirm Email</td>
   <td align="left"> <input type="text" name="bill_emailconfirm"  class="box" id="bill_emailconfirm"  size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font> Choose Password</td>
   <td align="left"> <input type="password" name="bill_emailpass"  class="box" id="bill_emailpass"  size="60" maxlength="60"></td>
  </tr>
  <tr> 
   <td align="right"><font color="#FF0000">*</font> Confirm Password</td>
   <td align="left"> <input type="password" name="bill_emailpassconfirm"  class="box" id="bill_emailpassconfirm"  size="60" maxlength="60"></td>
  </tr>
   <tr>
   <td colspan="1" class="hdone" align="left">Shipping Information</td>
   <td align="left"><input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);">
        <label for="chkSame" style="cursor:pointer">Same as Above </label>
</td></tr>
 
  <tr> 
   <td align="right"> First Name</td>
   <td align="left"> <input type="text" name="fnameship" class="box" id="fnameship" size="60" maxlength="60"></td>
  </tr>
   <tr> 
   <td  align="right">Last Name</td>
   <td align="left"> <input type="text" name="lnameship" class="box" id="lnameship"  size="60" maxlength="60"></td>
  </tr>
  
   <tr> 
   <td align="right">Address 1</td>
   <td align="left"><input type="text" name="bill_st1ship" class="box" id="bill_st1ship" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td align="right"> Address 2</td>
   <td align="left"> <input type="text" name="bill_st2ship" class="box" id="bill_st2ship"  size="30" maxlength="50"></td>
  </tr>
   
  <tr> 
   <td align="right">City</td>
   <td align="left"> <input type="text" name="bill_cityship" class="box" id="bill_cityship"></td>
  </tr>
  <tr> 
   <td align="right">State</td>
   <td align="left"> <input type="text" name="bill_stateship" class="box" id="bill_stateship"></td>
  </tr>
  <tr> 
   <td align="right">Zip</td>
   <td align="left"> <input type="text" name="bill_zipship"  class="box" id="bill_zipship"></td>
  </tr>
   <tr> 
   <td align="right">Country</td>
   <td align="left"> <input type="text" name="bill_countryship" class="box" id="bill_countryship"></td>
  </tr>
  
  <tr> 
   <td align="right">Phone</td>
   <td align="left"> <input type="text" name="bill_phoneship"  class="box" id="bill_phoneship"></td>
  </tr>
   <tr> 
   <td align="right">Fax</td>
   <td align="left"> <input type="text" name="bill_faxship"  class="box" id="bill_faxship"></td>
  </tr>
   <tr> 
   <td align="right">Email</td>
   <td align="left"> <input type="text" name="bill_emailship"  class="box" id="bill_emailship"  size="60" maxlength="60"></td>
  </tr>
  
 <tr><td colspan="2" align="center">
     
  <input name="btnModify" type="button" id="btnModify" value="Add" onclick="checkemail();" class="btn btn-success btn-sm">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="history.go(-1)" class="btn btn-success btn-sm">
 </td></tr>
 <tr>
   <td colspan="2" align="center">&nbsp;</td>
    </tr></table> </form>
</div>
    

<?php } else if(isset($forgot))

{
	?>
    <div class="fillup-form">
    <div class="col-md-4" style="margin:0 auto; display:table; float:inherit;">
	<form name="frorgotpassword" method="post" id="frorgotpassword">
    <table width="100%" border="0" align="center"  cellpadding="3" cellspacing="3" bordercolor="#99CC00"  bgcolor="#FFFFFF">
    <tr>
      <td colspan="2" align="center" class="hdonebig">Forgot Password</td>
    </tr>
    <tr><td width="10%" align="right">Enter Email Address:</td>
        <td align="left"><input type="text" name="forgotemail" id="forgotemail"><input type="submit" name="forgotsubmit" id="forgotsubmit" value="Go" class="btn btn-success btn-sm"></td></tr>
    <tr><td align="center" colspan="2"><font color="#000000"><h3>Your Temporary Password will be sent to your Email Address</h3></font></td></tr>
    </table>
    </form>
        </div>
                      </div>

<?php } 
else if(isset($change))

{
	?>
<div class="fillup-form">
<div class="col-md-4" style="margin:0 auto; display:table; float:inherit;">                      
<form name="changepass" method="post" id="changepass">
   <table width="100%" border="0" align="center"  cellpadding="3" cellspacing="3" bordercolor="#99CC00"  bgcolor="#FFFFFF">
  
  <tr>
   <td colspan="2" class="hdonebig">Change Password</td>
  </tr>
  <tr <?php if(isset($showmsg)) { ?>style="display:block" <?php } else { ?>style="display:none" <?php } ?>>
  	<td colspan="2" align="center"><font color="#009933" size="-1">Please Check Your Email Account For Temporary Password<br>
    Enter That Temporary Password Below And Then Enter New Password
    </td>
  </tr>
  <tr>
    <td width="10%" align="right" class="hdshopcartone">Enter Email</td>
    <td align="left"><input type="text" name="changeemail" id="changeemail"></td>
  </tr>
  <tr>
    <td align="right" class="hdshopcartone">Temporary Password</td>
    <td align="left"><input type="password" name="currpass" id="currpass"></td>
  </tr>
  <tr>
    <td align="right" class="hdshopcartone">New Password</td>
    <td align="left"><input type="password" name="newpass" id="newpass"></td>
  </tr>
  <tr>
   <td colspan="2" class="hdonebig" align="center"><input class="btn btn-success btn-sm" type="submit" name="changepass" id="changepass" value="Change Password"></td>
  </tr>
</table>

    </form>
    </div>
    </div>
    <?php }
else { ?>
<?php 
      
      $catlist = getCartContent(); 
      $chkcatid = array();
      foreach($catlist as $catlists)
      {    
          $chkcatid[] = $catlists['CatagoryId'];
      }
    
        $zipshipzone ="select ZIPCODE from shipzone where STATE IN ('NY','NJ','PA')";
	    $zipshipzone=mysql_query($zipshipzone);
        while ($ziprows = mysql_fetch_array($zipshipzone))
        {
            $zipcodechk[] = $ziprows['ZIPCODE'];   
        }
        if (in_array($_SESSION['shipamtses'],$zipcodechk))
        {
            $zipflag=1;
        }
        else  
        {
            $zipflag=2;
        }
        if(isset($_SESSION))
        {
            if(in_array('10010',$chkcatid) && !in_array('10001',$chkcatid) && $_SESSION['cbomethod1ses']=='50' && $_SESSION['radiotype1ses']=='residence' && $zipflag=='1')
            {
                if($_SESSION['shipamt44']=="" || $_SESSION['shipamt44']=="0.00")
                {
                }
            }
            elseif($_SESSION['shipamt44']=="" || $_SESSION['shipamt44']=="0.00")
            {
                header('Location: placeanorder.php?view=1&pricingtype=DOLLOR');
            }
        }
        else
        {
            header('Location: placeanorder.php?view=1&pricingtype=DOLLOR');
            exit;
        }
            /*if($catlist[0]['CatagoryId']=="10010" && $_SESSION['cbomethod1ses']=='50')
            {
                if($_SESSION['shipamt44']=="" || $_SESSION['shipamt44']=="0.00")
                {                   
		        }
                elseif($_SESSION['shipamt44']!="" || $_SESSION['shipamt44']!="0.00")
                {
                }
                else
                {
                    header('Location: placeanorder.php?view=1&pricingtype=DOLLOR');
                }
           }*/
    ?>
        <div class="col-md-4" style="margin:0 auto; display:table; float:inherit;">
		  <div class="wrapper">
          <form name="userlogin" method="post" id="userlogin"><?php  //echo $errorMessage; ?><?php echo $msg;?>
            <h4>Customer Login !</h4>
          
            <div class="aos-br-comn-blackhd">Login Name </div>
            
            <input name="txtuserid" type="text" class="aos-br-comn-input form-control" id="txtuserid"
           <?php if(isset($loginid)) { ?> value="<?php echo $loginid; ?>" <?php } ?> />
		  
            <div class="aos-br-comn-blackhd">Password:</div>
            <input name="txtpass" type="password" class="aos-br-comn-input form-control" id="txtpass" />
              
		   <input type="hidden" name='c1' value='<?php echo $c1?>'>
           <input type="hidden" name='q1' value='<?php echo $q1?>'>
           <input type="hidden" name='p1' value='<?php echo $p1?>'>
          
            
            
            <input name="btnLogin" type="submit" class="box btn btn-success btn-sm" id="btnLogin" value="Login" />
          <div class="clear">&nbsp;</div>
          New User  			
          <!--<a href="newuser.php?c1= <?php echo $c1?>&q1=<?php echo $q1?>&p1=<?php echo $p1?>">-->
          <a href="placeanorder.php?step=4&mkey=fresh&validateuser=validateuser">Sign Up</a> |
          <a href="placeanorder.php?step=4&forgot=forgotpassword">Forgot Password</a> | 
          <a href="placeanorder.php?step=4&change=changepassword">Change Password</a>
          
        
              <?php } ?></form></div>
                      </div>
                      
                      
          <?php /* <form name="userlogin" method="post" id="userlogin"><?php  //echo $errorMessage; ?><?php echo $msg;?>
          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" class="ddepot-blueborder">
          <tr>
            <td  height="37" colspan="2" align="center" valign="middle" class="hdbold">Customer Login ! </td>
          </tr>
          <tr class="dp-prodboxbg01">
            <td width="47%" align="right" valign="middle" class="aos-br-comn-blackhd">Login Name </td>
            <td width="53%" height="27" align="left" valign="middle">
            
            <input name="txtuserid" type="text" class="aos-br-comn-input" id="txtuserid"
           <?php if(isset($loginid)) { ?> value="<?php echo $loginid; ?>" <?php } ?> 
            
             /></td>
          </tr>
		  
          <tr class="dp-prodboxbg01">
            <td height="27" align="right" valign="middle" class="aos-br-comn-blackhd">Password:</td>
            <td height="27" align="left" valign="middle"><input name="txtpass" type="password" class="aos-br-comn-input" id="txtpass" /></td>
          </tr>
		  <input type="hidden" name='c1' value='<?php echo $c1?>'>
				<input type="hidden" name='q1' value='<?php echo $q1?>'>
						<input type="hidden" name='p1' value='<?php echo $p1?>'>
          <tr class="dp-prodboxbg01">
            
            <td height="29" align="center" valign="middle">&nbsp;</td>
            <td height="29" align="left" valign="middle"><input name="btnLogin" type="submit" class="box" id="btnLogin" value="Login" /></td>
          </tr>
          <tr class="dp-prodboxbg01">
            <td align="center" valign="middle" colspan="2">&nbsp;</td>
          </tr>
          <tr class="dp-prodboxbg01">
            <td align="center" valign="middle" colspan="2">New User  			
          <!--<a href="newuser.php?c1= <?php echo $c1?>&q1=<?php echo $q1?>&p1=<?php echo $p1?>">-->
          <a href="placeanorder.php?step=4&mkey=fresh&validateuser=validateuser">Sign Up</a> |
          <a href="placeanorder.php?step=4&forgot=forgotpassword">Forgot Password</a> | 
          <a href="placeanorder.php?step=4&change=changepassword">Change Password</a></td>
          </tr>
        </table>  
          <?php } ?></form> */?></td>
                </tr>
                </table>     
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="dp-midbox-bord">
                  
            </table></td>
            </tr>
          <tr>
            <td colspan="3" align="center" valign="top"><img src="../DENTADEPOT1/images/dp-spacer.gif" width="1" height="10" /></td>
          </tr>
          <tr>
            <td height="13" align="center" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="dp-midbox-bord">
               
            </table></td>
          </tr>
    </table></div></div>