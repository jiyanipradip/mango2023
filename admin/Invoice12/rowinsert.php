<?
require_once '../../library/config.php';
if(isset($q))
{
	//echo "hiiii";
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	$bar = $_GET['bar'];
	$si = $_GET['si'];
	$l = $_GET['l'];


	updatequantity($q,$srno,$cat,$bar,$si,$l);
}	
	function updatequantity($q,$srno,$cat,$bar,$si,$l)
	{
		$sql="insert into `dentadepot`.`invoice` (`sessid`,`Prodid`,`CustId `) values('$si',1,'$l')";
		echo $sql;die;
		$result=mysql_query($sql);
	
	header('Location: index.php?view=edit&oid=178&catId='.$cat.'&barcode='.$bar.'&sirno='.$srno);
}


?>
