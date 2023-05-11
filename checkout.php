<?php 
require_once 'library/config.php';
require_once 'library/cart-functions.php';
require_once 'library/checkout-functions.php';
//require_once 'library/encrypt1.php';

if (isCartEmpty()) {
	// the shopping cart is still empty
	// so checkout is not allowed
	header('Location: cart.php');
}
else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 4)
{
	$step = (int)$_GET['step'];
	$includeFile = '';
	if ($step == 4)
	{
		
		$includeFile = 'newuser.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	}
	else
	if ($step == 1)
	{
		$includeFile = 'step1.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	}
	else if ($step == 2)
	{
		//echo "samir123"; die;
		//echo $includeFile."**";
		$includeFile = 'checkoutConfirmation.php';
		//echo $includeFile; die;
		
		$pageTitle   = 'Checkout - Step 2 of 2';
	}
	else if ($step == 3)
	{
		
		if ($step==3)
		{
			
			$sid = session_id();
	
			$sql = "SELECT * From cartdetail ct,productmast  pd
					WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
			//echo $sql; die;
			
			$result = dbQuery($sql);
			$orderedItem = array();
			while ($row = dbFetchAssoc($result)) {
				$orderedItem[] = $row;
				//print_r($orderedItem)."<pre>";			
			}
		}
		
		$orderId     = saveOrder();
		//echo $orderId; die;
		
		$or=explode("-",$orderId);
		$orderId=$or[0];
		$orderno=$or[1];
		$orderAmount = getOrderAmount($orderId);
		$_SESSION['orderId'] = $orderId;
        $_SESSION['orderno'] = $orderno;
		
		//echo $_SESSION['shipamtses']; die;


/////////////////////////////////////////////////////////////////////////
		if ($step==3)
		{
			/*
			//echo $_SESSION['shipamtses']; die;
			$sql = "SELECT ProdName, PucrPrice,SellPrice,ProdHead,ProdDesc, oi.orderd_qty
					FROM ordermaster oi, productmast p 
					WHERE oi.prod_id = p.PordId and oi.order_id = $orderId
					ORDER BY order_id ASC";
			//echo $sql; 
			$result = dbQuery($sql);
			$orderedItem = array();
			while ($row = dbFetchAssoc($result)) {
				$orderedItem[] = $row;
				//print_r($orderedItem)."<pre>";			
			}*/
			
////////////////////////////////////////////////////////////////////////////////////////			
			
			
			
			//die;
			// 2 get payment information !
			$sqlx = "SELECT Pay_Method, Card_No, Card_Name, Card_Exp, 
					 Card_CVV, Cart_Id
					 FROM paydetail
					 WHERE Order_Id = $orderId";
			
			$resultx = dbQuery($sqlx);
			extract(dbFetchAssoc($resultx));
			
			// get order information
			$sql = "SELECT *
					FROM orderdata
					WHERE Order_Id = $orderId";
			
			//echo $sql; die;
			$result = dbQuery($sql);
			extract(dbFetchAssoc($result));
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php 
/*$tab = "Your Order:\n\r";
$tab .="Sr No.\n\r";
$tab .="Item.\n\r";
$tab .="Qty.\n\r";
$tab .="Unit Price.\n\r";
$tab .="Total.\n\r";*/

			/*$tab="<table width=570 border=0  align=center cellpadding=5 cellspacing=1 class=ddepot-blueborder bgcolor=#FFFFFF style=color:#FFFFFF;>
			
    <tr id=infoTableHeader> 
        <td colspan=5 class=hdbg bgcolor=6096f0><font color=#333333>Your Order&nbsp;</td>
    </tr>
    <tr align=center class=label> 
    <td bgcolor=dcf0ff><font color=#333333><b>Sr No.&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Item&nbsp;</td>
		 <td bgcolor=dcf0ff><font color=#333333><b>Qty&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Unit Price&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Total&nbsp;</td>
   </tr>";*/

$numItem  = count($orderedItem);
//$cartContent = getCartContent();
/*echo "<pre>";
print_r($orderedItem);
echo "</pre>";*/

//echo $_REQUEST['Qty'];
//die;
$numItem     = count($orderedItem);
//echo $numItem; die;
$subTotal = 0;
$QtyDis = 0 ;            
$k='';
for ($i = 0; $i < $numItem; $i++)
{
	//print_r($orderedItem[$i])."<pre>";
	extract($orderedItem[$i]);
	//$Unit_Price = $SellPrice;
	//$Qty = $orderd_qty;
	//echo $Unit_Price; die;
	$subTotal += $Unit_Price  * $Qty;
    //$QtyDis =$QtyDis + $Qty;
    $QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
  // echo $subTotal;
  
$k = $k."SrNo : ".($i+1)."\n\r";
$k .= "Item_name : ".$ProdName."\n\r";
$k .= "Item_description : ".$ProdDesc."\n\r";
$k .= "Quantity : ".$Qty."\n\r";
$k .="Unit_Price  : $". number_format($Unit_Price,2)."\n\r";
//$k .= "Unit_Price  : $".number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2)."\n\r";
$k .= "Total  : $".number_format(($Unit_Price  * $Qty),2)."\n\r";

  /*$k=$k."<tr class=content> 
	<td bgcolor=f0f0f0><font color=#333333>".($i+1)."</td>
        <td align=left bgcolor=f0f0f0><font color=#000000>".
		$ProdHead."<br><font class=hdshopcartfour>".
		$ProdName."
		<br><br><font color=#333333>".$ProdDesc."<br><br>
		</td>
		<td bgcolor=f0f0f0><font color=#333333>".$Qty."<br>BOX</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$".number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2)."/Per Box</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$".number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty),2)."</td>
    </tr>";*/

}
//$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount =0;
	}
	else
	{
		//$discount = Get_Percent($Coupon_Rate,$subTotal);
		//$discount = ($subTotal * $Coupon_Rate)/100;
        if($Coupon_Rate!='0' && $Coupon_Rate!="")
        {
            $discount = ($subTotal * $Coupon_Rate)/100;
        }else{
            $discount = $QtyDis * $Coupon_Amt;
            //$discount = $Coupon_Amt;
        }
	}
$m = "Sub-total : $".number_format($subTotal,2)."\n\r";
//$m = "Discount : -$".number_format($discount,2)."\n\r";
if($discount>0)
{ $m = "Discount : -$".number_format($discount,2)."\n\r"; } else {  $m = "Discount : $".number_format($discount,2)."\n\r"; }

$m .= "Shipping : $".number_format($_SESSION['shipamt44'],2)."\n\r";
$m .= "Tax : $ 00.00\n\r";
$m .= "Total Price : $".number_format($subTotal + $_SESSION['shipamt44'] - $discount,2)."\n\r";
	
/*$m="<tr class=content> 

        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Sub-total&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$".number_format($subTotal,2)."</td>
    </tr>
    <tr class=content> 
	
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Shipping&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$".number_format($_SESSION['shipamt44'],2)."</td>
    </tr>
	<tr class=content>
	 
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Tax&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$00.00&nbsp;</td>
    </tr>
    <tr class=content>
	 
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Total&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$".number_format($subTotal + $_SESSION['shipamt44'],2)."</td>
    </tr>
	<tr class=content> 
      <td colspan=5 align=left bgcolor=f0f0f0><font color=#333333>
      <b>Terms and conditions:</b>
     <ul>
     <li>	The charges will be billed to your credit card at the time of your purchase</li>
     <li>	Delivery will be made to you in the month of May.</li> 
     <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
    <li>	You agree to pay all credit card charges for your purchase made.</li>
     <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
     <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
       </ul>
      </td>
    </tr>
  <tr class=content>
      <td height=37 colspan=5 align=center valign=middle bgcolor=f0f0f0><font color=#333333>Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.</td>
  </tr>
</table>";
*/
//$message_bottom .="Delivery in the month of May or June Depending on your order priority.\n\r";
$message_bottom = "Terms and conditions:\n\r";
$message_bottom .="Delivery in the month of May or June Depending on your order priority.\n\r";
$message_bottom .="Please provide a valid phone number and email address to communicate your confirmed delivery date.\n\r";
$message_bottom .="You agree to pay all credit card charges for your purchase made.\n\r";
$message_bottom .="Your confirmed order delivery is subject to approval by the USDA at the port of entry.\n\r";
$message_bottom .="Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount.\n\r";
$message_bottom .="Please call 1-855-696-2646 in USA or +919662303030 in India if you need more information.\n\r";
			


 $ccno =  stripslashes(ENCRYPT_DECRYPT($Card_No));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$kk='';
		for($ii=0;$ii<($ccno1 - 4);$ii++)
		{
		 $kk.="*";
		}
		//echo $k.$rest;
	 $dateformat=explode('-',$Order_Date);
				  $yr=$dateformat[0];
				  $mn=$dateformat[1];
				  $dy=$dateformat[2];
				  if($mn == '01')
				  {
				  $mn='January';
				  }
				  if($mn == '02')
				  {
				  $mn='February';
				  }
				  if($mn == '03')
				  {
				  $mn='March';
				  }
				  if($mn == '04')
				  {
				  $mn='April';
				  }
				  if($mn == '05')
				  {
				  $mn='May';
				  }
				  if($mn == '06')
				  {
				  $mn='June';
				  }
				  if($mn == '07')
				  {
				  $mn='July';
				  }
				  if($mn == '08')
				  {
				  $mn='August';
				  }
				  
				  if($mn == '09')
				  {
				  $mn='September';
				  }
				  if($mn == '10')
				  {
				  $mn='October';
				  }
				  if($mn == '11')
				  {
				  	$mn='November';
				  }
				  if($mn == '12')
				  {
				  $mn='December';
				  }
				  $ordate = $mn." ".$dy.",".$yr; 
 $sid = session_id();
$sql12 = "SELECT * From orderdata where Order_Id =$orderId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['AIRPORT'] == '') { 
$shipaddress= $Ship_FName.' '.$Ship_LName.'<br>'.
			$Ship_Adr1.' '.$Ship_Adr2.'<br>'.$Ship_City.' '.$Ship_State.'-'.$Ship_ZIP.'<br>'.$Ship_Country.'<br>'.$Ship_Email_Id;
      }
else
{
	$shipaddress='Shipping to Airport : '.$row12['AIRPORT'];
}				  
/*$billaddress= $FName.' '.$LName.'<br>'.
			$Adr1.' '.$Adr2.'<br>'.$City.' '.$State.'-'.$ZIP.'<br>'.$Country.'<br>'.$Email_Id;
$shipaddress= $Ship_FName.' '.$Ship_LName.'<br>'.
			$Ship_Adr1.' '.$Ship_Adr2.'<br>'.$Ship_City.' '.$Ship_State.'-'.$Ship_ZIP.'<br>'.$Ship_Country.'<br>'.$Ship_Email_Id;
*/
$sqlshipmethod = "SELECT METHOD From shipmethod where METHODID =$Ship_Method";
$resultshipmethod = dbQuery($sqlshipmethod);
$rowshipmethod=mysql_fetch_assoc($resultshipmethod);

$billaddress .="".$FName." ".$LName."\n\r";
$billaddress .="".$Adr1." ".$Adr2.",\n\r";
$billaddress .="".$City.",\n\r";
$billaddress .="".$State."-".$ZIP.",\n\r";
$billaddress .="".$Country."\n\r";
$billaddress .="".$Phone."\n\r";
$billaddress .="".$Email_Id."\n\r";

$shipaddress1 .="".$Ship_FName." ".$Ship_LName."\n\r";
$shipaddress1 .="".$Ship_Adr1." ".$Ship_Adr2.",\n\r";
$shipaddress1 .="".$Ship_City.",\n\r";
$shipaddress1 .="".$Ship_State."-".$Ship_ZIP.",\n\r";
$shipaddress1 .="".$Ship_Country."\n\r";
$shipaddress1 .="".$Ship_Phone."\n\r";
$shipaddress1 .="".$Ship_Email_Id."\n\r";


$orderdetail=
"Order Detail"."\n\r".
"Order Number : ".$orderno."\n\r".
"Order Date : ".$ordate."\n\r".
"Payament Method : ".stripslashes(ENCRYPT_DECRYPT($Pay_Method))." : ".$kk.$rest."\n\r".
"Shipping Method : ".$rowshipmethod['METHOD']."\n\r".
"Billing Address : ".strtoupper($billaddress)."\n\r".
"Shipping Address : ".strtoupper($shipaddress1)."\n\r";
	
/*$orderdetail="
<table  width=570 border=0  align=center cellpadding=5 cellspacing=1 class=whitbg>
        <tr>
        <td colspan=5 align=left valign=top bgcolor=#000000><table width=100% border=0 cellspacing=0 cellpadding=0>
          <tr>
            <th width=27% align=center valign=middle scope=row><img src=http://www.savanifarms.com//images/savanifarmslogo.gif alt=Savani farms width=117 height=95 /></th>
            <td width=73% align=left valign=middle><img src=http://www.savanifarms.com//images/savanifarms.gif alt=Savani farms width=301 height=30 /></td>
          </tr>
        </table>
          </td>
      </tr>
		<tr> 
            <td colspan=3 align=center class=hdbg bgcolor=6096f0>Order Detail</td>
        </tr>
        <tr> 
            <td rowspan=2 align=right class=label valign=top>
            
          <table width=100% height=107 border=0  align=left cellpadding=3 cellspacing=5 class=whitbg>
                <tr>
                  <td width=114 align=right class=label valign=top bgcolor=dcf0ff><strong>Order Number&nbsp;</strong></td>
                  <td width=166 class=content align=left valign=top bgcolor=f0f0f0>".$orderno."&nbsp;</td>
                </tr>
                <tr>
                  <td width=114 align=right valign=top class=label bgcolor=dcf0ff><strong>Order Date&nbsp;</strong></td>
                  <td class=content align=left valign=top bgcolor=f0f0f0>".$ordate."&nbsp;</td>
                </tr>
                <tr>
                  <td colspan=2 align=left valign=top class=label bgcolor=f0f0f0><b>Payament Method</b><br>
                  
   ".stripslashes(ENCRYPT_DECRYPT($Pay_Method))." : ".$kk.$rest."</td>
                </tr>
              </table>            </td>
            <td align=left bgcolor=dcf0ff><b>Billing Address</b> </td>
			<td align=left bgcolor=dcf0ff><b>Shipping Address</b> </td>
        </tr>
        <tr> 
            <td class=content valign=top align=left bgcolor=f0f0f0>".$FName." ".$LName."<br>".
			$Adr1." ".$Adr2."<br>".$City." ".$State."-".$ZIP."<br>".$Country."<br>E : ".$Email_Id."</td>
			<td class=content valign=top align=left bgcolor=f0f0f0>".$shipaddress."</td>
        </tr>
</table>";*/
/*
$shippinginfo='
<table border=1  align=center cellpadding=5 cellspacing=1 class=ddepot-blueborder>
    <tr id=infoTableHeader> 
        <td colspan=2 class=hdbg>Shipping Information&nbsp;</td>
    </tr>
    <tr> 
        <td class=label>First Name&nbsp;</td>
        <td class=content>'.$Ship_FName.'</td>
    </tr>
    <tr> 
        <td class=label>Last Name&nbsp;</td>
        <td class=content>'.$Ship_LName.'</td>
    </tr>
    <tr> 
        <td class=label>Address1&nbsp;</td>
        <td class=content>'.$Ship_Adr1.'</td>
    </tr>
    <tr> 
        <td class=label>Address2&nbsp;</td>
        <td class=content>'.$Ship_Adr2.'</td>
    </tr>
    <tr> 
        <td class=label>Phone Number&nbsp;</td>
        <td class=content>'.$Ship_Phone.'</td>
    </tr>
    <tr> 
        <td class=label>Province / State&nbsp;</td>
        <td class=content>'.$Ship_State.'</td>
    </tr>
    <tr> 
        <td class=label>City&nbsp;</td>
        <td class=content>'.$Ship_City.'</td>
    </tr>
    <tr> 
        <td class=label>Postal Code&nbsp;</td>
        <td class=content>'.$Ship_ZIP.'</td>
    </tr>
</table>';

*/
$tablecont=$k.$m.$message_bottom;
$to=$Email_Id;
//$from="savanifarms@dentaoffice.com";			
$from="info@savanifarms.com";			
$subject="SavaniFarms Orderconfirmation Mail".$orderno;

$message = "Dear:".strtoupper($Ship_FName)." ".strtoupper($Ship_LName)."\n\r";
//$message .="Thank You for shopping with Savani Farms! we have received the order , Delivery in the month of May or June Depending on your order priority.Please Keep this email for your record .\n\r";
$message .="Thank You for shopping with Savani Farms! we have received the order , Delivery in the month of May or June Depending on your order priority.Please Keep this email for your record .\n\r";
$message .="".$orderdetail.$tablecont."\n\r";
/*$message="<html><body><br>Dear ".$hidShippingFirstName." ".$hidShippingLastName."<br> Thank You for shopping with 
Savani Farms! we have received the order , Delivery of your order will be in the month of May.
Please Keep this email for your record .<br>".$orderdetail.$tablecont."</body></html>";*/

//echo $tablecont; die;

//echo $message; die;

$headers .="MIME-Version: 1.0\n";
$headers .="Content-Type: text/plain; charset=iso-8859-1\n";
//$headers .="Content-Type: text/html; charset=iso-8859-1\r\n";
//$headers .="Content-Transfer-Encoding: 8bit\r\n";
$headers .="From: ".$from;
//echo $message;die;
mail($to, $subject, $message, $headers);
mail("savanifarms@dentaoffice.com", $subject, $message, $headers);
//mail("deepak.dentaweb@gmail.com", $subject, $message, $headers);
mail("jigneshr.dentaweb@gmail.com", $subject, $message, $headers);
//mail("pradip.dentaweb@gmail.com", $subject, $message, $headers);
mail("kumar@admgllc.com", $subject, $message, $headers);
//mail("kishor@dentaoffice.com", $subject, $message, $headers);

			//header("Location: placeanorder.php?success=success&orderno=".$orderno."&oid=".$orderId);
            header("Location: thankyou.php?success=success");
			exit;
		}
		else
		{
			$includeFile = "abc.php.php";	
		}
	}
}
else
{
	// missing or invalid step number, just redirect
	header('Location: index.php');
}
require_once 'include/header.php';
?>
<script language="JavaScript" type="text/javascript" src="library/checkout.js"></script>
<?php 
require_once "include/$includeFile";
?>