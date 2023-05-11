<?
require_once '../../../library/config.php';
if(isset($a))
{
$suply = $_GET['suply'];
$contact = $_GET['contact'];
$a = $_GET['a'];
call($suply,$contact,$a);
}
function call($suply,$contact,$a)
{
$sql="UPDATE invoicemaster SET invfor = '$suply',contact='$contact' where invoiceno = '$a'";
$result=mysql_query($sql);
}
header('Location: ../index.php?view=edit&oid=178&unsetsession=unsetsession');die;
 ?>