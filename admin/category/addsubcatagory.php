<?php
if (!defined('SAVANI_FARM'))
{
	exit;
}

if (isset($_GET['catId']))
 {
	$catId = $_GET['catId'];
	$sql2 = " AND  p.CatagoryId = '$catId'";
	$queryString = "catId='$catId'";
 	
 }
 else
 {
	$catId = 0;
	$sql2  = 'AND  p.CatagoryId = "bacool"';
	$queryString = '';
 }


//$l = $parentId;
if(isset($parentId))
{
	$parentId =$_GET['parentId'];
	$catId = $parentId;
}
else
{
	$parentId = 0;
}
//(isset($_GET['parentId']) && $_GET['parentId']);
$sql = "SELECT p.PordId, c.CatagoryId, CatagoryName,p.ProdName,p.pd_thumbnail
        FROM productmast p, catgmaster c
		WHERE p.CatagoryId = c.CatagoryId
		ORDER BY ProdName";
$result = mysql_query($sql) or die(mysql_error());;
//$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$data1=mysql_fetch_assoc($result);

$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);


//$categoryList = buildCategoryOptions1($parentId);
$errorMessage   = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processCategory.php?action=addsubcatagory&categoryid=<? echo $parentId ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Add SUB Category</td></tr>
  <tr><td width="150" class="label">CATEGORY</td><td class="content">
  
  	<select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct();")>
   
                <?
                    if ($numCategory > 0)
                    {
                        $i = 0;
                        ?>
                            <option>-- Select Category --</option>
                        <?
                        for ($i; $i < $numCategory; $i++)
                        {
                            extract ($categoryList[$i]);
                ?>
                    <option value="<? echo $code; ?>" <?php if ($catId==$code){echo "selected";}?>><? echo $name; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
  
  </td>
  </tr>
   <tr> 
   <td width="150" class="label">Sub Category ID</td>
   <td class="content"> <input name="txtsubcatid" type="text" class="box" id="txtsubcatid" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Sub Category Name</td>
   <td class="content">  <textarea name="txtName" cols="50" rows="2" class="box" id="txtName"></textarea></td>
  </tr>
  <input name="hidParentId" type="hidden" id="hidParentId" value="<?php echo $parentId; ?>">
 <tr>
 	<td colspan="2">
 <p align="center"> 
  <input name="btnAddCategory" type="submit" id="btnAddCategory" value="Add Sub Category" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=1&catId=<?php echo $parentId; ?>';">  
 </p>
 	</td>
 </tr> 
</table>   
</form>