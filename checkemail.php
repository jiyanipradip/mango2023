<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';

if(isset($_POST['checksubmit']))
{    
	$bill_email=$_POST['checkemail'];
    $from='savanifarms@dentaoffice.com';			
    $subject = 'SavaniFarms';
    $body ='<html>
    <body>
    <a href="http://www.savanifarms.com"><img src="http://savanifarms.com/E-mail.jpg" /></a><br />
    </body></html>';
    $headers='MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
    //$headers .= 'From: System Admin <noreply@example.com>' . "\r\n";
    $headers .= "From: ".$from;
    mail($bill_email, $subject, $body, $headers);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Savanifarms</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
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
    <tr>
      <td colspan="2" align="center" class="hdonebig">CHECK EMAIL</td>
    </tr>
    <tr><td align="right" class="hdshopcartone">Enter Email Address:</td><td align="left"><input type="text" name="checkemail" id="checkemail"><input type="submit" name="checksubmit" id="checksubmit" value="Go"></td></tr>
    
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
        
 </td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>