<?php 
include("../../library/config.php");
error_reporting(E_ALL ^ E_NOTICE);
function cleanData(&$str) { 
$str = preg_replace("/\t/", "\\t", $str); 
$str = preg_replace("/\r?\n/", "\\n", $str); 
if(strstr($str, '"')) 
  $str = '"' . str_replace('"', '""', $str) . '"'; 
} // filename for download 
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
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
if($from_date!="" && $to_date!="")
{
	$sql_orderdata ="select * from orderdata where Order_Date BETWEEN '$from_date' AND '$to_date' ORDER BY Order_Id";
	$res_orderdata =mysql_query($sql_orderdata);
	$jp = 0;
	
	  while($datanew=mysql_fetch_assoc($res_orderdata))
      {
		    $jp++;
			$sql_paydetail = "select * from paydetail where Order_Id='$datanew[Order_Id]'";
			$res_paydetail =mysql_query($sql_paydetail);
			$num_paydetail=mysql_num_rows($res_paydetail);
			$data_paydetail =mysql_fetch_assoc($res_paydetail);
			$pay_method = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Pay_Method']));
			$credit_cart_no = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_No']));
			$credit_card_expiration_date = "20-".stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_Exp'])); 
			$card_cvv_no= stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_CVV']));

			$invoice_number=substr($datanew['invoiceno'],0,20);
			$description=substr("SAVANI FARM PREMIUM KESAR MANGOES",0,255);
			$amount=substr(number_format($datanew['Order_Tot'],2),0,15);
			if($pay_method=="") 
			{ 
				$pay_method="CC"; 
			}else
			{ 
				$pay_method="CC"; 
			}
			$credit_cart_no= substr($credit_cart_no,0,25);
			$credit_card_expiration_date =date('my',strtotime($credit_card_expiration_date));
			$card_cvv_no =substr($card_cvv_no,0,4);
			$bill_fname = strtoupper(substr(trim($datanew['FName']),0,50));
			$bill_lname = strtoupper(substr(trim($datanew['LName']),0,50));
			$bil_comp_name = strtoupper(substr(trim($datanew['Comp_Name']),0,50));
			$bill_add = trim($datanew['Adr1'])." ".trim($datanew['Adr2']);
			$bill_address=strtoupper(substr(trim($bill_add),0,60));
			//echo $bill_address;
			$bill_city=strtoupper(substr(trim($datanew['City']),0,40));
			$bill_state=strtoupper(substr(trim($datanew['State']),0,40));
			$bill_zip=strtoupper(substr($datanew['ZIP'],0,20));
			$bill_country=strtoupper(substr(trim($datanew['Country']),0,20));
			$customer_phone=substr($datanew['Phone'],0,25);
			$customer_email=substr(trim($datanew['Email_Id']),0,255);
			$ship_fname =strtoupper(substr(trim($datanew['Ship_FName']),0,50));
			$ship_lname=strtoupper(substr(trim($datanew['Ship_LName']),0,50));
			$ship_company=strtoupper(substr(trim($datanew['Ship_Comp_Name']),0,50));
			$ship_add =trim($datanew['Ship_Adr1'])." ".trim($datanew['Ship_Adr2']);
			$ship_address=strtoupper(substr(trim($ship_add),0,60));
			$ship_city=strtoupper(substr(trim($datanew['Ship_City']),0,40));
			$ship_state=strtoupper(substr(trim($datanew['Ship_State']),0,40));
			$ship_zip=substr($datanew['Ship_ZIP'],0,20);
			$ship_country=strtoupper(substr(trim($datanew['Ship_Country']),0,60));
			
			
			if($datanew['Ship_Desti']=="residence")
			{ 
				$customer_type="R"; 
			}else
			{ 
				$customer_type="B"; 
			} 
			$sql_box = "select * from ordermaster where Order_Id='$datanew[Order_Id]'";
			$res_box =mysql_query($sql_box);
			$num_box=mysql_num_rows($res_box);
			$data_box =mysql_fetch_assoc($res_box);
			$cancel_order = '';
			if($datanew["od_status"]=='Cancelled')
			  $cancel_order = $data_box["orderd_qty"];
			  
			$sql_box1 = "select * from shipmethod where METHODID ='".$datanew["Ship_Method"]."'";
			$res_box1 =mysql_query($sql_box1);
			$num_box1=mysql_num_rows($res_box1);
			$data_box1 =mysql_fetch_assoc($res_box1);
			$Ship_Method = $data_box1["METHOD"];
			
			$netorder = $data_box["orderd_qty"] - $cancel_order;
			$data[] = array("Sr. No"=>$jp,"Date"=>date("F d, Y",strtotime($datanew["Order_Date"])),"Name"=>$bill_fname.' '.$bill_lname,"Order"=>$invoice_number,"Order Status"=>$datanew["od_status"],"Number of Boxes"=>$data_box["orderd_qty"],"Cancelled Order"=>$cancel_order,"Net Orders"=>$netorder,"Unit Price ($)"=>$data_box["Order_rate"],"Net Charges for Mangoes"=>$data_box["Sub_total"],"Shipping Charged"=>$datanew["Ship_Tot"],"Billed Amount"=>$amount,"Shipping Address"=>$ship_address,"Shipping City"=>$ship_city,"Shipping State"=>$ship_state,"Shipping Zip Code"=>$ship_zip,"Shipping Country"=>$ship_country,"Phone No."=>$customer_phone,"Shipping Method"=>$Ship_Method,""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"",""=>"");
		}
	}

//echo "<pre>";print_r($data);die;
$filename = "website_data_" . date('Ymd') . ".xls"; 
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Content-Type: application/vnd.ms-excel"); 
$flag = false; 

foreach($data as $row) 
{ 
	if(!$flag) 
	{ 
	// display field/column names as first row 
	echo implode("\t", array_keys($row)) . "\r\n"; 
	$flag = true; 
	} 
	array_walk($row, 'cleanData'); 
	echo implode("\t", array_values($row)) . "\r\n"; 
} 
exit;

?>
