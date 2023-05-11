<?
require_once '../../library/config.php';

$orderId = (int)$_GET['oid'];

// get ordered items
//echo samir
$sql = "SELECT * from invoice where invoiceno = '$invoiceno'
		AND Prodid != 1
		ORDER BY srno ASC";
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
                 <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                 204 A IT Tower 1, Infocity<br>
					Gandhinagar 382009,<br>
					Gujarat, India
                 </td>
                 </tr>
</table>                 
 </td>
 <td width=88% valign="right">
 		<table align="right" >
        	<tr><td><h1>Invoice </h1>
            			<table border="0" class="maintable" cellpadding="0" cellspacing="0">
                        	<tr><td class="leftbtm">Date</td>
                        	<td class="btmbrd">Invoice #.</td>
                        	</tr>
                            <tr><td class="leftbtm"><b><? $k =  explode('-',$invdate);
							//echo $k[0];
														echo $k[1]."-".$k[2]."-".$k[0];

							//echo $k[2];

							 ?></b></td><td class="leftbtm"><b>&nbsp;<? echo $invoiceno; ?></b><input type = "hidden" name="oid" id="oid" value="<? echo $oid; ?>"></td></tr><tr><td colspan="2" class="leftbtm2">Invoice For : <? if(isset($invoiceno))
	{
	$sql333 = "select * from invoicemaster where invoiceno= $invoiceno";
	$result333=mysql_query($sql333);
	$row333=mysql_fetch_assoc($result333);
	echo $row333['invfor'];
	} ?></td></tr>
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
				<td width=50% align="right" style="display:none;">
				<table border="0" cellpadding="0" cellspacing="0" class="maintable" style="visibility:hidden;">
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
 <table width="665" border="0" align="right" cellpadding="0" cellspacing="0" class="maintable" style="display:none;">
  
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
        <td align="left" width="330" class="rightbrd"><? echo $Proddesc; ?></td>
        <td align="right" width="96" class="rightbrd"><?php echo (($Prodprice)); ?></td>
       
        <td align="right" width="94"><?php echo (($qty * $Prodprice)); ?></td>
    </tr>
<?php
}
?>
	<? 	if((isset($numItem)) && ($numItem < 22)) { for($k=0;$k<(22 - $numItem);$k++) {?>
    <tr>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td class="rightbrd">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
	<? }} ?>
    <td colspan="3" class="topbrd">Customer Service Contact : <? if(isset($invoiceno))
	{
	$sql333 = "select * from invoicemaster where invoiceno= $invoiceno";
	$result333=mysql_query($sql333);
	$row333=mysql_fetch_assoc($result333);
	echo $row333['contact'];
	} ?></td>
        <td colspan="1" align="right" class="rightbrd topbrd">Net Amount Total&nbsp;</td>
        <td align="right" class="topbrd"><?php echo ($netamt); ?></td>
  </tr>
   <tr> 
        <td colspan="4" align="right" class="rightbrd">Tax Amount&nbsp;</td>
        <td align="right" class="topbrd"><? echo ($netperc); ?></td>
    </tr>
    <tr> 
        <td colspan="4" align="right" class="rightbrd">Shipping&nbsp;</td>
        <td align="right" class="topbrd">&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="4" align="right" class="rightbrd">Total&nbsp;</td>
        <td align="right" class="topbrd"><?php echo (($subTotal)); ?></td>
    </tr>
    <tr><td colspan="4" align="center" class="rightbrd">
    
    </td><td></td>
  </table>
  <table align="center">
  	<tr><td class="rightbrd">&nbsp;</td></tr>
  	<tr>
    	<td style="font-family:'Times New Roman', Times, serif; font-size:14px;text-decoration:underline;" align="center">
        	Phone:215-550-3068  : www.savlite.com
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