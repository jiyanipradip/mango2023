<?php 
include("../../library/config.php");
if (!defined('SAVANI_FARM')) {
	exit;
}
error_reporting(E_ALL ^ E_NOTICE);

$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];

$status = '';
if($_REQUEST["orderstatuscombo"]!='' && $_REQUEST["orderstatuscombo"]!='All')
 $status = "AND od_status='".$_REQUEST["orderstatuscombo"]."'";

if($_REQUEST["orderstatuscombo"]=='New')
 $status = "AND (od_status='' OR od_status='New')";
  
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
if($from_date!='' && $to_date!='')
{
    $sql_orderdata ="select * from orderdata where Order_Date BETWEEN '$from_date' AND '$to_date' ".$status." ORDER BY Order_Id";
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
			
			if($datanew['Ship_Adr2']=='')
			 $datanew['Ship_Adr2'] = ' ';
			
			$ship_address=strtoupper(substr(trim($ship_add),0,60));
			$ship_city=strtoupper(substr(trim($datanew['Ship_City']),0,40));
			$ship_state=strtoupper(substr(trim($datanew['Ship_State']),0,40));
			$ship_zip=substr($datanew['Ship_ZIP'],0,20);
			$ship_country=strtoupper(substr(trim($datanew['Ship_Country']),0,60));
			
			$sql1 = "SELECT *
							FROM ordermaster oi, productmast p 
							WHERE oi.prod_id = p.PordId and oi.order_id = '$datanew[Order_Id]'
							ORDER BY oi.order_id ASC";

			$result1 = dbQuery($sql1);
			$orderedItem1 = array();
			$strboxxx = '';
			$strboxx = '';
			$Ship_Weight = 0;
			while ($row1 = dbFetchAssoc($result1)) {
				$orderedItem1[] = $row1;
				extract($row1);
				$strboxx = $strboxx.'<br>'.$orderd_qty.' X '.$Order_rate;
				$strboxxx = $strboxxx + $orderd_qty;
				if($Order_rate=='18')
				 $Ship_Weight = $Ship_Weight + ($orderd_qty*4);
				else if($Order_rate=='29')
				 $Ship_Weight = $Ship_Weight + ($orderd_qty*8);
			}
			
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
			if($invoice_number=='1304240056')
			 $received_amount = 25.00;
			else if($invoice_number=='1305010069')
			 $received_amount = 0;
			else
			 $received_amount = $amount;
			
			if($datanew["od_status"]=='Cancelled' || $datanew["od_status"]=='Decline')
			{
			  $cancel_order = $strboxxx;
			}
			else
			{
			 $totalshipping_taken = $totalshipping_taken + $datanew["Ship_Tot"];
			 $totalshipping_given = $totalshipping_given + $datanew["actual_shipping"];
			 //$total = $total + $data_box["Sub_total"];
			 $total = $total + $data_box["Sub_total"];
			}  
			$sql_box1 = "select * from shipmethod where METHODID ='".$datanew["Ship_Method"]."'";
			$res_box1 =mysql_query($sql_box1);
			$num_box1=mysql_num_rows($res_box1);
			$data_box1 =mysql_fetch_assoc($res_box1);
			$Ship_Method = $data_box1["METHOD"];
			
			$netorder = $strboxxx - $cancel_order;
			
			$data[] = array("Sr. No"=>$jp,"Order"=>$invoice_number,"Date"=>strtoupper(date("m-d-Y",strtotime($datanew["Order_Date"]))),"Name"=>strtoupper($bill_fname.' '.$bill_lname),"Order Status"=>($datanew["od_status"]!='') ? strtoupper($datanew["od_status"]) : ' ',"Number of Boxes"=>$strboxxx,"Cancelled Order"=>($cancel_order!='') ? $cancel_order : ' ',"Net Orders"=>$netorder,"Net Charges for Mangoes"=>$data_box["Sub_total"],"Shipping Charged"=>$datanew["Ship_Tot"],"Actual Shipping"=>($datanew["actual_shipping"]) ? $datanew["actual_shipping"] : ' ' ,"Billed Amount"=>$amount,"Received Amount"=>$received_amount,"Tracking No"=>($datanew["shipping_tracking"]) ? $datanew["shipping_tracking"] : ' ' ,"Shipping Name"=>strtoupper($ship_fname.' '.$ship_lname),"Shipping Address"=>strtoupper($ship_address),"Shipping City"=>strtoupper($ship_city),"Shipping State"=>strtoupper($ship_state),"Shipping Zip Code"=>$ship_zip,"Shipping Country"=>strtoupper($ship_country),"Phone No."=>$customer_phone,"Shipping Method"=>strtoupper($Ship_Method));
			if($datanew["od_status"]!='Cancelled' || $datanew["od_status"]=='Decline')
			{
			$addressforship = $datanew['Ship_Adr1'].' '.$datanew['Ship_Adr2'];
			$shippingdata[] = array("Order"=>$invoice_number,"Name"=>strtoupper($bill_fname.' '.$bill_lname),"Shipping Address1"=>strtoupper(trim($addressforship)),"Shipping City"=>strtoupper($ship_city),"Shipping State"=>strtoupper($ship_state),"Shipping Country"=>strtoupper($ship_country),"Shipping Zip Code"=>$ship_zip,"Phone No."=>$customer_phone,"E-Mail"=>strtoupper($customer_email));
			}
		}
}
function cleanData(&$str) { 
$str = preg_replace("/\t/", "\\t", $str); 
$str = preg_replace("/\r?\n/", "\\n", $str); 
if(strstr($str, '"')) 
  $str = '"' . str_replace('"', '""', $str) . '"'; 
}
if($_REQUEST["exporttoexcelornot"]=='Yes')
{
		$filename = "Mango_Reports_".date('Ymd').".csv"; 
//header("Content-Disposition: attachment; filename=\"$filename\""); 
//header("Content-Type: application/vnd.ms-excel"); 
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header("Content-Transfer-Encoding: binary");
	$flag = false; 

	echo array2csv($data);
	exit;
}

if($_REQUEST["excelforsam"]=='Yes')
{
		$filename = "Mango_Shipping_".date('Ymd').".csv"; 
//header("Content-Disposition: attachment; filename=\"$filename\""); 
//header("Content-Type: application/vnd.ms-excel"); 
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header("Content-Transfer-Encoding: binary");
	$flag = false; 

	echo array2csv($shippingdata);
	exit;
}
function array2csv(array &$data)
{
   if (count($data) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($data)));
   foreach ($data as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="New_report_2012.css" rel="stylesheet" type="text/css" />
<title>Mango Report</title>
<style>
.fixtbl{
	width:900px;
	height:auto;
	overflow:scroll;
	height:auto;
}
</style>
<script src="jquery-latest.js"></script>
<!--<script type="text/javascript" src="jquery.js"></script>-->
<script type="text/javascript" src="validate.js"></script>
<script type="text/javascript" src="calender.js"></script>
<link rel="stylesheet" type="text/css" href="calender.css" />
    
<title>FixedHeaderTable Test</title>
<link href="css/960.css" rel="stylesheet" media="screen" />
<link href="css/defaultTheme.css" rel="stylesheet" media="screen" />
<link href="css/myTheme.css" rel="stylesheet" media="screen" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="jquery.fixedheadertable.js"></script>
<script src="demo.js"></script>    
    
<script>
  $(document).ready(function(){
    $("#form1").validate();
	$("#from_date").calendar();
	$("#to_date").calendar();
  });
  function Fundatecheck()
{	
    document.form1.exporttoexcelornot.value = '';
	document.form1.excelforsam.value = '';
	var from_date =document.getElementById("from_date").value;
	var to_date =document.getElementById("to_date").value;
	if(from_date=="")
	{
		alert("Please Enter From Date !!!");
		document.form1.from_date.focus();
		return false;
	}
	if(to_date=="")
	{
		alert("Please Enter To Date !!!");
		document.form1.to_date.focus();
		return false;
	}
	document.form1.submit();
}
function ExportExcel()
{	
	document.form1.exporttoexcelornot.value = 'Yes';
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
	document.form1.submit();
}
function ExcelForShipping()
{	
	document.form1.excelforsam.value = 'Yes';
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
	document.form1.submit();
}
  </script>
</head>

<body>
<form name="form1" id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="exporttoexcelornot" id="exporttoexcelornot" value="">
<input type="hidden" name="excelforsam" id="excelforsam" value="">
<table width="100%" border="1" cellspacing="5" cellpadding="5" class="reference" align="center">
  <tr>
  	<td align="center" bgcolor="#f0f0f0"><strong>ORDER REPORT</strong></td>
  </tr>
  <tr>
  	<td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
        <tr>
        	<td width="20%" align="right">Select <strong>FROM</strong> Date : &nbsp; <input type="text" name="from_date" id="from_date" class="box required calendarFocus" value="<?php echo $from_date; ?>" > (yyyy-mm-dd)</td>
            <td width="16%" align="left">Select <strong>TO</strong> Date : &nbsp; <input type="text" name="to_date" id="to_date" class="box required calendarFocus" value="<?php echo $to_date ?>" > (yyyy-mm-dd)</td>
			<td width="16%" align="left"><strong>Order Status</strong>
			<select name="orderstatuscombo" id="orderstatuscombo">
			  <option value="All" <?php if($_REQUEST["orderstatuscombo"]=='All') echo 'selected="selected"';?>>All</option>
			  <option value="New" <?php if($_REQUEST["orderstatuscombo"]=='New') echo 'selected="selected"';?>>New</option>
			  <option value="Paid" <?php if($_REQUEST["orderstatuscombo"]=='Paid') echo 'selected="selected"';?>>Paid</option>
			  <option value="Decline" <?php if($_REQUEST["orderstatuscombo"]=='Decline') echo 'selected="selected"';?>>Decline</option>
			  <option value="Shipped" <?php if($_REQUEST["orderstatuscombo"]=='Shipped') echo 'selected="selected"';?>>Shipped</option>
			  <option value="Completed" <?php if($_REQUEST["orderstatuscombo"]=='Completed') echo 'selected="selected"';?>>Completed</option>
			  <option value="Cancelled" <?php if($_REQUEST["orderstatuscombo"]=='Cancelled') echo 'selected="selected"';?>>Cancelled</option>
			</select> </td>
        </tr>
        <tr>
        	<td align="center" colspan="27" bgcolor="#f0f0f0"><input type="button" name="button1" id="button1" value="Submit" onclick="return Fundatecheck();" /> &nbsp;&nbsp;<input type="button" name="button2" id="button2" value="Export to Excel" onclick="return ExportExcel();" /> &nbsp;&nbsp;<input type="button" name="button3" id="button3" value="Excel for Shipping" onclick="return ExcelForShipping();" /></td>	
        </tr>
        </table>
    </td>
  </tr>
  </table>
  <br />
  <br />
    
    <div class="container_12">
    		<div class="grid_4">
    			
    				<script>
$('#myTable01').fixedHeaderTable({ 
	footer: true,
	cloneHeadToFoot: true,
	altClass: 'odd',
	autoShow: false
});
    			</script>
    			
    		</div>
    		<div class="grid_8 height250">
    			<table class="fancyTable" id="myTable01" cellpadding="0" cellspacing="0">
    			    <thead>
    			        <tr>
    			            <th bgcolor="#FFFF00"><strong>Sr. No</strong></th>
                            <th bgcolor="#FFFF00"><strong>Order</strong></th>	
                            <th bgcolor="#FFFF00"><strong>Date</strong></th>
                            <th bgcolor="#FFFF00"><strong>Name</strong></th>
                            <th bgcolor="#FFFF00"><strong>Order Status</strong></th>
                            <th bgcolor="#FFFF00"><strong>Number of Boxes</strong></th>
                            <th bgcolor="#CC6666"><strong>Cancelled Boxes</strong></th>
                            <th bgcolor="#33CC66"><strong>Net Orders</strong></th>
                            <th bgcolor="#FFFF00"><strong>Net Charges for Mangoes</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Charged</strong></th>
                            <th bgcolor="#FFFF00"><strong>Fedex Shipping Charges</strong></th>
                            <th bgcolor="#FFFF00"><strong>Billed Amount</strong></th>
                            <th bgcolor="#FFFF00"><strong>Received Amount</strong></th>
                            <th bgcolor="#FFFF00"><strong>Tracking No</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Name</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Address</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping City</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping State</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Zip Code</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Country</strong></th>
                            <th bgcolor="#FFFF00"><strong>Phone No.</strong></th>
                            <th bgcolor="#FFFF00"><strong>Shipping Method</strong></th>
    			        </tr>
    			    </thead>
    			    <tbody>
                        <?php 
                        if(count($data)>0)
                        {
    			          $total = 0;
                          $totalshipping_taken = 0;
                          $totalshipping_given = 0;
                          $totalNumberofBoxes = 0;
                          $totalCancelled_Order = 0;
                          $totalNet_Orders = 0;
                          $totalNetChargesforMangoes = 0;
                          $totalReceivedAmount = 0;
                          foreach($data as $row) 
                          { 
                           $bgcolor = '#fff';
                           if($row["Order Status"]=='CANCELLED')
                            $bgcolor = '#CC6666';
                           if($row["Order Status"]=='DECLINE')
                            $bgcolor = '#33CC66';

                           $totalNumberofBoxes = $totalNumberofBoxes + $row["Number of Boxes"];
                           $totalCancelled_Order = $totalCancelled_Order + $row["Cancelled Order"];
                           $totalNet_Orders = $totalNet_Orders + $row["Net Orders"];
                           $totalNetChargesforMangoes = $totalNetChargesforMangoes + $row["Net Charges for Mangoes"];
                           $totalshipping_taken = $totalshipping_taken + $row["Shipping Charged"];
                           $totalshipping_given = $totalshipping_given + $row["Actual Shipping"];
                           $totalReceivedAmount = $totalReceivedAmount + $row["Received Amount"];
                           $total = $total + $row["Billed Amount"];

                          ?>
                              <tr bgcolor="<?php echo $bgcolor;?>">
                                <td><?php echo $row["Sr. No"]; ?></td>
                                <td><?php echo $row["Order"]; ?></td>
                                <td><?php echo $row["Date"]; ?></td>
                                <td><?php echo $row["Name"]; ?></td>
                                <td><?php echo $row["Order Status"]; ?></td>
                                <td><?php echo $row["Number of Boxes"]; ?></td>
                                <td><?php echo $row["Cancelled Order"]; ?></td>
                                <td><?php echo $row["Net Orders"]; ?></td>
                                <td><?php echo $row["Net Charges for Mangoes"]; ?></td>
                                <td><?php echo $row["Shipping Charged"]; ?></td>
                                <td><?php echo $row["Actual Shipping"]; ?></td>
                                <td><?php echo $row["Billed Amount"]; ?></td>
                                <td><?php echo $row["Received Amount"]; ?></td>
                                <td><?php echo $row["Tracking No"]; ?></td>
                                <td><?php echo $row["Shipping Name"]; ?></td>
                                <td><?php echo $row["Shipping Address"]; ?></td>
                                <td><?php echo $row["Shipping City"]; ?></td>
                                <td><?php echo $row["Shipping State"]; ?></td>
                                <td><?php echo $row["Shipping Zip Code"]; ?></td>
                                <td><?php echo $row["Shipping Country"]; ?></td>
                                <td><?php echo $row["Phone No."]; ?></td>
                                <td><?php echo $row["Shipping Method"]; ?></td>
                              </tr>
                      <?php
                      }
                      ?> 
                      <tr>
                       <td colspan="25">&nbsp;</td>
                      </tr>     
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $totalNumberofBoxes;?></strong></td>
                        <td><strong><?php echo $totalCancelled_Order;?></strong></td>
                        <td><strong><?php echo $totalNet_Orders;?></strong></td>
                        <td><strong><?php echo $totalNetChargesforMangoes;?></strong></td>
                        <td><strong><?php echo $totalshipping_taken;?></strong></td>
                        <td><strong><?php echo $totalshipping_given;?></strong></td>
                        <td><strong><?php echo $total;?></strong></td>
                        <td><strong><?php echo $totalReceivedAmount;?></strong></td>
                        <td></td>	
                        <td colspan="8"></td>
                      </tr>     
                         </tbody>
                    </table>
                  
<?php }else
	{
		$msg = "NO RECORDS FOUND !!!";
	?>
    	<table width="100%" border="1" cellspacing="0" cellpadding="0" class="reference"><tr><td align="center"><font color="#FF0000"><?php echo $msg; ?></font></td></tr></table>
    <?php }
?>
                </div>
    		<div class="clear"></div>
    	</div>
<input type="hidden" id="datatodisplay" name="datatodisplay" value="<?php echo $str; ?>" />
</form>
</body>
</html>