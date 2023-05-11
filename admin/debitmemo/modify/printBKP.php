<?
require_once '../../../library/config.php';

$orderId = (int)$_GET['oid'];

// get ordered items
$sql = "SELECT * from invoice oi, productmast p  where oi.Prodid = p.PordId  AND oi.sessid = '$sis' AND oi.CustId  = $oid
		AND oi.Prodid != 1
		ORDER BY oi.srno ASC";

$result = dbQuery($sql);
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}
// 2 get payment information !
$sqlx = "SELECT * from custmast where custid = '$oid'
		 ";

$resultx = dbQuery($sqlx);
extract(dbFetchAssoc($resultx));

// get order information
$sql = "SELECT Order_Date, Ship_FName, Ship_LName, Ship_Adr1, 
        Ship_Adr2, Ship_Phone, Ship_State, Ship_City, Ship_ZIP, 
		FName, LName, Adr1, Adr2, Phone,
		State, City, ZIP
	   	FROM orderdata
		WHERE Order_Id = $orderId";

$result = dbQuery($sql);
extract(dbFetchAssoc($result));

$orderStatus = array('New', 'Paid', 'Shipped', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == '$od_status') {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$status</option>\r\n";
}
?>
<body onLoad="window.print()"><table border="0" align="left" width="80%"><tr><td>
<form action="" method="get" name="frmOrder" id="frmOrder">

<table border="0" width="100%" align="center">
  <tr><td width=22% valign="top">
<table  border="0" valign="top" align="left">
      			<tr>
        			<td valign="top">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="130" height="35">
            <param name="movie" value="../../../images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="../../user/images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" width="560" height="97" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed>
          			</object>
	       		  </td>
          </tr>
                 <tr>
                 <td>415 Sargon Way , Sut # G <br>
                 	 Horsham PA 19044
                 </td>
                 </tr>
</table>                 
 </td>
 <td width=78% valign="right">
 		<table align="right">
        	<tr><td><h1>Invoice </h1>
            			<table border="1">
                        	<tr><td>Date</td>
                        	<td>Invoice #.</td>
                        	</tr>
                            <tr><td><? echo date("Y-m-d"); ?></td><td>&nbsp;<? echo $invoiceno; ?><input type = "hidden" name="oid" id="oid" value="<? echo $oid; ?>"></td></tr>
                        </table>
            </td></tr>
        </table>    
 </td></tr></table>                
  <table width="675" align="center">
<tr>
    			<td width=50%>
<table class="ddepot-blueborder" border="1" border="1" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td width="256" class="hdbg">Bill To</td>
           	</tr>
                                <tr><td>
                					<?php echo $bill_st1; ?> <br>
                					<?php echo $bill_st2; ?><br>
                					<?php echo $bill_city; ?><br>
                                    <?php echo $bill_state; ?><?php echo $bill_zip; ?>
                                   
                				</td>
                           </tr>
                       </table>		
			  </td>
				<td width=50%>
<table class="ddepot-blueborder" border="1" border="1" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td width="295" class="hdbg">Ship To</td>
                       	  </tr>
                                <tr><td>
                                
               				 		<?php echo $ship_st1; ?> <br>
                					<?php echo $ship_st2; ?><br>
                					<?php echo $ship_city; ?><br>
                                    <?php echo $ship_state; ?><?php echo $ship_zip; ?>
                                    
                				</td>
                            </tr>
                       </table>
			  </td>
	  </tr>
  </table></td></tr><tr><td>
  <table width="650" border="1" cellpadding="0" cellspacing="0" align="right">
  
  <tr>
  <td align="center">P.O. Number</td><td align="center"> Terms</td><td align="center"> Ship</td><td align="center"> Via</td>
    </tr>
    <tr>
  <td><input type="text"></td><td> <input type="text"></td><td><input type="text"></td><td><input type="text"></td>
    </tr>
    </table></td></tr><tr><td>
<table width="657" border="1"  align="center" border="1" cellpadding="0" cellspacing="0" class="ddepot-blueborder">

    <tr align="center" class="label"> 
          <td width="64">Quantity&nbsp;</td>
        <td width="66">Item Code&nbsp;</td>
      <td width="281">Description&nbsp;</td>
      <td width="91">Price Each&nbsp;</td>
      <? /*
      <td width="30">Net Amt&nbsp;</td>
      <td width="42">Tax %&nbsp;</td>
      */ ?>
	  <td width="87">Amount&nbsp;</td>

   </tr>
<?php
/*
$numItem  = count($orderedItem);
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++)
{
	extract($orderedItem[$i]);
	$subTotal += $PucrPrice * $orderd_qty;
*/?>
<?
$numItem  = count($orderedItem);

//echo $numItem."maddy";

$subTotal = 0;
$netperc = 0;
$netamt = 0;
for ($i = 0; $i < $numItem; $i++)
{
	if($numItem != 0)
{

	extract($orderedItem[$i]);
}
	//$subTotal += $Prodprice * $qty;
	$subTotal +=(($qty * $Prodprice*$taxperc)/100)+($qty * $Prodprice);
	$netperc += (($qty * $Prodprice*$taxperc)/100);
	$netamt +=($qty * $Prodprice);
?>
    <tr> 
            <td align="right"><? echo $qty; ?></td>

        <td><?php echo $Prodid; ?>&nbsp;</td>
        <td align="left"><? echo $ProdName; ?>&nbsp;</td>
        <td align="right"><?php echo number_format(($Prodprice),2); ?></td>
        <? /*
        <td align="right"><?php echo ($qty * $Prodprice); ?>&nbsp;</td>
        <td align="right"><?php echo ($taxperc); ?>&nbsp;</td>
        */ ?>
		<td align="right"><?php echo number_format(($qty * $Prodprice),2); ?></td>

    </tr>
<?php
}
?><? 	if((isset($numItem)) && ($numItem < 4)) { for($k=0;$k<5;$k++) {?>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><? }} ?>
        <td colspan="4" align="right">Net Amount Total&nbsp;</td>
        <td align="right"><?php echo number_format($netamt,2); ?></td>
  </tr>
   <tr> 
        <td colspan="4" align="right">Tax Amount&nbsp;</td>
        <td align="right"><? echo number_format($netperc,2); ?></td>
    </tr>
    <tr> 
        <td colspan="4" align="right">Shipping&nbsp;</td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="4" align="right">Total&nbsp;</td>
        <td align="right"><?php echo number_format(($subTotal),2); ?></td>
    </tr>
  </table>
<? 

/*
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="2" class="hdbg">Shipping Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">First Name&nbsp;</td>
        <td class="content"><?php echo $Ship_FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Last Name&nbsp;</td>
        <td class="content"><?php echo $Ship_LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address1&nbsp;</td>
        <td class="content"><?php echo $Ship_Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address2&nbsp;</td>
        <td class="content"><?php echo $Ship_Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Phone Number&nbsp;</td>
        <td class="content"><?php echo $Ship_Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Province / State&nbsp;</td>
        <td class="content"><?php echo $Ship_State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">City&nbsp;</td>
        <td class="content"><?php echo $Ship_City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Postal Code&nbsp;</td>
        <td class="content"><?php echo $Ship_ZIP; ?> &nbsp;</td>
    </tr>
</table>
*/ ?>
<? /*
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr> 
        <td colspan="2" class="hdbg">Payment Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">First Name&nbsp;</td>
        <td class="content"><?php echo $FName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Last Name&nbsp;</td>
        <td class="content"><?php echo $LName; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address1&nbsp;</td>
        <td class="content"><?php echo $Adr1; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Address2&nbsp;</td>
        <td class="content"><?php echo $Adr2; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Phone Number&nbsp;</td>
        <td class="content"><?php echo $Phone; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Province / State&nbsp;</td>
        <td class="content"><?php echo $State; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">City&nbsp;</td>
        <td class="content"><?php echo $City; ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Postal Code&nbsp;</td>
        <td class="content"><?php echo $ZIP; ?> &nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr id="infoTableHeader"> 
        <td colspan="2" class="hdbg">Billing Information&nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Payment Method&nbsp;</td>
        <td class="content"><?php echo stripslashes(ENCRYPT_DECRYPT($Pay_Method)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card No. &nbsp;</td>
        <td class="content"><?php echo stripslashes(ENCRYPT_DECRYPT($Card_No)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Name &nbsp;</td>
        <td class="content"><?php echo stripslashes(ENCRYPT_DECRYPT($Card_Name)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Expire Date &nbsp;</td>
        <td class="content"><?php echo stripslashes(ENCRYPT_DECRYPT($Card_Exp)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card CCV No. &nbsp;</td>
        <td class="content"><?php echo stripslashes(ENCRYPT_DECRYPT($Card_CVV)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="150" class="label">Card Id&nbsp;</td>
        <td class="content"><?php echo $Cart_Id; ?> &nbsp;</td>
    </tr>
</table>
*/ ?>
</p></form></td></tr><table></body>