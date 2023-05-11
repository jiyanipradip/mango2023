<?php require_once 'head.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Savanifarms</title>
<script type="text/javascript" src="AC_RunActiveContent.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script language="javascript">

 function validate()
 {
 
 if (document.form1.name.value=="")
 {
 alert("NAME CANNOT BE LEFT BLANK");
 document.form1.name.focus();
 return false;
 
 }
if (document.form1.phone.value=="")
 {
 alert("PHONE CANNOT BE LEFT BLANK");
 document.form1.phone.focus();
 return false;
 
 }
 
 if (document.form1.email.value=="")
 {
 alert("EMAIL CANNOT BE LEFT BLANK");
 document.form1.email.focus();
 return false;
 
 }


 return true;
 }

</script>

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
    <td align="center" valign="top"><table width="1081" border="0" cellspacing="0" cellpadding="0" class="tableclr">
      <tr>
        <td align="center" valign="top"><?php  include('registermiddle_test.php'); ?></td>
      </tr>
    </table></td>
  </tr>
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
</body>
</html>
