<?
require_once '../../../library/config.php';
{
	//echo "hi";die;
	$cat = $_GET['cat'];
	$inv = $_GET['inv'];

	
	updatequantity($cat,$inv);
}	
	function updatequantity($cat,$inv)
	{
		$sql="DELETE from invoice where CustId = '$cat' AND invoiceno = '$inv'";
		//echo $sql;
		$result=mysql_query($sql);
			header('Location: ../index.php');
}
?>