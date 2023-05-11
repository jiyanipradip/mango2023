<?
require_once '../../library/config.php';
if(isset($q))
{
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	$si = $_GET['si'];

	
	updatequantity($q,$srno,$cat,$bar,$si);
}	
	function updatequantity($q,$srno,$cat,$bar,$si)
	{
		$sql1="select * from productmast where PordId = '$q'";
		$result1=mysql_query($sql1);
		$data1=mysql_fetch_assoc($result1);
		$barcode=$data1['ProdSKU'];
		$sql="UPDATE invoice SET Prodid = $q where srno = $srno";
		//echo $sql;die;
		$result=mysql_query($sql);
		
	header('Location: index.php?view=edit&oid=178&catId='.$cat.'&barcode='.$barcode.'&sirno='.$srno.'&prodchange=prodchange');
}


?>
