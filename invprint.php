<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
//error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/config.php';
$orderId = (int)$_GET['oid'];
$orderno=$_GET['orderno'];

//$coupne = $_GET['coupne'];
//echo $coupne; 
$Coupon_Rate = $_GET['Coupon_Rate'];
$Coupon_Amt = $_GET['Coupon_Amt'];
$Qty = $_GET['qty'];
//$Order_rate=$_GET['Order_rate'];
require_once 'library/encrypt1.php';
require_once 'library/cart-functions.php';


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
$tmp_data=mysql_fetch_assoc($resultx);
//$tmp_data=dbFetchAssoc($resultx);
//extract($tmp_data);

// get order information
$sql = "SELECT *
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
$tmp_data1=mysql_fetch_assoc($result);
//$tmp_data1=dbFetchAssoc($result);
//extract(dbFetchAssoc($result));

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
<script>
//setTimeout("window.print();",1000);
//setTimeout("window.close();",1000);
</script>
<style>
	.product-cart {
    	width: 100%;
    	float: left;
    	border-bottom: 1px solid #ccc;
    	padding-bottom: 15px;
    	margin-bottom: 15px;
	}
	h1{color:#FFAE00; font-size:26px;}
	h5{color:#D76C0D;}
	h6{color:#000; text-transform: uppercase; font-size:14px;}
	p{color:#666;}

	.btn-primary{background: #1473e6; border:none;}
	.btn-primary:hover{background: #0d66d0;}
	.product-cart label{font-size:14px; font-weight: normal; color:#666;}
	.cart-pay {
    width: 100%;
    padding-bottom: 5px;
}
.table-responsive 
{
  display: block;
  width: 100%;
  overflow-x: auto;
}
.cart-pay-amount {
    font-weight: bold;
    padding-bottom: 5px;
}
.cart-pay-amount label{font-weight: bold;}
.w50{width:40px;}
.close-icon{vertical-align: text-top;}
.w100{width:100%;}
.m15{margin-top:15px;}
h4 {
    color: #D76C0D;
}
h2{color:#FFAE00; font-size:22px;}
.w150{width:150px;}
table tr th{
	border:1px solid #5cb85c;
	padding:10px;
	background: #5cb85c;
	color:#fff;
}
table tr td{
	border:1px solid #ccc;
	/*padding:10px;*/
}
.red{color:#f00;}
.orange{color:#D76C0D;}
.btn-success{border:none;}
.border-none tr td{border:none;}
</style>
<body>
    
<div class="table table-responsive">
    <form action="" method="get" name="frmOrder" id="frmOrder">
	<table width="100%">
        <tr>
        <td style="text-align: center;" colspan="5" class="hdone"><img src="http://www.savanifarms.com//images/savanifarmslogo.gif" alt="Savani Farms" width="117" height="95" />
        <img src="http://www.savanifarms.com//images/savanifarms.gif" alt="Savani Farms" width="301" height="30" />
        </td>
      </tr>
<tr>
        <tr>
			<td style="text-align: center;"><h2>Your Order</h2></td>
		</tr>
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
				   $dateformat=explode('-',$tmp_data1['Order_Date']);
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
				  echo $mn." ".$dy.",".$yr; ?> &nbsp;</td>
								</tr>
								<tr>
									<td width="50%"><strong>Payment Method</strong></td>
									<td width="50%"><?php  $ccno =  stripslashes(ENCRYPT_DECRYPT($tmp_data['Card_No']));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?>
                      <?php  echo stripslashes(ENCRYPT_DECRYPT($tmp_data['Pay_Method'])).":".$k.$rest; ?></td>
								</tr>
							</table>
							
						</td>
						<td width="35%" align="left" valign="top">
							<h4>Billing Address</h4>
							<p><?php  echo $tmp_data1['FName']." ".$tmp_data1['LName']; ?><br>          
         <?php  echo $tmp_data1['Adr1']; ?> <br><?php  echo $tmp_data1['Adr2']; ?><br>
          <?php  echo $tmp_data1['City']." ".$tmp_data1['State']."-".$tmp_data1['ZIP']; ?><br>
          <?php  echo $tmp_data1['Country']; ?></p>
						</td>
						<td width="35%" align="left" valign="top">
							<h4>Shipping Address</h4>
							<p><?php $sid = session_id();
$sql12 = "SELECT * From orderdata where Order_Id =$orderId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['AIRPORT'] == '') { 
    ?>
           <?php  echo $tmp_data1['Ship_FName']." ".$tmp_data1['Ship_LName']; ?><br>
            <?php  echo $tmp_data1['Ship_Adr1']; ?> <br><?php  echo $tmp_data1['Ship_Adr2']; ?><br>
          <?php  echo $tmp_data1['Ship_City']."  ".$tmp_data1['Ship_State']."-".$tmp_data1['Ship_ZIP']; ?><br>
          <?php  echo $tmp_data1['Ship_Country'];  
      }
else
{
?>
<font class="hdone">Shipping to Airport </font><br /><strong>
<?php echo $row12['AIRPORT']; ?>
<?php }
 ?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
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
                        $subTotal += $Order_rate * $orderd_qty;
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
						<td style="text-align: center;"><?php  echo $orderd_qty; ?><br>
      Box</td>
						<td style="text-align: right;">$<?php  echo number_format($Order_rate,2); ?> / Per Box</td>
						<td style="text-align: right;">$<?php  echo number_format(($orderd_qty * $Order_rate),2); ?></td>
					</tr>
                    <?php 
                            }
                            //echo $coupne."=====".$subTotal;
                            //$discount = $subTotal - (number_format(($subTotal - Get_Percent($coupne,$subTotal)),2));
                                /*if($coupne=='0' || $coupne=="")
                                {	
                                    $discount = 0;
                                }else
                                {
                                    //$discount = Get_Percent($coupne,$subTotal);
                                    $discount = ($subTotal * $coupne)/100;
                                }*/
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
                                        //$discount = $QtyDis * $Coupon_Amt;
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
						<td colspan="1" style="text-align: right;"><?php echo "$".number_format($_GET['shipamt44'],2); ?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Tax</td>
						<td colspan="1" style="text-align: right;">$00.00</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;">Total</td>
						<td colspan="1" style="text-align: right;">$<?php  echo number_format($subTotal + $_GET['shipamt44'] - $discount,2); ?></td>
					</tr>

				</table>
			</td>
		</tr>
        <tr>
			<td>
				<h6 class="red">Terms and Conditions:</h6>
				<ul>
                    <li>The charges will be billed to your credit card at the time of your purchase</li>
                    <li>Delivery in the month of May or June Depending on your order priority.</li> 
                    <li>Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
                    <li>You agree to pay all credit card charges for your purchase made.</li>
                    <li>Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
                    <li>Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
                </ul>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;" class="red">Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.<br>
      www.savanifarms.com</td>
		</tr>
        
        
    </table>
    </form>
</div>
    
<?php /*<table border="1" align="left" width="665" align="center">
<tr>
<td align="center">
<form action="" method="get" name="frmOrder" id="frmOrder">
  <table width="662" border="1"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
  <tr>
        <td colspan=5 class=hdone><img src=http://www.savanifarms.com//images/savanifarmslogo.gif alt=Savani Farms width=117 height=95 />
        <img src=http://www.savanifarms.com//images/savanifarms.gif alt=Savani Farms width=301 height=30 />
        </td>
      </tr>
<tr> 
            <td colspan="2" align="center" class="hdone"><strong>Your Order</strong></td>
</tr>
        <tr> 
            <td align="right" valign="top" class="label"><table width="100%" height="100%" border="1"  align="center" cellpadding="3" cellspacing="1" class="ddepot-blueborder">
                <tr>
                  <td width="155" align="right" class="label" valign="top"><strong>Order Number&nbsp;</strong></td>
                  <td width="166" class="content" align="left" valign="top"><?php  echo $orderno; ?>&nbsp;</td>
              </tr>
                <tr>
                  <td width="155" align="right" valign="top" class="label"><strong>Order Date&nbsp;</strong></td>
                  <td class="content" align="left" valign="top" ><?php 
				   $dateformat=explode('-',$tmp_data1['Order_Date']);
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
				  echo $mn." ".$dy.",".$yr; ?> &nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top" class="label">Payament Method<br>
                      <?php  $ccno =  stripslashes(ENCRYPT_DECRYPT($tmp_data['Card_No']));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?>
                      <?php  echo stripslashes(ENCRYPT_DECRYPT($tmp_data['Pay_Method'])).":".$k.$rest; ?> </td>
                </tr>
              </table></td>
          <td width="291" valign="top" align="right"><table cellpadding="3" cellspacing="1" class="whitbg"><tr><td align="left">
		  <b>Billing Address :</b></td><td  align="left"><b>Shipping Address : </b></td><tr>
          <tr><td align="left" valign="top">
           <?php  echo $tmp_data1['FName']." ".$tmp_data1['LName']; ?><br>          
         <?php  echo $tmp_data1['Adr1']; ?> <br><?php  echo $tmp_data1['Adr2']; ?><br>
          <?php  echo $tmp_data1['City']." ".$tmp_data1['State']."-".$tmp_data1['ZIP']; ?><br>
          <?php  echo $tmp_data1['Country']; ?>
          </td>
          <td align="left" valign="top">
		  <?php $sid = session_id();
$sql12 = "SELECT * From orderdata where Order_Id =$orderId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['AIRPORT'] == '') { 
    ?>
           <?php  echo $tmp_data1['Ship_FName']." ".$tmp_data1['Ship_LName']; ?><br>
            <?php  echo $tmp_data1['Ship_Adr1']; ?> <br><?php  echo $tmp_data1['Ship_Adr2']; ?><br>
          <?php  echo $tmp_data1['Ship_City']."  ".$tmp_data1['Ship_State']."-".$tmp_data1['Ship_ZIP']; ?><br>
          <?php  echo $tmp_data1['Ship_Country'];  
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
          </tr></table>
          </td>
    </tr>
</table>
  

<table width="657" border="1"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
  <!--  <tr id="infoTableHeader"> 
      <td colspan="3" bgcolor="#6699CC" class="hdbg"><strong>Ordered Item&nbsp;</strong></td>
    </tr>-->
    <tr align="center" class="label">
      <td width="35" align="center" valign="middle"><strong>SrNo.</strong></td>
      <td width="296" align="center" valign="middle"><strong>Item</strong></td>
      <td width="25" align="center" valign="middle"><strong>Qty</strong></td>
      <td width="58" align="center" valign="middle"><strong>UnitPrice</strong></td>
      <td width="68" align="center" valign="middle"><strong>Total</strong></td>
  </tr>
<?php 
$numItem  = count($orderedItem);
$subTotal = 0;
$QtyDis = 0 ;    
for ($i = 0; $i < $numItem; $i++)
{
	extract($orderedItem[$i]);
	$subTotal += $Order_rate * $orderd_qty;
    //$QtyDis =$QtyDis + $orderd_qty;
    $QtyDis =$QtyDis + ROUND($DiscQty * $orderd_qty,0);
?>
    <tr class="content"> 
    <td><?php  echo $i+1;; ?></td>
      <td align="left"><font color="#000000"><?php echo "<b>".$ProdHead."</b>"; ?></font><br>
        <font class="hdshopcartfour"><?php echo $ProdName; ?></font><br>        
        <font color="#333333"><?php echo $ProdDesc;  ?></font>        </td>
      <td><?php  echo $orderd_qty; ?><br>
      Box</td>
        <td align="right">$<?php  echo number_format($Order_rate,2); ?> / Per Box</td>
      <td align="right">$<?php  echo number_format(($orderd_qty * $Order_rate),2); ?></td>
  </tr>
<?php 
}
//echo $coupne."=====".$subTotal;
//$discount = $subTotal - (number_format(($subTotal - Get_Percent($coupne,$subTotal)),2));
    <!--if($coupne=='0' || $coupne=="")
	{	
		$discount = 0;
	}else
	{
		//$discount = Get_Percent($coupne,$subTotal);
		$discount = ($subTotal * $coupne)/100;
	}-->
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
            //$discount = $QtyDis * $Coupon_Amt;
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
      <td align="right"><?php echo "$".number_format($_GET['shipamt44'],2); ?></td>
  </tr>
    <tr class="content"> 
        <td colspan="4" align="right"><strong>Tax</strong></td>
        <td align="right">$00.00</td>
  </tr>
    <tr class="content">
      <td colspan="4" align="right"><strong>Total</strong></td>
      <td align="right">$<?php  echo number_format($subTotal + $_GET['shipamt44'] - $discount,2); ?></td>
  </tr>
 <tr class="content"> 
    
      <td colspan="5" align="left">
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
      <td height="37" colspan="5" align="center" valign="middle" class="hdshopcartthree">Please call 1-855-696-2646 in USA or   +91 96 62 30 30 30   in India if you need more information. <br>
      www.savanifarms.com </td>
  </tr>
</table>
  
    </form></td></tr></table></body> */?>