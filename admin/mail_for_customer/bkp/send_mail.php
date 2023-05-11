<?
require_once '../../library/config.php';
require_once '../../library/cart-functions.php';
require_once '../../library/checkout-functions.php';
$orderno= $_REQUEST['orderno'];
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
	
	$INDIVIDUAL_ORDER=$data_pp['ProdHead'];
	//echo INDIVIDUAL_ORDER;
	$ProdName=$data_pp['ProdName'];
	$ProdDesc=$data_pp['ProdDesc'];
	
	$Prod_Tot=$data_rr['Prod_Tot'];
	$Ship_Tot=$data_rr['Ship_Tot'];
	$Order_Tot=$data_rr['Order_Tot'];
	
	
	$QTY=$row_pp['orderd_qty'];
	$Unit_Price =number_format($row_pp['Order_rate'],2);
	
	$sub_Total =number_format($row_pp['Sub_total'],2);
	//echo $sub_Total;
	$sub_total_fil =number_format($sub_Total,2);
	
	
	$k = $k."SrNo : ".($i++)."\n\r";
	$k .= "Item_name : ".$ProdName."\n\r";
	$k .= "Item_description : ".$ProdDesc."\n\r";
	$k .= "Quantity : ".$QTY."\n\r";
	$k .= "Unit_Price  : $".number_format($Unit_Price,2)."\n\r";
	$k .= "Total  : $".number_format($sub_Total,2)."\n\r";
	
}
$m = "Sub-total : $".number_format($Prod_Tot,2)."\n\r";
$m .= "Shipping : $".number_format($Ship_Tot,2)."\n\r";
$m .= "Tax : $ 00.00\n\r";
$m .= "Total Price : $".number_format($Order_Tot,2)."\n\r";

$message_bottom = "Terms and conditions:\n\r";
$message_bottom .="Delivery will be made to you in the month of May.\n\r";
$message_bottom .="Please provide a valid phone number and email address to communicate your confirmed delivery date.\n\r";
$message_bottom .="You agree to pay all credit card charges for your purchase made.\n\r";
$message_bottom .="Your confirmed order delivery is subject to approval by the USDA at the port of entry.\n\r";
$message_bottom .="Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount.\n\r";
$message_bottom .="Please call 1-855-696-2646 in USA or +919662303030 in India if you need more information.\n\r";


$billaddress .="".$FName." ".$LName."\n\r";
$billaddress .="".$Adr1." ".$Adr1."\n\r";
$billaddress .="".$City."\n\r";
$billaddress .="".$State."-".$ZIP."\n\r";
$billaddress .="".$Country."\n\r";
$billaddress .="".$Email_Id."\n\r";

$shipaddress1 .="".$Ship_FName." ".$Ship_LName."\n\r";
$shipaddress1 .="".$Ship_Adr1." ".$Ship_Adr2."\n\r";
$shipaddress1 .="".$Ship_City."\n\r";
$shipaddress1 .="".$Ship_State."-".$Ship_ZIP."\n\r";
$shipaddress1 .="".$Ship_Country."\n\r";
$shipaddress1 .="".$Ship_Email_Id."\n\r";


$orderdetail=
"Order Detail"."\n\r".
"Order Number : ".$orderno."\n\r".
"Order Date : ".$ordate."\n\r".
"Payament Method : ".stripslashes(ENCRYPT_DECRYPT($Pay_Method))." : ".$kk.$rest."\n\r".
"Billing Address : ".$billaddress."\n\r".
"Shipping Address : ".$shipaddress1."\n\r";

		

$tablecont=$k.$m.$message_bottom;
$to=$Email_Id;
$from="savanifarms@dentaoffice.com";			
$subject="SavaniFarms Orderconfirmation Mail".$orderno;

$message = "Dear:".$Ship_FName." ".$Ship_LName."\n\r";
$message .="Thank You for shopping with Savani Farms! we have received the order , Delivery of your order will be in the month of May.Please Keep this email for your record .\n\r";
$message .="".$orderdetail.$tablecont."\n\r";

$headers .="MIME-Version: 1.0\n";
$headers .="Content-Type: text/plain; charset=iso-8859-1\n";
//$headers .="Content-Type: text/html; charset=iso-8859-1\r\n";
//$headers .="Content-Transfer-Encoding: 8bit\r\n";
$headers .="From: ".$from;
//echo $message;die;
/*mail($to, $subject, $message, $headers);
mail("savanifarms@dentaoffice.com", $subject, $message, $headers);
mail("deepak.dentaweb@gmail.com", $subject, $message, $headers);
mail("kishor@dentaoffice.com", $subject, $message, $headers);*/
$msg="Mail Send Successfully!!!";
echo $msg;

	}
}	
	

?>
