<?
require_once '../../library/config.php';
if(isset($q))
{
	//echo "hiiii";
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	updatequantity($q,$srno,$cat,$bar);
}	
	function updatequantity($q,$srno,$cat,$bar)
	{
		$sql="UPDATE invoice SET Prodprice = $q where srno = $srno";
		//echo $sql;die;
		$result=mysql_query($sql);
	
	header('Location: index.php?view=edit&oid=178&catId='.$cat.'&barcode='.$bar.'&sirno='.$srno.'&unitprice=unitprice');
}


?>
