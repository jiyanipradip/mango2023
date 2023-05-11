<?php
require_once 'config.php';
//ob_start();
/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/
function addTolist()
{
	//echo "asdf"; die;
	$mast1=$_SESSION['MAST'];
	// make sure the product id exist
		if ((isset($_GET['p']) && $_GET['p']) && (isset($_GET['q2']) && $_GET['q2']) && (isset($_GET['cc']) && $_GET['cc']) && (isset($_GET['c']) && $_GET['c'])) {
		$productId = $_GET['p'];
		$qty = $_GET['q2'];
		$Categorymain = $_GET['cc'];
		$Subcategory = $_GET['c'];
	}
	else
	{
		header('Location: index.php?cartlist=cartlist');
	}
		$sql = "SELECT *
	           FROM productmast
			   WHERE Categorymain = '$Categorymain' AND CatagoryId = '$Subcategory' AND PordId = '$productId'";
			  // echo $sql;die;
		$result = dbQuery($sql);
	
	if(dbNumRows($result) != 1)
	{
		// the product doesn't exist
		header('Location: cart.php');
	}
	else
	{
		// how many of this product we
		// have in stock
		$row = dbFetchAssoc($result);
		$currentStock = $row['TotBuyQty'];
		//echo $currentStock; die;
		if ($currentStock == 0)
		{
			// we no longer have this product in stock
			// show the error message
			setError('The product you requested is no longer in stock');
			header('Location: cart.php');
			exit;
		}
	}	
	//echo "samir";	 die;
	// current session id
	$sid = session_id();
	$sql = "SELECT *
	        FROM cartlist
			WHERE Prod_Id = '$productId' AND CategoryMain= '$Categorymain' AND Subcatid = '$Subcategory' AND ct_session_id = '$sid' AND Customer_Name='$mast1'";
			//echo $sql;die; 
	$result = dbQuery($sql);
	$sku  =  $row['ProdSKU'];
	if (dbNumRows($result) == 0)
	{
		$sql = "INSERT INTO cartlist(Prod_Id,CategoryMain,Subcatid,Qty,ct_session_id,Cart_Date,Customer_Name)
				VALUES ('$productId','$Categorymain','$Subcategory','$qty','$sid',NOW(),'$mast1')";
		$result = dbQuery($sql);
	}
	else
	{
		// update product quantity in cart table
		$sql = "UPDATE cartlist 
		        SET Qty = Qty + $qty
				WHERE ct_session_id = '$sid' AND Prod_Id = '$productId' AND CategoryMain= '$Categorymain' AND Subcatid = '$Subcategory' AND Customer_Name='$mast1'";		
		//echo $sql;
		$result = dbQuery($sql);		
	}
	
	
	deleteAbandonedCart();
	
	header('Location: ' . $_SESSION['shop_return_url']);				
}
function addToCart()
{
	
	//unset($_SESSION['shipamtses']);	
	//unset($_SESSION['cbomethod1ses']);	
	//unset($_SESSION['radiotype1ses']);
	//unset($_SESSION['shipamt44']);
	
	//echo $_GET['p']."<br>*";
	//echo $_GET['q2']."<br>*";
	//echo $_GET['cc']."<br>*";
	//echo $_GET['c']."<br>";
	//die;

		// make sure the product id exist
	if ((isset($_GET['p']) && $_GET['p']) && (isset($_GET['q2']) && $_GET['q2']) && (isset($_GET['cc']) && $_GET['cc']) && (isset($_GET['c']) && $_GET['c'])) {
		$productId = $_GET['p'];
		$qty = $_GET['q2'];
		$Categorymain = $_GET['cc'];
		$Subcategory = $_GET['c'];
		$pricingtype = $_GET['pricingtype'];

		//echo "hello";die;
	}
	else
	{
		//echo "else"; die;
		header('Location: index.php');
	}
	$sql = "SELECT * FROM productmast  WHERE Categorymain = '$Categorymain' AND CatagoryId = '$Subcategory' AND PordId = '$productId'";
	//echo $sql; die;
	$result = dbQuery($sql);
	if (dbNumRows($result) != 1)
	{
		// the product doesn't exist
		header('Location: cart.php');
	}
	else
	{
		// how many of this product we
		// have in stock
		$row = dbFetchAssoc($result);
		$currentStock = $row['TotBuyQty'];
		$SellPrice=$row['SellPrice'];
		//echo $currentStock; die;
		if ($currentStock == 0)
		{
			// we no longer have this product in stock
			// show the error message
			setError('The product you requested is no longer in stock');
			header('Location: cart.php');
			exit;
		}
	}
	//echo "samir"; die;
	// current session id
	$sid = session_id();
	// check if the product is already
	// in cart table for this session
	$sql = "SELECT *
	        FROM cartdetail
			WHERE Prod_Id = '$productId' AND Categorymain = '$Categorymain' AND Subcategory = '$Subcategory' AND ct_session_id = '$sid'";
	//echo $sql; die;
	$result = dbQuery($sql);
	$sku  =  $row['ProdSKU'];
	//echo dbNumRows($result); die;
	if (dbNumRows($result) == 0) {
		// put the product in cart table
		$sql = "INSERT INTO cartdetail (Prod_Id,Categorymain,Subcategory,Qty,ct_session_id,Cart_Date,pricingtype,Unit_Price)
				VALUES ('$productId','$Categorymain','$Subcategory','$qty','$sid',NOW(),'$pricingtype','$SellPrice')";
							//echo $sql;die;

		$result = dbQuery($sql);
	}
	else
	{
		// update product quantity in cart table
		$sql = "UPDATE cartdetail 
		        SET Qty = Qty + $qty
				WHERE ct_session_id = '$sid' AND Prod_Id = '$productId' AND Categorymain = '$Categorymain' AND Subcategory = '$Subcategory'";		
		$result = dbQuery($sql);		
	}
	//echo $sql; die;
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	deleteAbandonedCart();

	//echo "samir"; die;
	//header('Location: ' . $_SESSION['shop_return_url'].'&showmini=showmini');
	header("Location: placeanorder.php?view=1&pricingtype=".$_GET['pricingtype']);				
}

/*
	Get all item in current session
	from shopping cart table
*/

function Get_Percent($number,$total)
{
	//echo $number."--".$total;
	//die;
	$percentage = number_format((($number * $total)/100),2);
	return $percentage;
}

function getCartContent()
{
	$cartContent = array();
	$sid = session_id();
	//echo $sid; die;
	//echo "<pre>";
	//print_r($_SESSION); die;
	$sql = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
	//echo $sql; die;
	$result = dbQuery($sql);
	while ($row = dbFetchAssoc($result))
	{
		if ($row['pd_thumbnail'])
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/product/' . $row['pd_thumbnail'];
		}
		else
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	return $cartContent;
}
// Location Content
function getLocationContent()
{
	if(isset($_SESSION['MAST'])) {
		$p = $_SESSION['MAST'];
		}
	$cartContent = array();
	$sid = session_id();
	$sql = "SELECT *
			FROM userlogin  ct, custloc  pd
			WHERE  ct.user_id = pd.user_id AND ct.user_name = '$_SESSION[MAST]'";
	$result = dbQuery($sql);
	while ($row = dbFetchAssoc($result))
	{
		$cartContent[] = $row;
	}
	return $cartContent;
}
// LIST CONTENTS
function getlistContent()
{
	$cartContent = array();
	$sid = session_id();
	if(isset($_SESSION['MKEYTMP']) && isset($_SESSION['masterkey']))
	{
	$p = $_SESSION['masterkey'];
	$sql = "SELECT * from cartlist ct, productmast pd
			WHERE ct.Customer_Name='$p' AND ct.Prod_Id = pd.PordId";
	$result = dbQuery($sql);
	$sqlupsid = "UPDATE cartlist
				 SET ct_session_id = '$sid'
				 WHERE Customer_Name='$p'";
	dbQuery($sqlupsid);
	}
	else
	{
	$sql = "SELECT * from cartlist ct, productmast pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId";
	$result = dbQuery($sql);
	}
	while ($row = dbFetchAssoc($result))
	{
		if ($row['pd_thumbnail'])
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/product/' . $row['pd_thumbnail'];
		}
		else
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}
// CONTRACT -->
function getcontractContent()
{
	$cartContent = array();
	$sid = session_id();
	if(isset($_SESSION['MKEYTMP']) && isset($_SESSION['masterkey']))
	{
	$p = $_SESSION['masterkey'];
	$sql = "SELECT *
			FROM userprice ct, productmast pd
			WHERE ct.Customername='$p' AND ct.Prod_code = pd.PordId";
	$result = dbQuery($sql);
	$sqlupsid = "UPDATE userprice
				 SET ct_session_id = '$sid'
				 WHERE Customername='$p'";
	dbQuery($sqlupsid);
	}
	else
	{
	$sql = "SELECT Cart_Id, ct.Prod_Id,ct.Qty,ProdName, PucrPrice, pd_thumbnail, pd.CatagoryId,pd.BrandName
			FROM cartlist ct, productmast pd, subcatgmaster cat
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND cat.SubCatId = pd.CatagoryId";
	$result = dbQuery($sql);
	}
	while ($row = dbFetchAssoc($result))
	{
		if ($row['pd_thumbnail'])
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/product/' . $row['pd_thumbnail'];
		}
		else
		{
			$row['pd_thumbnail'] = SAVANI_FARM . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	return $cartContent;
}
// CONTRACT COMPLETES

/*
	Remove an item from the cart
*/

function deleteFromCart($cartId = 0)
{
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0)
	{
		$cartId = (int)$_GET['cid'];
	}
	if ($cartId)
	{	
		$sql  = "DELETE FROM cartdetail
				 WHERE Cart_Id = '$cartId'";
		$result = dbQuery($sql);
		unset($_SESSION['shipamtses']);	
		unset($_SESSION['cbomethod1ses']);	
		unset($_SESSION['radiotype1ses']);
		unset($_SESSION['shipamt44']);
	}
}

function deletecoupon($cartId = 0)
{
	//echo "hello";
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0)
	{
		$cartId = (int)$_GET['cid'];
	}
	
	if ($cartId)
	{	
		$sql  = "UPDATE cartdetail SET Coupon_Rate = '',Coupon_Amt = '',Coupon_Desc = '',Coupon_code=''
				 WHERE Cart_Id = '$cartId'";
		$result = dbQuery($sql);
		header('Location: placeanorder.php?view=1');
		//header('location : placeanorder.php?view=1');
	}
				//echo "hii";
				

}



/*
	Update item quantity in shopping cart
*/
function updateCart()
{   
	$sku        = $_POST['hidProductsku'];
	$cartId     = $_POST['hidCartId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$couponcode1 =$_POST['couponcode'];
	$numDeleted = 0;
	$notice     = '';

	for ($i = 0; $i < $numItem; $i++)
	{
		$newQty = (int)$itemQty[$i];
		if ($newQty < 1)
		{
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		}
		else
		{
			// check current stock
			$sql = "SELECT ProdName,PordId TotBuyQty,ProdSKU,BrandName
			        FROM productmast 
					WHERE PordId =$productId[$i]";
			//echo $sql;
			$result = dbQuery($sql);
			$row    = dbFetchAssoc($result);
			if ($newQty > $row['TotBuyQty'])
			{
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
			
			
			$sql = "UPDATE cartdetail
					SET Qty = $newQty
					WHERE Cart_Id = {$cartId[$i]}";
			//echo $sql;die;
			dbQuery($sql);
			}
			else
			{
				
				$tday= date('Y-m-d');

					$sqlcoupon="select * from couponmaster where Coupon_code='$couponcode1' AND From_Date<= '$tday' AND To_Date >= '$tday'";
					//echo $sqlcoupon;die;
					$resultcoupon=mysql_query($sqlcoupon);
					$rowcoupon=mysql_fetch_assoc($resultcoupon);
					if(mysql_num_rows($resultcoupon)<1)
					{
						$errormessage="Please Enter Valid Coupon";
					}
					else
					{
		
					if($newQty<$rowcoupon['Min_Qty'])
					{
						
						$errormessage="Coupon is valid for Quantity more than  ".$rowcoupon['Min_Qty'];
					}
					else
					{
					$Coupon_code1=$rowcoupon['Coupon_code'];
					$c1=$_POST["couponcode"];;
					$Disc_perc=$rowcoupon['Disc_perc'];
					$Disc_Amt=$rowcoupon['Disc_Amt'];
						$sql12 = "UPDATE cartdetail
							SET `Coupon_code`='$c1',`Coupon_Rate`='$Disc_perc',`Coupon_Amt`='$Disc_Amt'
							SET Qty = $newQty
					WHERE Cart_Id = {$cartId[$i]}";
					//echo $sql12;
					$result12=mysql_query($sql12) or die(mysql_error());
					//header('location : placeanorder.php?view=1');
					}
			}
				
				
			}
		}
	}
	
	if ($numDeleted == $numItem)
	{
		// if all item deleted return to the last page that
		// the customer visited before going to shopping cart
		//echo "1111";
		//die;
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	}
	else
	{
		//echo "2";die;
		header('Location: placeanorder.php?view=1');	
	}
	
	exit;
}

function isCartEmpty()
{
	$isEmpty = false;
	$sid = session_id();
	$sql = "SELECT Cart_Id
			FROM cartdetail ct
			WHERE ct_session_id = '$sid'";
	$result = dbQuery($sql);
	if (dbNumRows($result) == 0)
	{
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM cartdetail WHERE Cart_Date < '$yesterday'";
	dbQuery($sql);		
}
?>