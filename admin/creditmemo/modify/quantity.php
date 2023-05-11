<?
require_once '../../../library/config.php';
if(isset($q))
{
	//echo "hiiii";
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	$sid = $_GET['sid'];
	updatequantity($q,$srno,$cat,$bar,$sid);
}	
	function updatequantity($q,$srno,$cat,$bar,$sid)
	{
		$sql="UPDATE invoice SET qty = $q where srno = $srno";
		$result=mysql_query($sql);
	
	header('Location: ../index.php?view=modify&oid=178&catId='.$cat.'&barcode='.$bar.'&sirno='.$srno.'&gotoprice=gotoprice&sid='.$sid);
}


?>