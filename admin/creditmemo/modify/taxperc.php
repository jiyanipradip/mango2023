<?
require_once '../../../library/config.php';
if(isset($q))
{
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	$si = $_GET['si'];
	$sid = $_GET['sid'];

	
	updatequantity($q,$srno,$cat,$bar,$sid);
}	
	function updatequantity($q,$srno,$cat,$bar,$sid)
	{
		$sql="UPDATE invoice SET taxperc = $q where srno = $srno";
		//echo $sql;die;
		$result=mysql_query($sql);
		$SQL3="SELECT * from invoice where sessid = '$si' AND Prodid = 1 AND CustId = '$cat'";
		$result3=mysql_query($SQL3);
		if(mysql_num_rows($result3) == 0)
		{
		$sql1="insert into invoice(`sessid`,`Prodid`,`CustId`) values('$si',1,'$cat')";
		//echo $sql1;
		$result1=mysql_query($sql1);
		}
	header('Location: ../index.php?view=modify&oid=178&catId='.$cat.'&barcode='.$bar.'&sirno='.$srno.'&unitprice=unitprice&textperc=textperc&sid='.$sid);
}


?>

