<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
$errorMessage1 ='';
$errorMessage = '';
if(isset($_POST['forgotsubmit']))
{
	$bill_email = mysql_real_escape_string($_POST['forgotemail']);
	//echo $bill_email; die;
	
	$sqlcust="select * from custmast where bill_email ='$bill_email'";
 	//echo $sqlcust; die; 
	$resultcust=mysql_query($sqlcust);
 	if(mysql_num_rows($resultcust) == 0)
	{
		$errorMessage1="THIS EMAIL ADDRESS IS NOT REGISTERED";
	}
	else
	{
		$temppasss=rand(5000000,9000000);
		//echo $temppasss;
		$temppass1 = ENCRYPT_DECRYPT($temppasss);
		$kmo= ENCRYPT_DECRYPT($temppass1);
		$sql    = "UPDATE `custmast` SET `password` = '$temppass1' where `bill_email` = '$bill_email'";
		$result=mysql_query($sql) or die(mysql_error());
		$from='savanifarms@dentaoffice.com';			
		$subject = 'SavaniFarms Your Temporary Password';
		$message  = 'Dear Customer Your Temporary savanifarms password is '.$kmo.'';
		$headers .="MIME-Version: 1.0\n";
		$headers .="Content-Type: text/plain; charset=iso-8859-1\n";
		$headers .="From: ".$from;
		mail($bill_email, $subject, $message, $headers);
		//mail('kishor@dentaoffice.com', $subject, $message, $headers);
		//mail('deepak.dentaweb@gmail.com', $subject, $message, $headers);
		$errorMessage = 'Your savanifarms temporary password is sent to your email address';
		header('Location: changepassword.php');
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
</head>
    
    
<body>
<div class="new-wraper">
    <?php include("header.php"); ?>
    <div class="inner-banner">
      <!--<div class="inner-relative"> <span class="inner-banner-title">Forgot Password</span> </div>-->
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div>
<div id="main-wraper">
<div class="container top">
    
  
    
    
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-6" style="margin:0 auto; display:table; float:inherit;">
          
         
          <div class="fillup-form">
          <div class="col-md-12">
            <label class="form-tagline"><strong><h3>Forgot Password</h3></strong></label>
            
          </div>


        <form name="frorgotpassword" method="post" id="frorgotpassword" action="">
            
            <?php if($errorMessage!='') { echo $errorMessage; } ?>
            
        <?php if($errorMessage1!='') { echo $errorMessage1; } ?>
            
        <div class="col-md-8 col-sm-8 col-xs-12">
                    <label>Enter Email Address:</label>
                    <input type="text" name="forgotemail" id="forgotemail" required>
                  </div>  
            
        <div class="col-md-4 col-sm-4 col-xs-12">
                    <label>&nbsp;</label>
                    <input class="btn-reg" type="submit" name="forgotsubmit" id="forgotsubmit" value="Go">
                  </div>  
           
        </form>
              <div class="col-md-12" style="position:inherit">   
        <p><a href="changepassword.php"><strong>Click here</strong></a> to change your password</p>
            <h4><p>Your Temporary Password will be sent to your Email Address.</p></h4>
            </div> 
              
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
    
    
<?php /*<body>
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
		<form name="frorgotpassword" method="post" id="frorgotpassword" action="">
    <table width="101%" border="0" align="center"  cellpadding="3" cellspacing="3">
	<?php
	 if($errorMessage!='')
	 {
	?>
	<tr>
      <td colspan="2" align="center" style="color:#FF0000;"><strong><?php echo $errorMessage;?></strong></td>
    </tr>
	<tr>
      <td colspan="2" align="center" style="color:#FF0000;"><a href="changepassword.php"><strong>Click here</strong></a> to change your password</td>
    </tr>
	<?php
	 }
	 if($errorMessage1!='')
	 {
	?>
	<tr>
      <td colspan="2" align="center" style="color:#FF0000;"><strong><?php echo $errorMessage1;?></strong></td>
    </tr>
	<?php 
	 }
	?>
    <tr>
      <td colspan="2" align="center" class="hdonebig">Forgot Password</td>
    </tr>
    <tr><td align="right" class="hdshopcartone">Enter Email Address:</td><td align="left"><input type="text" name="forgotemail" id="forgotemail" required><input type="submit" name="forgotsubmit" id="forgotsubmit" value="Go"></td></tr>
    <tr><td align="center" colspan="2"><font color="green"><h3>Your Temporary Password will be sent to your Email Address.</h3></font></td></tr>
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
