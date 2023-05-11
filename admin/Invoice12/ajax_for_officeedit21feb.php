<?php
//session_start();
require_once '../../library/config.php';
require_once '../library/functions.php';
$txt = $_GET['txt'];
$catId = $_GET['catId'];
//echo "catid===>".$catId;
// Escape User Input to help prevent SQL Injection
//$txt = mysql_real_escape_string($txt);
if($txt!="")
{
$sql= "select * from productmast where ProdSKU = 1";
//echo $sql;
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
	$resultduplicatecheck=mysql_query($sqlduplicatecheck);
			if(mysql_num_rows($resultduplicatecheck) == 0)
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
$result=mysql_query($sqlforinsert);		
}	
?>			
<?php
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}	   

 
}

return $orderedItem;
?>