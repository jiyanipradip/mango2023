<?
include("../../library/config.php");
error_reporting(E_ALL ^ E_NOTICE);

$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];

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
<title>New Report For 2012</title>
<script src="../../jquery-latest.js"></script>
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
	//location.href="invoice_report_test.php?from_date="+from_date+"&to_date="+to_date;
}
function setprocessflag(file,window)
{
	WindowName="MyPopUpWindow";
	
	var width  = 500;
	var height = 400;
	var left   = (screen.width  - width)/2;
	var top    = (screen.height - height)/2;
	var params = 'width='+width+', height='+height;
	params += ', top='+top+', left='+left;
	params += ', directories=no';
	params += ', location=no';
	params += ', menubar=no';
	params += ', resizable=yes';
	params += ', scrollbars=yes';
	params += ', status=no';
	params += ', toolbar=no';
	
	msgWindow=open(file,window,params);
	if (msgWindow.opener == null) msgWindow.opener = self;
}

function popup(url) 
{
 //alert(invoice_number); 
 var width  = 500;
 var height = 400;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=yes';
 params += ', scrollbars=yes';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}

function funemail(orderno)
{
	$.ajax({
		type: "POST",
		url: "send_mail_demo.php",
		data: "orderno="+orderno,
		success: function(html)
		{   
			alert(html);
			$("#mailmsgbox").html(html);
		}   
		});

}
</script>

</head>
<body>
<form name="form1" method="post">
<table width="100%" border="1" cellspacing="5" cellpadding="5" class="reference" align="center">
  <tr>
  	<td align="center" bgcolor="#f0f0f0"><strong>SAVANIFARM SEND MAIL REPORT 2012</strong></td>
  </tr>
  <tr>
  	<td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
        <tr>
        	<td width="38%" align="right">SELECT <strong>FROM</strong> ORDER NO&nbsp;</td>
            <td width="16%" align="left">
           	  <input type="text" name="from_date" id="from_date"  value="<? echo $_POST['from_date']; ?>" >
            </td>
            <td width="16%" align="left">SELECT <strong>TO</strong> ORDER NO&nbsp;</td>
            <td width="30%" align="left">
           	  <input type="text" name="to_date" id="to_date" value="<? echo $_POST['to_date']; ?>" >
            </td>
        </tr>
        <tr>
        	<td align="center" colspan="27" bgcolor="#f0f0f0"><input type="submit" name="submit" id="submit" value="submit" onclick="return Fundatecheck();" /></td>	
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
	$sql_orderdata ="select * from orderdata where Order_Id BETWEEN '$from_date' AND '$to_date' ORDER BY Order_Id";
	$res_orderdata =mysql_query($sql_orderdata);
	$num_orderdata=mysql_num_rows($res_orderdata);
	if($num_orderdata > 0)
	{
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="reference" id="ReportTable">
  <tr>
    <td bgcolor="#f0f0f0">Order Number </td>
    <td bgcolor="#f0f0f0">Order Date </td>
    <td bgcolor="#f0f0f0">Billing First Name</td>
    <td bgcolor="#f0f0f0">Billing Last Name</td>
    <td bgcolor="#f0f0f0">Billing Company</td>
    <td bgcolor="#f0f0f0">Billing Address</td>
    <td bgcolor="#f0f0f0">Billing City</td>
    <td bgcolor="#f0f0f0">Billing State</td>
    <td bgcolor="#f0f0f0">Billing Zip Code</td>
    <td bgcolor="#f0f0f0">Billing Country</td>
    <td bgcolor="#f0f0f0">Customer Phone</td>
    <td bgcolor="#f0f0f0">Customer Email</td>
    <td bgcolor="#f0f0f0">Shipping First Name</td>
    <td bgcolor="#f0f0f0">Shipping Last Name</td>
    <td bgcolor="#f0f0f0">Shipping Company</td>
    <td bgcolor="#f0f0f0">Shipping Address</td>
    <td bgcolor="#f0f0f0">Shipping City</td>
    <td bgcolor="#f0f0f0">Shipping State</td>
    <td bgcolor="#f0f0f0">Shipping Zip Code</td>
    <td bgcolor="#f0f0f0">Item</td>        
    <td bgcolor="#f0f0f0">Qty</td>
    <td bgcolor="#f0f0f0">Unit_Price</td>
    <td bgcolor="#f0f0f0">Total</td>
     <td bgcolor="#f0f0f0">Email</td>
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

			$invoice_number=substr($datanew['invoiceno'],0,20);
			//echo $invoice_number;
			$description=substr("SAVANI FARM PREMIUM KESAR MANGOES",0,255);
			$amount=substr(number_format($datanew['Order_Tot'],2),0,15);
			//echo $amount;
			
			
			$sql_order="select * from ordermaster where order_id='$datanew[Order_Id]'";
			//echo $sql_order;
			$res_order =mysql_query($sql_order);
			$num_order=mysql_num_rows($res_order);
			$data_order =mysql_fetch_assoc($res_order);
			
			$sql_pay="select * from productmast where PordId='$data_order[prod_id]'";
			$res_pay =mysql_query($sql_pay);
			$num_pay=mysql_num_rows($res_pay);
			$data_pay =mysql_fetch_assoc($res_pay);
			
			
			
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
         <? 
				  $Order_Date =$datanew['Order_Date'];
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
				  
				  
					$sub_Total =$data_order['orderd_qty'] * $data_order['Order_rate'];
					$Unit_Price =$data_order['Order_rate'];
					$Ship_Tot  =$datanew['Ship_Tot'];
					$Order_Tot = $datanew['Order_Tot'];
				  
				  
          
		$sql_fz = "SELECT * From ordermaster WHERE orderno='$data_order[orderno]'";
		$res_fz= mysql_query($sql_fz);
		$num_fz=mysql_num_rows($res_fz);
		$i=1;
		while($row_pp = mysql_fetch_assoc($res_fz))
		{
		$sql_pp = "SELECT * From productmast WHERE PordId='$row_pp[prod_id]'";
		//echo $sql_pp;
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
		}
 ?>        
          <tr>
            <td><? echo $invoice_number; ?></td>
            <td><? echo $ordate; ?></td>
            <td><? echo $bill_fname; ?></td>
            <td><? echo $bill_lname; ?></td>
            <td><? echo $bil_comp_name; ?></td>
            <td><? echo $bill_address; ?></td>
            <td><? echo $bill_city; ?></td>
            <td><? echo $bill_state; ?></td>
            <td><? echo $bill_zip; ?></td>
            <td><? echo $bill_country; ?></td>
            <td><? echo $customer_phone; ?></td>
            <td><? echo $customer_email; ?></td>
            <td><? echo $ship_fname; ?></td>
            <td><? echo $ship_lname; ?></td>
            <td><? echo $ship_company; ?></td>
            <td><? echo $ship_address; ?></td>
            <td><? echo $ship_city; ?></td>
            <td><? echo $ship_state; ?></td>
            <td><? echo $ship_zip; ?></td>
            <td><? //echo $ProdName; ?>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0">
                   	<?
						$sql_fz = "SELECT * From ordermaster WHERE orderno='$data_order[orderno]'";
						$res_fz= mysql_query($sql_fz);
						$num_fz=mysql_num_rows($res_fz);
						$i=1;
						while($row_pp = mysql_fetch_assoc($res_fz))
						{
						$sql_pp = "SELECT * From productmast WHERE PordId='$row_pp[prod_id]'";
						//echo $sql_pp;
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
					?>
                        <tr>
                            <td><? echo $ProdName; ?></td>
                        </tr>
                   <?
				   }
				   ?>
                    </table>
            </td>
            <td>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <?
					$sql_fz = "SELECT * From ordermaster WHERE orderno='$data_order[orderno]'";
					$res_fz= mysql_query($sql_fz);
					$num_fz=mysql_num_rows($res_fz);
					$i=1;
					while($row_pp = mysql_fetch_assoc($res_fz))
					{
				?>
                <tr>
                <td valign="middle"><? echo $row_pp['orderd_qty']; ?><br>BOX</td>
                </tr>
                <?
				}
				?>
                </table>
			
            <td>
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <?
					$sql_fz = "SELECT * From ordermaster WHERE orderno='$data_order[orderno]'";
					$res_fz= mysql_query($sql_fz);
					$num_fz=mysql_num_rows($res_fz);
					$i=1;
					while($row_pp = mysql_fetch_assoc($res_fz))
					{
				?>
                <tr>
                <td valign="middle">$<? echo number_format($row_pp['Order_rate'],2).""."/Per Box";?> </td>
                </tr>
                <?
				}
				?>
                </table>
            
            </td>
            <td>
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <?
					$sql_fz = "SELECT * From ordermaster WHERE orderno='$data_order[orderno]'";
					$res_fz= mysql_query($sql_fz);
					$num_fz=mysql_num_rows($res_fz);
					$i=1;
					while($row_pp = mysql_fetch_assoc($res_fz))
					{
						$sub_Total11 =$row_pp['orderd_qty'] * $row_pp['Order_rate'];
				?>
                <tr>
                	<td>$<? echo number_format($sub_Total11,2); ?></td>
                </tr>
                <?
				}
				?>
                </table>
            
            </td>
           <td>
           <a href="javascript:setprocessflag('send_mail_demo.php?invoice_number=<? echo $invoice_number; ?>','window1');">Send Email</a>
           </td>
          
          </tr>
         
  <?
  		 
  
		}
	}
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

<div id="mailmsgbox" align="left"></div>
</form>
</body>
</html>