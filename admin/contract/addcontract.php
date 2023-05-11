<?
if((isset($_POST['barcodeentry'])) || (isset($barcode2)))
 {
 	if(isset($barcodeentry))
	{
		$barcode = $_POST['barcodeentry'];
	}
	else
	{
		if(isset($barcode2))
		{
				$barcode = $barcode2;
		}
 	}
		$sql= "select * from productmast where ProdSKU = '$barcode'";
	//	echo $sql."<br><br>";
		$result = dbQuery($sql);
	//	echo mysql_num_rows($result)."<br><br>";
		$rowprod=mysql_fetch_assoc($result);
		if(mysql_num_rows($result) > 0)
		{
			$p1 = $rowprod['PordId'];
			$p2 = $rowprod['ProdDesc'];
			$p3 = $rowprod['SellPrice'];
			$p4 = $rowprod['TaxCode'];
			$sid = session_id();
			$sqlduplicatecheck="select * from quickorder where CustId = '$catId'AND Prodid = '$p1' AND Proddesc = '$p2' AND Prodprice = '$p3' AND sessid = '$sid'";
				//	echo $sqlduplicatecheck."<br><br>";

			$resultduplicatecheck=dbQuery($sqlduplicatecheck);
			//if(mysql_num_rows($resultduplicatecheck) == 0)
			$sqlinvno="select invoiceno from quickordermaster ORDER BY invoiceno DESC";
			$resultinvno=mysql_query($sqlinvno);
			$rowinvno=mysql_fetch_assoc($resultinvno);
			$invno=$rowinvno['invoiceno'];
			$sqlforinsert="INSERT INTO `dentadepot`.`quickorder` (
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
//echo $sqlforinsert."<br><br>";
	$resultforinsert = mysql_query($sqlforinsert);
	
	//$sqlforinsert="insert into invoice CustId = '$catId',Prodid = '$p1',Proddesc = '$p2',Prodprice = '$p3'";
	//echo $sqlforinsert."bacool";
	//$resultforinsert = mysql_query($sqlforinsert);
	}
	else
	{
	echo "Enter valid Barcode";
	}
	
}
$sid = session_id();
$sqlforno="select * from quickordermaster order by invoiceno DESC";
							$resultforno=mysql_query($sqlforno);
							$rowno=mysql_fetch_assoc($resultforno);
$invoiceno = $rowno['invoiceno'];

$sql = "SELECT ProdName,SellPrice,Categorymain,CatagoryId,PordId,ProdSKU,p.ProdDesc, oi.Prodprice , oi.qty,oi.srno,oi.taxperc 
	    FROM quickorder  oi, productmast p 
		WHERE oi.Prodid = p.PordId and oi.Prodid !=1 and oi.CustId = $catId and oi.sessid='$sid' and oi.invoiceno = $invoiceno
		ORDER BY oi.srno DESC";
		$result = dbQuery($sql);
if(isset($qty))
 {
$orderd_qty = $qty;
}
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}
$sqlcont="select * from custmast where custid = $catId";
$resultcont = mysql_query($sqlcont);
$rowcont=mysql_fetch_assoc($resultcont);

?>
 <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="ddepot-blueborder">
 <tr>
      <td colspan="4" class="hdbg">Contract For : <? echo $rowcont['name']; ?></td>
    </tr>
<tr>
<td align = "center" class="hdbg" colspan="4"><form method="post" name="formbarcode" action="">Enter Barcode<input type="text" name="barcodeentry" id="barcodeentry"><input type="submit" name="go" value="GO"></form>
</td><? if(isset($orderedItem))
{
$numItem  = count($orderedItem);
}
?>
</tr><form name="exampleForm" method="post" action="functionsforcart.php?action=add&num=<? echo $numItem; ?>">

<tr><td colspan="4" align="center"><input type="submit" value="Order Now" name="Order">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Clear" name="Clear"></td></tr>

<tr><td width="16%" align="left" class="hdbg">Product #</td>
<td width="28%" align="left" class="hdbg">Qty</td>
<td width="19%" align="left" class="hdbg">Size</td>
<td width="37%" align="left" class="hdbg">Description</td>
</tr>
<?php
if(isset($orderedItem))
{
$numItem  = count($orderedItem);
}
?>
<?php
if(isset($orderedItem))
{
$numItem  = count($orderedItem);
//echo $numItem."maddy";
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++)
{
	if($numItem != 0)
{
	extract($orderedItem[$i]);
}
	//$subTotal += $Prodprice * $qty;
	$subTotal +=(($qty * $Prodprice*$taxperc)/100)+($qty * $Prodprice);
?>
    <tr class="content"> 
   		<td valign="top" align="left" class="lightbluebg"><? echo (($numItem - ($i)));  echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ProdSKU; /* ?><input type="text" maxsizze="6" size="6" name="barcode<? echo $srno; ?>" id="barcode<? echo $srno; ?>" <? if($ProdSKU != 1) {
		 ?> value="<? echo $ProdSKU; ?>" <? } ?> <? /*onBlur="viewProduct2('<? echo $oid; ?>',this,'<? echo $srno; ?>')"  ?> style="text-align:right"> */ ?></td>
        <td valign="top" align="left" class="lightbluebg">
		<input type="text" <? if($ProdSKU != 1) { ?> value="<? echo $qty; ?>" <? } ?> name="qtytext<? echo $i; ?>" maxsizze="3" size="3" id="qtytext<? echo $i; ?>" <? /*
          onblur="enterqty(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>');" */ ?> style="text-align:right"/></td> 
        <td valign="top" align="left" class="lightbluebg"><input type="text" <? if($ProdSKU != 1) { ?> value="<?php echo $SellPrice; ?>" <? } ?> maxsizze="6" size="6"
        <? /* onBlur="enterqty7(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $barcode; ?>','<? echo $sid;?>');" */ ?> name="prod1<? echo $i; ?>" id="prod1<? echo $i; ?>" style="text-align:right"></td>
        <input type="hidden" name="catg<? echo $i; ?>" id="catg<? echo $i; ?>" value="<? echo $Categorymain; ?>">
        <input type="hidden" name="subcatg<? echo $i; ?>" id="subcatg<? echo $i; ?>" value="<? echo $CatagoryId; ?>">
        <input type="hidden" name="srno" id="srno" value="<? echo (($numItem - ($i))); ?>">
        <td valign="top" align="left" class="lightbluebg"><? echo $ProdName; ?> &nbsp;</td>
    </tr>
<?php
}}
?>
</table>