<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
require_once('functions.php');
if (!isset($_SESSION['Customer_Id']) || $_SESSION['Customer_Id'] <= 0) {
			header('Location: login.php');
		}
if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: myorder.php');
}

$orderId = (int)$_GET['oid'];

// get ordered items
$sql = "SELECT ProdName, PucrPrice,SellPrice, oi.orderd_qty
	    FROM ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and oi.order_id = $orderId
		ORDER BY order_id ASC";

$result = dbQuery($sql);
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}
// 2 get payment information !
$sqlx = "SELECT Pay_Method, Card_No, Card_Name, Card_Exp, 
         Card_CVV, Cart_Id
	   	 FROM paydetail
		 WHERE Order_Id = $orderId";

$resultx = dbQuery($sqlx);
extract(dbFetchAssoc($resultx));

// get order information
$sql = "SELECT Order_Date, Ship_FName, Ship_LName, Ship_Adr1, 
        Ship_Adr2, Ship_Phone, Ship_State, Ship_City, Ship_ZIP, 
		FName, LName, Adr1, Adr2, Phone,
		State, City, ZIP,od_status
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
extract(dbFetchAssoc($result));
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="maintable"> 
<tr> 
  <td align="left" valign="top"><?php  include('header.php'); ?></td> 
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
        <td align="center" valign="top"> <table width="1063" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td> 
            </tr> 
            <tr> 
              <td colspan="2" align="center" valign="top"> <form action="" method="post" name="frmadd" id="frmadd"> 
                  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" class="ddepot-blueborder"> 
                    <tr> 
                      <td  height="37" colspan="2" align="right" valign="middle"><a href="myaccount.php" style="text-decoration:none;">Edit Profile</a> | <a href="addshipping.php" style="text-decoration:none;">Add Shipping</a> | <a href="myorder.php" style="text-decoration:none;">Order History</a> | <a href="changepassword.php" style="text-decoration:none;">Change Password</a></td> 
                    </tr> 
					<tr> 
                      <td  height="37" colspan="2" align="left" valign="middle" class="hdone">Order Detail&nbsp;</td> 
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
                      <td width="100%" align="right" valign="middle" class="aos-br-comn-blackhd"> 
					    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  								<tr> 
								<td width="150" class="label"><strong>Order Number&nbsp;</strong></td>
								<td class="content"><?php  echo $orderId; ?>&nbsp;</td>
							</tr>
							<tr> 
								<td width="150" class="label"><strong>Order Date&nbsp;</strong></td>
								<td class="content"><?php  echo $Order_Date; ?>&nbsp;</td>
							</tr>
						   
							<tr> 
								<td class="label"><strong>Status&nbsp;</strong></td>
								<td class="content"><?php  echo $od_status; ?>&nbsp;</td>
							</tr>
							<tr>
							    <td colspan="2" align="left"><table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="3" class="hdbg"><strong>Ordered Item&nbsp;</strong></td>
    </tr>
    <tr align="center" class="label"> 
        <td><strong>Item&nbsp;</strong></td>
        <td><strong>Unit Price&nbsp;</strong></td>
        <td><strong>Total&nbsp;</strong></td>
   </tr>
<?php 
$numItem  = count($orderedItem);
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++)
{
	extract($orderedItem[$i]);
	$subTotal += $SellPrice * $orderd_qty;
?>
    <tr class="content"> 
        <td><?php  echo "$orderd_qty X $ProdName"; ?>&nbsp;</td>
        <td align="right"><?php  echo ($SellPrice); ?>&nbsp;</td>
        <td align="right"><?php  echo ($orderd_qty * $SellPrice); ?>&nbsp;</td>
    </tr>
<?php 
}
?>
    <tr class="content"> 
        <td colspan="2" align="right">Sub-total&nbsp;</td>
        <td align="right"><?php  echo ($subTotal); ?>&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Shipping&nbsp;</td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Total&nbsp;</td>
        <td align="right"><?php  echo ($subTotal); ?>&nbsp;</td>
    </tr>
</table></td>
							</tr>
							<tr>
								<td colspan="2" align="left"><table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="2" class="hdbg"><strong>Shipping Information&nbsp;</strong></td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>First Name&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Last Name&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Address1&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Address2&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Phone Number&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Province / State&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>City&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Postal Code&nbsp;</strong></td>
        <td class="content"><?php  echo $Ship_ZIP; ?> &nbsp;</td>
    </tr>
</table></td>
							</tr>
							<tr>
								<td colspan="2" align="left"><table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr> 
        <td colspan="2" class="hdbg"><strong>Billing Information&nbsp;</strong></td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>First Name&nbsp;</strong></td>
        <td class="content"><?php  echo $FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Last Name&nbsp;</strong></td>
        <td class="content"><?php  echo $LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Address1&nbsp;</strong></td>
        <td class="content"><?php  echo $Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Address2&nbsp;</strong></td>
        <td class="content"><?php  echo $Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Phone Number&nbsp;</strong></td>
        <td class="content"><?php  echo $Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Province / State&nbsp;</strong></td>
        <td class="content"><?php  echo $State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>City&nbsp;</strong></td>
        <td class="content"><?php  echo $City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label"><strong>Postal Code&nbsp;</strong></td>
        <td class="content"><?php  echo $ZIP; ?> &nbsp;</td>
    </tr>
</table></td>
							</tr>
 						</table>





					  </td> 
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
        <td align="left" valign="top"><?php  include('footer.php'); ?></td> 
      </tr>  
    </table>
</body>
</html>
