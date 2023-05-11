<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php //$orderId = (int)$_GET['oid'];
require_once 'library/encrypt1.php';
// get ordered items
$sql = "SELECT *
	    FROM orderdata o,ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and o.Order_Id = oi.Order_Id and o.order_id = $orderId 
		ORDER BY o.order_id ASC";

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
$sql = "SELECT *
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
extract(dbFetchAssoc($result));

$orderStatus = array('New', 'Paid', 'Shipped', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == '$od_status') {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$status</option>\r\n";
}
?>

<form action="" method="get" name="frmOrder" id="frmOrder">
<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="30%" align="left" valign="top">
							<table width="100%" class="border-none">
								<tr>
									<td width="50%"><strong>Order Number&nbsp;</strong></td>
									<td width="50%"><?php  echo $orderno; ?>&nbsp;</td>
								</tr>
								<tr>
									<td width="50%"><strong>Order Date&nbsp;</strong></td>
									<td width="50%"><?php  
				  
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
				  echo $mn." ".$dy.",".$yr; ?>&nbsp;</td>
								</tr>
								<tr>
									<td width="50%"><strong>Payament Method</strong></td>
									<td width="50%"><?php  $ccno =  stripslashes(ENCRYPT_DECRYPT($Card_No));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?> 
   <?php  echo stripslashes(ENCRYPT_DECRYPT($Pay_Method)).":".$k.$rest; ?></td>
								</tr>
							</table>
							
						</td>
						<td width="35%" align="left" valign="top">
							<h4>Billing Address</h4>
							<p><?php  echo $FName." ".$LName; ?><br>
          
         <?php  echo $Adr1; ?> <br><?php  echo $Adr2; ?><br>
          
          <?php  echo $City." ".$State."-".$ZIP; ?><br>
          <?php  echo $Country; ?></p>
						</td>
						<td width="35%" align="left" valign="top">
							<h4>Shipping Address</h4>
							<p><?php $sid = session_id();
$sql12 = "SELECT * From orderdata where Order_Id =$orderId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['AIRPORT'] == '') { 
    ?>
           <?php  echo $Ship_FName." ".$Ship_LName; ?><br>
            <?php  echo $Ship_Adr1; ?> <br><?php  echo $Ship_Adr2; ?><br>
          <?php  echo $Ship_City."  ".$Ship_State."-".$Ship_ZIP; ?><br>
          <?php  echo $Ship_Country;  
      }
else
{
?>
<font class="hdone">Shipping to Airport </font><br /><strong>
	
<?php echo $row12['AIRPORT']; ?>
<?php }
 ?> </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
</form>

<tr>
			<td>
				<table>
					<tr>
						<th width="8%" style="text-align: center;">Sr No.</th>
						<th width="57%">Item</th>
						<th width="10%" style="text-align: center;">Qty</th>
						<th width="15%" style="text-align: right;">Unit Price</th>
						<th width="10%" style="text-align: right;">Total</th>
					</tr>
                    <?php 
                    $numItem  = count($orderedItem);
                    $subTotal = 0;
                    $QtyDis = 0 ;    
                    for ($i = 0; $i < $numItem; $i++)
                    {
                        extract($orderedItem[$i]);
                        $subTotal += ($Order_rate) * $orderd_qty;
                        //$QtyDis =$QtyDis + $orderd_qty;
                        $QtyDis =$QtyDis + ROUND($DiscQty * $orderd_qty,0);
                    ?>
					<tr>
						<td style="text-align: center;"><?php  echo $i+1;; ?></td>
						<td>
							<h6><?php echo "<b>".$ProdHead."</b>"; ?></h6>
							<h5><?php echo $ProdName; ?></h5>
							<p><?php echo $ProdDesc;  ?></p>
						</td>
                        
						<td style="text-align: center;"><?php  echo $orderd_qty; ?><br>Box</td>
						<td style="text-align: right;">$<?php  echo number_format($Order_rate,2); ?> / Per Box</td>
						<td style="text-align: right;">$<?php  echo number_format(($orderd_qty * ($Order_rate)),2); ?></td>
					</tr>
                    <?php 
                    }
                    //$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
                     if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
                        {	
                            $discount = 0;
                        }else
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

                    ?>
					<tr>
						<td colspan="4" style="text-align: right;">Sub-Total</td>
						<td colspan="1" style="text-align: right;">$<?php  echo number_format($subTotal,2); ?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Discount</td>
						<td colspan="1" style="text-align: right; font-weight: bold;" class="orange"><?php if($discount>0){ echo "-$".number_format($discount,2); }else{ echo "$".number_format($discount,2); } ?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Shipping</td>
						<td colspan="1" style="text-align: right;"><?php echo "$".number_format($_SESSION['shipamt44'],2); ?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Tax</td>
						<td colspan="1" style="text-align: right;">$00.00</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Total</td>
						<td colspan="1" style="text-align: right;">$<?php  echo number_format($subTotal + $_SESSION['shipamt44'] - $discount ,2); ?></td>
					</tr>

				</table>
			</td>
		</tr>
<tr>
			<td>
				<h6>Terms and Conditions:</h6>
				<ul>
                    <li>The charges will be billed to your credit card at the time of your purchase</li>
                    <li>Delivery in the month on may or June Depending on your order priority</li>
                    <li>Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
                    <li>You agree to pay all credit card charges for your purchase made.</li>
                    <li>Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
                    <li>Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount.</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;" class="red">Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.</td>
		</tr>
    <tr class="content">
     <td colspan="5" align="center"><input type="button" class="btn btn-success btn-sm" name="Print" value="Print"
    onClick="window.open('invprint.php?orderno=<?php echo $orderno; ?>&oid=<?php echo $orderId; ?>&shipamt44=<?php echo $_SESSION['shipamt44']; ?>&qty=<?php echo $QtyDis; ?>&Coupon_Amt=<?php echo $Coupon_Amt; ?>&Coupon_Rate=<?php echo $Coupon_Rate; ?>','mywindow','width=500,height=300,resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no')">     </td> 
    </tr>
<?php 
$sid = session_id();
$sql = "DELETE FROM cartdetail
				        WHERE ct_session_id = '$sid'";
				$result = dbQuery($sql);
session_destroy();								

?>




<?php /* <form action="" method="get" name="frmOrder" id="frmOrder">
<table width="100%" border="1"  align="center" cellpadding="5" cellspacing="1"  class="whitbg">
       
        <tr> 
            <td colspan="2" align="center" class="hdone"><strong>Your Order</strong></td>
</tr>
        <tr> 
            <td align="right" valign="top" class="label">
              <table width="246" height="107" border="1"  align="center" cellpadding="3" cellspacing="1" class="whitbg">
                <tr>
                  <td width="114" align="right" class="label" valign="top"><strong>Order Number&nbsp;</strong></td>
                  <td width="111" class="content" align="left" valign="top"><?php  echo $orderno; ?>&nbsp;</td>
                </tr>
                <tr>
                  <td width="114" align="right" valign="top" class="label"><strong>Order Date&nbsp;</strong></td>
                  <td class="content" align="left" valign="top" ><?php  
				  
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
				  echo $mn." ".$dy.",".$yr; ?>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top" class="label">Payament Method<br>
                   <?php  $ccno =  stripslashes(ENCRYPT_DECRYPT($Card_No));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?> 
   <?php  echo stripslashes(ENCRYPT_DECRYPT($Pay_Method)).":".$k.$rest; ?> 
                  </td>
                </tr>
              </table></td>
          <td width="291" valign="top" align="right">
          <table cellpadding="3" cellspacing="1" class="whitbg"><tr><td align="left">
		  <b>Billing Address :</b></td><td  align="left"><b>Shipping Address : </b></td><tr>
          <tr><td align="left" valign="top">
           <?php  echo $FName." ".$LName; ?><br>
          
         <?php  echo $Adr1; ?> <br><?php  echo $Adr2; ?><br>
          <br>
          <?php  echo $City." ".$State."-".$ZIP; ?><br>
          <?php  echo $Country; ?>
          
		 
          </td>
          <td align="left" valign="top">
		  <?php $sid = session_id();
$sql12 = "SELECT * From orderdata where Order_Id =$orderId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['AIRPORT'] == '') { 
    ?>
           <?php  echo $Ship_FName." ".$Ship_LName; ?><br>
            <?php  echo $Ship_Adr1; ?> <br><?php  echo $Ship_Adr2; ?><br>
          <?php  echo $Ship_City."  ".$Ship_State."-".$Ship_ZIP; ?><br>
          <?php  echo $Ship_Country;  
      }
else
{
?>
<font class="hdone">Shipping to Airport </font><br /><strong>
	<font color="#333333">
<?php echo $row12['AIRPORT']; ?>
<?php }
 ?>    
          
                   </td>
          </tr></table>          </td>
    </tr>
</table>
</form>
<table width="100%" border="1"  align="center" cellpadding="5" cellspacing="1"  class="whitbg">
  <!-- <tr id="infoTableHeader"> 
      <td colspan="3" bgcolor="#6699CC" class="hdbg"><strong>Ordered Item&nbsp;</strong></td>
    </tr> -->
    <tr align="center" class="label">
      <td width="35" align="left"><strong>Sr No.</strong>&nbsp;</td>
      <td width="296" align="left"><strong>Item</strong>&nbsp;</td>
            <td width="25" align="left"><strong>Qty</strong>&nbsp;</td>

      <td width="58" align="right"><strong>Unit Price&nbsp;</strong></td>
      <td width="68" align="right"><strong>Total&nbsp;</strong></td>
  </tr>
<?php 
$numItem  = count($orderedItem);
$subTotal = 0;
$QtyDis = 0 ;    
for ($i = 0; $i < $numItem; $i++)
{
	extract($orderedItem[$i]);
	$subTotal += ($Order_rate) * $orderd_qty;
    //$QtyDis =$QtyDis + $orderd_qty;
    $QtyDis =$QtyDis + ROUND($DiscQty * $orderd_qty,0);
?>
    <tr class="content"> 
    <td><?php  echo $i+1;; ?></td>
      <td align="left"><font color="#000000"><?php echo "<b>".$ProdHead."</b>"; ?></font>
       <br>
       <br>
        <font class="hdshopcartfour"><?php echo $ProdName; ?></font>
       <br><br>
        
        <font color="#333333">
        <?php echo $ProdDesc;  ?></font>
         <br><br />

         <!--<font class="hdshopcarttwo">SHIPPING:</font>
        <br>
         <font class="hdshopcartthree">
        	<?php //echo $SHIPPINGTYPE;  ?>
        </font>    --></td>
      <td><?php  echo $orderd_qty; ?><br>
      Box</td>
        <td align="right">$<?php  echo number_format($Order_rate,2); ?> / Per Box</td>
      <td align="right">$<?php  echo number_format(($orderd_qty * ($Order_rate)),2); ?></td>
  </tr>
<?php 
}
//$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
 if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount = 0;
	}else
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

?>
   
    <tr class="content"> 
    
      <td colspan="4" align="right"><strong>Sub-total</strong></td>
      <td align="right">$<?php  echo number_format($subTotal,2); ?></td>
  </tr>
  <tr class="content"> 
      <td colspan="4" align="right"><strong>Discount</strong></td>
      <td align="right"><font color="#FF0000" size="2"><strong><?php if($discount>0){ echo "-$".number_format($discount,2); }else{ echo "$".number_format($discount,2); } ?></strong></font></td>
      <!--<td align="right"><?php echo "$".number_format($_SESSION['shipamt44'],2); ?></td>-->
  </tr>
  <tr class="content"> 
      <td colspan="4" align="right"><strong>Shipping</strong></td>
      <td align="right"><?php echo "$".number_format($_SESSION['shipamt44'],2); ?></td>
  </tr>
  
    <tr class="content"> 
        <td colspan="4" align="right"><strong>Tax</strong></td>
        <td align="right">$00.00</td>
  </tr>
    <tr class="content">
      <td colspan="4" align="right"><strong>Total</strong></td>
      <td align="right">$<?php  echo number_format($subTotal + $_SESSION['shipamt44'] - $discount ,2); ?></td>
  </tr>
 <tr class="content"> 
    
      <td colspan="5" align="left" class="shopcart">
      <b> Terms and conditions:</b>
     <ul>
     <li>	The charges will be billed to your credit card at the time of your purchase</li>
     <li>	Delivery in the month of May or June Depending on your order priority.</li> 
     <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
     <li>	You agree to pay all credit card charges for your purchase made.</li>
     <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
     <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
       </ul>
      </td>
    </tr>
  <tr class="content">
      <td height="37" colspan="5" align="center" valign="middle" class="hdshopcartthree">Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.</td>
  </tr>
    <tr class="content">
     <td colspan="5" align="center"><input type="button" name="Print" value="Print"
    onClick="window.open('invprint.php?orderno=<?php echo $orderno; ?>&oid=<?php echo $orderId; ?>&shipamt44=<?php echo $_SESSION['shipamt44']; ?>&qty=<?php echo $QtyDis; ?>&Coupon_Amt=<?php echo $Coupon_Amt; ?>&Coupon_Rate=<?php echo $Coupon_Rate; ?>','mywindow','width=500,height=300,resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no')">     </td> 
    </tr>
</table>
<?php 
$sid = session_id();
$sql = "DELETE FROM cartdetail
				        WHERE ct_session_id = '$sid'";
				$result = dbQuery($sql);
session_destroy();								

?> */ ?>
