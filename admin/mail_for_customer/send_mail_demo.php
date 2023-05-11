<?
require_once '../../library/config.php';
require_once '../../library/cart-functions.php';
require_once '../../library/checkout-functions.php';
$orderno= $_GET['invoice_number'];
//echo $orderno;


FUNCTION encrypt_decrypt($Str_Message) 
{ 
    $Len_Str_Message=STRLEN($Str_Message); 
    $Str_Encrypted_Message=""; 
    FOR ($Position = 0;$Position<$Len_Str_Message;$Position++)
	{ 
        $Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2) 
        $Key_To_Use = (255+$Key_To_Use) % 255; 
        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1); 
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted); 
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation 
        $Encrypted_Byte = CHR($Xored_Byte); 
        $Str_Encrypted_Message .= $Encrypted_Byte; 
 	} 
    RETURN $Str_Encrypted_Message; 
}

$sql_or="select * from orderdata where invoiceno='$orderno'";
//echo $sql_or;
$res_or =mysql_query($sql_or);
$num_or=mysql_num_rows($res_or);
if($num_or > 0)
{
	while($datanew=mysql_fetch_assoc($res_or))
  	{
		$sql_paydetail = "select * from paydetail where Order_Id='$datanew[Order_Id]'";
		$res_paydetail =mysql_query($sql_paydetail);
		$num_paydetail=mysql_num_rows($res_paydetail);
		$data_paydetail =mysql_fetch_assoc($res_paydetail);
		
		$pay_method = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Pay_Method']));
		$credit_cart_no = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_No']));
		$credit_card_expiration_date = "20-".stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_Exp'])); 
		$card_cvv_no= stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_CVV']));

		$invoice_number=substr($datanew['invoiceno'],0,20);
		//echo $invoice_number;
		$description=substr("SAVANI FARM PREMIUM KESAR MANGOES",0,255);
		$amount=substr(number_format($datanew['Order_Tot'],2),0,15);
		
		$sql_order="select * from ordermaster where order_id='$datanew[Order_Id]'";
		$res_order =mysql_query($sql_order);
		$num_order=mysql_num_rows($res_order);
		$data_order =mysql_fetch_assoc($res_order);
		
		$sql_pay="select * from productmast where PordId='$data_order[prod_id]'";
		$res_pay =mysql_query($sql_pay);
		$num_pay=mysql_num_rows($res_pay);
		$data_pay =mysql_fetch_assoc($res_pay);
		
		
		$Card_No=$data_paydetail['Card_No'];
		$ccno =  stripslashes(ENCRYPT_DECRYPT($Card_No));
		$ccno1 = strlen($ccno);	
		$rest = substr($ccno, -4);
		$kk='';
		for($ii=0;$ii<($ccno1 - 4);$ii++)
		{
		 $kk.="*";
		}
		//echo $k.$rest;
	 
	 $Order_Date=$datanew['Order_Date'];
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
			//echo $ordate;
			
				$FName = $datanew['FName'];
				$LName = $datanew['LName'];
				$Adr1 = $datanew['Adr1'];
				$Adr2 =$datanew['Adr2'];
				$City  =$datanew['City'];
				$State  =$datanew['State'];
				$ZIP  =$datanew['ZIP'];
				$Country=$datanew['Country'];
				$Email_Id =$datanew['Email_Id'];
				
				$Ship_FName  =$datanew['Ship_FName'];
				$Ship_LName  =$datanew['Ship_LName'];
				$Ship_Adr1  =$datanew['Ship_Adr1'];
				$Ship_Adr2  =$datanew['Ship_Adr2'];
				$Ship_City  =$datanew['Ship_City'];
				$Ship_State  =$datanew['Ship_State'];
				$Ship_ZIP  =$datanew['Ship_ZIP'];
				$Ship_Country  =$datanew['Ship_Country'];
				$Ship_Email_Id =$datanew['Ship_Email_Id'];
	
				$INDIVIDUAL_ORDER=$data_pay['ProdHead'];
				$mango_type =$data_pay['ProdName'];
				$prod_desce =$data_pay['ProdDesc'];
	
				$QTY =$data_order['orderd_qty'];
				$sub_Total =number_format($data_order['orderd_qty'],2) * number_format($data_order['Order_rate'],2);
				$sub_total_fil =number_format($sub_Total,2);
				$Unit_Price =number_format($data_order['Order_rate'],2);
				$Ship_Tot  =$datanew['Ship_Tot'];
				$Order_Tot = $datanew['Order_Tot'];
	
	

$tab='<table width=570 border=0  align=center cellpadding=5 cellspacing=1 class=ddepot-blueborder bgcolor=#FFFFFF style=color:#FFFFFF;>
			
    <tr id=infoTableHeader> 
        <td colspan=5 class=hdbg bgcolor=6096f0><font color=#333333>Your Order&nbsp;</td>
    </tr>
    <tr align=center class=label> 
    <td bgcolor=dcf0ff><font color=#333333><b>Sr No.&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Item&nbsp;</td>
		 <td bgcolor=dcf0ff><font color=#333333><b>Qty&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Unit Price&nbsp;</td>
        <td bgcolor=dcf0ff><font color=#333333><b>Total&nbsp;</td>
   </tr>';


$sql_fz = "SELECT * From ordermaster WHERE orderno='$orderno'";
$res_fz= mysql_query($sql_fz);
$num_fz=mysql_num_rows($res_fz);
$i=1;
while ($row_pp = mysql_fetch_assoc($res_fz)) 
{
	$sql_pp = "SELECT * From productmast WHERE PordId='$row_pp[prod_id]'";
	$res_pp = mysql_query($sql_pp);
	$num_pp=mysql_num_rows($res_pp);
	$data_pp =mysql_fetch_assoc($res_pp);

	$sql_rr = "SELECT * From orderdata WHERE Order_Id='$row_pp[order_id]'";
	$res_rr = mysql_query($sql_rr);
	$num_rr=mysql_num_rows($res_rr);
	$data_rr =mysql_fetch_assoc($res_rr);
	//echo $sql_rr;
	
	$INDIVIDUAL_ORDER=$data_pp['ProdHead'];
	//echo INDIVIDUAL_ORDER;
	$ProdName=$data_pp['ProdName'];
	$ProdDesc=$data_pp['ProdDesc'];
	
	$Prod_Tot=$data_rr['Prod_Tot'];
	//echo $Prod_Tot."<br>";<br />
	
	$Ship_Tot=$data_rr['Ship_Tot'];
	$Order_Tot=$data_rr['Order_Tot'];
	
	$QTY=$row_pp['orderd_qty'];
	$Unit_Price =number_format($row_pp['Order_rate'],2);
	//echo $Unit_Price."<br>";
	$sub_Total =number_format($row_pp['Sub_total'],2);
	//echo $sub_Total;
	
	$sql_rr1 = "SELECT Disc_perc From couponmaster where Coupon_code='$data_rr[Coupon_code]'";
	$res_rr1 = mysql_query($sql_rr1);
	//$num_pp1=mysql_num_rows($res_rr1);
	$data_pp1 =mysql_fetch_assoc($res_rr1);
	$Disc_perc=$data_pp1['Disc_perc'];
	//echo $Disc_perc;
	//echo"<pre>";print_r($data_pp1);
	
	if($Disc_perc=='0' || $Disc_perc=="")
	{	
		$discount = 0;
	}
	else
	{
		//$discount = Get_Percent($Coupon_Rate,$subTotal);
		$discount = ($sub_Total * $Disc_perc)/100;
	}
	//echo $discount."<br>";
	$sub_total_fil =number_format($sub_Total,2);
	
	
	$k=$k.'<tr class=content> 
	<td bgcolor=f0f0f0><font color=#333333>'.($i++).'</td>
        <td align=left bgcolor=f0f0f0><font color=#000000>'.
		$ProdHead."<br><font class=hdshopcartfour>".
		$ProdName.'
		<br><br><font color=#333333>'.$ProdDesc.'<br><br>
		</td>
		<td bgcolor=f0f0f0><font color=#333333>'.$QTY.'<br>BOX</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$'.number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2).'/Per Box</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$'.number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $QTY),2).'</td>
    </tr>';
}

if($discount>0)
{ $discount_final = "-$".number_format($discount,2)."\n\r"; } else { $discount_final = "$".number_format($discount,2)."\n\r"; }


$m='<tr class=content> 

        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Sub-total&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$'.number_format($Prod_Tot,2).'</td>
    </tr>
	<tr class=content> 
	
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#FF0000><b>Discount&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#FF0000>'.$discount_final.'</td>
    </tr>
    <tr class=content> 
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Shipping&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$'.number_format($Ship_Tot,2).'</td>
    </tr>
	<tr class=content>
	 
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Tax&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$00.00&nbsp;</td>
    </tr>
    <tr class=content>
	 
        <td colspan=4 align=right bgcolor=dcf0ff><font color=#333333><b>Total&nbsp;</td>
        <td align=right bgcolor=f0f0f0><font color=#333333>$'.number_format($Order_Tot,2).'</td>
    </tr>
	<tr class=content> 
      <td colspan=5 align=left bgcolor=f0f0f0><font color=#333333>
      <b>Terms and conditions:</b>
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
  <tr class=content>
      <td height=37 colspan=5 align=center valign=middle bgcolor=f0f0f0><font color=#333333>Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.</td>
  </tr>
</table>';

$billaddress .="".$FName." ".$LName."<br>";
$billaddress .="".$Adr1." ".$Adr2."<br>";
$billaddress .="".$City."<br>";
$billaddress .="".$State."-".$ZIP."<br>";
$billaddress .="".$Country."<br>";
$billaddress .="".$Email_Id."<br>";

$shipaddress1 .="".$Ship_FName." ".$Ship_LName."<br>";
$shipaddress1 .="".$Ship_Adr1." ".$Ship_Adr2."<br>";
$shipaddress1 .="".$Ship_City."<br>";
$shipaddress1 .="".$Ship_State."-".$Ship_ZIP."<br>";
$shipaddress1 .="".$Ship_Country."<br>";
$shipaddress1 .="".$Ship_Email_Id."<br>";


$orderdetail='
<table  width=570 border=0  align=center cellpadding=5 cellspacing=1 class=whitbg>
        <tr>
        <td colspan=5 align="left" valign=top bgcolor=#000000><table width=100% border=0 cellspacing=0 cellpadding=0>
          <tr>
            <th width=27% align=center valign=middle scope=row><img src=http://www.aaadentalab.com/shoppingcartdemo/savanifarms/images/savanifarmslogo.gif alt=Savani farms width=117 height=95 /></th>
            <td width=73% align=left valign=middle><img src=http://www.aaadentalab.com/shoppingcartdemo/savanifarms/images/savanifarms.gif alt=Savani farms width=301 height=30 /></td>
          </tr>
        </table>
          </td>
      </tr>
		<tr> 
            <td colspan=3 align=center class=hdbg bgcolor=6096f0>Order Detail</td>
        </tr>
        <tr> 
            <td rowspan="2" align=right class=label valign=top>
            
          <table width=100% height=107 border=0  align=left cellpadding=3 cellspacing=5 class=whitbg>
                <tr>
                  <td width=114 align=right class=label valign=top bgcolor=dcf0ff><strong>Order Number&nbsp;</strong></td>
                  <td width=166 class=content align=left valign=top bgcolor=f0f0f0>'.$orderno.'&nbsp;</td>
                </tr>
                <tr>
                  <td width=114 align=right valign=top class=label bgcolor=dcf0ff><strong>Order Date&nbsp;</strong></td>
                  <td class=content align=left valign=top bgcolor=f0f0f0>'.$ordate.'&nbsp;</td>
                </tr>
                <tr>
                  <td colspan=2 align=left valign=top class=label bgcolor=f0f0f0><b>Payament Method</b><br>
   						'.$pay_method.' : '.$kk.$rest.'</td>
                </tr>
              </table>            </td>
            <td align=left bgcolor=dcf0ff><b>Billing Address</b> </td>
			<td align=left bgcolor=dcf0ff><b>Shipping Address</b> </td>
        </tr>
        <tr> 
            <td class=content valign=top align=left bgcolor=f0f0f0>'.$billaddress.'</td>
			<td class=content valign=top align=left bgcolor=f0f0f0>'.$shipaddress1.'</td>
        </tr>
</table>';

$tablecont=$tab.$k.$m;
$message = "Dear : ".$Ship_FName." ".$Ship_LName."<br>";
$message .="Thank You for shopping with Savani Farms! we have received the order , Delivery in the month of May or June Depending on your order priority .Please Keep this email for your record .<br>";
$message .="".$orderdetail.$tablecont."<br>";
echo $message;
	}
}	
?>
<script src="jquery-latest.js"></script>
<script type="text/javascript">
function funsendmail(orderno)
{
	
	var answer = confirm ("Are you sure to send Mail?");
	if (answer)
	{
		$.ajax({
		type: "POST",
		url: "send_mail.php",
		data: "orderno="+orderno,
		success: function(html)
		{   
			alert(html);
			//$("#trmailmsg").show;
			$("#mailmsgbox").html(html);
			//window.close();
		}   
		});
	}
}
function funcancle()
{
	window.close();
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" align="right"><input type="submit" name="submit" id="submit" value="Send Mail" onclick="funsendmail('<? echo $orderno ?>');" /></td>
    <td width="51%" align="left"><input type="button" name="cancle" id="cancle" value="Close" onclick="funcancle();" /></td>
  </tr>
</table>
<div id="mailmsgbox" align="left"></div>
