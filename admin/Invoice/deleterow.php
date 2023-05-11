<?
require_once '../../library/config.php';
if(isset($q))
{
	$q = $_GET['q'];
	$srno = $_GET['srno'];
	$cat = $_GET['cat'];
	//$bar = $_GET['bar'];
//	$si = $_GET['si'];

	
	updatequantity($q,$srno,$cat);
}	
	function updatequantity($q,$srno,$cat)
	{
		$sql="DELETE from invoicetemp where srno = $srno";
		$result=mysql_query($sql);
			header('Location: index.php?view=edit&oid=178&catId='.$cat.'&barcode2=1');
}
?>