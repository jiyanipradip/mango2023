<?
include("../../library/config.php");
error_reporting(E_ALL ^ E_NOTICE);

$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="New_report_2012.css" rel="stylesheet" type="text/css" />
<title>Savanifarm Report</title>
<script type="text/javascript" language="javascript">
function Fundatecheck()
{	
	var from_date =document.getElementById("from_date").value;
	var to_date =document.getElementById("to_date").value;
	if(from_date=="")
	{
		alert("Please Enter From Order No !!!");
		document.form1.from_date.focus();
		return false;
	}
	if(to_date=="")
	{
		alert("Please Enter To Order No !!!");
		document.form1.to_date.focus();
		return false;
	}
	location.href="order_list.php?from_date="+from_date+"&to_date="+to_date;
}
</script>
<style>
.fixtbl{
	width:900px;
	height:auto;
	overflow:scroll;
	height:auto;
}
</style>
<script src="jquery-latest.js"></script>
</head>
<body>
<form name="form1" method="post" action="SaveToExcel_test.php" target="_blank">
<table width="100%" border="1" cellspacing="5" cellpadding="5" class="reference" align="center">
  <tr>
  	<td align="center" bgcolor="#f0f0f0"><strong>SAVANIFARM ORDER WISE REPORT</strong></td>
  </tr>
  <tr>
  	<td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
        <tr>
        	<td width="38%" align="right">SELECT <strong>FROM</strong> ORDER NO&nbsp;</td>
            <td width="16%" align="left">
           	  <input type="text" name="from_date" id="from_date"  value="<? echo $from_date; ?>" >
            </td>
            <td width="16%" align="left">SELECT <strong>TO</strong> ORDER NO&nbsp;</td>
            <td width="30%" align="left">
           	  <input type="text" name="to_date" id="to_date" value="<? echo $to_date ?>" >
            </td>
        </tr>
        <tr>
        	<td align="center" colspan="27" bgcolor="#f0f0f0"><input type="button" name="submit" id="submit" value="submit" onclick="return Fundatecheck();" /></td>	
        </tr>
        </table>
    </td>
  </tr>
  </table>
  <br />
  <br />
<?
if($from_date!="" && $to_date!="")
{
	$sql_orderdata ="select * from orderdata where Order_Id BETWEEN '$from_date' AND '$to_date' ORDER BY Order_Id DESC";
	//$sql_orderdata ="select * from orderdata where Order_Id BETWEEN '$from_date' AND '$to_date' ORDER BY Order_Id";
	//echo $sql_orderdata; die;
	$res_orderdata =mysql_query($sql_orderdata);
	$num_orderdata=mysql_num_rows($res_orderdata);
	if($num_orderdata > 0)
	{
?>
<!--<div align="left">
<pre title="Export to Excel"><font color="#0066FF">Export To Text</font><input type="image" src="excel_icon.gif" width="30" height="30" border="0"  ></pre>
</div>-->
<!--<input type="submit" name="s" id="s" value="submit" />-->

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="reference" id="ReportTable">
  <tr>
   	<td bgcolor="#f0f0f0">Order Date</td>
    <td bgcolor="#f0f0f0">Invoice Number</td>
    <td bgcolor="#f0f0f0">Amount</td>
    <td bgcolor="#f0f0f0">Coupon Cord</td>
    <td bgcolor="#f0f0f0">Billing Zip Code</td>
    <td bgcolor="#f0f0f0">Shipping Zip Code</td>
    <td bgcolor="#f0f0f0">Shipping Zip Code 2</td>
  </tr>
  <?
  while($datanew=mysql_fetch_assoc($res_orderdata))
  {
		if($num_orderdata > 0)
		{
			$sql_paydetail = "select * from paydetail where Order_Id='$datanew[Order_Id]'";
			//echo $sql_paydetail; 	
			$res_paydetail =mysql_query($sql_paydetail);
			$num_paydetail=mysql_num_rows($res_paydetail);
			$data_paydetail =mysql_fetch_assoc($res_paydetail);
			$pay_method = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Pay_Method']));
			$credit_cart_no = stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_No']));
			$credit_card_expiration_date = "20-".stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_Exp'])); 
			$card_cvv_no= stripslashes(ENCRYPT_DECRYPT($data_paydetail['Card_CVV']));

			$order_date=substr($datanew['Order_Date'],0,20);
			$invoice_number=substr($datanew['invoiceno'],0,20);
			$coupon_code=substr($datanew['Coupon_code'],0,20);
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
			$ship_zip2=substr($datanew['Ship_Zipcode'],0,20);
		
			//echo $fname;
			//echo $ccc;
			//echo $data_paydetail['Card_CVV'];
			//echo $data_paydetail['Card_CVV'];
			//$ph = $datanew['Phone'];
			//$phone = explode("-",$ph);
			//$phone_first = $phone[0];
			//$pno = "(".$phone_first.")";
			//$final_phone =$pno."".$phone[1]."-".$phone[2];
			
			if($datanew['Ship_Desti']=="residence")
			{ 
				$customer_type="R"; 
			}else
			{ 
				$customer_type="B"; 
			} 
			
	?>
          <tr>
          	<td><? echo $order_date; ?></td>
            <td><? echo $invoice_number; ?></td>
            <td><? echo "$".$amount; ?></td>
            <td><? echo $coupon_code; ?></td>
            <td><? echo $bill_zip; ?></td>
          	<td><? echo $ship_zip; ?></td>
            <td><? echo $ship_zip2; ?></td>
          </tr>
          
          <?
		  if($invoice_number=="")
		  {
		  	$invoice_number=" ";
		  }else
		  {
		  	$invoice_number ='**********'.$invoice_number.'**********';
		  }
		  if($description=="")
		  {
		  	$description=" ";
		  }else
		  {
		  	$description ='**********'.$description.'**********';
		  }
		  if($amount=="")
		  {
		  	$amount=" ";
		  }else
		  {
		  	$amount ='**********'.$amount.'**********';
		  }
		  if($credit_cart_no=="")
		  {
		  	$credit_cart_no=" ";
		  }else
		  {
		  	$credit_cart_no ='**********'.$credit_cart_no.'**********';
		  	
		  }
		  if($credit_card_expiration_date=="")
		  {
		  	$credit_card_expiration_date=" ";
		  }else
		  {
		  	$credit_card_expiration_date ='**********'.$credit_card_expiration_date.'**********';
		  	
		  }
		  if($card_cvv_no=="")
		  {
		  	$card_cvv_no=" ";
		  }else
		  {
		  	$card_cvv_no ='**********'.$card_cvv_no.'**********';
		  	
		  }
		  if($customer_type=="")
		  {
		  	$customer_type=" ";
		  }else
		  {
		  	$customer_type ='**********'.$customer_type.'**********';
		  	
		  }
		  if($bill_fname=="")
		  {
		  	$bill_fname=" ";
		  }else
		  {
		  	$bill_fname ='**********'.$bill_fname.'**********';
		  	
		  }
		  if($bill_lname=="")
		  {
		  	$bill_lname=" ";
		  }else
		  {
		  	$bill_lname ='**********'.$bill_lname.'**********';
		  	
		  }
		 if($bil_comp_name=="")
		  {
		  	$bil_comp_name = " ";
		  }else
		  {
		  	$bil_comp_name = '**********'.$bil_comp_name.'**********';
		  }
		  if($bill_address=="")
		  {
		  	$bill_address = " ";
		  }else
		  {
		  	$bill_address = '**********'.$bill_address.'**********';
		  }
		  if($bill_city=="")
		  {
		  	$bill_city = " ";
		  }else
		  {
		  	$bill_city = '**********'.$bill_city.'**********';
		  }
		  if($bill_state=="")
		  {
		  	$bill_state = " ";
		  }else
		  {
		  	$bill_state = '**********'.$bill_state.'**********';
		  }
		  if($bill_zip=="")
		  {
		  	$bill_zip = " ";
		  }else
		  {
		  	$bill_zip = '**********'.$bill_zip.'**********';
		  }
		  if($bill_country=="")
		  {
		  	$bill_country = " ";
		  }else
		  {
		  	$bill_country = '**********'.$bill_country.'**********';
		  }
		  if($customer_phone=="")
		  {
		  	$customer_phone = " ";
		  }else
		  {
		  	$customer_phone = '**********'.$customer_phone.'**********';
		  }
		  if($customer_email=="")
		  {
		  	$customer_email = " ";
		  }else
		  {
		  	$customer_email = '**********'.$customer_email.'**********';
		  }
		  if($ship_fname=="")
		  {
		  	$ship_fname = " ";
		  }else
		  {
		  	$ship_fname = '**********'.$ship_fname.'**********';
		  }
		  if($ship_lname=="")
		  {
		  	$ship_lname = " ";
		  }else
		  {
		  	$ship_lname = '**********'.$ship_lname.'**********';
		  }
		  if($ship_company=="")
		  {
		  	$ship_company = " ";
		  }else
		  {
		  	$ship_company = '**********'.$ship_company.'**********';
		  }
		  if($ship_address=="")
		  {
		  	$ship_address = " ";
		  }else
		  {
		  	$ship_address = '**********'.$ship_address.'**********';
		  }
		  if($ship_city=="")
		  {
		  	$ship_city = " ";
		  }else
		  {
		  	$ship_city = '**********'.$ship_city.'**********';
		  }
		  if($ship_state=="")
		  {
		  	$ship_state = " ";
		  }else
		  {
		  	$ship_state = '**********'.$ship_state.'**********';
		  }
		  if($ship_zip=="")
		  {
		  	$ship_zip = " ";
		  }else
		  {
		  	$ship_zip = '**********'.$ship_zip.'**********';
		  }
		  if($ship_country=="")
		  {
		  	$ship_country = " ";
		  }else
		  {
		  	$ship_country = '**********'.$ship_country.'**********';
		  }
		  
			$str .= $invoice_number.','.$description.','.$amount.',**********'."CC".'**********,'.$credit_cart_no.','.$credit_card_expiration_date.','.$card_cvv_no.','.$customer_type.','.$bill_fname.','.$bill_lname.','.$bil_comp_name.','.$bill_address.','.$bill_city.','.$bill_state.','.$bill_zip.','.$bill_country.','.$customer_phone.','.$customer_email.','.$ship_fname.','.$ship_lname.','.$ship_company.','.$ship_address.','.$ship_city.','.$ship_state.','.$ship_zip.','.$ship_country."\r\n";
			?>
  <?
  		}
	}
//echo $str;
?>
</table>
<?	
	
		}else
	{
		$msg = "NO RECORDS FOUND !!!";
	?>
    	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="reference"><tr><td align="center"><font color="#FF0000"><? echo $msg; ?></font></td></tr></table>
    <?
	}
}
//echo $str;
?>
<input type="hidden" id="datatodisplay" name="datatodisplay" value="<? echo $str; ?>" />
</form>
</body>
</html>