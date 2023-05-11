<?php

if (!defined('SAVANI_FARM'))
{
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
$parentId = (isset($_GET['parentId']) && $_GET['parentId'] > 0) ? $_GET['parentId'] : 0;
?> 
<form action="processCategory.php?action=add" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <?php echo $errorMessage; ?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
<tr>
<td colspan="2" class="hdbg">Add Coupon
</td>
</tr>
 <tr> 
   <td width="150" align="right" class="label">Coupon Code</td>
   <td class="content"><input name="txtaddid" type="text" class="box" id="txtaddid" size="30" maxlength="50">
   <input type="hidden" name="txtName" id="txtName" value="<? echo $catId; ?>">
   </td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Description</td>
   <td class="content"> <textarea name="desc" cols="50" rows="4" class="box" id="desc"></textarea></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">From Date</td>
   <td class="content"><input name="fromdate" type="text" class="box" id="fromdate" size="30" maxlength="50" onClick="ds_sh(this,'no','','')">
   <? require_once('calreviewreport.php');?>
   </td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">To Date</td>
   <td class="content"><input name="todate" type="text" class="box" id="todate" size="30" maxlength="50" onClick="ds_sh(this,'no','','')">
   <? require_once('calreviewreport.php');?>
   </td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Min Qty</td>
   <td class="content"> <input name="minqty" type="text" class="box" id="minqty" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Disc %</td>
   <td class="content"><input name="discperc" type="text" class="box" id="discperc" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" align="right" class="label">Disc Amt</td>
   <td class="content"><input name="discamt" type="text" class="box" id="discamt" size="30" maxlength="50"></td>
  </tr>
  
    <input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
<tr>
   <td colspan="2" align="center">
    <input name="btnAddCategory" type="submit" id="btnAddCategory" value="Add Coupon" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=0&catId=<?php echo $parentId; ?>';">  
   </td>
</tr>
</table>
</form>