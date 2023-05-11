<?
require_once '../../../library/config.php';
if(isset($q))
{

	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	$invoice = $_GET['invoice'];
	updatequantity($q,$srno,$cat,$bar,$invoice);
}	
	function updatequantity($q,$srno,$cat,$bar,$invoice)
	{
		$sql="DELETE from debitmemo where srno = $srno";
		//echo $sql;die;
		$result=mysql_query($sql);
			header('Location: ../index.php?view=modify&oid=178&catId='.$cat.'&barcode='.$bar.'&sirno='.$srno.'&memono='.$invoice);
//modify&oid=178&modify=8f7da09aeff94aacb552c7357757e9f9&catId=25&sirno=318&barcode=1&invno=318
}
?>