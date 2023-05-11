<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
require_once('functions.php');
if (!isset($_SESSION['Customer_Id']) || $_SESSION['Customer_Id'] <= 0) {
			header('Location: login.php');
		}
		
		
if(isset($_REQUEST["fname"]) && $_REQUEST["fname"]!='')
{
		@extract($_REQUEST);
		$sqlcust = "SELECT bill_email
		        FROM custmast 
				WHERE custid = '".$_SESSION['Customer_Id']."'";	
		$resultcust=mysql_query($sqlcust);
		if(mysql_num_rows($resultcust) == 1)				
			 { 
		$sql = "UPDATE custmast
                 SET
					`fname` = '".addslashes($fname)."',
					`lname` = '".addslashes($lname)."',
					`bill_st1` = '".addslashes($bill_st1)."',
					`bill_st2` = '".addslashes($bill_st2)."',
					`bill_city` = '".addslashes($bill_city)."',
					`bill_state` = '".addslashes($bill_state)."',
					`bill_zip` = '".addslashes($bill_zip)."',
					`bill_country` = '".addslashes($bill_country)."',
					`bill_phone` = '".addslashes($bill_phone)."',
					`shipfname` = '".addslashes($fnameship)."',
					`shiplname` = '".addslashes($lnameship)."',
					`ship_st1` = '".addslashes($bill_st1ship)."',
					`ship_st2` = '".addslashes($bill_st2ship)."',
					`ship_city` = '".addslashes($bill_cityship)."',
					`ship_state` = '".addslashes($bill_stateship)."',
					`ship_zip` = '".addslashes($bill_zipship)."',
					`ship_country` = '".addslashes($bill_countryship)."',
					`ship_phone` = '".addslashes($bill_phoneship)."',
					`ship_email` = '".addslashes($bill_emailship)."',
					`fax` = '".addslashes($bill_fax)."',
					`ship_fax` = '".addslashes($bill_faxship)."'
 				 WHERE bill_email = '".$_SESSION['udepot']."'";
		$result = dbQuery($sql);
		$msg = "Information updated successfully";	 
		}				  
}

$sql = "SELECT *
		        FROM custmast 
				WHERE custid = '".$_SESSION['Customer_Id']."'";	
$result = dbQuery($sql);
@extract(dbFetchAssoc($result));

if($_REQUEST["multipleshipping"]!='')
{
$sql = "SELECT *
		        FROM cust_shipping 
				WHERE id = '".$_REQUEST["multipleshipping"]."'";	
$result = dbQuery($sql);
@extract(dbFetchAssoc($result));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Savanifarms</title>
    
<!-- New Design Start -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link href="cssss/style.css" rel="stylesheet" type="text/css">
<!--<link href="csss/style.css" rel="stylesheet" type="text/css">-->
<link href="cssss/responsive.css" rel="stylesheet" type="text/css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500&display=swap" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="application/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="application/javascript"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- New Design End -->
    
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<script>
function checkemail()
 {
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
		else
		{
		 document.frmadd.submit();
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
						//fnameship.readOnly  = true;
			
		} else {
			
	
		}
	}
}

</script>
</head>
<body>
<div class="new-wraper">
<?php include('header.php'); ?>
    <div class="inner-banner">
      <!--<div class="inner-relative"> <span class="inner-banner-title">Profile Edit</span> </div>-->
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div>
    <p>&nbsp;</p>
<div id="main-wraper">
<div class="container top">
    
  <?php //include("header.php"); ?>
    
    
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          
         <div class="fillup-form">
          <div class="col-md-12">
            <label class="form-tagline"><h5><a href="myaccount.php" style="text-decoration:none;">Edit Profile</a> | <a href="addshipping.php" style="text-decoration:none;">Add Shipping</a> | <a href="myorder.php" style="text-decoration:none;">Order History</a> | <a href="changepassword.php" style="text-decoration:none;">Change Password</a>
            </h5></label><p>&nbsp;</p>
              <label class="form-tagline"><h2>Edit Profile </h2></label><p>&nbsp;</p>
              
              <?php if($msg!='') { ?> 
                <label class="form-tagline" style="color:red;"><h5> <?php echo $msg;?> </h5></label>
            <?php } ?> 
                <label class="form-tagline"><strong><span class="req">*</span>Reguired Fields</strong></label>
              
          </div>

        <form action="" method="post" name="frmadd" id="frmadd"> 
            
        <div class="col-md-12">       
            <label class="form-tagline"><h4> Billing Information </h4></label>
        </div>
                         
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>First Name<span class="req">*</span></label>
                    <input type="text" name="fname" id="fname" size="60" value="<?php echo $fname;?>" maxlength="60">
                  </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Last Name<span class="req">*</span></label>
                    <input type="text" name="lname" id="lname"  size="60" value="<?php echo $lname;?>" maxlength="60">
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Address 1<span class="req">*</span></label>
                    <input type="text" name="bill_st1" id="bill_st1" size="30" value="<?php echo $bill_st1;?>" maxlength="50">
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Address 2</label>
                    <input type="text" name="bill_st2" id="bill_st2"  size="30" value="<?php echo $bill_st2;?>" maxlength="50">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>City<span class="req">*</span></label>
                    <input type="text" name="bill_city" id="bill_city" value="<?php echo $bill_city;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>State<span class="req">*</span></label>
                    <input type="text" name="bill_state" id="bill_state" value="<?php echo $bill_state;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Zip<span class="req">*</span></label>
                    <input type="text" name="bill_zip" id="bill_zip" value="<?php echo $bill_zip;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Country<span class="req">*</span></label>
                    <input type="text" name="bill_country" id="bill_country" value="<?php echo $bill_country;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Phone<span class="req">*</span></label>
                    <input type="text" name="bill_phone" id="bill_phone" value="<?php echo $bill_phone;?>" onkeypress="getchar(this)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off">
            
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Fax</label>
                    <input type="text" name="bill_fax"  class="box" id="bill_fax" value="<?php echo $bill_fax;?>">
                  </div>
        <div class="col-md-12">
        <label class="form-tagline"><h4> Shipping Information </h4></label>
        
            
        <label class="form-tagline">
        <input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"> <label for="chkSame" style="cursor:pointer">Same as Above </label> <strong>OR</strong>  
            <select name="multipleshipping" id="multipleshipping" onchange="javascript:document.frmadd.submit();">
            <option value=""> Select Shipping</option>
				<?php
				$sql = "select id,shipfname,shiplname from cust_shipping where custid = '".$_SESSION['Customer_Id']."'";
				$result = dbQuery($sql);
				if (dbNumRows($result) > 0) {
				$i = 0;
				while($row = dbFetchAssoc($result)) {
				?>
				<option value="<?php echo $row["id"];?>"><?php echo $row["shipfname"].' '.$row["shiplname"];?></option>
				<?php
				}	
				}	
                ?>
                
        </select> &nbsp;&nbsp;&nbsp;<a href="addshipping.php" style="text-decoration:none;">Add Shipping</a></label>
        </div>    
        
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>First Name</label>
                    <input type="text" name="fnameship" id="fnameship" size="60" maxlength="60" value="<?php echo $shipfname;?>">
                  </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Last Name</label>
                    <input type="text" name="lnameship" id="lnameship"  size="60" maxlength="60" value="<?php echo $shiplname;?>">
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Address 1</label>
                    <input type="text" name="bill_st1ship" id="bill_st1ship" size="30" maxlength="50" value="<?php echo $ship_st1;?>">
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Address 2</label>
                    <input type="text" name="bill_st2ship" id="bill_st2ship"  size="30" maxlength="50" value="<?php echo $ship_st2;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>City</label>
                    <input type="text" name="bill_cityship" id="bill_cityship" value="<?php echo $ship_city;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>State</label>
                    <input type="text" name="bill_stateship" id="bill_stateship" value="<?php echo $ship_state;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Zip</label>
                    <input type="text" name="bill_zipship" id="bill_zipship" value="<?php echo $ship_zip;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Country</label>
                    <input type="text" name="bill_countryship" id="bill_countryship" value="<?php echo $ship_country;?>">
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Phone</label>
                    <input type="text" name="bill_phoneship" id="bill_phoneship" value="<?php echo $ship_phone;?>">
            
                  </div>
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>Fax</label>
                    <input type="text" name="bill_faxship" id="bill_faxship" value="<?php echo $ship_fax;?>">
                  </div>
        
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Email</label>
                    <input type="text" name="bill_emailship" id="bill_emailship"  size="60" maxlength="60" value="<?php echo $ship_email;?>">
                  </div>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label>&nbsp;</label>
         <input class="btn-reg" name="btnModify" type="button" id="btnModify" value="Save" onclick="checkemail();">
            </div>    
        
        </form>
      </div>
    </div>
  </div>
</div>  
    
  <?php include("footer.php"); ?>
            
</div>
    </div>
<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
</body>    
    
    
    
<?php /* <body> 
<table width="1081" border="0" cellpadding="0" cellspacing="0" class="maintable"> 
<tr> 
  <td align="left" valign="top"><?php  include('top.php'); ?></td> 
</tr> 
<tr> 
  <td>&nbsp;</td> 
</tr> 
<tr> 
  <td align="center" valign="top"><?php  include('banner.php'); ?></td> 
</tr> 
<tr> 
  <td>&nbsp;</td> 
</tr> 
<tr> 
  <td align="center" valign="top"><table width="1081" border="0" cellspacing="0" cellpadding="0"  class="tableclr"> 
      <tr> 
        <td align="center" valign="top"> <table width="1063" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td> 
            </tr> 
            <tr> 
              <td colspan="2" align="center" valign="top"> <form action="" method="post" name="frmadd" id="frmadd"> 
                  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" class="ddepot-blueborder"> 
                    <tr> 
                      <td  height="37" colspan="2" align="center" valign="middle"><a href="myaccount.php" style="text-decoration:none;">Edit Profile</a> | <a href="addshipping.php" style="text-decoration:none;">Add Shipping</a> | <a href="myorder.php" style="text-decoration:none;">Order History</a> | <a href="changepassword.php" style="text-decoration:none;">Change Password</a></td> 
                    </tr> 
					<tr> 
                      <td  height="37" colspan="2" align="left" valign="middle" class="hdone">Edit Profile </td> 
                    </tr> 
                    <?php 
		    if($msg!='')
		    {
		  ?> 
                    <tr> 
                      <td  height="37" colspan="2" align="center" valign="middle" class="hdbold"><?php echo $msg;?></td> 
                    </tr> 
                    <?php
		    }
		  ?> 
                    <tr class="dp-prodboxbg01"> 
                      <td width="100%" align="right" valign="middle" class="aos-br-comn-blackhd"> <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" class="ddepot-blueborder"> 
                          <tr> 
                            <td colspan="2" class="hdbold" align="left">Billing Information </td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> First Name</td> 
                            <td align="left"> <input type="text" name="fname" class="box" id="fname" size="60" value="<?php echo $fname;?>" maxlength="60"></td> 
                          </tr> 
                          <tr> 
                            <td  align="right"><font color="#FF0000">*</font> Last Name</td> 
                            <td align="left"> <input type="text" name="lname" class="box" id="lname"  size="60" value="<?php echo $lname;?>" maxlength="60"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> Address 1</td> 
                            <td align="left"><input type="text" name="bill_st1" class="box" id="bill_st1" size="30" value="<?php echo $bill_st1;?>" maxlength="50"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"> Address 2</td> 
                            <td align="left"> <input type="text" name="bill_st2" class="box" id="bill_st2"  size="30" value="<?php echo $bill_st2;?>" maxlength="50"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> City</td> 
                            <td align="left"> <input type="text" name="bill_city" class="box" id="bill_city" value="<?php echo $bill_city;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> State</td> 
                            <td align="left"> <input type="text" name="bill_state" class="box" id="bill_state" value="<?php echo $bill_state;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> Zip</td> 
                            <td align="left"> <input type="text" name="bill_zip"  class="box" id="bill_zip" value="<?php echo $bill_zip;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> Country</td> 
                            <td align="left"> <input type="text" name="bill_country" class="box" id="bill_country" value="<?php echo $bill_country;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"><font color="#FF0000">*</font> Phone</td> 
                            <td align="left"> <input type="text" name="bill_phone"  class="box" id="bill_phone" value="<?php echo $bill_phone;?>" onkeypress="getchar(this)" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Fax</td> 
                            <td align="left"> <input type="text" name="bill_fax"  class="box" id="bill_fax" value="<?php echo $bill_fax;?>"></td> 
                          </tr> 
                          <tr> 
                            <td colspan="1" class="hdbold" align="left">Shipping Information</td> 
                            <td align="left"><input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"> 
                              <label for="chkSame" style="cursor:pointer">Same as Above </label> <strong>OR</strong>  
							  <select name="multipleshipping" id="multipleshipping" onchange="javascript:document.frmadd.submit();">
							    <option value=""> Select Shipping</option>
								<?php
								 $sql = "select id,shipfname,shiplname from cust_shipping where custid = '".$_SESSION['Customer_Id']."'";
								 $result = dbQuery($sql);
								 if (dbNumRows($result) > 0) {
									$i = 0;
									while($row = dbFetchAssoc($result)) {
									?>
									<option value="<?php echo $row["id"];?>"><?php echo $row["shipfname"].' '.$row["shiplname"];?></option>
									<?php
									}	
								  }	
								?>
							  </select> &nbsp;&nbsp;&nbsp;<a href="addshipping.php" style="text-decoration:none;">Add Shipping</a>
							  </td> 
                          </tr> 
                          <tr> 
                            <td align="right"> First Name</td> 
                            <td align="left"> <input type="text" name="fnameship" class="box" id="fnameship" size="60" maxlength="60" value="<?php echo $shipfname;?>"></td> 
                          </tr> 
                          <tr> 
                            <td  align="right">Last Name</td> 
                            <td align="left"> <input type="text" name="lnameship" class="box" id="lnameship"  size="60" maxlength="60" value="<?php echo $shiplname;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Address 1</td> 
                            <td align="left"><input type="text" name="bill_st1ship" class="box" id="bill_st1ship" size="30" maxlength="50" value="<?php echo $ship_st1;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right"> Address 2</td> 
                            <td align="left"> <input type="text" name="bill_st2ship" class="box" id="bill_st2ship"  size="30" maxlength="50" value="<?php echo $ship_st2;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">City</td> 
                            <td align="left"> <input type="text" name="bill_cityship" class="box" id="bill_cityship" value="<?php echo $ship_city;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">State</td> 
                            <td align="left"> <input type="text" name="bill_stateship" class="box" id="bill_stateship" value="<?php echo $ship_state;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Zip</td> 
                            <td align="left"> <input type="text" name="bill_zipship"  class="box" id="bill_zipship" value="<?php echo $ship_zip;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Country</td> 
                            <td align="left"> <input type="text" name="bill_countryship" class="box" id="bill_countryship" value="<?php echo $ship_country;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Phone</td> 
                            <td align="left"> <input type="text" name="bill_phoneship"  class="box" id="bill_phoneship" value="<?php echo $ship_phone;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Fax</td> 
                            <td align="left"> <input type="text" name="bill_faxship"  class="box" id="bill_faxship" value="<?php echo $ship_fax;?>"></td> 
                          </tr> 
                          <tr> 
                            <td align="right">Email</td> 
                            <td align="left"> <input type="text" name="bill_emailship"  class="box" id="bill_emailship"  size="60" maxlength="60" value="<?php echo $ship_email;?>"></td> 
                          </tr> 
                          <tr> 
                            <td colspan="2" align="center"> <input name="btnModify" type="button" id="btnModify" value="Save" onclick="checkemail();"> 
&nbsp;&nbsp; </td> 
                          </tr> 
                          <tr> 
                            <td colspan="2" align="center">&nbsp;</td> 
                          </tr> 
                        </table></td> 
                    </tr> 
                    <tr class="dp-prodboxbg01"> 
                      <td align="center" valign="middle" colspan="2">&nbsp;</td> 
                    </tr> 
                  </table> 
                </form></td> 
              <td width="335" align="center" valign="top"><table width="335" border="0" cellspacing="0" cellpadding="0"> 
                  <tr> 
                    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="5" /></td> 
                  </tr> 
                  <tr> 
                    <td align="center" valign="top"><a href="trackyourorders.php"><img src="images/trackyourorder.jpg" width="335" height="84" /></a></td> 
                  </tr> 
                  <tr> 
                    <td><img src="images/spacer.gif" width="1" height="10" /></td> 
                  </tr> 
                  <tr> 
                    <td align="center" valign="top"><a href="missionmango.php"><img src="images/mango_img4.jpg" alt="Mango" width="330" height="347" border="0" /></a></td> 
                  </tr> 
                </table></td> 
            </tr> 
          </table></td> 
      </tr> 
    </table> 
<tr> 
        <td>&nbsp;</td> 
      </tr> 
      <tr> 
        <td align="left" valign="top"><?php  include('bottom.php'); ?></td> 
      </tr> 
      <tr> 
        <td>&nbsp;</td> 
      </tr> 
</table>	  	
    <p>&nbsp;</p> 
    <p>&nbsp;</p> 
</body>  */ ?>
</html>
