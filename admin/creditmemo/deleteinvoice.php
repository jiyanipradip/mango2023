<?
require_once '../../library/config.php';
{
	
	$cat = $_GET['cat'];
	$si = $_GET['si'];

	
	updatequantity($cat,$si);
}	
	function updatequantity($cat,$si)
	{
		$sql="DELETE from invoice where CustId = '$cat' AND sessid = '$si'";
		//echo $sql;
		$result=mysql_query($sql);
			header('Location: index.php?view=edit&oid=178&unsetsession=unsetsession');
}
?>