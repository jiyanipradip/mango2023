<?php

require_once '../library/config.php';
require_once './library/functions.php';

$errorMessage = '&nbsp;';

if (isset($_POST['txtUserName'])) {
	$result = doLogin();
	
	if ($result != '') {
		$errorMessage = $result;
	}
}

?>
<html>
<head>
<title>SAVANI FARMS- Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="750" border="0" align="center" cellpadding="0"  class="graybox">
 <tr> 
  <td></td>
 </tr>
 <tr> 
  <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="20">
    <tr> 
     <td class="contentArea"> <form method="post" name="frmLogin" id="frmLogin">
       <p>&nbsp;</p>
       <table width="627" border="0" align="center"  class="ddepot-blueborder">
       
        <tr>
        	<!--FOR LIVE -->
            <!--<td colspan="2" align="center"><a href="<? //echo SAVANI_FARM; ?>"><img src="<?php //echo SAVANI_FARM;?>images/savanifrm-admin-header-top.jpg" width="121%" height="131" alt="Sav-lite" /></td>-->
           
           <!-- FOR LOCAL -->
            <td colspan="2" align="center"><a href=""><img src="../images/savanifrm-admin-header-top.jpg" width="100%" height="131" alt="Sav-lite" /></td>
            </tr>
       
       
        <tr> 
         <td class="hdbg">:: Admin Login ::</td>
        </tr>
        <tr> 
         <td class="contentArea"> 
		 <div class="errorMessage" align="center"><?php echo $errorMessage; ?></div>
		  <table width="100%" border="0" cellpadding="2"  class="text">
           
           <tr class="text"> 
            <td align="right">User Name</td>
            <td><input name="txtUserName" type="text" class="box" id="txtUserName"  size="10" maxlength="20"></td>
           </tr>
           <tr> 
            <td align="right">Password</td>
            <td><input name="txtPassword" type="password" class="box" id="txtPassword"  size="10"></td>
           </tr>
           <tr> 
            <td colspan="2" align="center"><input name="btnLogin" type="submit" class="box" id="btnLogin" value="Login">&nbsp;</td>
            </tr>
           
          </table></td>
        </tr>
         <tr>
            <!--FOR LIVE-->
            <!--<td colspan="2" align="center"><img src="<?php //echo SAVANI_FARM;?>images/savanifrm-admin-header-bottom.jpg" width="100%" height="131" alt="Sav-lite" /></td>-->
         	<!--FOR LOCAL-->  
           <td colspan="2" align="center"><img src="../images/savanifrm-admin-header-bottom.jpg" width="100%" height="131" alt="Sav-lite" /></td>
            </tr>
       </table>
       <p>&nbsp;</p>
      </form></td>
    </tr>
   </table></td>
 </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
