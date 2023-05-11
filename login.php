<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
require_once('functions.php');
if (isset($_GET['logout']) && $_GET['logout']=='true')
{
	session_destroy();
	$msg = "Logout Successfully";
    session_start();
}
if (isset($_POST['txtuserid']))
{
	$errorMessage = '';
	$userName = mysql_real_escape_string($_POST['txtuserid']);
	//echo $userName;
	$password=$_POST['txtpass'];
	$password1=ENCRYPT_DECRYPT($password);
    //echo $userName."**".$password."<br>";
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	}
    $pass = mysql_real_escape_string($password1);
	$sqlcust = "SELECT custid,bill_email
		        FROM custmast 
				WHERE bill_email='$userName' AND password='$pass'";
    /*$sqlcust = "SELECT *
		        FROM custmast 
				WHERE bill_email = '$userName' AND password = '$password'";*/
    //echo $sqlcust; die;
	$resultcust=mysql_query($sqlcust);
	if(mysql_num_rows($resultcust)==1)				
		 {
            //echo "hi";die;
		    extract(dbFetchAssoc($resultcust)); 
			$_SESSION['dentadepot_user_id'] = $row['user_id'];
			$_SESSION['udepot']=$userName;
			$_SESSION['masterkey']=$userName;
			$_SESSION['MAST']=$userName;
			$_SESSION['Customer_Id']=$custid;
			header("Location: myaccount.php");
			exit;
			} else {
			$errorMessage = 'Wrong username or password';
		}
}
$msg="";
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
<?php include('header.php'); ?>
    <div class="inner-banner">
      <!--<div class="inner-relative"> <span class="inner-banner-title">Login</span> </div>-->
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div>
    <p>&nbsp;</p>
<div id="main-wraper">
<div class="container top">
  
    <?php //include("header.php"); ?>
    
    
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4" style="margin:0 auto; display:table; float:inherit;">
        <div class="wrapper">
              <form class="form-signin" name="userlogin" method="post" id="userlogin"><?php  echo $errorMessage; ?><?php echo $msg;?>
             <h4>Login</h4>
              
              
              <input name="txtuserid" type="text" class="form-control" placeholder="Email" id="txtuserid"
              <?php if(isset($loginid)) { ?> value="<?php echo $loginid; ?>" <?php } ?> required autofocus />
               <div class="clear">&nbsp;</div>
              <input name="txtpass" type="password" class="form-control" id="txtpass" placeholder="Password" required />
                  
              <input type="hidden" name='c1' value='<?php echo $c1?>'>
              <input type="hidden" name='q1' value='<?php echo $q1?>'>
              <input type="hidden" name='p1' value='<?php echo $p1?>'>
                <p>&nbsp;</p>
              <input name="btnLogin" type="submit" class="btn btn-lg btn-primary btn-block" id="btnLogin" value="Login" />
                <div class="clear">&nbsp;</div>
            <a href="register.php">Sign Up</a> | <a href="forgotpassword.php">Forgot Password</a>
              </form>
              
              
              
            
        </div>
      </div>
    </div>
  </div>
  
    <?php include("footer.php"); ?>
    
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
    <td align="center" valign="top"><table width="1081" border="0" cellspacing="0" cellpadding="0" class="tableclr">
      <tr>
        <td align="center" valign="top">
		<table width="1063" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top">
		<form name="userlogin" method="post" id="userlogin"><?php  echo $errorMessage; ?><?php echo $msg;?>
          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" class="ddepot-blueborder">
          <tr>
            <td  height="37" colspan="2" align="center" valign="middle" class="hdbold">Customer Login !! </td>
          </tr>
          <tr class="dp-prodboxbg01">
            <td width="47%" align="right" valign="middle" class="aos-br-comn-blackhd">Login Name </td>
            <td width="53%" height="27" align="left" valign="middle">
            
            <input name="txtuserid" type="text" class="aos-br-comn-input" id="txtuserid"
           <?php if(isset($loginid)) { ?> value="<?php echo $loginid; ?>" <?php } ?> 
            
              required /></td>
          </tr>
		  
          <tr class="dp-prodboxbg01">
            <td height="27" align="right" valign="middle" class="aos-br-comn-blackhd">Password:</td>
            <td height="27" align="left" valign="middle"><input name="txtpass" type="password" class="aos-br-comn-input" id="txtpass" required /></td>
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
            <td align="center" valign="middle" colspan="2">
          <a href="register.php">Sign Up</a> |
          <a href="forgotpassword.php">Forgot Password</a>
          </td>
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
