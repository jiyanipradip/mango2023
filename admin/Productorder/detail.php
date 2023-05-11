<?php 
if (!defined('SAVANI_FARM')) {
	exit;
}
require_once '../../library/encrypt1.php';
if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
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
		State, City, ZIP
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
extract(dbFetchAssoc($result));

$sql = "SELECT *
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
extract(dbFetchAssoc($result));

$orderStatus = array('New', 'Paid', 'Shipped', 'Decline', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == $od_status) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$status</option>\r\n";
}
?>
<p>&nbsp; </p>
<form action="" method="get" name="frmOrder" id="frmOrder">
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
        <tr> 
            <td colspan="2" align="center" class="hdbg">Order Detail&nbsp;</td>
        </tr>
        <tr> 
            <td width="150" class="label">Order Number&nbsp;</td>
            <td class="content"><?php  echo $orderId; ?>&nbsp;</td>
        </tr>
        <tr> 
            <td width="150" class="label">Order Date&nbsp;</td>
            <td class="content"><?php  echo $Order_Date; ?>&nbsp;</td>
        </tr>
       
        <tr> 
            <td class="label">Status&nbsp;</td>
            <td class="content"> <select name="cboOrderStatus" id="cboOrderStatus" class="box">
                    <?php  echo $orderOption; ?> </select> <input name="btnModify" type="button" id="btnModify" value="Modify Status" onClick="modifyOrderStatus(<?php  echo $orderId; ?>);">&nbsp;</td>
        </tr>
</table>
</form>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="3" class="hdbg">Ordered Item&nbsp;</td>
    </tr>
    <tr align="center" class="label"> 
        <td>Item&nbsp;</td>
        <td>Unit Price&nbsp;</td>
        <td>Total&nbsp;</td>
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
<?php  
	$sql_dis = "SELECT * FROM couponmaster where Coupon_code='$Coupon_code'";
	$res_dis = mysql_query($sql_dis);
	$data_dis = mysql_fetch_assoc($res_dis);
	//$discount_dis =  $data_dis['Disc_perc'];
	//$discount = ($Prod_Tot * $discount_dis)/100; 
    
            $Disc_perc = $data_dis['Disc_perc'];
            $Disc_Amt = $data_dis['Disc_Amt'];
            if(($Disc_perc=='0' || $Disc_perc=="") && ($Disc_Amt=='0' || $Disc_Amt==""))
            {	
                $discount = 0;
            }
            else
            {
                if($Disc_perc!='0' && $Disc_perc!="")
                {
                    $discount = ($Prod_Tot * $Disc_perc)/100;
                }else{
                    $discount = $orderd_qty * $Disc_Amt;
                }
            }
	 
?>
    <tr class="content"> 
        <td colspan="2" align="right">Sub-total&nbsp;</td>
        <td align="right"><?php  echo ($subTotal); ?>&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Discount&nbsp;</td>
        <td align="right"><?php if($discount>0) { echo "-".number_format($discount,2); }else{ echo number_format($discount,2); } ?>&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Shipping&nbsp;</td>
        <td align="right"><?php echo $Ship_Tot;?></td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Total&nbsp;</td>
        <td align="right"><?php  echo ($subTotal + $Ship_Tot - $discount); ?>&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="2" class="hdbg">Shipping Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">First Name&nbsp;</td>
        <td class="content"><?php  echo $Ship_FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Last Name&nbsp;</td>
        <td class="content"><?php  echo $Ship_LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address1&nbsp;</td>
        <td class="content"><?php  echo $Ship_Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address2&nbsp;</td>
        <td class="content"><?php  echo $Ship_Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Phone Number&nbsp;</td>
        <td class="content"><?php  echo $Ship_Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Province / State&nbsp;</td>
        <td class="content"><?php  echo $Ship_State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">City&nbsp;</td>
        <td class="content"><?php  echo $Ship_City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Postal Code&nbsp;</td>
        <td class="content"><?php  echo $Ship_ZIP; ?> &nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr> 
        <td colspan="2" class="hdbg">Billing Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">First Name&nbsp;</td>
        <td class="content"><?php  echo $FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Last Name&nbsp;</td>
        <td class="content"><?php  echo $LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address1&nbsp;</td>
        <td class="content"><?php  echo $Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address2&nbsp;</td>
        <td class="content"><?php  echo $Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Phone Number&nbsp;</td>
        <td class="content"><?php  echo $Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Province / State&nbsp;</td>
        <td class="content"><?php  echo $State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">City&nbsp;</td>
        <td class="content"><?php  echo $City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Postal Code&nbsp;</td>
        <td class="content"><?php  echo $ZIP; ?> &nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="2" class="hdbg">Payment Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Payment Method&nbsp;</td>
        <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Pay_Method)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card No. &nbsp;</td>
        <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_No)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Name &nbsp;</td>
        <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_Name)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Expire Date &nbsp;</td>
        <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_Exp)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card CCV No. &nbsp;</td>
        <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_CVV)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Id&nbsp;</td>
        <td class="content"><?php  echo $Cart_Id; ?> &nbsp;</td>
    </tr>
   
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center"> 
    <input name="btnBack" type="button" id="btnBack" value="Back" onClick="window.history.back();">
</p>
