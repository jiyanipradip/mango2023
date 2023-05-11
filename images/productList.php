<?php
if (!defined('SAVANI_FARM'))
{
	exit;
}
$productsPerRow = 4;
$productsPerPage = 4;
//$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
//$ccatId  = (isset($_GET['cc']) && $_GET['cc'] != '1') ? $_GET['cc'] : 0;
//$Parentid=$_GET['c'];
//$ChildId=$_GET['cc'];
if(isset($manufact))
{
$sql = "SELECT * from productmast where CatagoryId = '$Parentid' AND Categorymain = '$ChildId' AND ProdOwner = '$manufact'";
}
else
{
$sql = "SELECT * from productmast";
}
//echo $sql;
$resultfirst =dbQuery($sql);
$result     = dbQuery(getPagingQuery($sql, $productsPerPage));
$data3=mysql_fetch_assoc($resultfirst);
$pagingLink = getPagingLink($sql, $productsPerPage);
$numProduct = dbNumRows($result);
// the product images are arranged in a table. to make sure
// each image gets equal space set the cell width here
$columnWidth = (int)(100 / $productsPerRow);
?>
<script language="javascript">
function manufact12(cc,c)
{
with (window.document.form1) {
		if (manufact.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?manufact=' + manufact.options[manufact.selectedIndex].value + '&c=' + c + '&cc=' + cc;
		}
	}
}
function manufact(cc,c)
{
alert('hi');
	
}
function  testfun(CategoryMain,SubCatId,PordId,k)
{
	//alert("hiiiiii");
	var tt="txtqty4["+k+"]";
	var txtqty4=document.form1(tt).value;
	window.location="cart.php?action=add"+"&cc="+CategoryMain+"&c="+SubCatId+"&p="+PordId+"&q2="+txtqty4+"&shomini=showmini";
}

function  testfun1(CategoryMain,SubCatId,PordId,k)
{
	var tt="txtqty4["+k+"]";
	var txtqty4=document.form1(tt).value;
<?
	if(isset($_SESSION['MAST']))
 		{
?>
		window.location="cart.php?action=list"+"&cc="+CategoryMain+"&c="+SubCatId+"&p="+PordId+"&q2="+txtqty4;
<?
		}
		else
		{
?>
		window.location="indexsample.php?action=add"+"&c1="+SubCatId+"&p1="+PordId+"&q1="+txtqty4;
<?
		}
?>
}
</script>
<p class="dp-copy-nav01">
<?

$sqlproductlist = "SELECT *
	     FROM productmast";
$resultsqlproductlist = mysql_query($sqlproductlist) or die(mysql_error());
$dataproductlist=mysql_fetch_assoc($resultsqlproductlist);
$categname = $dataproductlist['Categorymain'];
$suncatname = $dataproductlist['CatagoryId'];
$sql1 = "SELECT *
	     FROM subcatgmaster where CatagoryId = '$categname' AND SubCatId = '$suncatname'
		 ORDER BY CatagoryId";
$result1 = mysql_query($sql1) or die(mysql_error());
$data1=mysql_fetch_assoc($result1);
$maincat = $data1['SubCatName'];
$sql2 = "SELECT CatagoryName
	     FROM catgmaster where CatagoryId = '$categname'
		 ORDER BY CatagoryName";
$result2 = mysql_query($sql2) or die(mysql_error());
$data2=mysql_fetch_assoc($result2);
$minicat2=$data2['CatagoryName'];
?>
<p class="dp-copy-nav01">
<?
if(isset($_SESSION['MAST'])) {
		//echo "welcome ".$MAST;  
}
?>

<p><p class="dp-copy-nav01">
</p><br><br><br><form name="form1" method="post">		

<table width="98%" border="0" align="center" cellPadding="1" cellSpacing="1" style="display:none;">
	<tr class="dp-prodboxbg01">
			<td align="left" vAlign="top" class="dp-prod-matter">
			Filter By:
            </td>
			<td align="left" vAlign="top" class="dp-prod-matter">
			Manufacturer:
            </td>
			<td align="left" vAlign="top" class="dp-prod-matter">
			Promotion:
            </td>
			<td height="19" colspan="2" align="left" vAlign="top" class="dp-prod-matter">
			Sort By:
            </td>
	</tr>
	<tr align="left" valign="middle">
			<td height="28">&nbsp;&nbsp;</td>
			 <TD class="dp-prod-matter">
             <select name="manufact" class="box" id="manufact" onChange="manufact12('<? echo $cc; ?>','<? echo $c; ?>');">
   <option>Select Manufacturer</option>
    <? $sqlmanufact = "SELECT DISTINCT(ProdOwner)  
	        FROM productmast where CatagoryId = '$Parentid' AND Categorymain = '$ChildId' 
			ORDER BY ProdOwner DESC";
			
    $resultmanufact = mysql_query($sqlmanufact) or die(mysql_error());
    //$cat = array();
    while ($rowmanufact = mysql_fetch_assoc($resultmanufact)) { ?>
     <option value="<? echo $rowmanufact['ProdOwner']; ?>" <? if(isset($manufact)) { if($manufact == $rowmanufact['ProdOwner']) {?> selected <? } }?>><? echo $rowmanufact['ProdOwner']; ?></option>
     
     <? }  ?>
   </select>
           </TD>
			<TD><select class="dp-select" name="MeridianForm:MeridianContent:_ctl0:ddPromo" id="MeridianForm_MeridianContent__ctl0_ddPromo">
			<option selected="selected" value="0">--All--</option>
			<option value="A">Auto Free Goods</option>
			<option value="P">Promotion</option>
			</select>
            </TD>
			<TD class="dp-prod-matter"><select class="dp-select" name="MeridianForm:MeridianContent:_ctl0:ddSort" id="MeridianForm_MeridianContent__ctl0_ddSort">
			<option selected="selected" value="D">Product Description</option>
			<option value="I">Item #</option>
			<option value="M">Manufacturer</option>
			<option value="P">Price</option>
			</select>
            </TD>
			<td class="dp-prod-matter">
            <input type="image" name="MeridianForm:MeridianContent:_ctl0:btnSubmitSort" id="MeridianForm_MeridianContent__ctl0_btnSubmitSort" src="petimages/Submit.gif" alt="" border="0" />
            </td>
  		</tr>
							&nbsp;
</table>
<p align="center" class="dp-copy-nav01"><?php echo $pagingLink; ?></p>
<table width="93%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#99CC00">
<tr  class="dp-prodboxbg01">
    	<td width="20%" class="dp-prod-matter">Image</td>
   	  <td width="64%" class="dp-prod-matter">Product Name </td>
	<? /*  <td width="50%" class="dp-prod-matter">Description</td> */ ?>
	  <td width="16%" colspan="2" align="right" class="dp-prod-matter" bgcolor="#FFFFFF"> Price</td>
      
   </tr>
<?php 
	if ($numProduct > 0 )
	{

		$i = 0;
		$k=0;
		while ($row = dbFetchAssoc($result))
		{
			extract($row);
			if ($pd_thumbnail)
			{
				$pd_thumbnail = SAVANI_FARM . 'images/product/' . $pd_thumbnail;
			}
			else
			{
				$pd_thumbnail = SAVANI_FARM . 'images/no-image-small.png';
			}
			if ($i % $productsPerRow == 0)
			{
				echo '<tr class="dp-prodboxbg01"">';
			}
		// format how we display the price
		$PucrPrice = $PucrPrice;
		?>

		<tr  class="dp-prodboxbg01">
    	<td class="dp-prod-matter">&nbsp;</td><td class="dp-prod-matter">&nbsp;</td>
		<td class="dp-prod-matter" colspan="2" align="right">&nbsp;</td>
   </tr>
<? echo '<tr>';
		echo "<td align=\"left\"><a href=\"" . $_SERVER['PHP_SELF'] . "?p=$PordId" . "\"><img src=\"$pd_thumbnail\" border=\"0\" height=55 width=55>"; echo "</td>";
		?>
        <td class="dp-prod-matter" align="left"><a href=<? $_SERVER['PHP_SELF'] . "?p=$PordId"?>><? echo $ProdName; ?></a>
        <br>
        <? echo $ProdDesc;  ?>
        </td>
    <? /*    <td class="dp-prod-matter" align="left"><? echo $ProdDesc;  ?></td> */ ?>
		<td class="dp-prod-matter" align="right"><? echo $SellPrice;  ?><br> PER BOX
        
        <br>
         <input type="hidden" id="txtqty4[<? echo $k;?>]" name="txtqty4[<? echo $k;?>]" value="1" size="3">
			<img src="images\dp-addtocart-btn.gif" onClick="testfun('<? echo $Categorymain; ?>','<? echo $CatagoryId; ?>','<? echo $PordId; ?>','<? echo $k; ?>')">
        </td>
		
		
		
<?
		$k++;
		
		echo '</tr>';
		
		if ($TotBuyQty <= 0)
		{
		
		//echo "<td>";
		//echo "<br>Out Of Stock";
		//echo "</td>\r\n";
		}
		if ($i % $productsPerRow == $productsPerRow - 1)
		{
			
		}
		?>
		<?
		$i += 1;
	}
		if ($i % $productsPerRow > 0)
		{
			
		}
  
	}
	else
	{
?>
	<tr><td colspan="3" align="center" valign="center">No products in this category</td>
	</tr>
<?php	
}	
?>

<tr><td  colspan="3" align="right" valign="middle"><br><br><br><br><br><a href="placeanorder.php?view=1"><b> CHECKOUT</b></a></td>
</tr>
</table>

</form>