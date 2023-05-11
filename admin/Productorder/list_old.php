<?php 
if (!defined('SAVANI_FARM')) {
	exit;
}
if (isset($_GET['product']) && $_GET['product'] != '') 
{
$product=$_GET['product'];
}
else
{
$product="";
}

if (isset($_GET['catId']) && $_GET['catId'] != '') 
{
$catId=$_GET['catId'];
}
else
{
$catId="";
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
require_once '../../library/encrypt1.php';
// for paging
// how many rows to show per page
$rowsPerPage = 10;
if (isset($_GET['appdate']) && $_GET['appdate'] != '') 
{
	if($catId == 'INR')
	{
		$sqlorder ="AND o.Order_Type='$catId'";
	}
	else if($catId == 'USD')
	{
		$sqlorder ="AND o.Order_Type='$catId'";
	}
	else
	{
		$sqlorder="";
	}
if($product != 'ALL')
{
	$sqlprod="AND oi.prod_id='$product'";
}
else
{
	$sqlprod="";
}

if($product=="")
{
	$sqlprod="";
}
$sql = "SELECT * FROM orderdata o, ordermaster oi, productmast p, shipmethod s 
		WHERE oi.prod_id = p.PordId and o.Order_Id = oi.Order_Id AND o.Ship_Method = s.METHODID AND o.Order_Date BETWEEN '$appdate' AND '$appdate1' $sqlorder $sqlprod
		GROUP BY o.Order_Id
		ORDER BY o.Order_Id DESC";
}
else
{
$sql = "SELECT * FROM orderdata o, ordermaster oi, productmast p, shipmethod s  
		WHERE oi.prod_id = p.PordId and o.Order_Id = oi.Order_Id AND o.Ship_Method = s.METHODID $sql2
		GROUP BY o.Order_Id
		ORDER BY o.Order_Id DESC";
}	
	$result     = dbQuery($sql);

//$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
//$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$pagingLink='';
$orderStatus = array('New', 'Paid', 'Shipped', 'Decline', 'Completed', 'Cancelled');
$orderOption = '';
foreach ($orderStatus as $stat) {
	$orderOption .= "<option value=\"$stat\"";
	if ($stat == $status) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$stat</option>\r\n";
}

$orderStatus1 = array('USD', 'INR');
$orderType = '';
foreach ($orderStatus1 as $stat) {
	$orderType .= "<option value=\"$stat\"";
	if ($stat == $status) {
		$orderType .= " selected";
	}
	
	$orderType .= ">$stat</option>\r\n";
}



$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?> 
<script language="javascript">

</script>
<p class="errorMessage"><?php  echo $errorMessage; ?></p>
<form action="processOrder.php" method="post"  name="frmOrderList" id="frmOrderList">
<center> Order </center>
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder">
 <tr align="center">
  <td align="right" class="hdbg" colspan="">SELECT ORDER TYPE<select name="cboOrderType" class="box" id="cboOrderType"   onChange="viewProduct1forlist();" >
    <option value="ALL" <?php if($catId=='ALL') { ?> selected<?php } ?>>All</option>
		<option value="USD" <?php if($catId=='USD') { ?> selected<?php } ?>>USD</option>
        <option value="INR" <?php if($catId=='INR') { ?> selected<?php } ?>>INR</option>
  </select></td>
  </tr>
 
 
 
   <tr><td colspan="6" align="center">From Date : <input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE"
   <?php if(isset($appdate)) {?> value="<?php echo $appdate; ?>" <?php } else { ?> value="<?php echo date("m-d-Y"); ?>" <?php } ?> onClick="ds_sh(this,'no','','')" size="10" maxlength="10"  readonly="yes">
  
  To Date : <input name="appdate1" type="text" id="appdate1" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" size="10" maxlength="10" <?php if(isset($appdate1)) {?> value="<?php echo $appdate1; ?>"<?php } else { ?> value="<?php echo date("m-d-Y"); ?>"
   <?php } ?>  readonly="yes" ><?php include('calreviewreport.php');?>
                </td></tr>
                <tr align="center">
  <td align="right" class="hdbg" colspan="">Order Status<select name="cboOrderStatus" class="box" id="cboOrderStatus" <?php /* onChange="viewOrder();" */ ?>>
    <option value="" selected>All</option>
    <?php  echo $orderOption; ?>
  </select></td>
  </tr>
  <tr align="center">
  <td align="right" class="hdbg" colspan="">Select Product<select name="product" class="box" id="product" onChange="viewProduct1forlist();">
  <option value="ALL" <?php if($product == 'ALL') { ?> selected <?php } ?>>ALL</option>
    <?php if($catId == 'INR')
	{
		$sqlorder1 ="where INR != ''";
	}
	else if($catId == 'USD')
	{
		$sqlorder1 ="where INR = ''";
	}
	else
	{
		$sqlorder1="";
	}
	
	$sqlproduct="select * from productmast $sqlorder1";
	$resultproduct=mysql_query($sqlproduct);
	while($rowproduct=mysql_fetch_assoc($resultproduct))
	{
	?>
	<option value="<?php echo $rowproduct['PordId'];?>" <?php if($product == $rowproduct['PordId']) { ?> selected <?php } ?>>
	<?php echo $rowproduct['PordId']."-".$rowproduct['ProdHead']."-".$rowproduct['ProdName']; ?>
    </option>    
    <?php }
	 ?>
    
     </select></td>
  </tr>
  
  
  
  
</table>

 <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center"> 
   <td class="hdbg">OrderTotal</td>
      <td width="100" class="hdbg">Billing & Shipping Info</td>
   <td class="hdbg"> Payment Details</td>
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
  <tr class="<?php  echo $class; ?>"> 
   <td>
   <?php 
	   $dateformat=explode('-',$Order_Date);
				  $yr=$dateformat[0];
				  $mn=$dateformat[1];
				  $dy=$dateformat[2];
				  if($mn == '01')
				  {
				  $mn='January';
				  }
				  if($mn == '02')
				  {
				  $mn='February';
				  }
				  if($mn == '03')
				  {
				  $mn='March';
				  }
				  if($mn == '04')
				  {
				  $mn='April';
				  }
				  if($mn == '05')
				  {
				  $mn='May';
				  }
				  if($mn == '06')
				  {
				  $mn='June';
				  }
				  if($mn == '07')
				  {
				  $mn='July';
				  }
				  if($mn == '08')
				  {
				  $mn='August';
				  }
				  
				  if($mn == '09')
				  {
				  $mn='September';
				  }
				  if($mn == '10')
				  {
				  $mn='October';
				  }
				  if($mn == '11')
				  {
				  	$mn='November';
				  }
				  if($mn == '12')
				  {
				  $mn='December';
				  }
				  //echo $mn." ".$dy.",".$yr; ?>
   
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%" align="right" >Order No :</td>
    <td width="70%" align="left"><a href="<?php  echo $_SERVER['PHP_SELF']; ?>?view=detail&oid=<?php  echo $Order_Id; ?>"><?php  echo $orderno; ?></a></td>
  </tr>
  <tr>
    <td align="right">Date :</td>
    <td align="left"><font color="#000000"><?php echo $mn." ".$dy.",".$yr; ?></font></td>
  </tr>
  <tr>
    <td align="right">Customer Name :</td>
    <td align="left"><font color="#000000"><?php echo $name ?></font></td>
  </tr>
</table>

  
  
   <table width="410" border="0"  align="center" cellpadding="5" cellspacing="1">
     
     <tr align="center" class="label"> 
       <td width="236"><strong>Prod Name&nbsp;</strong></td>
          <td width="43"><strong>Qty</strong>&nbsp;</td>
          <td width="36"><strong>Rate</strong>&nbsp;</td>
          <td width="50"><strong>Total</strong>&nbsp;</td>
     </tr>
  <?php 
if($product != 'ALL')
{
	$sqlprod="AND p.PordId='$product'";
}
else
{
	$sqlprod="";
}
if($product=="")
{
	$sqlprod="";;
}
$sql1 = "SELECT *
	    FROM ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and oi.order_id = '$Order_Id' $sqlprod
		ORDER BY oi.order_id ASC";

$result1 = dbQuery($sql1);
$orderedItem1 = array();
while ($row1 = dbFetchAssoc($result1)) {
	$orderedItem1[] = $row1;
}
$numItem1  = count($orderedItem1);
$subTotal = 0;
 
for ($y = 0; $y < $numItem1; $y++)
{
	extract($orderedItem1[$y]);
	$subTotal += $Order_rate * $orderd_qty;
	?>
     <tr class="content"> 
       <td><?php  echo "$ProdName"; ?>&nbsp;</td>
          <td align="right"><?php  echo ($orderd_qty); ?><br>BOX&nbsp;</td>
          <td align="right">$<?php  echo number_format(($Order_rate),2); ?>&nbsp;</td>
          <td align="right">$<?php  echo number_format(($orderd_qty * $Order_rate),2); ?>&nbsp;</td>
      </tr>
  	<?php 
}
?>
     <tr class="content"> 
       <td colspan="3" align="right"><strong>Sub-total</strong>&nbsp;</td>
          <td align="right">$<?php  echo number_format(($Prod_Tot),2); ?>&nbsp;</td>
      </tr>
     <tr class="content"> 
	 <!--
       <td colspan="3" align="right"><strong>Shipping</strong>&nbsp;</td>
	 -->
       <td colspan="3" align="right"> <?php  echo 'Shipp:'.$METHOD; ?> &nbsp;</td>
          <td align="right">$<?php  echo number_format(($Ship_Tot),2); ?>&nbsp;</td>
      </tr>
     <tr class="content"> 
       <td colspan="3" align="right"><strong>Total</strong>&nbsp;</td>
          <td align="right">$<?php  echo number_format(($Order_Tot),2); ?>&nbsp;</td>
      </tr>
   </table></td>
      <td align="center" valign="top"><table cellpadding="3" cellspacing="1" width="100%">
     <tr><td align="left">
		  <b>Billing  :</b></td><td  align="left"><b>Shipping: <?php  echo $Ship_Desti; ?> </b></td> <tr>
          <tr><td align="left" valign="top">
           <?php  echo $FName." ".$LName; ?><br>
          
         <?php  echo $Adr1; ?> <br><?php  echo $Adr2; ?><br>
          <?php  echo $City." ".$State."-".$ZIP; ?><br>
          <?php  echo $Country; ?>
          
		 
          </td>
          <td align="left" valign="top">
		  
          
           <?php  echo $Ship_FName." ".$Ship_LName; ?><br>
            <?php  echo $Ship_Adr1; ?> <br><?php  echo $Ship_Adr2; ?><br>
          <?php  echo $Ship_City."  ".$Ship_State."-".$Ship_ZIP; ?><br>
          <?php  echo $Ship_Country; ?>          </td>
          </tr></table></td>
          <td valign="top">
<?php $sqlx = "SELECT Pay_Method, Card_No, Card_Name, Card_Exp, 
         Card_CVV, Cart_Id
	   	 FROM paydetail
		 WHERE Order_Id = '$Order_Id'";

$resultx = dbQuery($sqlx);
extract(dbFetchAssoc($resultx));
?>
          <table width="303" border="0"  align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr> 
        <td width="114" class="label"> Method&nbsp;</td>
      <td width="157" class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Pay_Method)); ?> &nbsp;</td>
  </tr>
    <tr> 
        <td width="114" class="label">Card No. &nbsp;</td>
      <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_No)); ?>
       &nbsp;</td>
    </tr>
    <tr> 
        <td width="114" class="label"> Name &nbsp;</td>
      <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_Name)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="114" class="label"> Expire Date &nbsp;</td>
      <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_Exp)); ?> &nbsp;</td>
    </tr>
    <tr> 
        <td width="114" class="label"> CCV No. &nbsp;</td>
      <td class="content"><?php  echo stripslashes(ENCRYPT_DECRYPT($Card_CVV)); ?> &nbsp;</td>
    </tr>
</table>        </td>
  </tr>
  <?php 
	} // end while

?>
  <tr> 
   <td colspan="3" align="center">
   <?php  
   echo $pagingLink;
   ?></td>
  </tr>
<?php 
} else {
?>
  <tr> 
   <td colspan="3" align="center">No Orders Found </td>
  </tr>
  <?php 
}
?>
 </table>
 <p>&nbsp;</p>
</form>