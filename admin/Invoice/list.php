<script language="javascript">
function setValue()
{
//	alert('hh');
}
</script>
<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
if (isset($_GET['status']) && $_GET['status'] != '') {
	$status = $_GET['status'];
	$sql2   = " AND od_status = '$status'";
	$queryString = "&status=$status";
} else {
	$status = '';
	$sql2   = '';
	$queryString = '';
}	
if(isset($catId))
{
$catId = $catId;
}
else
{
	$catId = 0;
}
// for paging
// how many rows to show per page
$rowsPerPage = 10;
if((isset($catId) && ($catId != '0') && ($catId != 'undefined')) && isset($appdate) && isset($appdate1))
{
$sql = "SELECT DISTINCT(invoiceno),invdate from invoice where CustId = $catId AND SUBSTRING(invdate,1,10)
BETWEEN '$appdate' AND '$appdate1' AND Prodid != '1'
 ORDER BY srno DESC";
}
else if((isset($catId) && ($catId = '0') || ($catId = 'undefined')) && isset($appdate) && isset($appdate1))
{
	$sql = "SELECT DISTINCT(invoiceno),invdate from invoice where SUBSTRING(invdate,1,10)
BETWEEN '$appdate' AND '$appdate1' AND Prodid != '1'
 ORDER BY srno DESC";
}
else
{
	$sql = "SELECT DISTINCT(invoiceno) from invoice where invoiceno != 0 AND Prodid != '1' AND CustId != ''
		ORDER BY invoiceno DESC";
}		
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
$categoryList = buildcustomerselectionforlist();
$numCategory     = count($categoryList);
?> 

<p class="errorMessage"><?php echo $errorMessage; ?></p>
<head>
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
</script>
</head>
<body <?    
 if(isset($printpage))
 {
 $sid = session_id();
$invoiceno = $_GET['invoiceno'];
$sid = $_GET['sis'];
$catId = $_GET['catId'];

 ?>
	onload="newWindow1('print.php?oid=<? echo $catId; ?>&sis=<? echo $sid; ?>&invoiceno=<? echo $invoiceno; ?>','window');"
 <?
 } ?>>
<form action="processOrder.php" method="post"  name="frmOrderList" id="frmOrderList">
<center> Invoice List </center>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="6">Select Customer : <select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct1forlist(this);">
                <?
                    if ($numCategory > 0)
                    {
                        $i = 0;
                        ?>
                                    <option value="0">-- Select Customer --</option>
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
                </select></td><tr>
                <tr><td colspan="6" align="center">From Date : <input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE"
   <? if(isset($appdate)) {?> value="<? echo $appdate; ?>" <? } else { ?> value="<? echo date("m-d-Y"); ?>" <? } ?> onClick="ds_sh(this,'no','','')" size="10" maxlength="10"  readonly="yes">
  
  To Date : <input name="appdate1" type="text" id="appdate1" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" size="10" maxlength="10" <? if(isset($appdate1)) {?> value="<? echo $appdate1; ?>"<? } else { ?> value="<? echo date("m-d-Y"); ?>"
   <? } ?>  readonly="yes" ><? include('calreviewreport.php');?>
                </td></tr>
  <tr align="center"> 
   <td width="49" class="hdbg">Invoice No.</td>
      <td width="359" class="hdbg">Invoice Date</td>
  <td width="1661" class="hdbg">Customer Name</td>
   <td width="49" class="hdbg">Amount</td>
   <td width="45" class="hdbg">Modify</td>
   <td width="46" class="hdbg">Print</td>
  </tr>
  <?php
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	while($row = dbFetchAssoc($result)) {
	$invoiceno = $row['invoiceno'];
	$sqlnow="select * from invoice where invoiceno='$invoiceno' AND Prodid != '1'";
		$resultnow=mysql_query($sqlnow);
		$rownow=mysql_fetch_assoc($resultnow);
		$CustId = $rownow['CustId'];
		$sql1="select * from custmast where custid='$CustId'";
		$result1=mysql_query($sql1);
		$row1 = dbFetchAssoc($result1);
		//extract($row1);
		$name = $row1['name'].' : <p> '.$row1['fname']. ' ' . $row1['lname'];
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
;
				extract($row);
		$i += 1;
		?><?
   $sessid = $rownow['sessid'];
   $sqlforamount="select * from invoice where CustId = '$CustId' and invoiceno = '$invoiceno' AND invoiceno != '0'";
   $resultforamount=mysql_query($sqlforamount);
   // echo mysql_num_rows($resultforamount); 

   $subTotal = 0;
  	while($rowupdate = dbFetchAssoc($resultforamount)) {
	$qty1 = $rowupdate['qty'];
	$Prodprice1 = $rowupdate['Prodprice'];
	$taxperc1 = $rowupdate['taxperc'];
	$subTotal +=(($qty1 * $Prodprice1*$taxperc1)/100)+($qty1 * $Prodprice1);
  }
  ?>
	
  <tr class="<?php echo $class; ?>"> 
   <td width="49" align="right" valign="top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=detail&oid=<?php echo $CustId; ?>&sis=<? echo $sessid ; ?>&invoiceno=<? echo $rownow['invoiceno']; ?>"><?php echo $rownow['invoiceno']; ?></a></td>
   <td width="359" align="center" valign="top">
   <?
      if($rownow['invdate'] != '')
	{
   $k = $rownow['invdate'];
  // $f = $k[0]."-".$k[1]."-".$k[2];
  // echo "<br>".$f."<br>";
  // echo $inv;
	echo $k; 
   }
   ?>
   &nbsp;</td>
   <td valign="top"><?php echo $name ?>&nbsp;</td>
   <td width="49" align="right" valign="top"><? echo ($subTotal); ?>&nbsp;</td>
   
   <td width="45" align="center" valign="top"> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=modify&oid=178&modify=<? echo $rownow['sessid']; ?>&catId=<?php echo $rownow['CustId']; ?>&sirno=<? echo $rownow['invoiceno']; ?>&barcode=1&invno=<? echo $rownow['invoiceno']; ?>">Modify</a></td>
   <td valign="top"><a href="print.php?oid=<? echo $CustId; ?>&sis=<? echo $sessid; ?>&invoiceno=<? echo $rownow['invoiceno']; ?>" target="_blank">PRINT</a></td>
  </tr>
  <?php
	} // end while
?>
  <tr> 
   <td colspan="6" align="center" class="hdbg">
   <?php 
   echo $pagingLink;
   ?></td>
  </tr>
   <tr> 
   <td colspan="6" align="center" class="hdbg"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=edit&oid=178&generate=generate">NEW INVOICE</a>   </td>
  </tr>
<?php
} else {
?>
  <tr> 
   <td colspan="6" align="center">No Invoice Found </td>
  </tr>
  <tr> 
   <td colspan="6" align="center" class="hdbg"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=edit&oid=178&generate=generate">NEW INVOICE</a>
   <?php 
   echo $pagingLink;
   ?></td>
  </tr>
  <?php
}
?>
 </table>
 <p>&nbsp;</p>
</form>