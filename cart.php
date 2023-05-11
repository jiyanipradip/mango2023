<?php 
require_once 'library/config.php';
require_once 'library/cart-functions.php';
$errormessage='';
error_reporting(E_ALL ^ E_NOTICE);

if($_POST['submitcal'])
{
	$zipcode1 =$_POST['zipcode'];
	$_SESSION['shipamtses']=$zipcode1;
	 
	$cbomethod1 = $_POST['cbomethod1'];
	$_SESSION['cbomethod1ses']=$cbomethod1;
	
	$radiotype1 = $_POST['radiotype'];
	$_SESSION['radiotype1ses']=$radiotype1;
	//echo $zipcode1.'=='.$cbomethod1.'=='.$radiotype1;
	
	$sqlm ="select * from shipmethod where METHODID='$cbomethod1'";
	//echo $sqlm; die;
	$resm=mysql_query($sqlm);
	$datam=mysql_fetch_assoc($resm);
	$methdid = $datam['METHODID'];
	//echo $methdid; die;
	
	$sqlshipzone ="select * from shipzone where ZIPCODE='$zipcode1'";
	//echo $sqlshipzone; die;
	$resshipzone=mysql_query($sqlshipzone);
	$data=mysql_fetch_assoc($resshipzone);
	$num_tot=mysql_num_rows($resshipzone);
	$shipzone_days = $data['DAYS'];
	$zonerate ='ZONE'.$data['ZONE'];
	//echo $shipzone_days."<br>";
	//echo $methdid."<br>";
    if($num_tot > 0)
	{
		//if($shipzone_days > 2 && $methdid > 40)
		if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30))
		{
			$msg= "Due to the perishable nature of this product we do not recommend Selected Shipping Method for your area. Please select an alternate mode of shipping OR Give us a call at 1-855-696-2646 for more information.";
		}
		
		$itemQty   = $_POST['txtQty'];
		$numItem    = count($itemQty);
		$productId  = $_POST['hidProductId'];
		$totwt = 0;
		//print_r($itemQty); echo "<br>";
		//print_r($productId);
	
		for ($i = 0; $i < count($productId); $i++)
		{
			$newQty = (int)$itemQty[$i];
			$sql_new = "SELECT GrossWeight from productmast where PordId = $productId[$i]";
			//echo $sql_new;
			$res_new=mysql_query($sql_new);
			$data_new=mysql_fetch_assoc($res_new);
			//echo $data_new['GrossWeight'];
			$totwt = $totwt + ($data_new['GrossWeight'] * $newQty);
		}
		//die;
		//echo $totwt;
		//$_SESSION['totwt']=$totwt;
		$RateWt = $totwt;
		//echo $methdid;
		
		if($methdid < 50)   //Ground
		{
			//echo $methdid;
			
			if($totwt > 1999)
				{
					$RateWt = 2000;
				}
			elseif($totwt > 999)
				{
					$RateWt = 1000;
				}
			elseif($totwt > 499)
				{
					$RateWt = 500;
				}
			elseif($totwt > 99)
				{
					$RateWt = 100;
				}
		}
		//echo $RateWt."<br>";
		//echo $RateWt . "-" . $totwt;
		
		$sql5 ="select $zonerate as zr from shiprate where METHODID='$cbomethod1' and WEIGHT='$RateWt'";
		//echo $sql5; die;
		$res5=mysql_query($sql5);
		//$num_rec =mysql_num_rows($res5);
		$data5=mysql_fetch_assoc($res5);
		$num_shiprate = mysql_num_rows($res5);

		//echo $num_shiprate;
		//echo $totwt;
		if($num_shiprate > 0)
		{
			//echo $data5['zr'] . ' * '. $totwt;
			if($totwt > 99 && $methdid < 50)
			{
				$shipamt1 = ROUND($data5['zr'] * $totwt,2);
				//echo "IF".$shipamt1;
			}
			else
			{
				$shipamt1 = $data5['zr'];
				//echo "ELSE".$shipamt1;
			}
			//die;
			
			//echo $shipamt1;
			//die;
			//echo "Ship " . $shipamt1 . $radiotype1 ;

			if($radiotype1=='residence') 
			{
				//$shipamt1 = $data5['zr'];
				//echo $shipamt1. '-1-';
				//echo $datam['RESSUR'];
				/*if($methdid=='50')
                {
                    //echo $itemQty[0];
				    $shipamt4 = round(2.99 * $totqt,2);
				
				    $_SESSION['shipamt44']=$shipamt4; 
                    
                }else{*/
                    $shipamt2 = $shipamt1 + $datam['RESSUR'];
				    $shipamt4 = round($shipamt2 + round(($shipamt2*$datam['FUELSUR']/100),2),2);
				//echo '4 ' . $shipamt4;
				//echo $shipamt3;
				//$shipamt4 = round($shipamt3,2);
				    $shipamt14 = round(($shipamt4*20/100),2) + $shipamt4;
				    $_SESSION['shipamt44']=$shipamt14; 
               // }
                
				//echo $shipamt4. '-4-';
			}
			
			
			if($radiotype1=='Business') 
			{
				//$shipamt1 = $data5['zr'];
				//echo $shipamt1. '-1-';
                /*if($methdid=='50')
                {
                    //echo $itemQty[0];
				    $shipamt4 = round(2.99 * $totqt,2);
				    $_SESSION['shipamt44']=$shipamt4; 
                    
                }
                else
                {*/
                    $shipamt2 = $shipamt1 + $datam['BUSSUR'];
                    $shipamt4 = round($shipamt2 + round(($shipamt2*$datam['BUS_FUELSUR']/100),2),2);

                    //echo $shipamt3;
                    //$shipamt4 = round($shipamt3,2);
                    $shipamt14 = round(($shipamt4*20/100),2) + $shipamt4;
                    $_SESSION['shipamt44']=$shipamt14;
               // }
			}
		}
		else
		{
			$msg= "For shipping charge of your order please Give us a call at 1-855-696-2646 for more information.";
		}
	 }
	 else
	 {
	 	$msg="PLEASE CHECK ZIPCODE !!!";
	 }
 }
?>
<script src="jquery-latest.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function FunValidateShip()
{

	if(document.getElementById("zipcode").value=="" || isNaN(document.getElementById("zipcode").value))
	{
		alert("Please Enter Zipcode With Numeric Value !!!");
		document.getElementById('zipcode').value = '';
		document.getElementById("zipcode").focus();
		return false;
	}
	if(document.getElementById("cbomethod1").selectedIndex=="")
	{
		alert("Please Select Method !!!");
		//document.frmCart.cbomethod1.focus();
		return false;
	}
}
function validatecheckout()
{
	
	if(document.getElementById("zipcode").value=="" || isNaN(document.getElementById("zipcode").value))
	{
		alert("Please Enter Zipcode With Numeric Value !!!");
		document.getElementById('zipcode').value = '';
		document.getElementById("zipcode").focus();
		return false;
	}
	if(document.getElementById("cbomethod1").selectedIndex=="")
	{
		alert("Please Select Method !!!");
		//document.frmCart.cbomethod1.focus();
		return false;
	}
	if(document.getElementById("txtshipc").value=="" || document.getElementById("hiddenzipcode").value=="" || document.getElementById("hiddenmethod").value=="")
	{
		alert("Please Calculate Shipping !!!");
		return false;
	}
	if(document.getElementById('zipcode').value!=document.getElementById("hiddenzipcode").value || document.getElementById('cbomethod1').value!=document.getElementById("hiddenmethod").value || document.getElementById('radiotype').value!=document.getElementById("hiddendestination").value) 
	{
		alert("Please Calculate Again !!!");
		return false;
	}
		var zipcodechkout =document.getElementById('zipcode').value;
		var methodchkout =document.getElementById('cbomethod1').value;
		var typechkout =document.getElementById('radiotype').value;
		
		$.ajax({
		type: "POST",
		url: "cartvalidatezipcode.php",
		data: "zipcodechkout="+zipcodechkout+"&methodchkout="+methodchkout+"&typechkout="+typechkout,
		success: function(html)
		{              
			var new_arry1 = html.split("*");
			var shipzone_days=new_arry1[0];
			var num_tot=new_arry1[1];
			var methd_id=new_arry1[2];
			
			if(num_tot==0)
			{
				alert("PLEASE CHECK ZIPCODE!!!");	
				document.getElementById('zipcode').value = '';
				document.getElementById("zipcode").focus();
				return false;
			}
			if((shipzone_days >= 6 && shipzone_days <= 8) || (shipzone_days > 2 && methd_id > 30))
			{
				alert("Due to the perishable nature of this product we do not recommend Selected Shipping Method for your area. Please select an alternate mode of shipping OR Give us a call at 1-855-696-2646 for more information.!!!");	
				document.getElementById('zipcode').value = '';
				document.getElementById("zipcode").focus();
				return false;
			}
            else if(document.getElementById("txtshipc").value!="" && document.getElementById("hiddenzipcode").value!="" && document.getElementById("hiddenmethod").value!="")
			{
				window.location.href='placeanorder.php?step=4';
			}
            else
            {
                alert("Please calculate shipping...");
                window.location.href='placeanorder.php?view=1&pricingtype=DOLLOR';   
            }
			/*else
			{
				window.location.href='placeanorder.php?step=4';
			}*/
			
		}   
		});
}
function FunValidateUpdatecart()
{
	if(document.getElementById("zipcode").value=="" || isNaN(document.getElementById("zipcode").value))
	{
		alert("Please Enter Zipcode With Numeric Value !!!");
		document.getElementById('zipcode').value = '';
		document.getElementById("zipcode").focus();
		return false;
	}
	if(document.getElementById("cbomethod1").selectedIndex=="")
	{
		alert("Please Select Method !!!");
		//document.frmCart.cbomethod1.focus();
		return false;
	}
}
function functioncoupon()
{
	var couponcode =document.getElementById('couponcode').value;
	if(couponcode=='')
	{
		alert("Please Enter Couponcode!!!");
		document.getElementById("couponcode").focus();
		return false;
	}
}
</script>

<?php 
if(isset($_POST["hidProductsku"]))
{
	$sku = $_POST['hidProductsku'];
	//print_r($sku);
	$cartId     = $_POST['hidCartId'];
	//print_r($cartId);
	$productId  = $_POST['hidProductId'];
	//print_r($productId);
	$itemQty    = $_POST['txtQty'];
	//print_r($itemQty);
	$numItem    = count($itemQty);
	$couponcode1 =$_POST['couponcode'];
	$numDeleted = 0;
	$notice     = '';
	$totwt = 0;
	
	$zipcode1 =$_POST['zipcode'];
	$_SESSION['shipamtses']=$zipcode1;
	 
	$cbomethod1 = $_POST['cbomethod1'];
	$_SESSION['cbomethod1ses']=$cbomethod1;
	
	$radiotype1 = $_POST['radiotype'];
	$_SESSION['radiotype1ses']=$radiotype1;
	
	$sqlm ="select * from shipmethod where METHODID='$cbomethod1'";
	//echo $sqlm ; die;
	$resm=mysql_query($sqlm);
	$datam=mysql_fetch_assoc($resm);
	$methdid = $datam['METHODID'];
	
	$sqlshipzone ="select * from shipzone where ZIPCODE='$zipcode1'";
	//echo $sqlshipzone; die;
	$resshipzone=mysql_query($sqlshipzone);
	$data=mysql_fetch_assoc($resshipzone);
	$num_tot=mysql_num_rows($resshipzone);
	$shipzone_days = $data['DAYS'];
	$zonerate ='ZONE'.$data['ZONE'];
    
    $freeship_panjny='no';
    if($data['STATE']=='PA' || $data['STATE']=='NJ' || $data['STATE']=='NY')
    {
            $freeship_panjny = 'yes';
    }
    else
    {
            $freeship_panjny = 'no';
    }
	
	if($num_tot > 0)
	{
		//echo $methdid; die;
		if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30))
		{
			$msg= "Due to the perishable nature of this product we do not recommend<font size='2'> Selected Shipping Method</font> for your area. Please select an alternate mode of shipping OR Give us a call at 1-855-696-2646 for more information.";
		}
	
	//echo $datam['RESSUR']; die;
	
	$itemQty   = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$productId  = $_POST['hidProductId'];
	$totwt = 0;
    $totqt = 0;
	//print_r($productId);
	
	for ($i = 0; $i < count($productId); $i++)
		{
			$newQty = (int)$itemQty[$i];
			//echo $newQty;
			$sql_new = "SELECT GrossWeight,CatagoryId,DiscQty from productmast where PordId = $productId[$i]";
			//echo $sql_new;
			$res_new=mysql_query($sql_new);
			$data_new=mysql_fetch_assoc($res_new);

            $catId = $data_new['CatagoryId'];
            $DisQty = $data_new['DiscQty'];
			//echo $data_new['GrossWeight']. '--';
			if($catId=='10010' && $freeship_panjny=='yes')
            {
                $totwt = $totwt + 0;
                $totqt = $totqt + 0;
            }
            else
            {
			    $totwt = $totwt + ($data_new['GrossWeight'] * $newQty);
                $totqt = $totqt + ROUND($DisQty * $newQty,0);
            }
			//echo $data_new['GrossWeight']. '--';
			//$QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
			//$totwt = $totwt + ($data_new['GrossWeight'] * $newQty);
		}
		//echo $totwt; die;
		$RateWt = $totwt;
		if($methdid < 50)   //Ground
		{
			if($totwt > 1999)
				{
					$RateWt = 2000;
				}
			elseif($totwt > 999)
				{
					$RateWt = 1000;
				}
			elseif($totwt > 499)
				{
					$RateWt = 500;
				}
			elseif($totwt > 99)
				{
					$RateWt = 100;
				}
		}
		$sql5 ="select $zonerate as zr from shiprate where METHODID='$cbomethod1' and WEIGHT='$RateWt'";
		//echo $sql5; die;
		$res5=mysql_query($sql5);
		//$num_rec =mysql_num_rows($res5);
		$data5=mysql_fetch_assoc($res5);
		$num_shiprate = mysql_num_rows($res5);
		
		//echo $num_shiprate;
		
		if($num_shiprate > 0)
		{
			if($totwt > 99 && $methdid < 50)
			{
				$shipamt1 = ROUND($data5['zr'] * $totwt,2);
			}
			else
			{
				$shipamt1 = $data5['zr'];
			}
	
			//echo $shipamt1; die;

			if($radiotype1=='residence') 
			{
				//$shipamt1 = $data5['zr'];
				//echo $shipamt1. '-1-';
				/*if($methdid=='50')
                {
                    //echo $itemQty[0];
				    $shipamt4 = round(2.99 * $totqt,2);
				
				    $_SESSION['shipamt44']=$shipamt4; 
                    
                }else{*/
                    
                    $shipamt2 = $shipamt1 + $datam['RESSUR'];
                    $shipamt3 = $shipamt2 + round(($shipamt2*$datam['FUELSUR']/100),2);

                    //echo $shipamt3;

                    $shipamt4 = round($shipamt3,2);
                    $shipamt14 = round(($shipamt4*20/100),2) + $shipamt4;
                    $_SESSION['shipamt44']=$shipamt14;
               // }
				//echo $shipamt4. '-4-';
			}
			//echo $shipamt4; die;
			if($radiotype1=='Business') 
			{
				//$shipamt1 = $data5['zr'];
				//echo $shipamt1. '-1-';
				
                /*if($methdid=='50')
                {
                    //echo $itemQty[0];
				    $shipamt4 = round(2.99 * $totqt,2);
				
				    $_SESSION['shipamt44']=$shipamt4; 
                    
                }else{*/
                    $shipamt2 = $shipamt1 + $datam['BUSSUR'];
                    $shipamt3 = $shipamt2 + round(($shipamt2*$datam['BUS_FUELSUR']/100),2);

                    //echo $shipamt3;

                    $shipamt4 = round($shipamt3,2);
                    $shipamt14 = round(($shipamt4*20/100),2) + $shipamt4;
                    $_SESSION['shipamt44']=$shipamt14;
               // }
			}
		}
		else
		{
			$msg= "For shipping charge of your order please Give us a call at 1-855-696-2646 for more information.";
		}
		
		//echo $shipamt4; die;
		
	 }else
	 {
	 	$msg="PLEASE CHECK ZIPCODE !!!";
	 }
	
	for ($i = 0; $i < $numItem; $i++)
	{
		$newQty = (int)$itemQty[$i];
		
		//echo $newQty;
		if ($newQty < 1)
		{
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		}
		else
		{
			// check current stock
			$sql = "SELECT ProdName,PordId TotBuyQty,ProdSKU,BrandName,MinOrder
			        FROM productmast 
					WHERE PordId =$productId[$i]";
			//echo $sql;
			$result = dbQuery($sql);
			$row    = dbFetchAssoc($result);
			if ($newQty > $row['TotBuyQty'])
			{
				
				//$row['TotBuyQty']; 
				// we only have this much in stock
				$newQty = $row['TotBuyQty'];
				
				// if the customer put more than
				// we have in stock, give a notice
				if ($row['TotBuyQty'] > 0)
				{
					setError('The quantity you have requested is more than we currently have in stock. The number available is indicated in the &quot;Quantity&quot; box. ');
				}
				else
				{
					// the product is no longer in stock
					setError('Sorry, but the product you want (' . $row['pd_name'] . ') is no longer in stock');

					// remove this item from shopping cart
					deleteFromCart($cartId[$i]);	
					$numDeleted += 1;					
				}
			} 
					//echo "hii";die;		
			// update product quantity
			if($couponcode1 =='')
			{
					//echo "TEST"; die;
					
					if($newQty < $row['MinOrder'])
					{
					$errormessage='Bulk order is for 99+ boxes';
					}
					else
					{
					$sql = "UPDATE cartdetail
							SET `Qty` = $newQty,
							`Coupon_code`='',`Coupon_Rate`='',`Coupon_Amt`=''
							WHERE Cart_Id = {$cartId[$i]}";
					//echo $sql;
					dbQuery($sql);
					}
			}
			else
			{
				$tday= date('Y-m-d');
					
					if($_POST['couponcode']!=='')
					{
						$sqlcoupon="select * from couponmaster where Coupon_code='$couponcode1' AND From_Date<= '$tday' AND To_Date >= '$tday'";
					//echo $sqlcoupon;die;
					$resultcoupon=mysql_query($sqlcoupon);
					$rowcoupon=mysql_fetch_assoc($resultcoupon);
					if(mysql_num_rows($resultcoupon)<1)
					{
						$errormessage_code="CouponCode Is Not Valid";
					}
					else
					{
						$errormessage_code="CouponCode Accepted";
						//$cartContent = getCartContent();
						//$numItem = count($cartContent);
					
							if($newQty<$rowcoupon['Min_Qty'])
							{
								
								$errormessage="Coupon is valid for Quantity more than  ".$rowcoupon['Min_Qty'];
							}
							
							else if($newQty < $row['MinOrder'])
							{
							$errormessage='Bulk order is for 99+ boxes';
							}
											
							else
							{
							$Coupon_code1=$rowcoupon['Coupon_code'];
							$c1=$_POST["couponcode"];;
							$Disc_perc=$rowcoupon['Disc_perc'];
							$Disc_Amt=$rowcoupon['Disc_Amt'];
								$sql12 = "UPDATE cartdetail
									SET `Coupon_code`='$c1',`Coupon_Rate`='$Disc_perc',`Coupon_Amt`='$Disc_Amt',
									`Qty` = '$newQty' 
							WHERE Cart_Id = {$cartId[$i]}";
							//echo $sql12;die;
							$result12=mysql_query($sql12) or die(mysql_error());
							//header('location : placeanorder.php?view=1');
							}
					}
					}
			}
		}
	}
}

//***********
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';
//echo $action; die;
//echo ($action.'KISHOR');
switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'list' :
		if(isset($cartlist))
		{
		  header("Location: index.php?cartlist=cartlist");
				exit;
		}
		addTolist();
		break;
		case 'deletecoupon' :
		deletecoupon();
		break;	
		
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
		//break;
}
$cartContent = getCartContent();

//print_r($cartContent); die;
$numItem = count($cartContent);


$pageTitle = 'Shopping Cart';

// show the error message ( if we have any )
displayError();

//echo $$numItem;
if ($numItem > 0 )
{
?>
<style type="text/css">
<!--
.style1 {
	color: #333333;
	font-weight: bold;
}
-->
</style>

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
</style>

<?php /*?><?PHP
echo number_format(($_SESSION['shipamt44']),2);
?><?php */?>

<div class="container">
	<div class="row">
		
			
<form action="" method="post" name="frmCart" id="frmCart">
 <div class="col-md-12">
    
    <div class="text-center">
    <input type="button" class="btn btn-primary btn-sm" value="Continue Shopping" onClick="window.location.href='placeanorder.php?flag=Product Catalog&pricingtype=<?php echo $_GET['pricingtype']; ?>';" />
    <?php  
    if ($numItem > 0)
    {
    ?>  
    <input type="button" class="btn btn-success btn-sm" value="Checkout" height="50" onClick="return validatecheckout();">
    <?php 
    }
    ?>
    </div>
    
    
<?php 
$subTotal = 0;
$QtyDis = 0 ;     
for ($i = 0; $i < $numItem; $i++)
{
	extract($cartContent[$i]);
	$productUrl = "index.php?c=$CatagoryId&p=$Prod_Id";

	//$subTotal += ($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty;
	$subTotal += $Unit_Price * $Qty;
    //$QtyDis =$QtyDis + $Qty;
     $QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
?>
 
  	<!--<a href="<?php  //echo $productUrl; ?>">-->
<div class="product-cart">
<div class="row">
    <div class="col-md-2 col-xs-2">
        <h5>Item</h5>
    <img src="<?php  echo $pd_thumbnail; ?>" border="0" width="75px"><!--</a>-->
    </div>
    
    <div class="col-md-7 col-xs-4">
						<h5>Description</h5>
						<h6><?php echo "<b>".$ProdHead."</b>"; ?></h6>
						<h5><?php echo $ProdName; ?></h5>
						<p><?php echo $ProdDesc;  ?></p>
</div>
    
    <div class="col-md-1 col-xs-2">
                        <h5>Price</h5>
						<div class="cart-pay">
							<img src="images/<?php echo $_GET['pricingtype'];?>.jpg">$<?php echo number_format($Unit_Price,2);//echo number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2); ?><br> PER BOX
						</div>
</div>
    
    <div class="col-md-1 col-xs-2">
						<h5>Quantity</h5>
						<div class="cart-pay">
							<input name="txtQty[]" type="text" id="txtQty[]" size="5" maxlength="5" value="<?php  echo $Qty; ?>" class="box" onKeyUp="checkNumber(this);"><br>
        <input name="btnDelete" type="button" id="btnDelete" value="Remove" onClick="window.location.href='<?php  echo $_SERVER['PHP_SELF'] . "?view=1&action=delete&cid=$Cart_Id"; ?>';" class="box btn btn-primary btn-sm"> <!--<img src="images/close.png" class="close-icon">-->
                            <input name="hidCartId[]" type="hidden" value="<?php  echo $Cart_Id; ?>">
        <input name="hidProductId[]" type="hidden" value="<?php  echo $Prod_Id; ?>">
        <input name="hidProductsku[]" type="hidden" value="<?php  echo $ProdSKU; ?>">
						</div>
					</div>
   	
  	<div class="col-md-1 col-xs-2">
						<h5>Cost</h5>
						<div class="cart-pay">
							<label><img src="images/<?php echo $_GET['pricingtype'];?>.jpg">$<?php echo number_format($Unit_Price * $Qty,2); //echo number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty),2); ?></label>
						</div>
					</div>
    </div>
     </div>
     
 <?php 
}
?>
    
    <div class="product-cart">
				<div class="col-md-12">
					<h5>Calculate Shipping</h5>

				</div>
				<div class="col-md-2 col-xs-4">
						<h5>Zipcode</h5>
						<input type="text" name="zipcode" id="zipcode" size="5%" value="<?php echo $_SESSION['shipamtses']; ?>" />
				</div>
				<div class="col-md-3 col-xs-6">
						<h5>Method</h5>
                    <?php $sqlmethod ="select * from shipmethod ORDER BY METHODID DESC";
			//echo $sqlmethod; die;
            $resmethod=mysql_query($sqlmethod);
            ?>
            <select name="cbomethod1" id="cbomethod1">
            <option>--Select Method--</option>
            <?php while($datam=mysql_fetch_assoc($resmethod))
            {
            ?>
            <option value="<?php echo $datam['METHODID']; ?>" <?php if($_SESSION['cbomethod1ses']==$datam['METHODID']){ ?> selected="selected"<?php } ?>><?php echo @$datam['METHOD']; ?></option>
            <?php 
			}
            ?>
            </select>
				</div>
				<div class="col-md-3 col-xs-12">
						<h5>Destination</h5>
						<input type="radio" name="radiotype" id="radiotype" checked="checked" value="residence"  /> <label>Residance</label>
						<input type="radio" name="radiotype" id="radiotype" value="Business" <?php  if($_POST['radiotype']=="Business") { ?> checked="checked" <?php } ?> /> <label>Business</label>
				</div>
				<div class="col-md-2 col-xs-12">
						<h5>&nbsp;</h5>
						<input type="submit" class="btn btn-primary btn-sm" name="submitcal" id="submitcal" value="Calculate" onclick="return FunValidateShip();" />
						<!--<button type="button" class="btn btn-primary btn-sm">Update Cart</button>-->
				</div>
        
 <?php 
  //$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
 	//echo $Coupon_Rate."<br>";
	//echo $subTotal;
	if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount = 0;
	}
	else
	{
		//$discount = Get_Percent($Coupon_Rate,$subTotal);   //is not work perfectally....
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
        
<div class="col-md-4 col-xs-12 pull-right">

    
<table class="table table-striped table-bordered m15 text-right">
    
    <tbody>
        <?php echo $msg; ?>
      <tr>
        <td>Sub-total</td>
        <td>$<?php  echo number_format(($subTotal),2); ?></td>
      </tr>
      <tr>
        <td>
        <input type="hidden" name="hiddenzipcode" id="hiddenzipcode" value="<?php echo $_SESSION['shipamtses']; ?>" />
        <input type="hidden" name="hiddenmethod" id="hiddenmethod" value="<?php echo $_SESSION['cbomethod1ses']; ?>" />
        <input type="hidden" name="hiddendestination" id="hiddendestination" value="<?php echo $_SESSION['radiotype1ses']; ?>" />
        <input type="hidden" name="txtshipc" id="txtshipc" value="<?php echo $_SESSION['shipamt44']; ?>" />
    Shipping Charges</td>
          <td align="right"><font color="#333333">$<?php   if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30)) { echo number_format((0),2); } else { echo number_format(($_SESSION['shipamt44']),2); } ?></font></td>
      </tr>
      <tr>
        <td>Tax</td>
        <td>$00.00</td>
      </tr>
      <tr>
        <td>Total</td>
        <td align="right"><font color="#333333">$<?php  if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30)) { echo number_format($subTotal,2); }else { echo number_format($shipamt_new,2); } ?></font></td>
      </tr>
        
        <font color="#FF0000"><?php echo "<b>".$errormessage_code; ?></font>
        
    </tbody>
  </table>
    
    
<?php /*<td align="left" colspan="2"><font class="hdshopcartfour">Coupon Code : </font>
 <input type="text" name="couponcode" id="couponcode" value="<?php echo $Coupon_code; ?>">
      <?php if($Coupon_code !='0' && $Coupon_code !='')
	  { ?>
      <input type="button" onClick="window.location.href='<?php  echo $_SERVER['PHP_SELF'] . "?view=1&action=deletecoupon&cid=$Cart_Id"; ?>';" class="box" value="Remove">
	<?php }
	else
	{
	?>
    <input type="submit" value="Apply Coupon" name="coupon" id="coupon" onclick="return functioncoupon();">
  	<?php }
	?>

</td> */ ?>
	  

      <input name="btnUpdate" type="submit" id="btnUpdate" value="Update Cart" class="box btn btn-primary btn-sm" onclick="return FunValidateUpdatecart();">
 
 
 
				</div>
        
        
        
    </div>
     
     </div>
      	
      
    
    
    
    
    
            
        
    
    <div style="position:inherit" class="col-md-12">
				<h4>Terms and conditions:</h4>
				<ul>
            <li>	The charges will be billed to your credit card at the time of your purchase</li>
            <li>	Delivery in the month of May or June Depending on your order priority</li> 
            <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
            <li>	You agree to pay all credit card charges for your purchase made.</li>
            <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
            <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
       </ul> 
			</div>
</form>
    
</div>
    </div>
                
    
    
  

            
            
            
            
            
<?php /*       
<form action="" method="post" name="frmCart" id="frmCart">
<table width="91%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr align="center"> 
    <td><center>
    <input type="button" class="btn btn-primary btn-sm" value="Continue Shopping" onClick="window.location.href='placeanorder.php?flag=Product Catalog&pricingtype=<?php echo $_GET['pricingtype']; ?>';" />
    <?php  
    if ($numItem > 0)
    {
    ?>  
    <input type="button" class="btn btn-success btn-sm" value="Checkout" height="50" onClick="return validatecheckout();"></center></td> 
    <?php 
    }
    ?>
    </tr>
    <tr><td>&nbsp;</td></tr>
  <tr><td> 
 <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2"  bgcolor="#FFFFFF">
 <tr class="dp-prodboxbg01"> 
   		<td colspan="5" align="center"><font color="#FF0000"><?php echo "<b>".$errormessage; ?></font></td>
	</tr>
<tr class="dp-prodboxbg01"> 
   	  <td colspan="2" align="center" class="hdshopcartone">Item</td>
	  <td width="66" align="center" class="hdshopcartone">Unit Price</td>
	  <td width="69" align="center" class="hdshopcartone">Quantity</td>
	  <td width="66" align="center" class="hdshopcartone">Cost</td>
	  </tr>
<?php 
$subTotal = 0;
$QtyDis = 0 ;     
for ($i = 0; $i < $numItem; $i++)
{
	extract($cartContent[$i]);
	$productUrl = "index.php?c=$CatagoryId&p=$Prod_Id";

	//$subTotal += ($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty;
	$subTotal += $Unit_Price * $Qty;
    //$QtyDis =$QtyDis + $Qty;
     $QtyDis =$QtyDis + ROUND($DiscQty * $Qty,0);
?>
 <tr class="content"> 
  	<td width="62" align="center"><!--<a href="<?php  //echo $productUrl; ?>">--><img src="<?php  echo $pd_thumbnail; ?>" border="0"><!--</a>--></td>
    <td width="384" align="left">
        <font color="#000000"><?php echo "<b>".$ProdHead."</b>"; ?></font>
        <br><br>
        <font class="hdshopcartfour"><?php echo $ProdName; ?></font>
        <br>
        <font color="#333333">
        <?php echo $ProdDesc;  ?></font> <br>
    
        <font class="hdshopcartthree">
        <?php //echo $SHIPPINGTYPE;  ?>
        </font>
    </td>
   	<td align="right">
			<font color="#333333"></font>
        <table>
        <tr><td align="right">
        <img src="images/<?php echo $_GET['pricingtype'];?>.jpg"></td><td valign="middle" align="left"><font color="#333333">$<?php echo number_format($Unit_Price,2);//echo number_format(($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)),2); ?><br> PER BOX</td></tr>
        </table></td>
  	<td width="69" align="center">
    	<input name="txtQty[]" type="text" id="txtQty[]" size="5" maxlength="5" value="<?php  echo $Qty; ?>" class="box" onKeyUp="checkNumber(this);"><br>
        <input name="btnDelete" type="button" id="btnDelete" value="Remove" onClick="window.location.href='<?php  echo $_SERVER['PHP_SELF'] . "?view=1&action=delete&cid=$Cart_Id"; ?>';" class="box btn btn-primary btn-sm">
        
        <input name="hidCartId[]" type="hidden" value="<?php  echo $Cart_Id; ?>">
        <input name="hidProductId[]" type="hidden" value="<?php  echo $Prod_Id; ?>">
        <input name="hidProductsku[]" type="hidden" value="<?php  echo $ProdSKU; ?>">
     </td>
   <td align="right">
    <table >
          <tr><td align="right">
        <img src="images/<?php echo $_GET['pricingtype'];?>.jpg"></td><td valign="middle" align="left">
		<font color="#333333">
		$<?php echo number_format($Unit_Price * $Qty,2); //echo number_format((($Unit_Price - Get_Percent($Coupon_Rate,$Unit_Price)) * $Qty),2); ?></td></tr>
        </table>   </td>
     <hr/>
   </tr>
     
 <?php 
}
?>
    <tr class="content">
    	<td colspan="4" align="left" valign="top">&nbsp;</td>
    </tr>
    
    <tr class="content">
	  <td colspan="4" align="left" valign="top">
      <table width="100%" height="93" border="0" cellpadding="1" cellspacing="1" align="left">
        <tr>
          <td colspan="4" align="left"><font class="hdshopcarttwo">Calculate Shipping</font></td>
        </tr>
        <tr>
          <td width="12%" colspan="" align="center"><font class="hdshopcartfournew">Zip Code </font></td>
          <td width="28%" colspan="" align="center"><font class="hdshopcartfournew">Method </font></td>
          <td align="left" colspan="3"><font class="hdshopcartfournew">Destination </font></td>
        </tr>
        <tr>
          <td  align="left"><input type="text" name="zipcode" id="zipcode" size="5%" value="<?php echo $_SESSION['shipamtses']; ?>" /></td>
          <td  align="center">
			<?php $sqlmethod ="select * from shipmethod ORDER BY METHODID DESC";
			//echo $sqlmethod; die;
            $resmethod=mysql_query($sqlmethod);
            ?>
            <select name="cbomethod1" id="cbomethod1">
            <option>--Select Method--</option>
            <?php while($datam=mysql_fetch_assoc($resmethod))
            {
            ?>
            <option value="<?php echo $datam['METHODID']; ?>" <?php if($_SESSION['cbomethod1ses']==$datam['METHODID']){ ?> selected="selected"<?php } ?>><?php echo @$datam['METHOD']; ?></option>
            <?php 
			}
            ?>
            </select>
          </td>
          <td width="18%" align="left"><input type="radio" name="radiotype" id="radiotype" checked="checked" value="residence"  />
              <font class="hdshopcartfournew">Residence</font></td>
          <td width="17%" align="left"><input type="radio" name="radiotype" id="radiotype" value="Business" <?php  if($_POST['radiotype']=="Business") { ?> checked="checked" <?php } ?> />
              <font class="hdshopcartfournew">Business</font></td>
          <td width="25%"><input type="submit" class="btn btn-primary btn-sm" name="submitcal" id="submitcal" value="Calculate" onclick="return FunValidateShip();" /></td>
        </tr>
      </table></td>
	  </tr>
  <?php 
  //$discount = $subTotal - (number_format(($subTotal - Get_Percent($Coupon_Rate,$subTotal)),2));
 	//echo $Coupon_Rate."<br>";
	//echo $subTotal;
	if(($Coupon_Rate=='0' || $Coupon_Rate=="") && ($Coupon_Amt=='0' || $Coupon_Amt==""))
	{	
		$discount = 0;
	}
	else
	{
		//$discount = Get_Percent($Coupon_Rate,$subTotal);   //is not work perfectally....
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
    	<td colspan="4" align="left"><font color="#FF0000"><strong><?php echo $msg; ?>
        </strong></font></td>
    </tr>  
  <tr class="content"> 
  	<td colspan="4" align="right"><font color="#333333">Sub-total</font></td>
  	<td align="right"><font color="#333333">$<?php  echo number_format(($subTotal),2); ?></font></td>
    </tr>
    <!--<tr class="content"> 
  	<td colspan="4" align="right"><font color="#FF0000"><strong>Discount</strong></font></td>
  	<td align="right"><font color="#FF0000" size="2"><strong><?php if($discount>0){ echo "-$".number_format($discount,2); }else{ echo "$".number_format($discount,2); } ?></strong></font></td>
    </tr> -->
<tr class="content"> 
  	<td colspan="4" align="right"><font color="#333333">
        <input type="hidden" name="hiddenzipcode" id="hiddenzipcode" value="<?php echo $_SESSION['shipamtses']; ?>" />
        <input type="hidden" name="hiddenmethod" id="hiddenmethod" value="<?php echo $_SESSION['cbomethod1ses']; ?>" />
        <input type="hidden" name="hiddendestination" id="hiddendestination" value="<?php echo $_SESSION['radiotype1ses']; ?>" />
        <input type="hidden" name="txtshipc" id="txtshipc" value="<?php echo $_SESSION['shipamt44']; ?>" />
    Shipping Charges</font></td>
  	<td align="right"><font color="#333333">$<?php   if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30)) { echo number_format((0),2); } else { echo number_format(($_SESSION['shipamt44']),2); } ?></font></td>
    </tr>
 <tr class="content"> 
  	<td colspan="4" align="right"><font color="#333333">Tax</font></td>
  	<td align="right"><font color="#333333">$0.00</td>
    </tr>
<tr class="content"> 
   	  <td colspan="4" align="right"><font color="#333333">Total </font></td>
	  <td align="right"><font color="#333333">$<?php  if(($shipzone_days >= 6 && $shipzone_days <= 8) || ($shipzone_days > 2 && $methdid > 30)) { echo number_format($subTotal,2); }else { echo number_format($shipamt_new,2); } ?></font></td>
      </tr>  
      <tr class="content">
	  <td colspan="4" align="left" valign="top"><font color="#FF0000"><?php echo "<b>".$errormessage_code; ?></font></td>
	  </tr>
      	
      <tr class="content">
<!--<td align="left" colspan="2"><font class="hdshopcartfour">Coupon Code : </font>
 <input type="text" name="couponcode" id="couponcode" value="<?php echo $Coupon_code; ?>">
      <?php if($Coupon_code !='0' && $Coupon_code !='')
	  { ?>
      <input type="button" onClick="window.location.href='<?php  echo $_SERVER['PHP_SELF'] . "?view=1&action=deletecoupon&cid=$Cart_Id"; ?>';" class="box" value="Remove">
	<?php }
	else
	{
	?>
    <input type="submit" value="Apply Coupon" name="coupon" id="coupon" onclick="return functioncoupon();">
  	<?php }
	?>

</td> -->
	  <td colspan="4" align="right">

      &nbsp;<input name="btnUpdate" type="submit" id="btnUpdate" value="Update Cart" class="box btn btn-primary btn-sm" onclick="return FunValidateUpdatecart();"></td>
 <td>&nbsp;</td>     
 
 </tr>
      
     <tr class="content">
	  <td colspan="5" align="left" valign="top">&nbsp;</td>
	  </tr> 
      <tr class="content"> 
	  <td colspan="4" align="left"><font color="#333333">
 <b> Terms and conditions:</b>
     <ul>
            <li>	The charges will be billed to your credit card at the time of your purchase</li>
            <li>	Delivery in the month of May or June Depending on your order priority</li> 
            <li>	Please provide a valid phone number and email address to communicate your confirmed delivery date</li>
            <li>	You agree to pay all credit card charges for your purchase made.</li>
            <li>	Your confirmed order delivery is subject to approval by the USDA at the port of entry</li>
            <li>	Savani Farms is in no way liable for your order not being delivered apart from a full refund of the amount. </li>
       </ul> 
       </td>
 </tr>
<tr class="content"> 
	  <td colspan="5" align="center"><table border="1" bordercolor="#999999"><tr><td align="left" class="hdshopcartblk">
      		Please call 1-855-696-2646 in USA or   +91 96 62 30 30 30   in India if you need more information.</td>
</tr></table></td>
</tr>
</table>
      </td></tr>
    </table></form> */ ?>
<?php 
}
else
{
?>
<p>&nbsp;</p><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
<tr>
	 <td class="dp-blackbold"><p align="center">No Item in Cart. Please add items to cart</p>
    	</td>
</tr>
</table>
<?php 
}
$shoppingReturnUr2 = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
$shoppingReturnUrl = '$shoppingReturnUrl?cartlist=cartlist';
?>
<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
	<tr align="center"> 
		<td><center>
		<input type="button" class="btn btn-primary btn-sm" value="Continue Shopping" onClick="window.location.href='placeanorder.php?flag=Product Catalog&pricingtype=<?php echo $_GET['pricingtype']; ?>';" />
		<?php  
if ($numItem > 0)
{
?>  
	  <input type="button" class="btn btn-success btn-sm" value="Checkout" height="50" onClick="return validatecheckout();"></center></td>  
<?php 
}
?>
	</tr>
</table>
