<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
require_once '../../library/encrypt1.php';

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}
$orderId = (int)$_GET['oid'];
// get ordered items
/*
$sql = "SELECT ProdName,PordId,ProdDesc, PucrPrice, oi.orderd_qty
	    FROM ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and oi.order_id = $orderId
		ORDER BY order_id ASC";
*/
if(isset($_GET['unsetsession']))
{
	session_regenerate_id();
	$sid=session_id();
	

	header('Location: index.php');
}
if(isset($generate))
{
$sqlgeneratesrno="insert into invoicemaster(`sid`) VALUES ('sid')";
	$resultgeneratesrno=mysql_query($sqlgeneratesrno);
}
if(isset($sirno))
{?>

<? }
if (isset($_GET['orderd_qty']))
 {
	$orderd_qty = $orderd_qty;
 }
 else
 {
 $orderd_qty = 1;
 }
if(isset($barcode))
{
$sql= "select * from productmast where ProdSKU = $barcode";
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
	/*
	
*/if(isset($srno1)) {
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
//*****
//echo $sqlforinsert."bacool";
	$resultforinsert = mysql_query($sqlforinsert);
	//$sqlforinsert="insert into invoice CustId = '$catId',Prodid = '$p1',Proddesc = '$p2',Prodprice = '$p3'";
	//echo $sqlforinsert."bacool";
	//$resultforinsert = mysql_query($sqlforinsert);
}
}
}
else
{
	echo "<script> callme($catId,$srno1);</script>";
}
$sql = "SELECT ProdName,PordId,ProdSKU,p.ProdDesc, oi.Prodprice , oi.qty,oi.srno,oi.taxperc 
	    FROM invoice  oi, productmast p 
		WHERE oi.Prodid = p.PordId and oi.CustId = $catId and oi.sessid='$sid'
		ORDER BY oi.srno ASC";
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
		$sid = session_id();
		$sql2="select * from invoice where sessid = '$sid' AND Prodid = '1' AND CustId = '$catId'";
		$result2=mysql_query($sql2);
		if(mysql_num_rows($result2) == 0)
		{
		$sql1="insert into invoice(`sessid`,`Prodid`,`CustId`) values('$sid',1,'$catId')";
		//echo $sql1;
		$result1=mysql_query($sql1);
		}
 	$sql= "select * from custmast where custid = $catId";
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
$categoryList = buildcustomerselection();
$numCategory     = count($categoryList);
?><head>
<script language="javascript">
function save(a)
{
//alert(a);
var b = document.frmOrder.appdate.value;
var invfor = document.frmOrder.supply.value;
var contact = document.frmOrder.continfo.value;
//alert(invfor);
window.location.href = 'unset.php?a=' + a + '&suply=' + invfor + '&contact=' + contact + '&b=' +b; 
}
function viewProduct1(oid)
{
	with (window.document.frmOrder) {
	//alert("hi");
		if (cboCategory.selectedIndex == 0) {
			//alert("hello");
			window.location.href = 'index.php?flag=1';
		} else {
		//alert("no hello");
			window.location.href = 'index.php?view=edit&oid=' + oid.value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value +'&barcode=1';
		}
	}
}
function viewProduct2(oid,barcode,srno)
{
var bar = barcode.value;
//alert(barcode);
//alert(document.frmOrder.cboCategory.selectedIndex);
	with (window.document.frmOrder) {
	//alert("hi");
		if (cboCategory.selectedIndex == 0) {
			//alert("hello");
			window.location.href = 'index.php?flag=1';
		} else {
		//alert("no hello");
			window.location.href = 'index.php?view=edit&oid=' + oid.value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value + '&barcode=' + bar + '&goqty=goqty&srno1=' + srno;
		}
	}
}
function enterqty(q,m,n,o)
{
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar;	
}
function enterqty2(q,m,n,o,p)
{
	//alert('hh');
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	var si	= p;	
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='taxperc.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;
}
function deleteCategory(q,m,n,o)
{
	//var q = q.value;
	
	var srno = q;
	var cat	= m;	
	var bar = n;
	var si	= o;
	window.location.href='deleterow.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;

}
function deleteCategory1(q,m)
{
	//var q = q.value;
	var cat	= q;	
	var si	= m;
	window.location.href='deleteinvoice.php?cat=' + cat + '&si=' + si;

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
	window.location.href='updateprod.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;
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
	window.location.href='updateprod1.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si;
}
function enterqty1(q,m,n,o)
{
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='unitprice.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar;	
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
</script></head>
 <body
 <? /*
 <? if(isset($sirno) && isset($unitprice) && isset($textperc)){ ?>
  onload=document.all["taxamttext<? echo $sirno1;?>"].focus()
   <? }else 
  if(isset($sirno) && isset($barcode) && isset($sirno)){ ?>
   onload=document.all["prod1"].focus()
    <? }
 else if(isset($sirno) && isset($unitprice)) { ?>
 onload=document.all["netamttext<? echo $sirno;?>"].focus()
  <? }
  else if(isset($sirno) && isset($barcode != 1) && isset($prodchange))
   {?>
    onload=document.all["qtytext<? echo $sirno; ?>"].focus()
    <? } else  if(isset($sirno) && isset($barcode) && isset($sirno)){ ?>
   onload=document.all["prod1"].focus()
    <? } else {?>
     onload=document.all["prod"].focus()
   <? } ?> 
   */
 ?> <?  
 if(isset($callme))
 {
 ?>
	onload="newWindow1('popupbarcodesearch.php?view=edit&oid=<? echo $oid; ?>&catId=<? echo $catId; ?>&srno1=<? echo $srno2; ?>','window');"
 <?
 }
 else
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
<? } ?>  
  >
<form action="" method="get" name="frmOrder" id="frmOrder">

<table border="0" width="100%"><tr><td width=50% valign="top">
<table  border="0" valign="top">
      			<tr>
        			<td valign="top">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="130" height="35">
            <param name="movie" value="../../images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <embed src="images/DentaDepot-LOGO-Globerotating-right2left-feb.swf" width="560" height="97" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed>
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
        	<tr><td><h1>Invoice </h1>
            			<table border="1">
                        	<tr><td>Date</td>
                        	<td>Invoice #.</td>
                        	</tr>
                            <tr><td>
                            <?
							$sqlforno="select * from invoicemaster order by invoiceno DESC";
							$resultforno=mysql_query($sqlforno);
							$rowno=mysql_fetch_assoc($resultforno);
						?>
							<script language="javascript">
function setme(e)
{
alert(e);
}
function handleHttpResponse() {
if (http.readyState == 4) {
if(http.status==200) {
var results=http.responseText;
//alert(results);
document.getElementById('offname').innerHTML = results;
//alert(results);
}
}
}
function ajax_fun(txt) {
//alert("hellooo");
var url = "ajax_for_officeedit.php?txt="; // The server-side script
var sId = txt; 
//document.getElementById("appdate").value;
//alert(sId);
//alert(url + escape(sId));
http.open("GET", url + escape(sId), true);


http.onreadystatechange = handleHttpResponse;
http.send(null);
}

function ajax_fun_addoffice()
{

	if(document.getElementById("appdate").value!=0 && document.getElementById("offname").value!=0)
	{
	
	
		var url = "ajax_for_addoffice.php?txt="; // The server-side script
		var sId = document.getElementById("appdate").value;
		var offname = document.getElementById("offname").value;
		
		http.open("GET", url + escape(sId)+"&offname="+escape(offname), true);
			
		http.onreadystatechange = handleHttpResponse_off;
		http.send(null);
	}
	else
	{
		alert("Please select information properly");
	}	
}

function getHTTPObject() {
var xmlhttp;

if(window.XMLHttpRequest){
xmlhttp = new XMLHttpRequest();
}
else if (window.ActiveXObject){
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
if (!xmlhttp){
xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}

}
return xmlhttp;
}

var http = getHTTPObject(); // We create the HTTP Object
</script>
</script>
<input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" onchange="setme();" size="10" maxlength="10" <? if($rowno['CustId'] == '') { ?> <? if(isset($k)) { ?> value="<? echo $k; ?>" <? } else { ?>value="<? echo date("Y-m-d"); ?>" <? } ?> <? } else { ?> value="<? echo $rowno['CustId']; ?>" <? } ?>
     readonly="yes" ><? include('calreviewreportedit.php');?> 
							
							</td><td>&nbsp;
							<?	echo $rowno['invoiceno'];
							 ?>
                            <input type = "hidden" name="oid" id="oid" value="<? echo $oid; ?>"></td></tr>
                        </table>
            </td></tr>
            <div id="offname">
     </div>
        </table>    
 </td></tr></table>                
<p>&nbsp;</p>
	<table class="ddepot-blueborder">
    <tr><td colspan="2" class="hdbg" align="left">Select Customer :
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
	   
 <a href="#" onClick="newWindow('popup1.php?view=edit&oid=<? echo $oid; ?>&catId=<? echo $catId; ?>&srno1=<? echo $srno2; ?>,'window')">
       
       Add New</a></td></tr>
			<tr>
    			<td width=50%>
   		  <table class="ddepot-blueborder">
                        	<tr>
                            	<td width="521" class="hdbg">Bill To</td>
           	</tr>
                                <tr><td><? if(isset($catId) && $catId != 0) { ?>
                					<?php echo $bill_st1; ?> <br>
                					<?php echo $bill_st2; ?><br>
                					<?php echo $bill_city; ?><br>
                                    <?php echo $bill_state; ?><?php echo $bill_zip; ?>
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
               				 		<?php echo $ship_st1; ?> <br>
                					<?php echo $ship_st2; ?><br>
                					<?php echo $ship_city; ?><br>
                                    <?php echo $ship_state; ?><?php echo $ship_zip; ?>
                                    <? } ?>
                				</td>
                            </tr>
                       </table>
			  </td>
	  </tr>
	</table>
<table width="729" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
<? /* <tr> 
        <td colspan="9">Enter Barcode : <input type="text" name="barcode" id="barcode" <? if(isset($barcode)) { ?> value="<? echo $barcode; ?>" <? } ?> onBlur="viewProduct2()"> <input type="button" value="Go" onClick="viewProduct2();"></td>
    </tr> */?>
<tr id="infoTableHeader"> 
        <td colspan="9" class="hdbg">Ordered Item&nbsp;</td>
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
   		<td valign="top"><input type="text" maxsizze="6" size="6" name="barcode" id="barcode" <? if(isset($barcode)) {
		if($ProdSKU != 1) { ?> value="<? echo $ProdSKU; ?>" <? }} ?> onBlur="viewProduct2('<? echo $oid; ?>',this,'<? echo $srno; ?>')" style="text-align:right"></td>
        <td valign="top"><input type="text" <? if($ProdSKU != 1) { ?> value="<?php echo $PordId; ?>" <? } ?> maxsizze="6" size="6" onBlur="enterqty7(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $barcode; ?>','<? echo $sid;?>');" name="prod1" id="prod1" style="text-align:right"></td>
        <td valign="top"><? echo $ProdName; ?> &nbsp;</td>
        <td valign="top">
		<input type="text" <? if($ProdSKU != 1) { ?> value="<? echo $qty; ?>" <? } ?> name="qtytext<? echo $srno; ?>" maxsizze="3" size="3" id="qtytext<? echo $srno; ?>"
          onblur="enterqty(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>');" style="text-align:right"/></td>
        <td align="right" valign="top"><input type="text" value="<?php echo number_format($Prodprice,2); ?>" name="ppricetext<? echo $srno; ?>" id="ppricetext<? echo $srno; ?>" maxsizze="3" size="3" onBlur="enterqty1(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>');" style="text-align:right"/>          &nbsp;</td>
      <td align="right" valign="top"><input type="text" name="netamttext<? echo $srno; ?>" id="netamttext<? echo $srno; ?>" value="<?php echo number_format(($qty * $Prodprice),2); ?>" maxsizze="3" size="3" style="text-align:right"></td>
      <td align="right" valign="top"><input type="text" name="taxtext<? echo $srno; ?>" id="taxtext<? echo $srno; ?>" value="<?php echo ($taxperc); ?>" maxsizze="3" size="3" 
      onBlur="enterqty2(this,'<? echo $srno; ?>','<? echo $catId;?>','<? echo $ProdSKU; ?>','<? echo $sid;?>');" style="text-align:right"></td>
      <td align="right" valign="top"><input type="text" name="taxamttext<? echo $srno; ?>" id="taxamttext<? echo $srno; ?>" value="<?php echo number_format(((($qty * $Prodprice*$taxperc)/100)+($qty * $Prodprice)),2) ?>" maxsizze="3" size="3" style="text-align:right"></td>
              <td><a  href="javascript:deleteCategory('<?  echo $srno; ?>','<? echo $catId;?>','<? echo $barcode; ?>','<? echo $sid; ?>');">Delete&nbsp;</td>


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
            <select name="supply" id="supply">
            <option value="Dental Supply" >Dental Supply</option>
            <option value="Office Supply">Office Supply</option>
            <option value="Equipment">Equipment</option>
            <option value="Service Charge">Service Charge</option>
            </select> Customer Service Contact : <input type="text" name="continfo" id="continfo">
    </td>
    </tr>
    
   
<? 
}
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
*/ ?> <tr><td colspan="9" align="center"><a href="index.php"> BACK </a> |
<?
if(isset($sid)){
$sql = "select invoiceno from invoice where custid='$catId' AND sessid='$sid'";
$result=mysql_query($sql);
$popat=mysql_fetch_assoc($result);
?>
<a href="javascript:save('<? echo $popat['invoiceno']; ?>')"> SAVE </a><? }/*
       <a href="index.php?view=edit&oid=178&unsetsession=unsetsession"> SAVE  </a> */ ?> | <? /*<a href="print.php?oid=<? echo $catId; ?>&sis=<? echo $sid; ?>&invoiceno=<? echo $srno; ?>&suply=" target="_blank">PRINT</a> */ ?> <a href="#" onclick="javascript:window.open('print.php?oid=<? echo $catId; ?>&sis=<? echo $sid; ?>&invoiceno=<? echo $srno; ?>&suply=' +document.frmOrder.supply.value + '&contact=' +document.frmOrder.continfo.value, '_blank');">PRINT</a>| 
    <a href="javascript:deleteCategory1('<? echo $catId;?>','<? echo $sid; ?>');">DELETE&nbsp;</a></td></tr>
</table>
</p></form></body>