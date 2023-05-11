<!--<link href="../css/style.css" rel="stylesheet" type="text/css" />-->
<Style>
    .col3 td{
        width: 30%;
        padding: 0 1% 1% 1%;
    }  
.col3 td label {
  font-size: 12px;
  font-weight: normal;
  color: #666;
}
 .col3 td input {
  font-size: 12px;
  font-weight: normal;
  color: #666;
     width:100%;
} 
    
.col3 td select {
  font-size: 12px;
font-weight: normal;
color: #666;
width: 100%;
height: 30px;
margin-bottom: 15px;
background: #fff;
border-radius: 5px;
border: 1px solid #ccc;
}  
    .col3 td select.col50 {
  font-size: 12px;
  font-weight: normal;
  color: #666;
    width:48%;
}  
    .col3 td.button input.col50{width:48%!important; color:#fff; font-weight: bold;}
    
   #chkSame {
  width: auto !important;
}
    @media only screen and (max-width: 768px) {
   .col3 td{
        width: 100%;
        padding: 0 1% 1% 1%;
       float:left;
    }  
}
</Style>
<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!defined('SAVANI_FARM')
    || !isset($_GET['step']) || (int)$_GET['step'] != 1) {
	exit;
}
require_once 'encrypt1.php';
	if(isset($_GET['errorMessage']))
		{
		$errorMessage=$_GET['errorMessage'];
		}
	else
		{
		$errorMessage = '&nbsp;';
		}
		//echo $m."test"; die;
if(isset($_GET['m']))
{
$k=1;
$sql = "select * from orderdatatemp order by Order_Id desc";
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());
$row    = mysql_fetch_assoc($result);
$data2=mysql_fetch_assoc($result);
}
else
{
$k=2;
}
if(isset($_GET['loginid']))
{
$sqlcust="SELECT *
		        FROM custmast 
				WHERE bill_email = '$_GET[loginid]'";
//echo $sqlcust;die;
$resultcust=mysql_query($sqlcust);
$rowcust=mysql_fetch_assoc($resultcust);				
}
?>
<script language="JavaScript" type="text/javascript" src="library/checkout.js"></script>
<script language = "Javascript">
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
 function checkemail()
 {
  crmonth = document.getElementById('txtccexpiredatemonth').value;
  currmonth = document.getElementById('currmonth').value;

 var v1= document.getElementById('txtShippingemail').value;
 var v2= document.getElementById('txtShippingemailconfirm').value;
 
if(document.getElementById('tracknshipcode').value=='')
{ 
  if(document.getElementById('txtPaymentFirstName').value=='')
		{
		alert('Please Enter Shipping To FirstName!');
		document.frmCheckout.txtPaymentFirstName.focus();
		return false;
		}
		else if(document.getElementById('txtPaymentLastName').value=='')
		{
		alert('Please Enter Shipping To LastName!');
		document.frmCheckout.txtPaymentLastName.focus();
		return false;
		}
		else if(document.getElementById('txtPaymentAddress1').value=='')
		{
		alert('Please Enter Shipping To Address 1 !');
		document.frmCheckout.txtPaymentAddress1.focus();
		return false;
		}
		else if(document.getElementById('txtPaymentCity').value=='')
		{
		alert('Please Enter Shipping To City !');
		document.frmCheckout.txtPaymentCity.focus();
		return false;
		}
		else if(document.getElementById('txtPaymentState').value=='')
		{
		alert('Please Enter Shipping To State!');
		document.frmCheckout.txtPaymentState.focus();
		return false;
		
		}
		else if(document.getElementById('txtPaymentcountry').value=='')
		{
		alert('Please Enter Shipping To Country!');
		document.frmCheckout.txtPaymentcountry.focus();
		return false;
		}
		else if(document.getElementById('txtpaymentphone').value=='')
		{
		alert('Please Enter Shipping To Phone No. !');
		document.frmCheckout.txtpaymentphone.focus();
		return false;
		}
 }
 
if(document.getElementById('txtShippingFirstName').value=='')
{
	alert('Please Enter FirstName !');
	document.frmCheckout.txtShippingFirstName.focus();
	return false;
}
else if(document.getElementById('txtShippingLastName').value=='')
{
alert('Please Enter LastName');
document.frmCheckout.txtShippingLastName.focus();
	return false;
}
else if(document.getElementById('txtShippingAddress1').value=='')
{
alert('Please Enter Address 1');
document.frmCheckout.txtShippingAddress1.focus();
	return false;
}
else if(document.getElementById('txtShippingCity').value=='')
{
alert('Please Enter City');
document.frmCheckout.txtShippingCity.focus();
	return false;
}
else if(document.getElementById('txtShippingState').value=='')
{
alert('Please Enter State');
document.frmCheckout.txtShippingState.focus();
	return false;
}
else if(document.getElementById('txtShippingPostalCode').value=='')
{
alert('Please Enter Postal Code');
document.frmCheckout.txtShippingPostalCode.focus();
	return false;
}
else if(document.getElementById('txtShippingcountry').value=='')
{
alert('Please Enter Country');
document.frmCheckout.txtShippingcountry.focus();
	return false;
}
else if(document.getElementById('txtShippingphone').value=='')
{
alert('Please Enter Phone Number !');
document.frmCheckout.txtShippingphone.focus();
	return false;
}
else if(v1=='')
{
alert('Please Enter Email Address !');
document.frmCheckout.v1.focus();
	return false;
}
		

else if(document.getElementById('txtccnum').value=='')
{
alert('Please Enter Credit card Number');
document.frmCheckout.txtccnum.focus();
return false;
}
else if(document.getElementById('txtccname').value=='')
{
alert('Please Enter Name On Credit card');
document.frmCheckout.txtccname.focus();
return false;
}



else if((document.getElementById('txtccexpiredateyear').value=='2011') && (parseInt(crmonth) < parseInt(currmonth)))
{
  
 
		alert('Please check your creditcard Expiration Date');
		
	
}
else if(document.getElementById('txtccv2value').value=='')
{
alert('Please Enter CCV Number');
document.frmCheckout.txtccv2value.focus();
return false;

}
else if(document.getElementById('otcno').value=='')
{
alert('Please Enter OTC Number');
document.frmCheckout.otcno.focus();
return false;
}

else
 if((v1 != v2))
 {
 alert('Please Confirm Your Email Address');
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
		 document.frmCheckout.submit();
		}
	}

function ValidateForm(){
	var emailID=document.frmCheckout.txtShippingemail
	
	if ((emailID.value==null)||(emailID.value=="")){
		alert("Please Enter your Email ID")
		emailID.focus()
		return false
	}
	if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	return true
 }
</script>
<script language = "Javascript">
var digits = "0123456789";
var phoneNumberDelimiters = "()- ";
var validWorldPhoneChars = phoneNumberDelimiters + "+";
var minDigitsInIPhoneNumber = 10;
function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    return true;
}
function trim(s)
{   var i;
    var returnString = "";
    for (i = 0; i < s.length; i++)
    {   
        var c = s.charAt(i);
        if (c != " ") returnString += c;
    }
    return returnString;
}
function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    for (i = 0; i < s.length; i++)
    {   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
var bracket=3
strPhone=trim(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

function Validatenum(){
	var Phone=document.frmCheckout.txtShippingphone
	
	if ((Phone.value==null)||(Phone.value=="")){
		alert("Please Enter your Phone Number")
		Phone.focus()
		return false
	}
	if (checkInternationalPhone(Phone.value)==false){
		alert("Please Enter a Valid Phone Number")
		Phone.value=""
		Phone.focus()
		return false
	}
	return true
 }
 function Validatenumext(){
	var Phone=document.frmCheckout.txtShippingphoneExten
	
	if ((Phone.value==null)||(Phone.value=="")){
		alert("Please Enter your Phone Number")
		Phone.focus()
		return false
	}
	if (checkInternationalPhone(Phone.value)==false){
		alert("Please Enter a Valid Phone Number")
		Phone.value=""
		Phone.focus()
		return false
	}
	return true
 }
function checkName(uname)
{
re = /^[A-Za-z]+$/;
if(re.test(uname.value))
{
}
else
{
alert('Invalid Name.');
}
}
</script> <SCRIPT language=Javascript>
    function chksp1(obj)
{

var name1=obj.value;

var namelength=name1.length;

var i=0;
	for(i=0;i<namelength;i++)
	{	
		if((name1.charCodeAt(i)==39)||(name1.charCodeAt(i)==34)||(name1.charCodeAt(i)==42)||(name1.charCodeAt(i)==36)||(name1.charCodeAt(i)==39)||(name1.charCodeAt(i)==47)||(name1.charCodeAt(i)==58)||(name1.charCodeAt(i)==59)||(name1.charCodeAt(i)==63)||(name1.charCodeAt(i)==92)||(name1.charCodeAt(i)==126))
		{
			alert("Do not type special characters like..\',\",?,*,&.. etc");
			var subst=name1.substring(namelength-1,namelength);
			
			var n2=name1.split(subst);
			
			obj.value=n2[0];
		}
	}
}
function chksp(obj)
{


//alert("hello");
if((event.keyCode<48)||(event.keyCode>57))
{
if(event.keyCode!=46)
{
event.returnValue=false;
}
}

}

function chksp11(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789.-";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }
   </SCRIPT>
<p id="errorMessage"><font color="#FFFFFF"><?php echo $errorMessage; ?></font></p>
			
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
   //if($_SESSION['shipamt44']=="" || $_SESSION['shipamt44']=="0.00")
     //{
        //header('Location: placeanorder.php?view=1&pricingtype=DOLLOR');
     //}
?>
<div class="fillup-form">
        <div class="col-md-12">
           <label class="form-tagline"><strong><span class="req">*</span>Reguired Fields</strong></label>
        </div>
<form action="placeanorder.php?step=2" method="post" name="frmCheckout" id="frmCheckout" onSubmit="return checkShippingAndPaymentInfo();">

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="3" class="col3">
<tr class="dp-prodboxbg01"> 
            <td colspan="3" class="hdone"><strong>Billing Information</strong> </td>
        </tr>
        <tr> 
            
            <td align="left">
                <label><font color="#FF0000">*</font> First Name</label>
                <input name="txtShippingFirstName"
            
            
             <? if($k==1) { ?> value="<? echo $row['FName']; ?>" <? }
			 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['fname']; ?>"<? } else {}
			 
			  ?> type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50"></td>
       
            
            <td align="left">
                <label><font color="#FF0000">*</font> Last Name</label>
                <input name="txtShippingLastName" <? if($k==1) { ?> value="<? echo $row['LName'];
			
			
			 ?>" <? } 
			 
			  else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['lname']; ?>"<? } else {}
			 
			 ?> type="text" class="box" id="txtShippingLastName" size="30" maxlength="50"></td>
       
            <td align="left">
                <label>M Name</label>
                <input name="txtShippingmName" <? if($k==1) { ?> value="<? echo $row['MName']; ?>" <? } ?> type="text" class="box" id="txtShippingmName" size="30" maxlength="50"></td>
        </tr>
		
		<tr style="display:none;"> 
            
            <td align="left"><label>Suffix</label><input name="txtShippingsuffix" <? if($k==1) { ?> value="<? echo $row['Suffix']; ?>" <? } ?> type="text" class="box" id="txtShippingsuffix" size="30" maxlength="50"></td>

            
            <td align="left"><label>Company Name</label><input name="txtShippingcomp" <? if($k==1) { ?> value="<? echo $row['Comp_Name']; ?>" <? } ?> type="text" class="box" id="txtShippingcomp" size="30" maxlength="50"></td>
       
            
            <td align="left"><label><font color="#FF0000">*</font> Address1</label><input name="txtShippingAddress1" <? if($k==1) { ?> value="<? echo $row['Adr1']; ?>" <? } 
			 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_st1']; ?>"<? } else {}
			
			
			?> type="text" class="box" id="txtShippingAddress1" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            
            <td align="left"><label>Address2</label><input name="txtShippingAddress2" <? if($k==1) { ?> value="<? echo $row['Adr2']; ?>" <? } 
				 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_st2']; ?>"<? } else {}
			
			?> type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"></td>
         
            
            <td align="left"><label><font color="#FF0000">*</font> City</label><input name="txtShippingCity" <? if($k==1) { ?> value="<? echo $row['City']; ?>" <? } 
				 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_city']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingCity" size="30" maxlength="32"></td>
        

            <td align="left">            <label><font color="#FF0000">*</font> Province / State</label><input type="text"  name="txtShippingState" <? if($k==1) { ?> value="<? echo $row['State']; ?>" <? } 
				 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_state']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingState" size="30" maxlength="32"></td>
        </tr>
       
        <tr> 
            
            <td align="left"><label><font color="#FF0000">*</font> Postal / Zip Code</label><input name="txtShippingPostalCode" <? if($k==1) { ?> value="<? echo  $row['ZIP']; ?>" <? } 
			 else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_zip']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10"></td>
       
            
            <td align="left"><label><font color="#FF0000">*</font> Country</label><input name="txtShippingcountry" <? if($k==1) { ?> value="<? echo $row['Country']; ?>" <? }  else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_country']; ?>"<? } else {}
			
			?> type="text" class="box" id="txtShippingcountry" size="10" maxlength="10"></td>
       
            
            <td align="left"><label><font color="#FF0000">*</font> Phone</label><input name="txtShippingphone" <? if($k==1) { ?> value="<? echo $row['Phone']; ?>" <? } 
			else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_phone']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingphone" size="10" maxlength="10" onblur="checkInternationalPhone(this);"></td>
        </tr>
		<tr style="display:none;"> 
            <td width="150" align="right">Phone Exten</td>
            <td align="left"><input name="txtShippingphoneExten" <? if($k==1) { ?> value="<? echo $row['Ph_Exten']; ?>" <? } ?> type="text" class="box" id="txtShippingphoneExten" size="10" maxlength="10"></td>
        </tr>
		
		<tr style="display:none;"> 
            <td width="150" align="right">Cell Phone</td>
            <td align="left"><input name="txtShippingcellphone" <? if($k==1) { ?> value="<? echo $row['Cell_Phone']; ?>" <? } ?> type="text" class="box" id="txtShippingcellphone" size="10" maxlength="10"></td>
        </tr>
		
		<tr> 
            
            <td align="left"><label><font color="#FF0000">*</font> Email</label><input name="txtShippingemail" <? if($k==1) { ?> value="<? echo $row['Email_Id']; ?>" <? } else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_email']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingemail" size="50" maxlength="50"></td>
        
            
            <td align="left"><label><font color="#FF0000">*</font> Confirm Email</label><input name="txtShippingemailconfirm" <? if($k==1) { ?> value="<? echo $row['Email_Id']; ?>" <? } 
			
			else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['bill_email']; ?>"<? } else {}
			?> type="text" class="box" id="txtShippingemailconfirm" size="50" maxlength="50"></td>
       
            
            <td align="left"><label>Fax</label>
            <?
				if($k==1) 
				{
					$txtShippingefaxVal1=$row['Fax'];
				}
				else if(isset($_GET['loginid'])) 
				{
					$txtShippingefaxVal1=$rowcust['fax'];
				}
				else
				{
					$txtShippingefaxVal1="";
				} 
			?>
            
            <input name="txtShippingefax"  value="<? echo $txtShippingefaxVal1; ?>"	type="text" class="box" id="txtShippingefax" size="50" maxlength="50">
            
           </td>
        </tr>
		<tr style="display:none;">
		  <td align="right">&nbsp;</td>
		  <td align="left">&nbsp;</td>
    </tr>
</table>
  <? 
  
 
$sid = session_id();
$sql12 = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
	//echo $sql12;die;
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
	//echo "<pre>"; print_r($row12);
  ?>        
            <table width="100%" border="0" align="center" class="col3" cellpadding="2" cellspacing="3"
             <? if($row12['ShippingCode'] != '') { ?> style="display:none;" <? } ?>>
              <tr class="dp-prodboxbg01">
                <td class="hdone">&nbsp;</td>
                <!--<td align="left" class="hdone">Shipping Information</td>-->
              </tr>
              <tr class="dp-prodboxbg01">
                <td width="150" class="hdone"><strong>Shipping Information</strong></td><br>

                
              </tr>
                <tr class="dp-prodboxbg01">
                

                <td align="left"><input type="checkbox" name="chkSame" id="chkSame" value="checkbox"
                 onClick="setPaymentInfo(this.checked);" class="nowidth" style="width: auto !important;
float: left !important;
margin-right: 10px;">
                    <label for="chkSame" style="cursor:pointer; width: auto !important;
">Same as Above </label></td>
              </tr>
                
                
              <tr style="display:none;"> 
                        <td width="150" align="right">Ship to</td>
                        <td align="left"><input name="txtShippingshipto" <? if($k==1) { ?> 
                        value="<? echo $row['Ship_to']; ?>" <? } ?> type="text"
                         class="box" id="txtShippingshipto" size="50" maxlength="50"></td>
                    </tr>
                    <tr  style="display:none;"> 
                        <td width="150" align="right">Ship Title</td>
                        <td align="left"><input name="txtShippingshiptitle" <? if($k==1) { ?>
                         value="<? echo $row['Ship_Title']; ?>" <? } ?> type="text" class="box"
                          id="txtShippingshiptitle" size="50" maxlength="50"></td>
                    </tr>
              <tr>
                
                <td align="left"><label><font color="#FF0000">*</font> First Name</label><input name="txtPaymentFirstName" type="text" <? if($k==1) { ?>
                value="<? echo $row['Ship_FName']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['shipfname']; ?>"<? } else {}
                        ?> class="box" id="txtPaymentFirstName" size="30" maxlength="50"></td>
             
                
                <td align="left"><label><font color="#FF0000">*</font> Last Name</label><input name="txtPaymentLastName"
                 type="text" <? if($k==1) { ?> value="<? echo $row['Ship_LName']; ?>" <? }
				  else if(isset($_GET['loginid'])) { ?> value="<? echo $rowcust['shiplname']; ?>"<? } else {}?> class="box" 
                 id="txtPaymentLastName" size="30" maxlength="50"></td>
             
                
                <td align="left"><label> M Name</label><input name="txtPaymentmName" type="text" 
				<? if($k==1) { ?> value="<? echo $row['Ship_MName']; ?>" <? } ?> 
                class="box" id="txtPaymentmName" size="30" maxlength="50"></td>
              </tr>
              <tr style="display:none;">
                <td width="150" align="right">Suffix</td>
                <td align="left"><input name="txtpaymentsuffix" type="text"
                 <? if($k==1) { ?> value="<? echo $row['Ship_Suffix']; ?>"
                  <? } else if(isset($_GET['loginid'])) { ?>
                   value="<? echo $rowcust['shiplname']; ?>"<? } else {}?> class="box" 
                   id="txtpaymentsuffix" size="30" maxlength="50"></td>
              </tr>
              <tr>
                
                <td align="left"><label> Comp Name</label><input name="txtPaymentcompName"
                 type="text" <? if($k==1) { ?> value="<? echo $row['Ship_Comp_Name']; ?>" <? } ?> 
                 class="box" id="txtPaymentcompName" size="30" maxlength="50"></td>
             
               
                <td align="left"> <label>Address1</label><input name="txtPaymentAddress1" type="text" 
				<? if($k==1) { ?> value="<? echo $row['Ship_Adr1']; ?>" <? }else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_st1']; ?>"<? } else {} ?> class="box" id="txtPaymentAddress1" size="50"
                 maxlength="100"></td>
             
                
                <td align="left"><label><font color="#FF0000">*</font> Address2</label><input name="txtPaymentAddress2" type="text" 
				<? if($k==1) { ?> value="<? echo $row['Ship_Adr2']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_st2']; ?>"<? } else {}?> class="box" id="txtPaymentAddress2" size="50" maxlength="100"></td>
              </tr>
              <tr>
                
                <td align="left"><label><font color="#FF0000">*</font> City</label><input name="txtPaymentCity" type="text" <? if($k==1) { ?> 
                value="<? echo  $row['Ship_City']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_city']; ?>"<? } else {}?> class="box" 
                id="txtPaymentCity" size="30" maxlength="32"></td>
              
                
                <td align="left"><label><font color="#FF0000">*</font> Province / State</label><input name="txtPaymentState" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_State']; ?>" <? } else if(isset($_GET['loginid'])) { ?>
                 value="<? echo $rowcust['ship_state']; ?>"<? } else {}?> class="box" 
                 id="txtPaymentState" size="30" maxlength="32"></td>
              
                
                <td align="left"><label><font color="#FF0000">*</font> Postal / Zip Code</label><input name="txtPaymentPostalCode" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_ZIP']; ?>" <? }else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_zip']; ?>"<? } else {} ?> class="box" 
                id="txtPaymentPostalCode" size="10" maxlength="10"></td>
              </tr>
              <tr>
                
                <td align="left"><label><font color="#FF0000">*</font> Country</label><input name="txtPaymentcountry" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_Country']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_country']; ?>"<? } else {}?> class="box" 
                id="txtPaymentcountry" size="30" maxlength="32"></td>
             
                
                <td align="left"><label><font color="#FF0000">*</font> Phone</label><input name="txtpaymentphone" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_Phone']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                value="<? echo $rowcust['ship_phone']; ?>"<? } else {}?> class="box"
                 id="txtpaymentphone" size="10" maxlength="10"></td>
            
                
                <td align="left"><label><font color="#FF0000">*</font> Email</label><input name="txtPaymentemail" type="text" <? if($k==1) { ?>
                 value="<? echo $row['Ship_Email_Id'];  ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                 value="<? echo $rowcust['ship_email']; ?>"<? } else {}?> class="box" 
                 id="txtPaymentemail" size="50" maxlength="50"></td>
              </tr>
              <tr style="display:none;">
                <td width="150" align="right">Phone Exten</td>
                <td align="left"><input name="txtPaymentphoneext" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_Ph_Exten']; ?>" <? }?> class="box" id="txtPaymentphoneext" 
                size="10" maxlength="10"></td>
              </tr>
              <tr style="display:none;">
                <td width="150" align="right">Cell Phone</td>
                <td align="left"><input name="txtPaymentcellphone" type="text" <? if($k==1) { ?> 
                value="<? echo $row['Ship_Cell_Phone']; ?>" <? }?> class="box" id="txtPaymentcellphone"
                 size="10" maxlength="10"></td>
              </tr>
              
                <tr> 
                        
                        <td align="left"><label>Fax</label><input name="txtPaymentfax" type="text" <? if($k==1) { ?> 
                        value="<? echo $row['Ship_Fax']; ?>" <? } else if(isset($_GET['loginid'])) { ?> 
                        value="<? echo $rowcust['ship_fax']; ?>"<? } else {}?> class="box" 
                        id="txtPaymentfax" size="50" maxlength="50"></td>
                        
                       
                        
              </tr>
              
              
            </table>

<table  width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
 <? if($allowship=="YES") { ?>
 <tr class="dp-prodboxbg01">
    <td  colspan="2" class="hdone">Shipping Information</td>
  </tr>
            <tr><td align="right" >Shipping Airport</td>
            <td align="left">
            <SELECT name="airport">
            <?
            $sqlairport="select * from shipairport";
			$resultairport=mysql_query($sqlairport);
			while($rowairport=mysql_fetch_assoc($resultairport)) 
			{
			?>
            <option value="<? echo $rowairport['AIRPORT']; ?>"><? echo $rowairport['AIRPORT']; ?></option>
            <?
			}
			?>
            </SELECT>
            <? }
			else
			{
			?>
            <input type="hidden" name="airport" id="airport">
            <?
			}
			 ?>
            </td></tr>
            
</table>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="3" style="display:none;">

<tr class="dp-prodboxbg01">
    <td  colspan="2" class="hdone">Coupon</td>
  </tr>
  <tr>
    <td width="28%" align="right">Apply Coupon</td>
    <td width="72%"  align="left"><input type="text" name="couponcode" id="couponcode"></td>	
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="3" class="col3">
  <tr class="dp-prodboxbg01">
    <td  colspan="3" class="hdone"><strong>Payment Information</strong></td>
  </tr>
  <tr>
    
    <td align="left"><label> Payment Method</label><select name="txtpaymentmethod" id="txtpaymentmethod">
    <option value="Visa" <? if($k==1) { ?> 
                <? if($row['Pay_method'] == 'Visa') {?> selected <? } }?>>Visa </option>
	<option value="Master Card"<? if($k==1) { ?> 
                <? if($row['Pay_method'] == 'Master Card') {?> selected <? } }?>>Master Card</option>
	<option value="American Express"<? if($k==1) { ?> 
                <? if($row['Pay_method'] == 'American Express') {?> selected <? } }?>> American Express </option>
	<option value="DISCOVER"<? if($k==1) { ?> 
                <? if($row['Pay_method'] == 'DISCOVER') {?> selected <? } }?>> DISCOVER </option></select></td>	
  
    
    <td  align="left"><label><font color="#FF0000">*</font> Credit Card Number</label><input type="text" name="txtccnum" id="txtccnum" <? if($k==1) { ?> value="<? echo $row['Card_No']; ?>" <? } ?> onkeypress="chksp(this)"></td>
  
    
    <td  align="left"><label><font color="#FF0000">*</font> Name on The Credit Card </label><input type="text" name="txtccname" id="txtccname" <? if($k==1) { ?> value="<? echo $row['Card_Name']; ?>" <? } ?> ></td>
  </tr>
  <tr>
   
    <td  align="left"> <label><font color="#FF0000">*</font> Credit Card Expiration Date (MM/CCYY) </label>
    <? if($k==1) { 
	$dte = $row['Card_Exp']; 
	$dtexp=explode("-",$dte);
	}?>
   
    <input type="hidden" name="currmonth" id="currmonth" value="<? echo date("n"); ?>">
    <select name="txtccexpiredatemonth" id="txtccexpiredatemonth" class="col50" style="float:left;"><? for($mon=01;$mon<=12;$mon++) {?>
    <option value="<? echo $mon; ?>" <? if($k==1) { if($dtexp[0] == $mon){ ?> selected <? } } ?>><? echo $mon; ?></option><? } ?></select>
    <select name="txtccexpiredateyear" id="txtccexpiredateyear" class="col50" style="float:right;"><? for($mon1=2017;$mon1<=2038;$mon1++) {?>
    <option value="<? echo $mon1; ?>" <? if($k==1) { if($dtexp[1] == $mon1){ ?> selected <? } } ?>><? echo $mon1; ?></option><? } ?></select> <br />  </td>
  
    
    
    <td  align="left"><label><font color="#FF0000">*</font> CVV2 Value </label><input type="text" name="txtccv2value" id="txtccv2value" <? if($k==1) { ?> value="<? echo $row['Card_CVV']; ?>" <? } ?>></td>
 <input type="hidden" name="txtcartid" id="txtcartid">
 </tr>
  <tr style="display:none;">
    <td align="right"> OTC NO.</td>
    
    <td  align="left"><input type="text" name="otcno" id="otcno"  value="111" ></td>
 </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td  align="left">&nbsp;</td>
  </tr>
    <tr>
        <td class="button"><input type="button" value="Back" class="btn-reg col50" onClick="history.go(-1)" style="float:left;"> <input name="btnStep1" class="btn-reg col50" type="button" id="btnStep1" value="Proceed &gt;&gt;" onclick="checkemail();" style="float:right">
            <input type="hidden" value="<? echo $row12['ShippingCode']; ?>" name="tracknshipcode" id="tracknshipcode" class="col50" >
        </td>
    </tr>
</table>



</form>
</div>