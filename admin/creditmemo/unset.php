<?
require_once '../../library/config.php';
if(isset($a))
{

$suply = $_GET['suply'];
$contact = $_GET['contact'];
$a = $_GET['a'];
$b = $_GET['b'];

call($suply,$contact,$a,$b);
}
function call($suply,$contact,$a,$b)
{
$sql5="UPDATE invoicemaster SET invfor = '$suply',contact='$contact' where invoiceno = '$a'";

$result5=mysql_query($sql5);
$sql="UPDATE invoice SET invdate = '$b' where invoiceno = '$a'";
$result=mysql_query($sql);

}
header('Location: index.php?view=edit&oid=178&unsetsession=unsetsession');die;
 ?>