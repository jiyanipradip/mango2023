<?
require_once '../../library/config.php';
require_once '../library/functions.php';
switch ($action) {
	case 'add' :
		addToCart();
		break;
		}
		
function addToCart()
{
$num = $_GET['num'];
$catId = $_GET['catId'];

for($i=0;$i<$num;$i++)
{
$productId = "pid".$i;
$Prodprice = "price".$i;
$Categorymain = "catg".$i;
$Subcategory = "subcatg".$i;
$qty = "qtytext".$i;

$productId = $_POST[$productId];
$Categorymain = $_POST[$Categorymain];
$Subcategory = $_POST[$Subcategory];
$qty = $_POST[$qty];
$Prodprice=$_POST[$Prodprice];

	$sid = session_id();
		$sql = "SELECT *
	        FROM contract 
			WHERE Prodid = $productId AND CustId = $catId";
			echo $sql;
	$result = mysql_query($sql);
	//$sku  =  $row['ProdSKU'];
	if (mysql_num_rows($result) > 0)
	{
		// put the product in cart table
	/*
		$sql = "INSERT INTO contract(Prod_Id,Categorymain,Subcategory,Qty,ct_session_id,Cart_Date)
				VALUES ('$productId','$Categorymain','$Subcategory','$qty','$sid',NOW())";
		$result = mysql_query($sql);
	*/
	$sql = "UPDATE contract 
		        SET PucrPrice = $Prodprice
				WHERE Prodid = $productId AND CustId = $catId";
				echo $sql;	
		$result = mysql_query($sql);	
	}
	else
	{
		// update product quantity in cart table
			
	}	
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	//deleteAbandonedCart();

}
//die;
	
	header('Location: index.php?ccatId='.$catId);

}
/*
if(isset($_POST['update1']))
{
  $srno = $_POST['srnoitem'];
  echo "hiiiiii";
  if(isset($orderedItem))
	{
		$numItem  = count($orderedItem);
	}
	$k = $srno + 50;
  	for($i = ($srno - 1); $i <= $k;$i++)
	{
 	$catId = $_GET['catId'];
	$invoiceno = $rowno['invoiceno'];
	$selfordate="select * from invoicemaster where invoiceno = $invoiceno";
	$resultfordate=mysql_query($selfordate);
	$rowfordate=mysql_fetch_assoc($resultfordate);
	$appdate = $rowfordate['CustId'];
	if($appdate == '')
	{
		$appdate = date('Y-m-d');
	}
	$sqlfinalsearch="select * from invoice where CustId = $catId AND invoiceno = $invoiceno AND srno = $i";
	$resultfinalsearch=mysql_query($sqlfinalsearch);
	if(mysql_num_rows($resultfinalsearch) ==1)
	{
	$v='qtytext'.$i;
	$v1='ppricetext'.$i;
	$qty = $_POST[$v];
	$price =  $_POST[$v1];
	$sql="UPDATE invoice SET qty = $qty,Prodprice = $price,invdate = '$appdate' where CustId = $catId AND invoiceno = $invoiceno AND srno = $i";
	$result=mysql_query($sql);
	}
	else
	{
	}
}
?>




<?
$sid = session_id();
	// check if the product is already
	// in cart table for this session
	$sql = "SELECT *
	        FROM cartdetail
			WHERE Prod_Id = '$productId' AND Categorymain = '$Categorymain' AND Subcategory = '$Subcategory' AND ct_session_id = '$sid'";
	$result = dbQuery($sql);
	$sku  =  $row['ProdSKU'];
	if (dbNumRows($result) == 0)
	{
		// put the product in cart table
		$sql = "INSERT INTO cartdetail (Prod_Id,Categorymain,Subcategory,Qty,ct_session_id,Cart_Date)
				VALUES ('$productId','$Categorymain','$Subcategory','$qty','$sid',NOW())";
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
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	deleteAbandonedCart();
*/?>