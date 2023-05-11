<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

$self = SAVANI_FARM . 'admin/index.php';
?>
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php echo SAVANI_FARM;?>library/common.js"></script>
<?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="' . SAVANI_FARM. 'admin/library/' . $script[$i]. '"></script>';
	}
}
?>
</head>
<body>
<table width="750" border="1" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td width="139" align="left" valign="top">
	 <table width="100%" border="1" cellpadding="1" cellspacing="1" class="ddepot-blueborder">
       <TR>
       <td valign="top" class="navArea">&nbsp;<P><P><P></TD>
       </TR>
     <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>">Home</a> </td></tr>
      <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/">Admin</a> </td></tr>
	<TR> <td class="hdbg"> <a href="<?php echo SAVANI_FARM; ?>admin/category/index.php?flag=0">Category</a></td></TR>
  	<TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/category/index.php?flag=1&catId=''">SubCatagory</a></td></TR>
	 <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/product/index.php">Product</a> </td></TR>
	 <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/order/index.php">Order</a> </td></TR>
   	 <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/Invoice/index.php">Invoice</a> </td></TR>
	 <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/user/">User</a>  </td></TR>
	 <TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/customer/">Customer</a>  </td></TR>
	<TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/customer/index.php?flag=1">Location</a></td>  </TR>
	<TR><td class="hdbg"><a href="<?php echo SAVANI_FARM; ?>admin/UserAccounts/index.php?flag=1">Accounts</a>  </td></TR>


	 <TR><td class="hdbg"><a href="<?php echo $self; ?>?logout">Logout</a></td></TR>
     
    
      <TR>
    <td valign="top" class="contentArea">&nbsp;
    </td>
  </tr>
</table></td>
    <td width="602" align="center" valign="top"><table width="100%" border="1" cellpadding="20" cellspacing="0">
        <tr>
          <td>
<?php
require_once $content;	 
?>
     </td>
        </tr>
        
    </table></td>
  </tr>
  <tr><td height="2" COLSPAN="2" valign="top">
   
</TD></TR>
</TABLE>
</body>
</html>
