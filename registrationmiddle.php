<?php require_once 'library/config.php';
require_once 'library/encrypt1.php';

error_reporting(E_ALL ^ E_NOTICE);

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];
require_once('functions.php');

error_reporting(E_ALL ^ E_NOTICE);
$errorMessage=$_GET['errorMessage'];
$flag =$_GET['flag'];
if(isset($errorMessage))
{
$errorMessage = $errorMessage;
}
else
{
$errorMessage = "";
}//$fname='';

?>
 <script>
 function checkemail()
 {
	
			var trim = (function() {
			
			  // if a reference is a `String`.
			  function isString(value){
				   return typeof value == 'string';
			  } 
			
			  // native trim is way faster: http://jsperf.com/angular-trim-test
			  // but IE doesn't have it... :-(
			  // TODO: we should move this into IE/ES5 polyfill
			
			  if (!String.prototype.trim) {
				return function(value) {
				  return isString(value) ? 
					 value.replace(/^\s*/, '').replace(/\s*$/, '') : value;
				};
			  }
			
			  return function(value) {
				return isString(value) ? value.trim() : value;
			  };
			
			})();



	var v1= document.getElementById('bill_email').value;
   var fname = document.getElementById('fname').value;
    var lname = document.getElementById('lname').value;
	
	if(trim(fname)=='')
	{
		
		alert('Please Enter FirstName !');
		document.frmadd.fname.focus();
		return false;
	}
		else if(trim(lname)=='')
		{
			
			alert('Please Enter LastName');
			document.frmadd.lname.focus();
			return false;
		}
		/*else if(document.getElementById('bill_st1').value=='')
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
		}*/
		else if(trim(document.getElementById('bill_phone').value)=='')
		{
			alert('Please Enter Phone No. !');
			document.frmadd.bill_phone.focus();
			return false;
		}
		else if(trim(document.getElementById('bill_email').value)=='')
		{
			alert('Please Enter Email Address !');
			document.frmadd.bill_email.focus();
			return false;
		}
		
		else if(trim(document.getElementById('bill_emailconfirm').value)=='')
		{
			alert('Please  Enter  Confirm Email Address !');
			document.frmadd.bill_email.focus();
			return false;
		}
		else if(trim(document.getElementById('bill_email').value) != trim(document.getElementById('bill_emailconfirm').value))
		{
			alert('Email does not match !');
			document.frmadd.bill_emailconfirm.focus();
			return false;
		}
		
		/*else if(trim(document.getElementById('bill_emailpass').value)=='')
		{
			alert('Please Enter Password !');
			document.frmadd.bill_emailpass.focus();
			return false;
		}
		else if(trim(document.getElementById('bill_emailpassconfirm').value)=='')
		{
			alert('Please Enter Confirm Password !');
			document.frmadd.bill_emailpass.focus();
			return false;
		}
		else if(trim(document.getElementById('bill_emailpass').value) != trim(document.getElementById('bill_emailpassconfirm').value))
		{
			alert('Password  does not match  !');
			document.frmadd.bill_emailpassconfirm.focus();
			return false;
		}*/
		else if(trim(document.getElementById('vercode').value)=='')
		{
			alert('Please  Enter captcha!');
			document.frmadd.bill_emailpass.focus();
			return false;
		}
	else
	{
		echeck(v1);
	}
	echeck(v1);
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
</script>


<div class="fillup-form">
          <div class="col-md-12">
            <label class="form-tagline"><strong>PLEASE REGISTER HERE FOR YOUR ORDER.</strong></label>
            <label class="form-tagline"><strong><span class="req">*</span>Reguired Fields</strong></label>
          </div>


        <form name="frmadd" id="frmadd" method="post" action="regfuncorona.php">
            
        <?php if($errorMessage!='') { echo $errorMessage; } ?> 
                    
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>First Name<span class="req">*</span></label>
                    <input type="text" name="fname" id="fname" size="60" maxlength="60" required>
                  </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Last Name<span class="req">*</span></label>
                    <input type="text" name="lname" id="lname"  size="60" maxlength="60" required>
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Phone<span class="req">*</span></label>
                    <td align="left"> <input type="text" name="bill_phone" id="bill_phone" onkeypress="getchar(this)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off" required></td>
            
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Email<span class="req">*</span></label>
                    <input type="text" name="bill_email" id="bill_email"  size="60" maxlength="60" required>
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Confirm Email<span class="req">*</span></label>
                    <input type="text" name="bill_emailconfirm" id="bill_emailconfirm"  size="60" maxlength="60" required>
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Enter Captcha<span class="req">*</span></label>
                    <input type="text" name="vercode"  id ="vercode"/> 
                  </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>&nbsp;</label>
                <img src="captcha.php" />
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>&nbsp;</label>
            <input class="btn-reg" name="btnModify" type="button" id="btnModify" value="Submit" onclick="checkemail();" />
            </div>  
        
            
        </form>
</div>



          <?php /*<table width="1063" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td>
            </tr>
            <tr>
              
              <td colspan="2" align="center" valign="top">
              <form name="frmadd" id="frmadd" method="post" action="regfuncorona.php">

              
              <table width="97%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" align="left" valign="middle" class="hdone">Registration</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" valign="middle" class="regbold">PLEASE REGISTER HERE FOR YOUR ORDER. <br />
                    </td>
                </tr>
                <tr>
                  <td align="right" valign="top">
                  	<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;*</font> <font class="regbold">Required fields</span> </font>                  </td>
                </tr>
                <tr>
                  <td align="center" valign="top"><font color="#FF0000" size="2.5px"><?php if($errorMessage!='') { echo $errorMessage; ?> 
                    <?php } ?></font></td>
                </tr>
                <tr>
                  <td align="left" valign="top">
                  	<table width="100%" border="0" cellpadding="1" cellspacing="3">
                    <!--DWLayoutTable-->
                    <tr> 
   <td align="right"><font color="#FF0000">*</font>First Name</td>
   <td align="left"> <input type="text" name="fname" class="box" id="fname" size="60" maxlength="60" required></td>
  </tr>
   <tr> 
   <td  align="right"><font color="#FF0000">*</font>Last Name</td>
   <td align="left"> <input type="text" name="lname" class="box" id="lname"  size="60" maxlength="60" required></td>
  </tr>
  
   
  
  <tr> 
   <td align="right"><font color="#FF0000">*</font>Phone</td>
   <td align="left"> <input type="text" name="bill_phone"  class="box" id="bill_phone" onkeypress="getchar(this)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off" required></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font>Email</td>
   <td align="left"> <input type="text" name="bill_email"  class="box" id="bill_email"  size="60" maxlength="60" required></td>
  </tr>
   <tr> 
   <td align="right"><font color="#FF0000">*</font>Confirm Email</td>
   <td align="left"> <input type="text" name="bill_emailconfirm"  class="box" id="bill_emailconfirm"  size="60" maxlength="60" required></td>
  </tr>
   
    <tr> 
   <td align="right"><font color="#FF0000">*</font>Enter Captcha</td>
   <td align="left"> <input type="text" name="vercode"  id ="vercode"/><img src="captcha.php"></td>
  </tr>
                    <tr valign="middle">
                      <td height="28" align="center" valign="top" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="28" align="left" valign="top" >  <input name="btnModify" type="button" id="btnModify" value="Submit" onclick="checkemail();">
</td>
                      <td height="28" align="center" valign="top" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                    </tr>
                        </table>                    </td>
                </tr>
                <tr>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
              </table>
              </form>
              </td>
              <td width="335" align="center" valign="top"><table width="335" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="5" /></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><a href="trackyourorders.html"><img src="images/trackyourorder.jpg" width="335" height="84" /></a></td>
                  </tr>
                  <tr>
                    <td><img src="images/spacer.gif" width="1" height="10" /></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><a href="missionmango.php"><img src="images/mango_img4.jpg" alt="Mango" width="330" height="347" border="0" /></a></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="46" align="center" valign="top">&nbsp;</td>
              <td width="682" align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top">&nbsp;</td>
            </tr>
          </table> */ ?>