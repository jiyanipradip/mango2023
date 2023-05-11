<?php 
require_once 'config.php';
error_reporting(E_ALL ^ E_NOTICE);
/*********************************************************
*                 CHECKOUT FUNCTIONS  ORIGINAL PAGE USED DEEPAK
*********************************************************/
function saveOrder()
{
	$zipcode1 =$_SESSION['shipamtses'];
	//echo $zipcode1;
	$cbomethod1=$_SESSION['cbomethod1ses'];
	//echo $cbomethod1;
	$radiotype1=$_SESSION['radiotype1ses'];
	
	//$totwt=$_SESSION['totwt'];
	//echo $radiotype1;  die;
	
	$orderId       = 0;
	$shippingCost  = 5;
	$requiredField = array('hidShippingFirstName', 'hidShippingLastName', 'hidShippingAddress1', 'hidShippingCity', 'hidShippingPostalCode',
						   'hidPaymentFirstName', 'hidPaymentLastName', 'hidPaymentAddress1', 'hidPaymentCity', 'hidPaymentPostalCode');
						   
	//if (checkRequiredPost($requiredField)) {
	    extract($_POST);
		$hidShippingFirstName = ucwords($hidShippingFirstName);
		$hidShippingLastName  = ucwords($hidShippingLastName);
		$hidPaymentFirstName  = ucwords($hidPaymentFirstName);
		$hidPaymentLastName   = ucwords($hidPaymentLastName);
		$hidShippingCity      = ucwords($hidShippingCity);
		$hidPaymentCity       = ucwords($hidPaymentCity);
		
		
		$hidPaymentphone       = $_POST['hidPaymenttxtphone'];
		$hidPaymentemail       = $_POST['hidPaymentemail'];
		$hidPaymentcountry       = $_POST['hidPaymentcountry'];
		$hidshippingphone       = $_POST['hidShippingphone'];
		$hidshippingemail       = $_POST['hidShippingemail'];;
		$hidshippingcountry       = $_POST['hidShippingcountry'];
		
		$hidPaymentfax       = $_POST['hidPaymenttxtfax'];
		$hidshippingfax       = $_POST['hidShippingfax'];
		$hidshippingairport       = $_POST['hidShippingairport'];
		$towhomthanks=$_POST['towhomthanks'];
		if($towhomthanks =='other')
		{
			$towhomthanks=$_POST['otherrefer'];
		}
					
			$sid = session_id();
			
			$sqlccode = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
			$resultccode = dbQuery($sqlccode);
			$rowccode=mysql_fetch_assoc($resultccode);	
			
			$couponcode=$rowccode['Coupon_code'];
			
			
			$sqlccode12 = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
			$resultccode12 = dbQuery($sqlccode12);
			$totwt=0;
			while($rowccode12=mysql_fetch_assoc($resultccode12))
			{
				$GrossWeight =$rowccode12['GrossWeight'];
				$totwt = $totwt + ($rowccode12['GrossWeight'] * $rowccode12['Qty']);
				
			}			

		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		
		$sqlcustmast = "select * from custmast where bill_email='$_SESSION[udepot]'";
		$rescustmast =mysql_query($sqlcustmast);
		$datacustmast=mysql_fetch_assoc($rescustmast);
		$custmustid = $datacustmast['custid'];
		//echo $custmustid; die;
		
		//$discount = $totamt - (number_format(($totamt - Get_Percent($Coupon_Rate,$totamt)),2));
		
		if($Coupon_Rate=='0' || $Coupon_Rate=="")
		{	
			$discount = '0';
		}
		else
		{
			//$discount = Get_Percent($Coupon_Rate,$totamt);
			$discount = ($totamt * $Coupon_Rate)/100;
		}
	
		
		
		//echo $hidshippingphone; die;
		// save order & get order id
		$sql = "INSERT INTO orderdata(Order_Date,Customer_Id, FName, LName, Adr1, 
		                              Adr2, State, City, ZIP, 
                                      Ship_FName, Ship_LName, Ship_Adr1, Ship_Adr2, 
									   Ship_State, Ship_City, Ship_ZIP,Country,Phone,Email_Id,Ship_Country,Ship_Phone,Ship_Email_Id,Ship_Method,Ship_Zipcode,Ship_Desti,Ship_Tot,Order_Wt,Fax,Ship_Fax,AIRPORT,Referal,Coupon_code)
                VALUES (NOW(),'$custmustid','$hidShippingFirstName', '$hidShippingLastName', '$hidShippingAddress1', 
				        '$hidShippingAddress2', '$hidShippingState', '$hidShippingCity', '$hidShippingPostalCode',
						'$hidPaymentFirstName', '$hidPaymentLastName', '$hidPaymentAddress1', 
						'$hidPaymentAddress2', '$hidPaymentState', '$hidPaymentCity', '$hidPaymentPostalCode','$hidshippingcountry','$hidshippingphone','$hidshippingemail','$hidPaymentcountry','$hidPaymentphone','$hidPaymentemail','$cbomethod1','$zipcode1','$radiotype1','$_SESSION[shipamt44]','$totwt','$hidshippingfax','$hidPaymentfax','$hidshippingairport','$towhomthanks','$couponcode')";
		
		//echo $sql;
		
		$result = dbQuery($sql);
		
		$new_autoid = mysql_insert_id();
		
		//echo $new_autoid; die;

		$orderId = dbInsertId();
		//echo $orderId;die;
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++)
			{
				extract($cartContent[$i]);
			$dt = date(ymd);
			$len = strlen($orderId);
			
			if($len == 4)
			{
			$orderno=$dt.$orderId;
			}else
			if($len == 3)
			{
			$orderno=$dt."0".$orderId;
			}
			else
			if($len == 2)
			{
			$orderno=$dt."00".$orderId;
			}
			else
			if($len == 1)
			{
			$orderno=$dt."000".$orderId;
			}
			else
			{
			$orderno=$dt."0000";
			}
				
				$sid = session_id();
				
				//This code comment for when we complete process checkout after that page Unit Price not correct so
				// I comment following block....[samir parikh]
				/*$sqlprod="select * from cartdetail ct,productmast  pd 
				where ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId and ";
				$resultprod=mysql_query($sqlprod);
				$rowprod=mysql_fetch_assoc($resultprod);
				$Unit_Price=$rowprod['Unit_Price'];
				$Coupon_Rate=$rowprod['Coupon_Rate'];*/
				if($rowprod['INR'] == '')
				{
				$Order_Type = "USD";
				}
				else
				{
					$Order_Type = "INR";
				}
				//$subtotal=number_format($cartContent[$i]['Qty']*($Unit_Price),2);
				$subtotal=$cartContent[$i]['Qty']*($Unit_Price);
				//$codedprice=number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2);
				$codedprice=number_format($Unit_Price,2);
				
				//echo "codeprice=".$codedprice."<br>";
				$sql = "INSERT INTO ordermaster(orderno,order_id, prod_id, orderd_qty,Order_rate,Sub_total,Order_Type)
						VALUES ('$orderno','$orderId','{$cartContent[$i]['Prod_Id']}',{$cartContent[$i]['Qty']},'$codedprice','$subtotal','$Order_Type')";
				//echo $sql."<br>";
				$result = dbQuery($sql);					
						$paymethod = $_POST['hidtxtpaymentmethod'];
						$ccnum = $_POST['hidtxtccnum'];
						$ccname = $_POST['hidtxtccname'];
						$expiredate = $_POST['hidtxtccexpiredate'];
						$cc2value = $_POST['hidtxtccv2value'];
						$cartid = $_POST['hidtxtcartid'];
						$otcno = $_POST['hidtxtotcno'];
						
				$sql_update = "UPDATE orderdata SET `invoiceno`='$orderno' WHERE `Order_Id`='$new_autoid'";
				//echo $sql_update; die;
				$res_update = mysql_query($sql_update);
			}
			//die;
			require_once 'encrypt1.php';

						// Encrypting Data
					   $Str_paymethod = ENCRYPT_DECRYPT($paymethod); 
   					   $Str_payccnum =  ENCRYPT_DECRYPT($ccnum); 
					   $Str_payccname = ENCRYPT_DECRYPT($ccname); 
					   $Str_payexpdate =ENCRYPT_DECRYPT($expiredate); 
					   $Str_paycc2vval =ENCRYPT_DECRYPT($cc2value); 
   					   $Str_payotcno =ENCRYPT_DECRYPT($otcno); 

					   $kl = addslashes($Str_paymethod);
					   $k2 = addslashes($Str_payccnum);
					   $k3 = addslashes($Str_payccname);
					   $k4 = addslashes($Str_payexpdate);
					   $k5 = addslashes($Str_paycc2vval);
					   $k6 = addslashes($Str_payotcno);
						
						$sql4 = "INSERT INTO paydetail(order_id, Pay_Method, Card_No, Card_Name, Card_Exp, Card_CVV, Cart_Id,OTC_NO)
						VALUES ('$orderId','$kl','$k2','$k3','$k4','$k5','$cartid','$k6')";
				$result4 = dbQuery($sql4);	
			
				//echo $sql4;
			
			//echo $sql4; die;
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "UPDATE productmast 
				        SET TotBuyQty = TotBuyQty - {$cartContent[$i]['Qty']}
						WHERE PordId = '{$cartContent[$i]['Prod_Id']}'";
				//echo "gbjhjkh".$sql; die;
				$result = dbQuery($sql);					
				//
			}
			// 9 july inserting data in to cart list
			
			if(isset($_SESSION['MKEYTMP']) && isset($_SESSION['masterkey']))
	{
	
	$p = $_SESSION['masterkey'];
	$sql9 = "SELECT prod_id, orderd_qty from ordermaster where order_id = '$orderId'";
	$result9 = dbQuery($sql9);
	//echo mysql_num_rows($result9);die;
	$sid = session_id();
	
	while ($row = dbFetchAssoc($result9)) {
		extract($row);
		$qty = $row['orderd_qty'];
	$productId = $row['prod_id'];
	//echo $productId."<br>";
		//  FOR CONTRACT
		
		
		$sqlcontractsearchprod = "SELECT *
	        FROM userprice
			WHERE Prod_code = '$productId' and Customername = '$p'";
	$resultcontractsearchprod = dbQuery($sqlcontractsearchprod);
			if (dbNumRows($resultcontractsearchprod) == 0) {		
		
		$sqlcontract = "INSERT INTO userprice (Prod_code,Customername,Last_Purchase_qty,ct_session_id,Date)
				VALUES ('$productId','$p','$qty','$sid',NOW())";
		$resultcontract = dbQuery($sqlcontract);
		}
		else
		{
	$sqlcontract = "UPDATE userprice SET Last_Purchase_qty = '$qty',Date = now() where Customername = '$p' AND Prod_code = '$productId'";
	$resultcontract = dbQuery($sqlcontract);
		
		}
		//    FOR CONTRACT COMPLETES
		
		
		$sql3 = "SELECT *
	        FROM cartlist
			WHERE Prod_Id = '$productId' and Customer_Name = '$p'";
	$result3 = dbQuery($sql3);
	//echo dbNumRows($result3);
	if (dbNumRows($result3) == 0) {
		
		$sql2 = "INSERT INTO cartlist (Prod_Id,Customer_Name ,Qty,ct_session_id,Cart_Date)
				VALUES ('$productId','$p','$qty','$sid',NOW())";
		$result2 = dbQuery($sql2);
	
}
	}
}	
	
	
	//

		
		//
			//9 july inserting data in to cart list completes
			// then remove the ordered items from cart
			
			
			/*for ($i = 0; $i < $numItem; $i++) {
				$sql = "DELETE FROM cartdetail
				        WHERE Cart_Id = {$cartContent[$i]['Cart_Id']}";
				$result = dbQuery($sql);					
			}*/	
			
		}					
	//}
	
	$sqlupdateorderdata="select * from ordermaster where order_id='$orderId'";
	$resultupdateorderdata=mysql_query($sqlupdateorderdata);
	$totamt=0;
	while($rowupdateorderdata=mysql_fetch_assoc($resultupdateorderdata))
	{
		$totamt=$totamt+$rowupdateorderdata['Sub_total'];
		$Order_Type = $rowupdateorderdata['Order_Type'];
	}
	
	$sqlupdate="UPDATE orderdata SET `Prod_Tot`='$totamt' ,`Order_Type` = '$Order_Type' where Order_Id='$orderId'";
	$resultupdate=mysql_query($sqlupdate);
	
	$sqlorderdata1="select * from orderdata where Order_Id='$orderId'";
	$resultorderdata1=mysql_query($sqlorderdata1) or die(mysql_error());
	
	//$discount = $totamt - (number_format(($totamt - Get_Percent($Coupon_Rate,$totamt)),2));
	
	 if($Coupon_Rate=='0' || $Coupon_Rate=="")
	{	
		$discount = '0';
	}else
	{
		//$discount = Get_Percent($Coupon_Rate,$totamt);
		$discount = ($totamt * $Coupon_Rate)/100;
	}
	
	while($roworderdata1=mysql_fetch_assoc($resultorderdata1))
	{
		extract($roworderdata1);
		//echo $roworderdata1['Prod_Tot']."----<br>";
		
		$Order_Tot1 = $Prod_Tot - $Coupon_Tot - $Gift_Tot - $Disc_Tot + $Tax_Tot + $SurChg_Tot + $HandChg_Tot + $Ship_Tot;
		$Order_Tot = $Order_Tot1 -  $discount; 
		$sqlupdate="UPDATE orderdata SET `Order_Tot`='$Order_Tot' where Order_Id='$orderId'";
		//$sqlupdate="UPDATE orderdata SET `Order_Tot`='$Order_Tot',`Disc_Tot`='$discount' where Order_Id='$orderId'";
		//echo $sqlupdate;die;
		$resultupdate=mysql_query($sqlupdate);
	}
	return $orderId."-".$orderno;
}
/*
	Get order total amount ( total purchase + shipping cost )
*/
function getOrderAmount($orderId)
{
	$orderAmount = 0;
	$sql = "SELECT SUM(PucrPrice * TotBuyQty)
	        FROM ordermaster oi, productmast p 
		    WHERE oi.prod_id = p.PordId and oi.order_id = $orderId";
	//echo $sql; die;
	$result = dbQuery($sql);
	if (dbNumRows($result) == 2) {
		$row = dbFetchRow($result);
		$totalPurchase = $row[0];
		
		$row = dbFetchRow($result);
		$shippingCost = $row[0];
		
		$orderAmount = $totalPurchase + $shippingCost;
	}	
	
	return $orderAmount;	
}
?>