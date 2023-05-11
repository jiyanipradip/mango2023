<?php 
/*
Line 1 : Make sure this file is included instead of requested directly
Line 2 : Check if step is defined and the value is two
Line 3 : The POST request must come from this page but the value of step is one
*/
//echo $shipamt44;
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/cart-functions.php';
$errorMessage = '&nbsp;';
/*
 Make sure all the required field exist is $_POST and the value is not empty
 Note: txtShippingAddress2 and txtPaymentAddress2 are optional
*/
if($_POST['tracknshipcode'] == '')
{
		$requiredField = array('txtShippingFirstName', 'txtShippingLastName', 'txtShippingAddress1', 'txtShippingphone', 'txtShippingState',  'txtShippingCity', 'txtShippingPostalCode',
							   'txtPaymentFirstName', 'txtPaymentLastName', 'txtPaymentAddress1', 'txtpaymentphone', 'txtPaymentState', 'txtPaymentCity', 'txtPaymentPostalCode');
							   
		if (!checkRequiredPost($requiredField)) {
			$errorMessage = 'Input not complete';
		}

}
function validateCC($ccnum,$type){ 

    //Clean up input 
	//echo $type."--".$ccnum;die;
    //$type = strtolower($type); 
    @$ccnum = ereg_replace('[-[:space:]]', '',$ccnum); 


    //Do type specific checks 

    if ($type == 'unknown') { 

        //Skip type specific checks 

    } 
    elseif ($type == 'Master Card'){ 
	
	//echo "hiiiii";die;

        if (strlen($ccnum) != 16 || !ereg('5[1-5]', $ccnum)) 
		{
		$errorMessage="Invalid Format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);
		//die;
		//return 0;
		}
		
		
    } 
    elseif ($type == 'Visa'){ 
        if ((strlen($ccnum) != 13 && strlen($ccnum) != 16) || substr 
($ccnum, 0, 1) != '4'){
		$errorMessage="Credit card number has invalid format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);
		}
    } 
    elseif ($type == 'American Express'){ 
        if (strlen($ccnum) != 15 || !ereg('3[47]', $ccnum)) {
		$errorMessage="Credit card number has invalid format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);
		}
    } 
    elseif ($type == 'DISCOVER'){ 
        if (strlen($ccnum) != 16 || substr($ccnum, 0, 4) != '6011') 
{
		$errorMessage="Credit card number has invalid format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);
		}
    } 
    else { 
        //invalid type entered 
		header("Location: placeanorder.php?step=1&m=1&errorMessage=Invalid Type Entered");
        return -1; 
    } 


    // Start MOD 10 checks 

    $dig = toCharArray($ccnum); 
    $numdig = sizeof ($dig); 
    $j = 0; 
    for ($i=($numdig-2); $i>=0; $i-=2){ 
        $dbl[$j] = $dig[$i] * 2; 
        $j++; 
    }     
    $dblsz = sizeof($dbl); 
    $validate =0; 
    for ($i=0;$i<$dblsz;$i++){ 
        $add = toCharArray($dbl[$i]); 
        for ($j=0;$j<sizeof($add);$j++){ 
            $validate += $add[$j]; 
        } 
    $add = ''; 
    } 
    for ($i=($numdig-1); $i>=0; $i-=2){ 
        $validate += $dig[$i]; 
    } 
    if (substr($validate, -1, 1) == '0') return 1; 
    else return 0; 
} 


// takes a string and returns an array of characters 

function toCharArray($input){ 
    $len = strlen($input); 
    for ($j=0;$j<$len;$j++){ 
        $char[$j] = substr($input, $j, 1);     
    } 
    return ($char); 
} 

function CheckCVV($cardNumber, $cvv) {
$firstnumber = (int) substr($cardNumber, 0, 1);
if ($firstnumber === 3)
 {
	if (!preg_match("/^\d{4}$/", $cvv))
	{

$errorMessage="CVV number has invalid format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);

	}
	else
	{
	 return true;
	}
 }
else if (!preg_match("/^\d{3}$/", $cvv))
 {
 	$errorMessage="CVV number has invalid format";
		header("Location: placeanorder.php?step=1&m=1&errorMessage=".$errorMessage);

 }
 else
 {
return true; } 	
}



$cartContent = getCartContent();
{
					$hidShippingFirstName	  =$_POST['txtShippingFirstName'];
					$hidShippingLastName	  =$_POST['txtShippingLastName']; 
					$hidShippingShippingmName =$_POST['txtShippingmName']; 
					$hidShippingsuffix		  =$_POST['txtShippingsuffix']; 
					$hidShippingcomp		  =$_POST['txtShippingcomp']; 
					$hidShippingAddress1	  =$_POST['txtShippingAddress1']; 
					$hidShippingAddress2	  =$_POST['txtShippingAddress2']; 
					$hidShippingCity		  =$_POST['txtShippingCity']; 
					$hidShippingState		  =$_POST['txtShippingState']; 
					$hidShippingPostalCode	  =$_POST['txtShippingPostalCode']; 
					$hidShippingcountry		  =$_POST['txtShippingcountry']; 
					$hidShippingphone		  =$_POST['txtShippingphone']; 
					$hidShippingcellphone	  =$_POST['txtShippingcellphone']; 
					$hidShippingemail		  =$_POST['txtShippingemail'];
					$hidShippingemailconfirm  =$_POST['txtShippingemailconfirm']; 
					$hidShippingfax			  =$_POST['txtShippingefax']; 
					$hidShippingshipto		  =$_POST['txtShippingshipto']; 
					$hidShippingshiptitle	  =$_POST['txtShippingshiptitle']; 
					$hidPaymentFirstName	  =$_POST['txtPaymentFirstName'];
					$hidPaymentLastName		  =$_POST['txtPaymentLastName'];
					$hidPaymentmName		  =$_POST['txtPaymentmName'];
					$hidpaymentsuffixe		  =$_POST['txtpaymentsuffix'];
					$hidPaymentcompName		  =$_POST['txtPaymentcompName']; 
					$hidPaymentAddress1		  =$_POST['txtPaymentAddress1']; 
					$hidPaymentAddress2		  =$_POST['txtPaymentAddress2']; 
					$hidPaymentCity			  =$_POST['txtPaymentCity']; 
					$hidPaymentState		  =$_POST['txtPaymentState']; 
					$hidPaymentPostalCode	  =$_POST['txtPaymentPostalCode']; 
					$hidPaymentcountry		  =$_POST['txtPaymentcountry']; 
					$hidpaymentphone		  =$_POST['txtpaymentphone']; 
					$hidPaymentphoneext		  =$_POST['txtPaymentphoneext']; 
					$hidPaymentcellphone      =$_POST['txtPaymentcellphone']; 
					$hidPaymentemail		  =$_POST['txtPaymentemail']; 
					$hidPaymentfax			  =$_POST['txtPaymentfax'];
					$hidPaymethod			  =$_POST['txtpaymentmethod'];
					$hidPayccnum			  =$_POST['txtccnum'];
					$hidPayccname			  =$_POST['txtccname'];
					validateCC($hidPayccnum,$hidPaymethod);
					
					$hidPayexpdate			  =$_POST['txtccexpiredatemonth']."-".$_POST['txtccexpiredateyear'];
					$hidPaycc2v				  =$_POST['txtccv2value'];
					CheckCVV($hidPayccnum,$hidPaycc2v);

					$hidotcno				  =$_POST['otcno'];

					require_once 'encrypt1.php';
					
                      $Str_fname =$hidShippingFirstName; 
					  $Str_lname =$hidShippingLastName; 
                      $Str_mname =$hidShippingShippingmName; 
					  $Str_suffix =$hidShippingsuffix; 
					  $Str_Comp_Name =$hidShippingcomp; 
                      $Str_Adr1 = $hidShippingAddress1; 
					  $Str_Adr2 = $hidShippingAddress2; 
					  $Str_City = $hidShippingCity; 
                      $Str_State = $hidShippingState; 
					  $Str_ZIP = $hidShippingPostalCode; 
					  $Str_Country =$hidShippingcountry; 
                      $Str_Phone = $hidShippingphone; 
					  $Str_Ph_Exten =$hidShippingphone; 
					  $Str_Cell_Phone =$hidShippingcellphone; 
                      $Str_Fax = $hidShippingfax; 
					  $Str_Email_Id =$hidShippingemail; 
					  $Str_ship2 = $hidShippingshipto; 
					  $Str_shiptitle =$hidShippingshiptitle; 
                      $Str_payfname = $hidPaymentFirstName; 
					  $Str_paylname = $hidPaymentLastName; 
					  $Str_paymname = $hidPaymentmName; 
                      $Str_paysuffix = $hidpaymentsuffixe; 
					  $Str_paycompname = $hidPaymentcompName; 
					  $Str_pay_add1 = $hidPaymentAddress1; 
                      $Str_pay_add2 = $hidPaymentAddress2; 
					  $Str_pay_city = $hidPaymentCity; 
					  $Str_paystate = $hidPaymentState; 
                      $Str_zip = $hidPaymentPostalCode; 
					  $Str_paycountry = $hidPaymentcountry; 
					  $Str_pay_phone = $hidpaymentphone; 
                      $Str_pay_phoneext =$hidPaymentphoneext; 
					  $Str_pay_cell =$hidPaymentcellphone; 
					  $Str_pay_fax =$hidPaymentfax; 
                      $Str_pay_email =$hidPaymentemail; 
					  $Str_pay_method =$hidPaymethod; 
                      $Str_pay_ccnum = $hidPayccnum; 
                      $Str_pay_ccname =$hidPayccname; 
                      $Str_pay_expdate =$hidPayexpdate; 
                      $Str_pay_cc2v = $hidPaycc2v; 
                       $Str_pay_hidotcno = $hidotcno; 
					$hir = mysql_real_escape_string($Str_fname); 
					$hir1 = mysql_real_escape_string($Str_Phone);
					$hir2 = mysql_real_escape_string($Str_Ph_Exten);
					$hir3 = mysql_real_escape_string($Str_pay_phone);
					$hir4 = mysql_real_escape_string($Str_pay_phoneext);
					$couponcode=$_POST['couponcode'];
		if ($_POST['couponcode'] != '') 
		{
			$couponcode=$_POST['couponcode'];
			$sqlcoupon="select * from couponmaster where Coupon_code='$couponcode'";
			$resultcoupon=mysql_query($sqlcoupon);
			if(mysql_num_rows($resultcoupon) ==0)
				{
					header("Location: placeanorder.php?step=1&m=1&errorMessage=Invalid Coupon Code");
				}
		}		
				
				$sql = "INSERT INTO orderdatatemp(`Customer_Id`,`FName`, `LName`, `MName`, `Suffix`, `Comp_Name`,
				 								  `Adr1`, `Adr2`, `City`, `State`, `ZIP`, `Country`,
												  `Phone`, `Ph_Exten`, `Cell_Phone`, `Fax`, `Email_Id`,
												  `Ship_to`, `Ship_Title`, `Ship_FName`, `Ship_LName`, `Ship_MName`,
												  `Ship_Suffix`, `Ship_Comp_Name`, `Ship_Adr1`, `Ship_Adr2`, `Ship_City`,
												  `Ship_State`, `Ship_ZIP`, `Ship_Country`, `Ship_Phone`, `Ship_Ph_Exten`, 
												  `Ship_Cell_Phone`, `Ship_Fax`, `Ship_Email_Id`,`Pay_method`,`Card_No`,`Card_Name`,`Card_Exp`,`Card_CVV`,`OTC_NO`)
                VALUES ('".$_SESSION['Customer_Id']."','$hir', '$Str_lname','$Str_mname','$Str_suffix','$Str_Comp_Name',
						'$Str_Adr1','$Str_Adr2','$Str_City','$Str_State','$Str_ZIP','$Str_Country','$hir1','$hir2','$Str_Cell_Phone','$Str_Fax','$Str_Email_Id',
						'$Str_ship2','$Str_shiptitle','$Str_payfname','$Str_paylname','$Str_paymname',
						'$Str_paysuffix','$Str_paycompname','$Str_pay_add1','$Str_pay_add2','$Str_pay_city',
						'$Str_paystate','$Str_zip','$Str_paycountry','$hir3','$hir4',
						'$Str_pay_cell','$Str_pay_fax','$Str_pay_email','$Str_pay_method','$Str_pay_ccnum','$Str_pay_ccname','$Str_pay_expdate','$Str_pay_cc2v','$Str_pay_hidotcno')";
		$result = dbQuery($sql);
}
?>

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
	padding:10px;
}
.red{color:#f00;}
.orange{color:#D76C0D;}
.btn-success{border:none;}
</style>

<script language="javascript">
function checkselection()
{
	if(document.getElementById('towhomthanks').value=='')
	{
		alert('Please Select Whom may we thank for referring you?');
		document.getElementById('towhom').style.backgroundColor='#ffcc00';
	}
	else
	{
			 document.frmCheckout.submit();

	}
}
</script>

<div class="table">
	<table width="100%">
		<tr>
			<td style="text-align: center;"><h1>Step 2 Of 3 : Confirm Order</h1></td>
		</tr>
        <tr>
			<td style="text-align: center;"><?php  echo $errorMessage; ?></td>
		</tr>
        
        <tr>
			<td><marquee> <font color="#333333">Please review you order for accuracy before clicking the 'complete purchase' button. Delivery in the month of May or June Depending on your order priority. </marquee></td>
		</tr>
        
        <form action="<?php  echo $_SERVER['PHP_SELF']; ?>?step=3" method="post" name="frmCheckout" id="frmCheckout">
            
            <tr>
			<td>
				<table width="100%">
					<tr>
						<td width="70%" align="left" valign="top">
							<h4>Billing Address</h4>
                            
							<p><?php  echo $_POST['txtShippingFirstName']." "; ?>
                            <?php  echo $_POST['txtShippingLastName']; ?><br>
                            <?php  echo $_POST['txtShippingAddress1']; ?><br>
                            <?php  echo $_POST['txtShippingAddress2']; ?><br>
                            <?php  echo $_POST['txtShippingCity']." "; ?> 
                            <?php  echo $_POST['txtShippingState']; ?> - 
                            <?php  echo $_POST['txtShippingPostalCode']; ?><br>
                            <?php  echo $_POST['txtShippingcountry']; ?></p>
                            
							
							<p><?php $sid = session_id();
$sql12 = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['ShippingCode'] == '') { ?>
   <h4>Shipping Address</h4>

 <?php  echo $_POST['txtPaymentFirstName']." "; ?>
 <?php  echo $_POST['txtPaymentLastName']; ?><br>
 <?php  echo $_POST['txtPaymentAddress1']."  "; ?><br>
 <?php  echo $_POST['txtPaymentAddress2']; ?><br>
 <?php  echo $_POST['txtPaymentCity']." "; ?>  <?php  echo $_POST['txtPaymentState']; ?> - 
 <?php  echo $_POST['txtPaymentPostalCode']; ?><br>
 <?php  echo $_POST['txtPaymentcountry'];  
}
else
{
?>
<font class="hdone">Shipping to Airport </font><br />
<?php echo $_POST['airport']; ?>
<?php }
 ?></p>
							
						</td>
						<td width="30%" align="left" valign="top">
							<h4>Payment Method</h4>
							<p><?php  $ccno =  $_POST['txtccnum'];
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?> 
   <?php  echo $_POST['txtpaymentmethod'].":".$k.$rest; ?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
    
    <tr>
			<td style="text-align: center;"><h2>Your Order</h2></td>
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
$numItem  = count($cartContent);
$subTotal = 0;
$QtyDis = 0 ; 
for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$subTotal += $Unit_Price * $Qty;
    //$QtyDis =$QtyDis + $Qty;
    $QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
	//$subTotal += ($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty;
	
?>
      <tr class="content">
      <td class="dp-prod-matter"><font color="#333333"><?php  echo $i+1; ?></td>
        <td align="left" valign="top" class="dp-prod-matter">
		<font color="#000000"><?php echo "<b>".$ProdHead."</b>"; ?></font>
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
        	<?php //echo $SHIPPINGTYPE;  ?>        </font>  -->       </td>
                <td class="dp-prod-matter"><font color="#333333"><?php  echo $Qty; ?><br> BOX</td>

        <td align="right" class="dp-prod-matter"><font color="#333333">
        $<?php echo number_format($Unit_Price,2); //echo number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2); ?> / <br>PER BOX</td>
        <td align="right" class="dp-prod-matter"><font color="#333333">$<?php  echo number_format($Unit_Price * $Qty,2); //echo number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty),2); ?></td>
      </tr>
      <?php 
}
	//$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
	if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount = 0;
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
	//echo $discount;
  	$shipamt_new = $subTotal + $_SESSION['shipamt44'] - $discount;
	//echo $shipamt_new;
?>
      <tr class="content">
      <td colspan="2" align="left">
	   <?php if($Coupon_code !='0' && $Coupon_code !='') { echo "<b>Coupon Code : ".$Coupon_code; }?></td>
        <td class="dp-prod-matter" colspan="2" align="right"><font color="#333333">Sub-total</td>
        <td class="dp-prod-matter" align="right"><font color="#333333">$<?php  echo number_format(($subTotal),2); ?></font></td>
      </tr>
      <tr class="content">
        <td class="dp-prod-matter" colspan="4" align="right"><font color="#333333">Discount</td>
        <td class="dp-prod-matter" align="right"><font color="#FF0000" size="2"><strong><?php if($discount>0){ echo "-$".number_format($discount,2); }else{ echo "$".number_format($discount,2); } ?></strong></font></td>
      </tr>
      <tr class="content">
        <td class="dp-prod-matter" colspan="4" align="right"><font color="#333333">Shipping</td>
        <td class="dp-prod-matter" align="right"><font color="#333333">$<font color="#333333"><?php  echo number_format($_SESSION['shipamt44'],2); ?></font></font></td>
      </tr>
       <tr class="content">
        <td class="hdshopcartblk" colspan="4" align="right">Tax</td>
        <td class="hdshopcartblk" align="right">$<?php  echo "00.00"; ?></td>
      </tr>
      <tr class="content">
        <td class="hdshopcartblk" colspan="4" align="right">Total</td>
        <td class="hdshopcartblk" align="right">$<?php  echo number_format(($shipamt_new),2); //echo number_format(($subTotal + $_SESSION['shipamt44']),2); ?></td>
      </tr>

				</table>
			</td>
		</tr>
    <tr>
        <td>
        <h6 class="red"> Terms and conditions:</h6>
   	  <ul>
     <li>	The charges will be billed to your credit card at the time of your purchase</li>
     <li>	Delivery in the month of May or June Depending on your order priority.</li> 
     <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
    <li>	You agree to pay all credit card charges for your purchase made.</li>
     <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
     <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
            </ul>     </td>      </tr>
            
    <tr>
    <td class="red">Please call 1-855-696-2646 in USA or +91 96 62 30 30 30   in India if you need more information.</td>
  </tr>
  <tr style="display:none;">
    <td align="left" valign="top" ><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
      <tr class="dp-prodboxbg01">
        <td colspan="2" class="hdbg">Shipping Information</td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">First Name</td>
        <td width="273" class="dp-prod-matter"><?php  echo $_POST['txtShippingFirstName']; ?>
            <input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php  echo $_POST['txtShippingFirstName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Last Name</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingLastName']; ?>
            <input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php  echo $_POST['txtShippingLastName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address1</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingAddress1']; ?>
            <input name="hidShippingAddress1" type="hidden" id="hidShippingAddress1" value="<?php  echo $_POST['txtShippingAddress1']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address2</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingAddress2']; ?>
            <input name="hidShippingAddress2" type="hidden" id="hidShippingAddress2" value="<?php  echo $_POST['txtShippingAddress2']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Province / State</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingState']; ?>
            <input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php  echo $_POST['txtShippingState']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">City</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingCity']; ?>
            <input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php  echo $_POST['txtShippingCity']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Postal Code</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingPostalCode']; ?>
            <input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php  echo $_POST['txtShippingPostalCode']; ?>"></td>
      </tr>
      
        <tr>
        <td width="254" class="dp-prod-matter" align="right">Phone No.</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingphone']; ?>
            <input name="hidShippingphone" type="hidden" id="hidShippingphone" value="<?php  echo $_POST['txtShippingphone']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Fax No.</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingefax']; ?>
            <input name="hidShippingfax" type="hidden" id="hidShippingfax" value="<?php  echo $_POST['txtShippingefax']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">E Mail</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingemail']; ?>
            <input name="hidShippingemail" type="hidden" id="hidShippingemail" value="<?php  echo $_POST['txtShippingemail']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">country</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingcountry']; ?>
            <input name="hidShippingcountry" type="hidden" id="hidShippingcountry" value="<?php  echo $_POST['txtShippingcountry']; ?>">
            
             <input name="hidShippingairport" type="hidden" id="hidShippingairport" value="<?php  echo $_POST['airport']; ?>">
            
            </td>
      </tr>
      
      
      
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top" id="towhom"><b>Whom may we thank for referring you? 
    <script language="javascript">
	function checkrefer()
	{
		if(document.getElementById('towhomthanks').value=='other')
		{
			document.getElementById('otherreferdiv').style.visibility = 'visible';
		}
		else
		{
			document.getElementById('otherreferdiv').style.visibility = 'hidden';
		}
	}
	</script>
    <select class="w150" name="towhomthanks" id="towhomthanks" onchange="checkrefer();">
    <option value="">Select Option</option>
        <option value="Billboard">Billboard</option>
        <option value="Facebook">Facebook</option>
        <option value="Instagram">Instagram</option>
    <option value="Divya Bhaskar">Divya Bhaskar</option>
<option value="Friends & Family">Friends & Family</option>
        <option value="Gujarat Times">Gujarat Times</option>

    <option value="India Abroad">India Abroad</option>

    <option value="Internet">Internet</option>
        <option value="PCCC-Business Club">PCCC-Business Club</option>
	 <option value="other">other</option>
    
    </select>
    <div id="otherreferdiv" style="visibility:hidden;">
   <b>Please Specify :  <input type="text"  name="otherrefer" id="otherrefer">
    </div>
    </td>
  </tr>
  <tr style="display:none;">
    <td align="left" valign="top"><table width="550" border="0" align="center" cellpadding="5" cellspacing="1">
      <tr class="dp-prodboxbg01">
        <td colspan="2" class="hdbg">Payment Information</td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">First Name</td>
        <td width="273" class="dp-prod-matter"><?php  echo $_POST['txtPaymentFirstName']; ?>
            <input name="hidPaymentFirstName" type="hidden" id="hidPaymentFirstName" value="<?php  echo $_POST['txtPaymentFirstName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Last Name</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentLastName']; ?>
            <input name="hidPaymentLastName" type="hidden" id="hidPaymentLastName" value="<?php  echo $_POST['txtPaymentLastName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address1</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentAddress1']; ?>
            <input name="hidPaymentAddress1" type="hidden" id="hidPaymentAddress1" value="<?php  echo $_POST['txtPaymentAddress1']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address2</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentAddress2']; ?>
            <input name="hidPaymentAddress2" type="hidden" id="hidPaymentAddress2" value="<?php  echo $_POST['txtPaymentAddress2']; ?>">        </td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Province / State</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentState']; ?>
            <input name="hidPaymentState" type="hidden" id="hidPaymentState" value="<?php  echo $_POST['txtPaymentState']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">City</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentCity']; ?>
            <input name="hidPaymentCity" type="hidden" id="hidPaymentCity" value="<?php  echo $_POST['txtPaymentCity']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Postal Code</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentPostalCode']; ?>
            <input name="hidPaymentPostalCode" type="hidden" id="hidPaymentPostalCode" value="<?php  echo $_POST['txtPaymentPostalCode']; ?>"></td>
            
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Country</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentcountry']; ?>
            <input name="hidPaymentcountry" type="hidden" id="hidPaymentcountry" value="<?php  echo $_POST['txtPaymentcountry']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Phone</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtpaymentphone']; ?>
            <input name="hidPaymenttxtphone" type="hidden" id="hidPaymenttxtphone" value="<?php  echo $_POST['txtpaymentphone']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Fax</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentfax']; ?>
            <input name="hidPaymenttxtfax" type="hidden" id="hidPaymenttxtfax" value="<?php  echo $_POST['txtPaymentfax']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Email Address</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentemail']; ?>
            <input name="hidPaymentemail" type="hidden" id="hidPaymentemail" value="<?php  echo $_POST['txtPaymentemail']; ?>"></td>
      </tr>
    </table>
	<p>
    
    
      
	<table width="550" border="0" align="center" cellpadding="5" cellspacing="1"  style="display:none;">
  <tr class="dp-prodboxbg01">
    <td  colspan="2" class="hdbg">Payment Information</td>
  </tr>
  <tr>
    <td width="246" class="dp-prod-matter" align="right"> Payment Method </td>
    <td width="297" class="dp-prod-matter"><?php  echo $_POST['txtpaymentmethod']; ?>  <input name="hidtxtpaymentmethod" type="hidden" id="hidtxtpaymentmethod" value="<?php  echo $_POST['txtpaymentmethod']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> Credit card number</td>
    <td class="dp-prod-matter">
	<?php  $ccno =  $_POST['txtccnum'];
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		echo $k.$rest;
		
	 ?> 
    
    <input name="hidtxtccnum" type="hidden" id="hidtxtccnum" value="<?php  echo $_POST['txtccnum']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> name on the credit card </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccname']; ?>  <input name="hidtxtccname" type="hidden" id="hidtxtccname" value="<?php  echo $_POST['txtccname']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> credit card expiration date <br>
MM/CCYY </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccexpiredatemonth']."-".$_POST['txtccexpiredateyear']; ?>  <input name="hidtxtccexpiredate" type="hidden" id="hidtxtccexpiredate" value="<?php  echo $_POST['txtccexpiredatemonth']."-".$_POST['txtccexpiredateyear']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> CVV2 value </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccv2value']; ?>  <input name="hidtxtccv2value" type="hidden" id="hidtxtccv2value" value="<?php  echo $_POST['txtccv2value']; ?>"></td>
  </tr>
   <tr>
    <td class="dp-prod-matter" align="right"> OTCNO </td>
    <td class="dp-prod-matter"><?php  echo $_POST['otcno']; ?>  <input name="hidtxtotcno" type="hidden" id="hidtxtotcno" value="<?php  echo $_POST['otcno']; ?>"></td>
  </tr>
  <tr style="display:none;">
    <td class="dp-prod-matter" align="right"> Cart Id </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtcartid']; ?>  <input name="hidtxtcartid" type="hidden" id="hidtxtcartide" value="<?php  echo $_POST['txtcartid']; ?>">
    <input name="couponcode" type="text" id="couponcode" value="<?php  echo $couponcode; ?>">
    
    </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td height="37" align="center" valign="top"> <input type="button" class="btn-reg" value="Back"
    
     onClick="window.location.href='placeanorder.php?step=1&m=1'">
        &nbsp;&nbsp;
        <?php 
      $catlist = getCartContent(); 
      $chkcatid = array();
      foreach($catlist as $catlists)
      {    
          $chkcatid[] = $catlists['CatagoryId'];
      }
    
        $zipshipzone ="select ZIPCODE from shipzone where STATE IN ('NY','NJ','PA')";
	    $zipshipzone=mysql_query($zipshipzone);
        while ($ziprows = mysql_fetch_array($zipshipzone))
        {
            $zipcodechk[] = $ziprows['ZIPCODE'];   
        }
        if (in_array($_SESSION['shipamtses'],$zipcodechk))
        {
            $zipflag=1;
        }
        else  
        {
            $zipflag=2;
        }
        
            if(isset($_SESSION))
            {
            if(in_array('10010',$chkcatid) && !in_array('10001',$chkcatid) && $_SESSION['cbomethod1ses']=='50' && $_SESSION['radiotype1ses']=='residence' && $zipflag=='1')
            {?>
                <input name="btnConfirm" class="btn-reg" type="button" id="btnConfirm" value="Complete Purchase &gt;&gt;" onclick="checkselection();">
      <?php }elseif($_SESSION['shipamt44']!="" && $_SESSION['shipamtses']!="" && $_SESSION['cbomethod1ses']!="" )
            {?>
                <input name="btnConfirm" class="btn-reg" type="button" id="btnConfirm" value="Complete Purchase &gt;&gt;" onclick="checkselection();">
            <?php }else{ ?>
                <div class="hdshopcartthree"><?php echo "To Complete Your Order Please Calculate Shipping!!";} ?></div>
        <?php }else{?><div class="hdshopcartthree"><?php echo "To Complete Your Order Please Calculate Shipping!!!";} ?></div>
        <?php /*<input name="btnConfirm" type="button" id="btnConfirm" value="Complete Purchase &gt;&gt;" onclick="checkselection();"> */?>
            
        </form>
        
        </table>
    </div>



<?php /*<div class="fillup-form">
        <div class="col-md-12">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="whitbg">
<tr>
      <td height="50" align="center" valign="bottom" class="hdonebig">Step 2 Of 3 : Confirm Order</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><p id="errorMessage"><?php  echo $errorMessage; ?></p>

</td>
  </tr>
  <tr>
  	<td height="37">
    <marquee> <font color="#333333">Please review you order for accuracy before clicking the 'complete purchase' button. Delivery in the month of May or June Depending on your order priority    </marquee></td>
  </tr>
  <form action="<?php  echo $_SERVER['PHP_SELF']; ?>?step=3" method="post" name="frmCheckout" id="frmCheckout">
  
 <tr><td align="center" valign="top">
 <table width="100%" border="1" align="center" cellpadding="5" cellspacing="1">
   <td width="494" align="left" style="border-bottom:none;"><strong>
     <font class="hdone">Billing Address</font><br />
<font color="#333333">
        <?php  echo $_POST['txtShippingFirstName']." "; ?>
<?php  echo $_POST['txtShippingLastName']; ?><br>

<?php  echo $_POST['txtShippingAddress1']; ?><br>
<?php  echo $_POST['txtShippingAddress2']; ?><br>
<?php  echo $_POST['txtShippingCity']." "; ?> 
<?php  echo $_POST['txtShippingState']; ?> - 
<?php  echo $_POST['txtShippingPostalCode']; ?><br>
<?php  echo $_POST['txtShippingcountry']; ?>
  </td><td width="318" rowspan="2" valign="top"><font class="hdone">Payment Method</font>
   <br>
   <?php  $ccno =  $_POST['txtccnum'];
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		//echo $k.$rest;
		
	 ?> <font color="#333333">
   <?php  echo $_POST['txtpaymentmethod'].":".$k.$rest; ?>   &nbsp;</td>
 </tr>
 <tr>
   <td align="left" valign="top" style="border-top:none;">
  <?php $sid = session_id();
$sql12 = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
  
  if($row12['ShippingCode'] == '') { 
    ?>
   <font class="hdone">Shipping Address</font><br /><strong>
<font color="#333333">
<?php  echo $_POST['txtPaymentFirstName']." "; ?>
<?php  echo $_POST['txtPaymentLastName']; ?><br>
<?php  echo $_POST['txtPaymentAddress1']."  "; ?><br>
<?php  echo $_POST['txtPaymentAddress2']; ?><br>
<?php  echo $_POST['txtPaymentCity']." "; ?>  <?php  echo $_POST['txtPaymentState']; ?> - 
<?php  echo $_POST['txtPaymentPostalCode']; ?><br>
<?php  echo $_POST['txtPaymentcountry'];  
}
else
{
?>
<font class="hdone">Shipping to Airport </font><br /><strong>
	<font color="#333333">
<?php echo $_POST['airport']; ?>
<?php }
 ?>
   </td>
   </tr></table></td>
 </tr>
  
  <tr>
    <td align="center" valign="top">
      
      <table width="100%" border="1" align="center" cellpadding="5" cellspacing="1">
      <tr>
        <td colspan="5" class="hdone">YOUR ORDER</td>
      </tr>
      <tr class="dp-prodboxbg01">
      <td width="40" bgcolor="#FFFFCC" class="hdshopcartone">Srno.</td>
        <td width="350" bgcolor="#FFFFCC" class="hdshopcartone">Item</td>
        <td width="23" bgcolor="#FFFFCC" class="hdshopcartone">Qty</td>
        <td width="32" bgcolor="#FFFFCC" class="hdshopcartone">Unit Price</td>
        <td width="38" bgcolor="#FFFFCC" class="hdshopcartone">Total</td>
      </tr>
      <?php 
$numItem  = count($cartContent);
$subTotal = 0;
$QtyDis = 0 ; 
for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$subTotal += $Unit_Price * $Qty;
    //$QtyDis =$QtyDis + $Qty;
    $QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
	//$subTotal += ($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty;
	
?>
      <tr class="content">
      <td class="dp-prod-matter"><font color="#333333"><?php  echo $i+1; ?></td>
        <td align="left" valign="top" class="dp-prod-matter">
		<font color="#000000"><?php echo "<b>".$ProdHead."</b>"; ?></font>
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
        	<?php //echo $SHIPPINGTYPE;  ?>        </font>  -->       </td>
                <td class="dp-prod-matter"><font color="#333333"><?php  echo $Qty; ?><br> BOX</td>

        <td align="right" class="dp-prod-matter"><font color="#333333">
        $<?php echo number_format($Unit_Price,2); //echo number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2); ?> / <br>PER BOX</td>
        <td align="right" class="dp-prod-matter"><font color="#333333">$<?php  echo number_format($Unit_Price * $Qty,2); //echo number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty),2); ?></td>
      </tr>
      <?php 
}
	//$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
	if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount = 0;
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
	//echo $discount;
  	$shipamt_new = $subTotal + $_SESSION['shipamt44'] - $discount;
	//echo $shipamt_new;
?>
      <tr class="content">
      <td colspan="2" align="left">
	   <?php if($Coupon_code !='0' && $Coupon_code !='') { echo "<b>Coupon Code : ".$Coupon_code; }?></td>
        <td class="dp-prod-matter" colspan="2" align="right"><font color="#333333">Sub-total</td>
        <td class="dp-prod-matter" align="right"><font color="#333333">$<?php  echo number_format(($subTotal),2); ?></font></td>
      </tr>
      <tr class="content">
        <td class="dp-prod-matter" colspan="4" align="right"><font color="#333333">Discount</td>
        <td class="dp-prod-matter" align="right"><font color="#FF0000" size="2"><strong><?php if($discount>0){ echo "-$".number_format($discount,2); }else{ echo "$".number_format($discount,2); } ?></strong></font></td>
      </tr>
      <tr class="content">
        <td class="dp-prod-matter" colspan="4" align="right"><font color="#333333">Shipping</td>
        <td class="dp-prod-matter" align="right"><font color="#333333">$<font color="#333333"><?php  echo number_format($_SESSION['shipamt44'],2); ?></font></font></td>
      </tr>
       <tr class="content">
        <td class="hdshopcartblk" colspan="4" align="right">Tax</td>
        <td class="hdshopcartblk" align="right">$<?php  echo "00.00"; ?></td>
      </tr>
      <tr class="content">
        <td class="hdshopcartblk" colspan="4" align="right">Total</td>
        <td class="hdshopcartblk" align="right">$<?php  echo number_format(($shipamt_new),2); //echo number_format(($subTotal + $_SESSION['shipamt44']),2); ?></td>
      </tr>
       <tr>
        <td colspan="5" valign="top" align="left" class="shopcart">
        <b> Terms and conditions:</b>
   	  <ul>
     <li>	The charges will be billed to your credit card at the time of your purchase</li>
     <li>	Delivery in the month of May or June Depending on your order priority.</li> 
     <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
    <li>	You agree to pay all credit card charges for your purchase made.</li>
     <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
     <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
       </ul>           </tr>
    </table></td>
  </tr>
  <tr>
    <td height="51" align="center" valign="middle" class="hdshopcartthree">Please call 1-855-696-2646 in USA or   +91 96 62 30 30 30   in India<br />
if you need more information.</td>
  </tr>
  <tr style="display:none;">
    <td align="left" valign="top" ><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
      <tr class="dp-prodboxbg01">
        <td colspan="2" class="hdbg">Shipping Information</td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">First Name</td>
        <td width="273" class="dp-prod-matter"><?php  echo $_POST['txtShippingFirstName']; ?>
            <input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php  echo $_POST['txtShippingFirstName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Last Name</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingLastName']; ?>
            <input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php  echo $_POST['txtShippingLastName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address1</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingAddress1']; ?>
            <input name="hidShippingAddress1" type="hidden" id="hidShippingAddress1" value="<?php  echo $_POST['txtShippingAddress1']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address2</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingAddress2']; ?>
            <input name="hidShippingAddress2" type="hidden" id="hidShippingAddress2" value="<?php  echo $_POST['txtShippingAddress2']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Province / State</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingState']; ?>
            <input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php  echo $_POST['txtShippingState']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">City</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingCity']; ?>
            <input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php  echo $_POST['txtShippingCity']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Postal Code</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingPostalCode']; ?>
            <input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php  echo $_POST['txtShippingPostalCode']; ?>"></td>
      </tr>
      
        <tr>
        <td width="254" class="dp-prod-matter" align="right">Phone No.</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingphone']; ?>
            <input name="hidShippingphone" type="hidden" id="hidShippingphone" value="<?php  echo $_POST['txtShippingphone']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Fax No.</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingefax']; ?>
            <input name="hidShippingfax" type="hidden" id="hidShippingfax" value="<?php  echo $_POST['txtShippingefax']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">E Mail</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingemail']; ?>
            <input name="hidShippingemail" type="hidden" id="hidShippingemail" value="<?php  echo $_POST['txtShippingemail']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">country</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtShippingcountry']; ?>
            <input name="hidShippingcountry" type="hidden" id="hidShippingcountry" value="<?php  echo $_POST['txtShippingcountry']; ?>">
            
             <input name="hidShippingairport" type="hidden" id="hidShippingairport" value="<?php  echo $_POST['airport']; ?>">
            
            </td>
      </tr>
      
      
      
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top" id="towhom"><b>Whom may we thank for referring you? 
    <script language="javascript">
	function checkrefer()
	{
		if(document.getElementById('towhomthanks').value=='other')
		{
			document.getElementById('otherreferdiv').style.visibility = 'visible';
		}
		else
		{
			document.getElementById('otherreferdiv').style.visibility = 'hidden';
		}
	}
	</script>
    <select name="towhomthanks" id="towhomthanks" onchange="checkrefer();">
    <option value="">Select Option</option>
        <option value="Billboard">Billboard</option>
        <option value="Facebook">Facebook</option>
        <option value="Instagram">Instagram</option>
    <option value="Divya Bhaskar">Divya Bhaskar</option>
<option value="Friends & Family">Friends & Family</option>
        <option value="Gujarat Times">Gujarat Times</option>

    <option value="India Abroad">India Abroad</option>

    <option value="Internet">Internet</option>
        <option value="PCCC-Business Club">PCCC-Business Club</option>
	 <option value="other">other</option>
    
    </select>
    <div id="otherreferdiv" style="visibility:hidden;">
   <b>Please Specify :  <input type="text"  name="otherrefer" id="otherrefer">
    </div>
    </td>
  </tr>
  <tr style="display:none;">
    <td align="left" valign="top"><table width="550" border="0" align="center" cellpadding="5" cellspacing="1">
      <tr class="dp-prodboxbg01">
        <td colspan="2" class="hdbg">Payment Information</td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">First Name</td>
        <td width="273" class="dp-prod-matter"><?php  echo $_POST['txtPaymentFirstName']; ?>
            <input name="hidPaymentFirstName" type="hidden" id="hidPaymentFirstName" value="<?php  echo $_POST['txtPaymentFirstName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Last Name</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentLastName']; ?>
            <input name="hidPaymentLastName" type="hidden" id="hidPaymentLastName" value="<?php  echo $_POST['txtPaymentLastName']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address1</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentAddress1']; ?>
            <input name="hidPaymentAddress1" type="hidden" id="hidPaymentAddress1" value="<?php  echo $_POST['txtPaymentAddress1']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Address2</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentAddress2']; ?>
            <input name="hidPaymentAddress2" type="hidden" id="hidPaymentAddress2" value="<?php  echo $_POST['txtPaymentAddress2']; ?>">        </td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Province / State</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentState']; ?>
            <input name="hidPaymentState" type="hidden" id="hidPaymentState" value="<?php  echo $_POST['txtPaymentState']; ?>" ></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">City</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentCity']; ?>
            <input name="hidPaymentCity" type="hidden" id="hidPaymentCity" value="<?php  echo $_POST['txtPaymentCity']; ?>"></td>
      </tr>
      <tr>
        <td width="254" class="dp-prod-matter" align="right">Postal Code</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentPostalCode']; ?>
            <input name="hidPaymentPostalCode" type="hidden" id="hidPaymentPostalCode" value="<?php  echo $_POST['txtPaymentPostalCode']; ?>"></td>
            
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Country</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentcountry']; ?>
            <input name="hidPaymentcountry" type="hidden" id="hidPaymentcountry" value="<?php  echo $_POST['txtPaymentcountry']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Phone</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtpaymentphone']; ?>
            <input name="hidPaymenttxtphone" type="hidden" id="hidPaymenttxtphone" value="<?php  echo $_POST['txtpaymentphone']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Fax</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentfax']; ?>
            <input name="hidPaymenttxtfax" type="hidden" id="hidPaymenttxtfax" value="<?php  echo $_POST['txtPaymentfax']; ?>"></td>
      </tr>
       <tr>
        <td width="254" class="dp-prod-matter" align="right">Email Address</td>
        <td class="dp-prod-matter"><?php  echo $_POST['txtPaymentemail']; ?>
            <input name="hidPaymentemail" type="hidden" id="hidPaymentemail" value="<?php  echo $_POST['txtPaymentemail']; ?>"></td>
      </tr>
    </table>
	<p>
    
    
      
	<table width="550" border="0" align="center" cellpadding="5" cellspacing="1"  style="display:none;">
  <tr class="dp-prodboxbg01">
    <td  colspan="2" class="hdbg">Payment Information</td>
  </tr>
  <tr>
    <td width="246" class="dp-prod-matter" align="right"> Payment Method </td>
    <td width="297" class="dp-prod-matter"><?php  echo $_POST['txtpaymentmethod']; ?>  <input name="hidtxtpaymentmethod" type="hidden" id="hidtxtpaymentmethod" value="<?php  echo $_POST['txtpaymentmethod']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> Credit card number</td>
    <td class="dp-prod-matter">
	<?php  $ccno =  $_POST['txtccnum'];
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$k='';
		for($i=0;$i<($ccno1 - 4);$i++)
		{
		 $k.="*";
		}
		echo $k.$rest;
		
	 ?> 
    
    <input name="hidtxtccnum" type="hidden" id="hidtxtccnum" value="<?php  echo $_POST['txtccnum']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> name on the credit card </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccname']; ?>  <input name="hidtxtccname" type="hidden" id="hidtxtccname" value="<?php  echo $_POST['txtccname']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> credit card expiration date <br>
MM/CCYY </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccexpiredatemonth']."-".$_POST['txtccexpiredateyear']; ?>  <input name="hidtxtccexpiredate" type="hidden" id="hidtxtccexpiredate" value="<?php  echo $_POST['txtccexpiredatemonth']."-".$_POST['txtccexpiredateyear']; ?>"></td>
  </tr>
  <tr>
    <td class="dp-prod-matter" align="right"> CVV2 value </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtccv2value']; ?>  <input name="hidtxtccv2value" type="hidden" id="hidtxtccv2value" value="<?php  echo $_POST['txtccv2value']; ?>"></td>
  </tr>
   <tr>
    <td class="dp-prod-matter" align="right"> OTCNO </td>
    <td class="dp-prod-matter"><?php  echo $_POST['otcno']; ?>  <input name="hidtxtotcno" type="hidden" id="hidtxtotcno" value="<?php  echo $_POST['otcno']; ?>"></td>
  </tr>
  <tr style="display:none;">
    <td class="dp-prod-matter" align="right"> Cart Id </td>
    <td class="dp-prod-matter"><?php  echo $_POST['txtcartid']; ?>  <input name="hidtxtcartid" type="hidden" id="hidtxtcartide" value="<?php  echo $_POST['txtcartid']; ?>">
    <input name="couponcode" type="text" id="couponcode" value="<?php  echo $couponcode; ?>">
    
    </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td height="37" align="center" valign="top"> <input type="button" class="btn-reg" value="Back"
    
     onClick="window.location.href='placeanorder.php?step=1&m=1'">
        &nbsp;&nbsp;
        <?php 
      $catlist = getCartContent(); 
      $chkcatid = array();
      foreach($catlist as $catlists)
      {    
          $chkcatid[] = $catlists['CatagoryId'];
      }
    
        $zipshipzone ="select ZIPCODE from shipzone where STATE IN ('NY','NJ','PA')";
	    $zipshipzone=mysql_query($zipshipzone);
        while ($ziprows = mysql_fetch_array($zipshipzone))
        {
            $zipcodechk[] = $ziprows['ZIPCODE'];   
        }
        if (in_array($_SESSION['shipamtses'],$zipcodechk))
        {
            $zipflag=1;
        }
        else  
        {
            $zipflag=2;
        }
        
            if(isset($_SESSION))
            {
            if(in_array('10010',$chkcatid) && !in_array('10001',$chkcatid) && $_SESSION['cbomethod1ses']=='50' && $_SESSION['radiotype1ses']=='residence' && $zipflag=='1')
            {?>
                <input name="btnConfirm" class="btn-reg" type="button" id="btnConfirm" value="Complete Purchase &gt;&gt;" onclick="checkselection();">
      <?php }elseif($_SESSION['shipamt44']!="" && $_SESSION['shipamtses']!="" && $_SESSION['cbomethod1ses']!="" )
            {?>
                <input name="btnConfirm" class="btn-reg" type="button" id="btnConfirm" value="Complete Purchase &gt;&gt;" onclick="checkselection();">
            <?php }else{ ?>
                <div class="hdshopcartthree"><?php echo "To Complete Your Order Please Calculate Shipping!!";} ?></div>
        <?php }else{?><div class="hdshopcartthree"><?php echo "To Complete Your Order Please Calculate Shipping!!!";} ?></div>
        
</form></td>
  </tr>
</table>
     </div></div> */?>
