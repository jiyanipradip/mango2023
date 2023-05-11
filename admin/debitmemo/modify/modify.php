<?php
require_once '../../library/encrypt1.php';
if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}
$orderId = (int)$_GET['oid'];

if((isset($_POST['barcodeentry'])) || (isset($barcode2)))
 {
echo "HIII";
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
		$sql= "select * from productmast where ProdSKU = $barcode";
		//echo $sql;
		$result = dbQuery($sql);
	$rowprod=mysql_fetch_assoc($result);
	if(mysql_num_rows($result) == 1)
	{
		$p1 = $rowprod['PordId'];
		$p2 = $rowprod['ProdDesc'];
		$p3 = $rowprod['SellPrice'];
		$p4 = $rowprod['TaxCode'];
		
			$sid = session_id();
		$sqlduplicatecheck="select * from debitmemo where CustId = '$catId'AND Prodid = '$p1' AND Proddesc = '$p2' AND Prodprice = '$p3' AND sessid = '$sid'";
		$resultduplicatecheck=dbQuery($sqlduplicatecheck);
		//if(mysql_num_rows($resultduplicatecheck) == 0)
		
		
		$sqlinvno="select memono from debitmemomaster where memono = $memono";
$resultinvno=mysql_query($sqlinvno);
$rowinvno=mysql_fetch_assoc($resultinvno);
$memono=$rowinvno['memono'];
			$sqlforinsert="INSERT INTO `dentadepot`.`debitmemo` (
`CustId` ,
`Prodid` ,
`Proddesc` ,
`Prodprice` ,
`sessid` ,
`qty`,
`invdate`,`memono`
)
VALUES (
'$catId', '$p1', '$p2', '$p3', '$sid',1,NOW(),$memono
)";
$resultforinsert = mysql_query($sqlforinsert);
	//$sqlforinsert="insert into invoice CustId = '$catId',Prodid = '$p1',Proddesc = '$p2',Prodprice = '$p3'";
	//echo $sqlforinsert."bacool";
	//$resultforinsert = mysql_query($sqlforinsert);
		
		
		

	}
	else
{
//echo "hiii";
	echo "<script> callmenowcreditmemo($catId,$memono);</script>";
}
	
 }
// get ordered items
/*
$sql = "SELECT ProdName,PordId,ProdDesc, PucrPrice, oi.orderd_qty
	    FROM ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and oi.order_id = $orderId
		ORDER BY order_id ASC";
*/
$sql = "SELECT ProdName,PordId,ProdSKU,p.ProdDesc, oi.Prodprice , oi.qty,oi.srno,oi.taxperc
	    FROM debitmemo  oi, productmast p 
		WHERE oi.Prodid = p.PordId and oi.CustId = $catId and oi.Prodid != '1'  and oi.memono = $memono
		ORDER BY oi.srno DESC";
		//echo $sql;
		$result = dbQuery($sql);
if(isset($qty))
 {
$orderd_qty = $qty;
}
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}

// 2 get payment information !
$sqlx = "SELECT Pay_Method, Card_No, Card_Name, Card_Exp, 
         Card_CVV, Cart_Id
	   	 FROM paydetail
		 WHERE Order_Id = $orderId";
$resultx = dbQuery($sqlx);
extract(dbFetchAssoc($resultx));
// get order information
/*
$sql = "SELECT Order_Date, Ship_FName, Ship_LName, Ship_Adr1, 
        Ship_Adr2, Ship_Phone, Ship_State, Ship_City, Ship_ZIP, 
		FName, LName, Adr1, Adr2, Phone,
		State, City, ZIP
	   	FROM orderdata
		WHERE Order_Id = $orderId";
*/
if (isset($_GET['catId']))
 {
	$catId = $catId;
//	$sql2 = " AND  p.CatagoryId = '$catId'";
	//$queryString = "catId='$catId'";
		//$sid = session_id();
		
 	$sql= "select * from vendormast where vendorid = $catId";
$result = dbQuery($sql);
extract(dbFetchAssoc($result));
 }
 else
 {
	$catId = 0;
	//$sql2  = 'AND  p.CatagoryId = "bacool"';
	//$/queryString = '';
	///$sql= "select * from custmast where custid = 'xyz'";
//$result = dbQuery($sql);
//extract(dbFetchAssoc($result));
 }
$orderStatus = array('New', 'Paid', 'Shipped', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == '$od_status') {
		$orderOption .= " selected";
	}
	$orderOption .= ">$status</option>\r\n";
}
$categoryList = buildvenderselectionforlist();
$numCategory     = count($categoryList);
?><head>
<script language="javascript">

function viewProduct1(oid)
{
//alert(document.frmOrder.cboCategory.selectedIndex);
	with (window.document.frmOrder) {
	//alert("hi");
		if (cboCategory.selectedIndex == 0) {
			//alert("hello");
			window.location.href = 'index.php?flag=1';
		} else {
		//alert("no hello");
			window.location.href = 'index.php?view=modify&oid=' + oid.value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value +'&barcode=1';
		}
	}
}

function viewProduct219()
{
alert('hi');
var bar = barcode.value;
//alert(barcode);
//alert(document.frmOrder.cboCategory.selectedIndex);
	with (window.document.frmOrder) {
	alert("hi");
		if (cboCategory.selectedIndex == 0) {
			alert("hello");
			window.location.href = 'index.php?flag=1';
		} else {
		alert("no hello");
			window.location.href = 'index.php?view=modify&oid=' + oid.value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value + '&barcode=' + bar + '&goqty=goqty&srno1=' + srno + '&sid=' + sid;
		}
	}
}
function enterqty(q,m,n,o,sid)
{
	alert('hi');
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify\quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&sid=' + sid;	
}



function enterqty7(q,m,n,o,p)
{
	//alert(q.value);
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	var si	= p;	
	//var l = l;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify\updateprod.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;
}
function enterqty6(q,m,n,o,p,a)
{
	alert(q.value);
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	var si	= p;	
	//var l = l;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify\updateprod1.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;
}

</script>
<script language="javascript">
function newWindow(file,window)
 	{
	
	//alert('HH');
	WindowName="MyPopUpWindow";

settings=
"toolbar=no,location=no,directories=no,"+
"status=no,menubar=no,scrollbars=yes,"+
"resizable=no,width=400,height=400";
   
    	msgWindow=open(file,window,settings);
    	if (msgWindow.opener == null) msgWindow.opener = self;
	}
	function newWindow1(file,window)
 	{
	
	//alert('HH');
	WindowName="MyPopUpWindow";

settings=
"toolbar=no,location=no,directories=no,"+
"status=no,menubar=no,scrollbars=yes,"+
"resizable=yes,width=400,height=400";
   
    	msgWindow=open(file,window,settings);
    	if (msgWindow.opener == null) msgWindow.opener = self;
	}
</script></head></head>
<? 
  if(isset($callme))
 {
// echo "looooooooo";
 }
 ?> 
 <body
 <?
  /*
 if(isset($oid) && isset($catId) && isset($barcode) && isset($unitprice) && isset($textperc)){ ?>
      onload=document.all["taxamttext<? echo $sirno; ?>"].focus()
<? } else
 if(isset($oid) && isset($catId) && isset($barcode) && isset($unitprice)){ ?>
      onload=document.all["taxtext<? echo $sirno; ?>"].focus()
<? } else
 if(isset($oid) && isset($catId) && isset($barcode) && isset($gotoprice)){ ?>
      onload=document.all["ppricetext<? echo $sirno; ?>"].focus()
<? } else if(isset($oid) && isset($catId) && isset($barcode) && isset($goqty)){ ?>
 <? $srno2 = $srno1 + 1; ?>
      onload=document.all["qtytext<? echo $srno1; ?>"].focus()
<? }  
  else if(isset($oid) && isset($catId) && isset($barcode)){ ?>
      onload=document.all["barcode"].focus()
<? } ?> */ 
 
if(isset($printpage))
 {
 $sid = session_id();
$memono = $memono;
 ?>
	onload="newWindow1('print.php?oid=<? echo $catId; ?>&sis=<? echo $sid;  ?>&memono=<? echo $memono; ?>','window');"
 <?
 } 
 else if(isset($callme))
 {
 ?>
	onload="newWindow1('modify/popupbarcodesearch.php?view=edit&oid=<? echo $oid; ?>&catId=<? echo $catId; ?>&memono=<? echo $memono; ?>','window');"
 <?
 }
 else{ ?>
onload=document.all["barcodeentry"].focus()
<? 
} 
?>  >

<form action="" method="post" name="frmOrder" id="frmOrder">

<table border="0" width="100%"><tr><td width=50% valign="top">
<table  border="0" valign="top">
      			<tr>
        			<td valign="top">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="130" height="35">
            <param name="movie" value="../../images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="../images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" width="560" height="97" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed>
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
 <td width=50% valign="right">
 		<table align="right">
        	<tr><td><h1>Debit Memo </h1>
            			<table border="1">
                        	<tr><td>Date</td>
                        	<td>Memo #.</td>
                        	</tr>
                            <tr><td><input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" size="10" maxlength="10" <? if(isset($sirno)) { 
							$sql= "select invdate from creditmemo where memono = '$memono'";
							$result=mysql_query($sql);
							$rw=mysql_fetch_assoc($result);  $k =  explode('-',$rw['invdate']);
							?> value="<?
							
							// echo $rw['invdate']; 
                             
                             
							//echo $k[0];
														echo $k[1]."-".$k[2]."-".$k[0];

							//echo $k[2];

							 ?>
                             
                             "<? } else { ?> value="<? echo date("Y-m-d"); ?>"
   <? } ?>  readonly="yes" ><? include('calreviewreport.php');?>  </td><td>&nbsp;<? echo $memono; ?>
   
   <input type = "hidden" name="oid" id="oid" value="<? echo $invno; ?>"></td></tr>
                        </table>
            </td></tr>
            
        </table>    
 </td></tr></table>                
<p>&nbsp;</p>
	<table class="ddepot-blueborder">
    <tr><td colspan="2" class="hdbg">Select Customer :
    <select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct1();">
                <?
                    if ($numCategory > 0)
                    {
                        $i = 0;
                        ?>
                                    <option>-- Select Customer --</option>
 	                    <?
	                      for ($i; $i < $numCategory; $i++)
                        {
                            extract ($categoryList[$i]);
                ?>
	                   <option value="<? echo $code; ?>" <?php if ($catId == $code){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
	   
       <a href="#" onClick="newWindow('popup1.php?view=edit&oid=<? echo $oid; ?>&catId=<? echo $catId; ?>','window')">
       
       Add New</a></td></tr>
			<tr>
    			<td width=50%>
   		  <table class="ddepot-blueborder">
                        	<tr>
                            	<td width="521" class="hdbg">Bill To</td>
           	</tr>
                                <tr><td><? if(isset($catId) && $catId != 0) { ?>
                					<?php echo $address1; ?> <br>
                					<?php echo $address2; ?><br>
                					<?php echo $city; ?><br>
                                    <?php echo $state; ?><?php echo $zip; ?>
                                    <? } ?>
                				</td>
                           </tr>
                       </table>		
			  </td>
				<td width=50%>
   		  <table class="ddepot-blueborder">
                        	<tr>
                            	<td width="717" class="hdbg">Ship To</td>
                       	  </tr>
                                <tr><td>
                                <? if(isset($catId) && $catId != 0) { ?>
               				 			<?php echo $address1; ?> <br>
                					<?php echo $address2; ?><br>
                					<?php echo $city; ?><br>
                                    <?php echo $state; ?><?php echo $zip; ?>
                                    <? } ?>
                				</td>
                            </tr>
                       </table>
			  </td>
	  </tr>
	</table></form>
<table width="729" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder" >
<? /* <tr> 
        <td colspan="9">Enter Barcode : <input type="text" name="barcode" id="barcode" <? if(isset($barcode)) { ?> value="<? echo $barcode; ?>" <? } ?> onBlur="viewProduct2()"> <input type="button" value="Go" onClick="viewProduct2();"></td>
    </tr> */?>
<tr id="infoTableHeader"> 
        <td colspan="9" class="hdbg">Ordered Item&nbsp;</td>
    </tr>
    <tr id="infoTableHeader"> 
        <td colspan="9" class="hdbg"><form method="post" name="formbarcode" action="">Enter Barcode<input type="text" name="barcodeentry" id="barcodeentry"><input type="submit" value="GO"></form></td>
    </tr>
    <tr align="center" class="label">
    	<td width="60">Barcode</td> 
      <td width="42">Item Code&nbsp;</td>
   	  <td width="302">Description</td>
      <td width="51">Quantity</td>
      <td width="35">Unit Price&nbsp;</td>
      <td width="30">Net Amt&nbsp;</td>
      <td width="31">Tax % &nbsp;</td>
      <td width="35">Total Amt&nbsp;</td>
      <td width="43">Delete&nbsp;</td>



   </tr>
    <? if(isset($_POST['printpage']))
 {
  $srno = $_POST['srnoitem'];
  echo "hiiiiii";
  if(isset($orderedItem))
	{
$numItem  = count($orderedItem);
	}
	$k = $srno + 50;
	//$k = $k +1;
	//echo $srno."-----";
		
		//echo "1";

  	for($i = ($srno - 1); $i <= $k;$i++)
{

 	$catId = $_GET['catId'];
	//$v='barcode'.$code[$i];
	
	$selfordate="select * from debitmemomaster where invoiceno = $memono";
	$resultfordate=mysql_query($selfordate);
	$rowfordate=mysql_fetch_assoc($resultfordate);
	$appdate = $rowfordate['CustId'];
	if($appdate == '')
	{
		//

		$appdate = date('Y-m-d');
		//echo $appdate."hiii";die;
	}
	$sqlfinalsearch="select * from debitmemo where CustId = $catId AND memono = $memono AND srno = $i";
	$resultfinalsearch=mysql_query($sqlfinalsearch);
	if(mysql_num_rows($resultfinalsearch) ==1)
	{
	$v='qtytext'.$i;
	$v1='ppricetext'.$i;
	$qty = $_POST[$v];
	$price =  $_POST[$v1];
	$sql="UPDATE debitmemo SET qty = $qty,Prodprice = $price,invdate = '$appdate' where CustId = $catId AND memono = $memono AND srno = $i";
	//echo $sql."<br>";
	$result=mysql_query($sql);
	}
	else
	{
	}
//die;
}
$supply = $_POST['supply'];
	$continfo = $_POST['continfo'];
$sql="UPDATE debitmemomaster SET invfor = '$supply',contact = '$continfo' where memono = $memono";
	//echo $sql."<br>";die;
	$result=mysql_query($sql);

header('Location: index.php?view=modify&oid=178&catId='.$catId.'&barcode1=1&printpage=printpage&memono='.$memono);
			exit;
	//----------------
  }
 if(isset($_POST['save1']))
 {
  $srno = $_POST['srnoitem'];
  echo "hiiiiii";
  if(isset($orderedItem))
	{
$numItem  = count($orderedItem);
	}
	$k = $srno + 50;
	//$k = $k +1;
	//echo $srno."-----";
		
		//echo "1";

  	for($i = ($srno - 1); $i <= $k;$i++)
{

 	$catId = $_GET['catId'];
	//$v='barcode'.$code[$i];
	
	$selfordate="select * from debitmemomaster where memono = $memono";
	$resultfordate=mysql_query($selfordate);
	$rowfordate=mysql_fetch_assoc($resultfordate);
	$appdate = $rowfordate['CustId'];
	if($appdate == '')
	{
		//

		$appdate = date('Y-m-d');
		//echo $appdate."hiii";die;
	}
	$sqlfinalsearch="select * from debitmemo where CustId = $catId AND memono = $memono AND srno = $i";
	$resultfinalsearch=mysql_query($sqlfinalsearch);
	if(mysql_num_rows($resultfinalsearch) ==1)
	{
	$v='qtytext'.$i;
	$v1='ppricetext'.$i;
	$qty = $_POST[$v];
	$price =  $_POST[$v1];
	$sql="UPDATE debitmemo SET qty = $qty,Prodprice = $price,invdate = '$appdate' where CustId = $catId AND memono = $memono AND srno = $i";
	//echo $sql."<br>";
	$result=mysql_query($sql);
	}
	else
	{
	}
//die;
}
$supply = $_POST['supply'];
	$continfo = $_POST['continfo'];
$sql="UPDATE debitmemomaster SET invfor = '$supply',contact = '$continfo' where memono = $memono";
	//echo $sql."<br>";die;
	$result=mysql_query($sql);

header('Location: index.php?view=list');
			exit;
	//----------------
  }
   if(isset($_POST['update1']))
  {
  $srno = $_POST['srnoitem'];
  echo "hiiiiii";
  if(isset($orderedItem))
	{
$numItem  = count($orderedItem);
	}
	$k = $srno + 50;
	//$k = $k +1;
	//echo $srno."-----";
		
		//echo "1";

  	for($i = ($srno - 1); $i <= $k;$i++)
{
		//echo "2"; die;
 	$catId = $_GET['catId'];
	//$v='barcode'.$code[$i];
	$memono = $memono;
	$selfordate="select * from debitmemomaster where memono = $memono";
	$resultfordate=mysql_query($selfordate);
	$rowfordate=mysql_fetch_assoc($resultfordate);
	$appdate = $rowfordate['CustId'];
	if($appdate == '')
	{
		//

		$appdate = date('Y-m-d');
		//echo $appdate."hiii";die;
	}
	$sqlfinalsearch="select * from debitmemo where CustId = $catId AND memono = $memono AND srno = $i";
	$resultfinalsearch=mysql_query($sqlfinalsearch);
	if(mysql_num_rows($resultfinalsearch) ==1)
	{
			//echo "3";die;
	$v='qtytext'.$i;
	$v1='ppricetext'.$i;
	$qty = $_POST[$v];
	$price =  $_POST[$v1];
	$sql="UPDATE debitmemo SET qty = $qty,Prodprice = $price,invdate = '$appdate' where CustId = $catId AND memono = $memono AND srno = $i";
	//echo $sql."<br>";
	$result=mysql_query($sql);
	}
	else
	{
	}
//die;
}
$supply = $_POST['supply'];
	$continfo = $_POST['continfo'];
$sql="UPDATE debitmemomaster SET invfor = '$supply',contact = '$continfo' where memono = $memono";
	//echo $sql."<br>";die;
	$result=mysql_query($sql);

header('Location: index.php?view=modify&oid=178&catId='.$catId.'&modify='.$modify.'&barcode1=1&memono='.$memono);
			exit;
  }
  ?>
   <?php
if(isset($orderedItem))
{
$numItem  = count($orderedItem);
}?>
<form name="exampleForm" method="post" >
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
   		<td valign="top">
     
        
        <input type="text" maxsizze="6" size="6" name="barcode" id="barcode"  value="<? echo $ProdSKU; ?>"  <? /* onBlur="viewProduct21(this,'<? echo $oid; ?>','<? echo $srno; ?>','<? echo $sid; ?>')" */ ?> style="text-align:right"></td>
        <td valign="top"><input type="text" <? if($ProdSKU != 1) { ?> value="<?php echo $PordId; ?>" <? } ?> maxsizze="6" size="6" <? /*onBlur="enterqty7(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $barcode; ?>','<? echo $sid;?>');" */ ?> name="prod1" id="prod1" style="text-align:right"></td>
        <td valign="top"><? echo $ProdName; ?> &nbsp;</td>
        <td valign="top">
		
		<input type="text" <? if($ProdSKU != 1) { ?>  value="<? echo $qty; ?>" <? } ?> name="qtytext<? echo $srno; ?>" maxsizze="3" size="3" id="qtytext<? echo $srno; ?>"
          <? /* onblur="enterqtymodify(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>','<? echo $sid; ?>');" */ ?> style="text-align:right"/></td>
        <td align="right" valign="top"><input type="text" value="<?php echo number_format($Prodprice,2); ?>" name="ppricetext<? echo $srno; ?>" id="ppricetext<? echo $srno; ?>" maxsizze="3" size="3" 
       <? /*  onBlur="enterqty1modify(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>','<? echo $sid; ?>');"  */ ?> style="text-align:right"/>          &nbsp;</td>
      <td align="right" valign="top"><input type="text" name="netamttext<? echo $srno; ?>" id="netamttext<? echo $srno; ?>" value="<?php echo number_format(($qty * $Prodprice),2); ?>" maxsizze="3" size="3" style="text-align:right"></td>
      <td align="right" valign="top"><input type="text" name="taxtext<? echo $srno; ?>" id="taxtext<? echo $srno; ?>" value="<?php echo ($taxperc); ?>" maxsizze="3" size="3" 
     <? /*  onBlur="enterqty2modify(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>','<? echo $sid;?>','<? echo $sid;?>');" */ ?> style="text-align:right"></td>
      <td align="right" valign="top"><input type="text" name="taxamttext<? echo $srno; ?>" id="taxamttext<? echo $srno; ?>" value="<?php echo number_format(((($qty * $Prodprice*$taxperc)/100)+($qty * $Prodprice)),2) ?>" maxsizze="3" size="3" style="text-align:right"></td>
              <td><a href="javascript:deleteCategoryformodify('<? echo $srno; ?>','<? echo $catId;?>','<? echo $barcode; ?>','<? echo $memono; ?>');">Delete&nbsp;</td>


    </tr>
<?php
}
?>
    <tr class="content"> 
        <td colspan="7" align="right">Sub-total&nbsp;</td>
        <td align="right"><?php echo ($subTotal); ?>&nbsp;</td><td>&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="7" align="right">Shipping&nbsp;</td>
        <td align="right">&nbsp;</td><td>&nbsp;</td>
    </tr>
    <tr class="content"> 
        <td colspan="7" align="right">Total&nbsp;</td>
        <td align="right"><?php echo ($subTotal); ?>&nbsp;</td><td>&nbsp;</td>
    </tr>
    <tr><td colspan="9" align="center">
    Invoice For :
    <?
if(isset($memono)){
$sqlyy = "select memono from debitmemo where custid='$catId' AND memono='$memono'";
$resultyy=mysql_query($sqlyy);
$popat=mysql_fetch_assoc($resultyy);
?>
<? $k = $popat['memono'];
	$sqlzz="select * from debitmemomaster where memono = $memono";
	//echo $sqlzz;
	$resultzz=mysql_query($sqlzz);
	$rows=mysql_fetch_assoc($resultzz);
	// echo $rows['invfor']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 ?><? }
           ?>
            <select name="supply" id="supply">
            <option value="Dental Supply" <? if($rows['invfor'] == 'Dental Supply') { ?> SELECTED <? } ?>>Dental Supply</option>
            <option value="Office Supply" <? if($rows['invfor'] == 'Office Supply') { ?> SELECTED <? } ?>>Office Supply</option>
            <option value="Equipment" <? if($rows['invfor'] == 'Equipment') { ?> SELECTED <? } ?>>Equipment</option>
            <option value="Service Charge" <? if($rows['invfor'] == 'Dental Supply') { ?> SELECTED <? } ?>>Service Charge</option>
            </select>
			<? /* $sql = "select * from invoice where CustId = '$catId' AND sessid = '$sid'";
			$result=mysql_query($sql);
			$roq=mysql_fetch_assoc($result);
			 echo $roq['invfor']; */?>Customer Service Contact :<input type="text" name="continfo" id="continfo" <? if(isset($memono)) {?> value="<? echo $rows['contact']; ?>"<? } ?> }
			 ?>
			 
            
    </td>
        <input type="hidden" name="srnoitem" value="<? echo $srno; ?>">

    <tr><td colspan="9" align="center"><a href="index.php"> BACK </a> <? /*|
    <a href="javascript:save1('<? echo $rows['invoiceno']; ?>')"> SAVE </a><?  /*
    <a href="../index.php?view=edit&amp;oid=178&amp;unsetsession=unsetsession"> SAVE  </a>*/ ?> <? /*<a href="modify/print.php?oid=<? echo $catId; ?>&amp;sis=<? echo $sid; ?>&amp;invoiceno=<? echo $sirno; ?>" target="_blank">PRINT</a> */?> |
    
  <? /*  <a href="#" onclick="javascript:window.open('modify/print.php?oid=<? echo $catId; ?>&amp;sis=<? echo $sid; ?>&amp;invoiceno=<? echo $sirno; ?>&suply=<? echo $rows['invfor'] ?>&contact=<? if(isset($sid)) { echo $rows['contact']; }?>', '_blank');">           PRINT            </a> */?>
     <?
if(isset($memono)){
$sqlyy = "select * from debitmemo where custid='$catId' AND memono='$memono'";
$resultyy=mysql_query($sqlyy);
$popat=mysql_fetch_assoc($resultyy);
/* ?> <a href="../Invoice/print.php?oid=<? echo $catId; ?>&sis=<? echo $popat['sessid'];  ?>&invoiceno=<? echo $invno; ?>" target="_blank">PRINT</a> <? */ } ?>
   | <a href="javascript: deleteCategoryfordelete('<? echo $catId;?>',<? echo $memono; ?>);">DELETE&nbsp;</a></td></tr>
    <tr><td colspan="9" align="center"><input type="submit" name="update1" value="UPDATE"><input type="submit" name="save1" value="SAVE"><input type="submit" name="printpage" value="PRINT"></td></tr>
</table>
<? 
}

?>
</p><input type="hidden" name="hiddensid" id="hiddensid" value="<? echo $sid; ?>"></form></body>
