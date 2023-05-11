<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// make sure a category id exists
if (isset($_GET['catId']) && $_GET['catId'])
{
	$catId = $_GET['catId'];
}
else
{
	header('Location:index.php');
}	
	
	$sql	 = "SELECT *
				FROM couponmaster 
				WHERE Coupon_code = '$catId'";
	$result  = dbQuery($sql);
	$row 	 = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modify&catId=<?php echo $catId; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr>
   <td colspan="2" class="hdbg">Edit Coupon</td>
 </tr> 
  <tr> 
   <td width="150" align="right" class="label">Coupon Code</td>
   <td class="content"><input name="txtaddid" type="text" class="box" id="txtaddid" value="<?php echo $Coupon_code; ?>" size="30" maxlength="50">
   <input type="hidden" name="txtName" id="txtName" value="<? echo $catId; ?>">
   </td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Description</td>
   <td class="content"> <textarea name="desc" cols="50" rows="4" class="box" id="desc"><?php  echo stripslashes($Desc); ?></textarea></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">From Date</td>
   <td class="content"><input name="fromdate" type="text" class="box" id="fromdate" value="<?php echo $From_Date; ?>" size="30" maxlength="50" onClick="ds_sh(this,'no','','')">
   <? require_once('calreviewreport.php');?>
   </td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">To Date</td>
   <td class="content"><input name="todate" type="text" class="box" id="todate" value="<?php echo $To_Date; ?>" size="30" maxlength="50" onClick="ds_sh(this,'no','','')"><? require_once('calreviewreport.php');?></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Min Qty</td>
   <td class="content"> <input name="minqty" type="text" class="box" id="minqty" value="<?php echo $Min_Qty; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Disc %</td>
   <td class="content"><input name="discperc" type="text" class="box" id="discperc" value="<?php echo $Disc_perc; ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Disc Amt</td>
   <td class="content"><input name="discamt" type="text" class="box" id="discamt" value="<?php echo $Disc_Amt; ?>" size="30" maxlength="50"></td>
  </tr>
  
 
 </table>
 <p align="center"> 
  <input name="btnModify" type="submit" id="btnModify" value="Save Modification" onClick="checkCategoryForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=0';" class="box">
 </p>
</form>