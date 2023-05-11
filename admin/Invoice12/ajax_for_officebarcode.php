<?php
//session_start();
require_once '../../library/config.php';
require_once '../library/functions.php';
$barcode= $_GET['barcode'];
if(isset($barcode))
{
echo "hello";die;
$sql= "select * from productmast where ProdSKU = $barcode";
$result = dbQuery($sql);
$rowprod=mysql_fetch_assoc($result);
$p1 = $rowprod['PordId'];
$p2 = $rowprod['ProdDesc'];
$p3 = $rowprod['SellPrice'];
$p4 = $rowprod['TaxCode'];
$sqlfortaxcode="select * from taxmaster where TaxCode = '$p4'";
$resultfortaxcode=mysql_query($sqlfortaxcode);
$rowfortaxcode=mysql_fetch_assoc($resultfortaxcode);
$p5 = $rowfortaxcode['TaxRate'];

			$sid = session_id();

if(mysql_num_rows($result) == 1)
{

	$sqlduplicatecheck="select * from invoice where CustId = '$catId'AND Prodid = '$p1' AND Proddesc = '$p2' AND Prodprice = '$p3' AND sessid = '$sid'";
	//	echo $sqlduplicatecheck."hey<br>";
	$resultduplicatecheck=dbQuery($sqlduplicatecheck);
	if((mysql_num_rows($resultduplicatecheck) == 0 ) && !(isset($sirno1)))
	{
	$b = time (); 
	$p4 = date("m/d/y").":".$b;
	$sqlcheckduplicaterows="select * from invoice where CustId= '$catId' AND 
	Prodid = '$p1' AND sessid = '$sid'";
	$resultcheckduplicaterows = mysql_query($sqlcheckduplicaterows);
	if(mysql_num_rows($resultcheckduplicaterows) == 0)
	{
	$sqlinvno="select invoiceno from invoicemaster ORDER BY invoiceno DESC";
$resultinvno=mysql_query($sqlinvno);
$rowinvno=mysql_fetch_assoc($resultinvno);
$invno=$rowinvno['invoiceno'];
if(isset($srno1)) {
$sqlforinsert="UPDATE `dentadepot`.`invoice` SET 
`CustId` = '$catId',
`Prodid` = '$p1',
`Proddesc` = '$p2',
`Prodprice` = '$p3',
`sessid` = '$sid',
`qty` = 1,
`taxperc` = '$p5',
`invoiceno` ='$invno',
`invdate` = NOW() where srno = '$srno1'";
}
else
{
$sqlforinsert="INSERT INTO `dentadepot`.`invoice` (
`CustId` ,
`Prodid` ,
`Proddesc` ,
`Prodprice` ,
`sessid` ,
`qty`,
`invdate`,`invoiceno`
)
VALUES (
'$catId', '$p1', '$p2', '$p3', '$sid',1,NOW(),$invno
)";
}
	$resultforinsert = mysql_query($sqlforinsert);
}
}
}}
?>