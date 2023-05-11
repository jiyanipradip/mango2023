<?
require_once '../../library/config.php';

$orderId = (int)$_GET['oid'];

// get ordered items
//echo samir
$sql = "SELECT * from creditmemo oi, productmast p  where oi.Prodid = p.PordId  AND oi.memono = '$memono' AND oi.CustId  = $oid
		AND oi.Prodid != 1
		ORDER BY oi.srno ASC";
//echo $sql;
$result = dbQuery($sql);
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
$inv = $row['srno'];
$invdate = $row['invdate'];
//echo $invdate."----------";
//echo $inv."+++++++";
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
<link href="<?php echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<body onLoad="window.print()">
<table border="0" align="left" width="665" align="center">
<tr>
<td align="center">
<form action="" method="get" name="frmOrder" id="frmOrder">

<table border="0" width="665" align="center" cellpadding="0">
  <tr><td width=22% valign="top">
<table  border="0" valign="top" align="left">
      			<tr>
        			<td valign="top">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="280" height="78">
            <param name="movie" value="../../images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="../user/images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" width="560" height="157" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed>
          			</object>
	       		  </td>
          </tr>
                 <tr>
                 <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">415 Sargon Way , Sut # G <br>
                 	 Horsham PA 19044
                 </td>
                 </tr>
</table>                 
 </td>
 <td width=88% valign="right">
 		<table align="right" >
        	<tr><td><h1>Credit Memo </h1>
            			<table border="0" class="maintable" cellpadding="0" cellspacing="0">
                        	<tr><td class="leftbtm">Date</td>
                        	<td class="btmbrd">Memo #.</td>
                        	</tr>
                            <tr><td class="leftbtm2"><? $k =  explode('-',$invdate);
							//echo $k[0];
														echo $k[1]."-".$k[2]."-".$k[0];

							//echo $k[2];

							 ?></td><td>&nbsp;<? echo $memono; ?><input type = "hidden" name="oid" id="oid" value="<? echo $oid; ?>"></td></tr>
                        </table>
            </td></tr>
           <? /*  <tr><td align="right" colspan="2">Invoice For : 
          <?  if(isset($suply)) { ?><? echo $suply; ?> <? } ?></td></tr> */ ?>
        </table>    
 </td>
 </tr>
 </table>
 
  <table width="665" align="center"  cellpadding="0" cellspacing="0">
<tr>
    			<td width=50% align="left">
				<table border="0" cellpadding="0" cellspacing="0" class="maintable">
                        	<tr>
                            	<td width="256" class="hdbg btmbrd">Bill To</td>
           	</tr>
                                <tr><td>

                                	<?php echo $fname." ".$lname;  ?><br>
                                    <?php echo $name."<br>"; ?>
                					<?php echo $bill_st1."  ".$bill_st2; ?> <br>
                					<?php echo $bill_city; ?><?php echo "&nbsp;&nbsp;".$bill_state."&nbsp;&nbsp;".$bill_zip; ?>
<br>
                                   
                				</td>
                           </tr>
                       </table>		
			  </td>
				<td width=50% align="right">
				<table border="0" cellpadding="0" cellspacing="0" class="maintable">
                        	<tr>
                            	<td width="295" class="hdbg btmbrd">Ship To</td>
                       	  </tr>
                                <tr><td>
                                <?php echo $fname." ".$lname;  ?><br>
                                <?php echo $name."<br>"; ?>
              				 		<?php echo $ship_st1."  ".$ship_st2; ?> <br>
                					<?php echo $ship_city; ?><?php echo "&nbsp;&nbsp;".$ship_state."&nbsp;&nbsp;"; ?><?php echo $ship_zip; ?>
<br>
                                    
                				</td>
                            </tr>
                       </table>
			  </td>
	  </tr>
  </table>
  </td>
  </tr>
  <tr>
  <td>    
 <table width="665" border="0" align="right" cellpadding="0" cellspacing="0" class="maintable">
  
  <tr>
  <td align="center" class="hdbg btmbrd rightbrd">P.O. Number</td>
  <td align="center" class="leftbtm"> Terms</td>
  <td align="center" class="leftbtm"> Ship</td>
  <td align="center" class="btmbrd"> Via</td>
    </tr>
    <tr>
  <td class="rightbrd"><input type="text"></td>
  <td class="rightbrd"> <input type="text"></td>
  <td class="rightbrd"><input type="text"></td>
  <td class=""><input type="text"></td>
    </tr>
    </table>  </td></tr>
    <tr><td>         

<table width="665" border="0"  align="center" cellpadding="0" cellspacing="0" class="maintable">
    <tr align="center" class="label"> 
          <td width="71" class="leftbtm">Quantity&nbsp;</td>

        <td width="74" class="leftbtm">Item Code&nbsp;</td>
      <td width="330" class="leftbtm">Description&nbsp;</td>
      <td width="96" class="leftbtm">Sales Price&nbsp;</td>
      <? /*
      <td width="30">Net Amt&nbsp;</td>
      <td width="42">Tax %&nbsp;</td>
	  */ ?>
      <td width="94" class="btmbrd">Total Amt &nbsp;</td>

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
	$netamt +=($qty * $Prodprice);?>
   
    <tr>
            <td align="right" width="71" class="rightbrd"><? echo $qty; ?></td>

        <td width="74" class="rightbrd"><?php echo $Prodid; ?></td>
        <td align="left" width="330" class="rightbrd"><? echo $ProdName; ?></td>
        <td align="right" width="96" class="rightbrd"><?php echo number_format(($Prodprice),2); ?></td>
       
        <td align="right" width="94"><?php echo number_format(($qty * $Prodprice),2); ?></td>
    </tr>
<?php
}
?>
	<? 	if((isset($numItem)) && ($numItem < 26)) { for($k=0;$k<(26 - $numItem);$k++) {?>
    <tr>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
	<? }} ?>
    <td colspan="3" class="topbrd">Customer Service Contact : <? if(isset($memono))
	{
	$sql333 = "select * from creditmemomaster where memono= $memono";
	$result333=mysql_query($sql333);
	$row333=mysql_fetch_assoc($result333);
	echo $row333['contact'];
	} ?></td>
        <td colspan="1" align="right" class="rightbrd topbrd">Net Amount Total&nbsp;</td>
        <td align="right" class="topbrd"><?php echo number_format($netamt,2); ?></td>
  </tr>
   <tr> 
        <td colspan="4" align="right" class="rightbrd">Tax Amount&nbsp;</td>
        <td align="right" class="topbrd"><? echo number_format($netperc,2); ?></td>
    </tr>
    <tr> 
        <td colspan="4" align="right" class="rightbrd">Shipping&nbsp;</td>
        <td align="right" class="topbrd">&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="4" align="right" class="rightbrd">Total&nbsp;</td>
        <td align="right" class="topbrd"><?php echo number_format(($subTotal),2); ?></td>
    </tr>
    <tr><td colspan="4" align="center" class="rightbrd">
    
    </td><td></td>
  </table>
  <table align="center">
  	<tr><td class="rightbrd">&nbsp;</td></tr>
  	<tr>
    	<td style="font-family:'Times New Roman', Times, serif; font-size:14px;text-decoration:underline;" align="center">
        	Phone:215-550-4585 :Fax: 215-675-2878 : www.dentadepot.com
        </td>
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
</p>
    </form></td></tr></table></body>