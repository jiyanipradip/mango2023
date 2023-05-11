<?php 
if (!defined('SAVANI_FARM')) {
	exit;
}
$self = SAVANI_FARM . 'admin/index.php';
?>
<html>
<head>
<title><?php  echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php  echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php  echo SAVANI_FARM;?>library/common.js"></script>
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
<table width="100%" border="1" bordercolor="#839D44" align="center" cellpadding="0" cellspacing="0">
 <TR>
 	<TD>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><img src="<?php  echo SAVANI_FARM;?>images/savanifrm-admin-header-top.jpg" width="100%" height="131" alt="SavaniFarm" /></td>
              
            </tr>
        </table>
    </TD>
 </TR>   
 
  <tr>  
    <td align="center" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ddepot-blueborder">   
             <tr><td width="4%" class="hdbgk">
                  <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/Green Home icon-Jan10.gif"><br>

             <a href="<?php  echo SAVANI_FARM; ?>">
                 <font color="#B5D926"> <b>Home</b></font></a> </td>
             <td width="4%" class="hdbgk">
           <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/green_home_icon.jpg"><br>
 
             <a href="<?php  echo SAVANI_FARM; ?>admin/">
              <font color="#B5D926"> <b>Admin</b></font></a> </td>
              <td width="5%" align="center" class="hdbgk"> 
              <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/home_icon (1).jpg"><br>
             <a href="<?php  echo SAVANI_FARM; ?>admin/category/index.php?flag=0">
              <font color="#B5D926"><b>Category</b></font></a></td>
             <td width="8%" class="hdbgk">
             
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/home_icon.jpg"><br>
             <a href="<?php  echo SAVANI_FARM; ?>admin/category/index.php?flag=1">
            <font color="#B5D926"> <b>SubCatagory</b></font></a></td>
           <?php /*    <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/product/index.php">Product</a> </td> */?>
            <td width="8%" class="hdbgk">
            <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/Green Home icon-Jan10.gif"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/productmaster/index.php">
             <font color="#B5D926"> <b>ProductMaster</b></font></a> </td>
             <td width="4%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/start-icon.png">
             <br>
             <a href="<?php  echo SAVANI_FARM; ?>admin/order/index.php">
             <font color="#B5D926"> <b>Order</b></font></a>
             </td>
            
            <td width="8%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/start-icon.png">
             <br>
             <a href="<?php  echo SAVANI_FARM; ?>admin/Productorder/index.php">
             <font color="#B5D926"> <b>ProductOrder</b></font></a>
             </td>
                 
            <?php /*
             <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/creditmemo/index.php">Credit Memo</a> </td>
            <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/debitmemo/index.php">Debit Memo</a> </td>
            <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/purchase/index.php">Purchase Bill</a> </td>
            */?>
                 
          	<?php /*<td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/Reports/index.php">Reports</a> </td>
            <td width="4%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/usergreen.jpg"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/user/">
             <font color="#B5D926"> <b>User</b></font></a>  </td>
            <td width="5%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/home_icon (1).jpg"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/vendermaster/">
             <font color="#B5D926"> <b>Vender Master</b></font></a>  </td>*/?>
                 
             <td width="10%" class="hdbgk">
               <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/Green Home icon-Jan10.gif"><br>
             
             <a href="<?php  echo SAVANI_FARM; ?>admin/customermaster/">
              <font color="#B5D926"> <b>Customer Master</b></font></a>  </td>
             <td width="12%" align="center" class="hdbgk"> 
              <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/couponlogo.jpg"><br>
                
              <a href="<?php  echo SAVANI_FARM; ?>admin/couponmaster/index.php?flag=0">
              <font color="#B5D926"><b>Coupom Master</b></font></a>
              </td>
                 
              <td width="8%" class="hdbgk">
              <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/report.gif"><br>
              <a href="<?php  echo SAVANI_FARM; ?>admin/REPORT/excel_report.php">
              <font color="#B5D926"> <b>Order Detail</b></font></a></td>
                 
              <td width="8%" class="hdbgk">
              <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/Invoice_Icon125_128_01.jpg"><br>
              <a href="<?php  echo SAVANI_FARM; ?>admin/Invoice/index.php">
              <font color="#B5D926"><b>Invoice</b></font></a> </td>
                 
            <?php /*   <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/customer/">Customer</a>  </td> 
          	 <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/contract/">Contract</a>  </td>
             <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/customer/index.php?flag=1">Location</a></td> 
             <td class="hdbg"><a href="<?php  echo SAVANI_FARM; ?>admin/UserAccounts/index.php?flag=1">Accounts</a>  </td>
            */?> 
                 
            <td width="4%" class="hdbgk">
            <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/report.gif"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/REPORT/invoice_report.php">
             <font color="#B5D926"> <b>Report</b></font></a></td>
            <td width="4%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/mail.jpg"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/mail_for_customer/User_mail.php">
             <font color="#B5D926"> <b>Mail</b></font></a></td>  
                 <td width="4%" class="hdbgk">
            <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/report.gif"><br>
            
            <a href="<?php  echo SAVANI_FARM; ?>admin/REPORT/zipcode_list.php">
             <font color="#B5D926"> <b>Zipcode</b></font></a></td>
            <td width="4%" class="hdbgk">
             <img height="50" width="50" src="<?php  echo SAVANI_FARM; ?>admin/include/icons/logout.JPG"><br>
            
            <a href="<?php  echo $self; ?>?logout">
             <font color="#B5D926"> <b>Logout</b></font></a></td>
			</table>  	
      	</td>
    </tr>  
        <tr>
          <td>
<?php 
require_once $content;	 
?>
     </td>
    </tr>
    </table>
    <tr><td height="2" COLSPAN="2" valign="top"></td></tr>
</body>
</html>