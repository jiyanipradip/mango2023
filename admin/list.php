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

// for paging
// how many rows to show per page
$rowsPerPage = 10;

$sql = "SELECT o.Order_Id, o.Ship_FName, Ship_LName, Order_Date
               	    FROM orderdata o, ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and o.Order_Id = oi.Order_Id $sql2
		GROUP BY Order_Id
		ORDER BY Order_Id DESC";
		//echo $sql;
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$orderStatus = array('New', 'Paid', 'Shipped', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $stat) {
	$orderOption .= "<option value=\"$stat\"";
	if ($stat == $status) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$stat</option>\r\n";
}
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?> 
<script language="javascript">
function viewProduct1forlist(n,m,o)
{
//alert("hiiii");
//n = frmOrderList.cboCategory.selectedIndex.value;
//alert(n.value);	
var a = document.frmOrderList.appdate.value;
var  b = document.frmOrderList.appdate1.value;
//alert(a);
//alert(b);
//alert(n);
	window.location.href = 'index.php?flag=1&catId='+ n.value +'&appdate='+ a +'&appdate1='+ b;;
		
}
</script>
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processOrder.php" method="post"  name="frmOrderList" id="frmOrderList">
<center> Order </center>
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder">
 <tr align="center">
  <td align="right" class="hdbg" colspan="">View<select name="cboOrderStatus" class="box" id="cboOrderStatus" <? /* onChange="viewOrder();" */ ?>>
    <option value="" selected>All</option>
    <?php echo $orderOption; ?>
  </select></td>
  </tr>
   <tr><td colspan="6" align="center">From Date : <input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE"
   <? if(isset($appdate)) {?> value="<? echo $appdate; ?>" <? } else { ?> value="<? echo date("m-d-Y"); ?>" <? } ?> onClick="ds_sh(this,'no','','')" size="10" maxlength="10"  readonly="yes">
  
  To Date : <input name="appdate1" type="text" id="appdate1" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" size="10" maxlength="10" <? if(isset($appdate1)) {?> value="<? echo $appdate1; ?>"<? } else { ?> value="<? echo date("m-d-Y"); ?>"
   <? } ?>  readonly="yes" ><? include('calreviewreport.php');?>
                </td></tr>
</table>

 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center"> 
   <td width="60" class="hdbg">Order #</td>
   <td class="hdbg">Customer Name</td>
   <td width="60" class="hdbg">Amount</td>
   <td width="150" class="hdbg">Order Time</td>
   <td width="70" class="hdbg">Status</td>
  </tr>
  <?php
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$name = $Ship_FName . ' ' . $Ship_LName;
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
;

		$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
   <td width="60"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=detail&oid=<?php echo $Order_Id; ?>"><?php echo $Order_Id; ?></a></td>
   <td><?php echo $name ?></td>
   <td width="60" align="right">&nbsp;</td>
   <td width="150" align="center"><?php echo $Order_Date; ?></td>
   <td width="70" align="center"> NEW</td>
  </tr>
  <?php
	} // end while

?>
  <tr> 
   <td colspan="5" align="center">
   <?php 
   echo $pagingLink;
   ?></td>
  </tr>
<?php
} else {
?>
  <tr> 
   <td colspan="5" align="center">No Orders Found </td>
  </tr>
  <?php
}
?>

 </table>
 <p>&nbsp;</p>
</form>