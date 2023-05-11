<?php
if (!defined('SAVANI_FARM')) {
	exit;
}

// make sure a category id exists
//echo $scatid."--".$catId."<br>";
/*if (isset($_GET['catId']) && $_GET['catId'])
{
		$catId = $_GET['catId'];
}
if (isset($_GET['scatid']) && $_GET['scatid'])
{
		$scatid = $_GET['scatid'];
}

else
{
		header('Location:index.php?flag=1');
}	
	*/
$sql 	= "SELECT c.CatagoryId,s.SubCatName,s.ADD_ID,s.EDIT_ID,s.SubCatId
		   FROM subcatgmaster s,catgmaster c
		   WHERE s.CatagoryId = c.CatagoryId  AND s.SubCatId= '$scatid' and c.CatagoryId='$catId'";

$result =  mysql_query($sql) or die(mysql_error());
$data1	=  mysql_fetch_assoc($result);
$ccat 	=  $data1['CatagoryId'];
//$categoryList = buildCategoryOptions1($ccat);
$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);


?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modifysubcategory&catId=<?php echo $catId; ?>&scat=<? echo $scatid; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
 <tr><td colspan="2" class="hdbg">Edit Sub Category</td></tr>
 <tr><td width="150" class"label">CATEGORY</td><td class="content">
   
   		<select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct();">
   
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
   <td class="content"><input name="txtaddid" type="text" class="box" id="txtaddid" value="<?php echo stripslashes($data1['SubCatId']); ?>" size="30" maxlength="50"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Sub Category Name </td>
   <td class="content"> <textarea name="txtName" cols="50" rows="4" class="box" id="txtName"><?php echo stripslashes($data1['SubCatName']); ?></textarea></td>
  </tr>
   <tr><td colspan="2" align="center">
  <input name="btnModify" type="button" id="btnModify" value="Save Modification" onClick="checkCategoryForm();">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php?flag=1&catId=<? echo $catId; ?>';">
 </td></tr>
 </table>
 
</form>
