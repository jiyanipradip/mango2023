<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
$errorMessage = '';
if(isset($_POST['changepass']))
{
	if($_POST['changeemail']=='' || $_POST['currpass']=='' || $_POST['newpass']=='')
	{
		$errorMessage="Please Insert Correct Information";
	}
	else
	{
		$changeemail = mysql_real_escape_string($_POST['changeemail']);
		$currpass = mysql_real_escape_string($_POST['currpass']);
		$newpass = mysql_real_escape_string($_POST['newpass']);
		//echo $newpass; 
		$currpass1 = ENCRYPT_DECRYPT($currpass);
		$sqlcust="select * from custmast where bill_email = '".$changeemail."' and password = '".$currpass1."'";
		//echo $sqlcust; die;
		$resultcust=mysql_query($sqlcust);
		//echo $sqlcust; die;
		if(mysql_num_rows($resultcust) == 0)
		{
			//echo "11";
			$errorMessage="Your Email Address And Password Didn't Match";
		}
		else
		{
			//echo "22";
			//if($_POST["newpass"]===$_POST["confirmedpassword"])
			//{
				$newpass1 = ENCRYPT_DECRYPT($newpass);
				$sql    = "UPDATE `custmast` SET `password` = '".$newpass1."' where `bill_email` = '".$changeemail."'";
		
				//echo $sql; die;
				//echo "hi";die;
				$result=mysql_query($sql) or die(mysql_error());
				$errorMessage="Your Password Changed Successfully";
		/*	}
			else 
			{
				$errorMessage="Your Password And Retype Password Didn't Match";
			}*/
		}
	 }
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
    
<script type="text/javascript">
function Validate() 
{
	// alert('hello');
    var changeemail = document.getElementById("changeemail").value;
    if(changeemail=='')
    {
    		alert("Please Enter Email Address.");
      	return false;
    }
    var currpass = document.getElementById("currpass").value;
    if(currpass=='')
    {
    		alert("Please Enter Temporary Password.");
      	return false;    	
    }
    var newpass = document.getElementById("newpass").value;
    if(newpass=='')
    {
    		alert("Please Enter New Password.");
      	return false;    	
    }
    var confirmedpassword = document.getElementById("confirmedpassword").value;
    if(confirmedpassword=='')
    {
    		alert("Please Enter Retype Password.");
      	return false;    	
    }
    if (newpass != confirmedpassword) 
    {
       	alert("Passwords do not match.");
       	return false;
    }
       	return true;
}
</script>
</head>
    
    
<body>
<div class="new-wraper">
<?php include("header.php"); ?>
        <div class="inner-banner">
      <!--<div class="inner-relative"> <span class="inner-banner-title">Change Password</span> </div>-->
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div>
<div id="main-wraper">
<div class="container top">
    
  
    
    
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          
         
          <div class="fillup-form">
          <div class="col-md-12">
              <br><br>
            <a href="myaccount.php" style="text-decoration:none;">Edit Profile</a> | <a href="addshipping.php" style="text-decoration:none;">Add Shipping</a> | <a href="myorder.php" style="text-decoration:none;">Order History</a> | <a href="changepassword.php" style="text-decoration:none;">Change Password</a> <p>&nbsp;</p>
              
              <?php if($msg!='') { ?> 
                <label class="form-tagline" style="color:red;"><h5> <?php echo $msg;?> </h5></label>
            <?php } ?> 
              <label class="form-tagline"><strong><h2>Change Password</h2></strong></label>
            
              <p>Please Check Your Email Account For Temporary Password<br>
		Enter That Temporary Password Below And Then Enter New Password</p>
          </div>


        <form name="frorgotpassword" method="post" id="frorgotpassword">
            
          <?php if($errorMessage!='') { echo $errorMessage; } ?> 
            
        <p <?php if(isset($showmsg)) { ?>style="display:block" <?php } else { ?>style="display:none" <?php } ?>>
		Please Check Your Email Account For Temporary Password<br>
		Enter That Temporary Password Below And Then Enter New Password
		
	    </p>
            
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Enter Email Address:</label>
                    <input type="text" name="changeemail" id="changeemail">
                  </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Current/Temporary Password</label>
                    <input type="password" name="currpass" id="currpass">
                  </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>New Password</label>
                    <input type="password" name="newpass" id="newpass">
                  </div>     
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Retype Password</label>
                    <input type="password" name="confirmedpassword" id="confirmedpassword">
                  </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>&nbsp;</label>
            <input class="btn-reg" type="submit" name="changepass" id="changepass" value="Change Password" onclick="return Validate()">
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
        <td align="center" valign="top">
		<table width="1063" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top">
		<form name="frorgotpassword" method="post" id="frorgotpassword">
    <table width="101%" border="0" align="center"  cellpadding="3" cellspacing="3">
	<?php
	 if($errorMessage!='')
	 {
	?>
	<tr>
      <td colspan="2" align="center" style="color:#FF0000;"><strong><?php echo $errorMessage;?></strong></td>
    </tr>
	<?php
	 }
	?>
			<tr>
	   <td colspan="2" class="hdonebig"><font color="#009933" size="-1">Please Check Your Email Account For Temporary Password<br>
		Enter That Temporary Password Below And Then Enter New Password</font></td>
	  </tr>
      <tr>
	   <td colspan="2" class="hdonebig">Change Password</td>
	  </tr>
	  <tr <?php if(isset($showmsg)) { ?>style="display:block" <?php } else { ?>style="display:none" <?php } ?>>
		<td colspan="2" align="center"><font color="#009933" size="-1">Please Check Your Email Account For Temporary Password<br>
		Enter That Temporary Password Below And Then Enter New Password
		</td>
	  </tr>
	  <tr>
		<td align="right" class="hdshopcartone">Enter Email Address</td>
		<td align="left"><input type="text" name="changeemail" id="changeemail"></td>
	  </tr>
	  <tr>
		<td align="right" class="hdshopcartone">Current/Temporary Password</td>
		<td align="left"><input type="password" name="currpass" id="currpass"></td>
	  </tr>
	  <tr>
		<td align="right" class="hdshopcartone">New Password</td>
		<td align="left"><input type="password" name="newpass" id="newpass"></td>
	  </tr>
	  <tr>
		<td align="right" class="hdshopcartone">Retype Password</td>
		<td align="left"><input type="password" name="confirmedpassword" id="confirmedpassword"></td>
	  </tr>
	  <tr>
	   <td colspan="2" class="hdonebig" align="center"><input type="submit" name="changepass" id="changepass" value="Change Password" onclick="return Validate()"></td>
	  </tr>
    </table>
    </form>
	
		</td>
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
              </table>
		</td>
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
</body> */ ?>
</html>
