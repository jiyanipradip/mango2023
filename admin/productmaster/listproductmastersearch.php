<?php
if (!defined('SAVANI_FARM')) {
	exit;
}


if (isset($_GET['prdsearchid']))
{
	
	$sqls = "Select * from productmast where PordId='$prdsearchid' order by PordId";	
	$results = mysql_query($sqls) or die(mysql_error());
	$num=mysql_num_rows($results);
}
elseif(isset($_GET['prdsearchname']))
{	
	$sqls = "Select * from productmast where ProdName like '%$prdsearchname%'";	
	$results = mysql_query($sqls) or die(mysql_error());
	$num=mysql_num_rows($results);	
}
else
{
	$sqls = "Select * from productmast where ProdName='samirparikh'";
	$results = mysql_query($sqls) or die(mysql_error());
	$num=mysql_num_rows($results);
}

?> 

<script language="javascript">
function getclear()
{
	document.frmListProduct.patsearch.value="";
	document.frmListProduct.patsearch.focus();	
}


function productsearch()
{
	var srch=document.frmListProduct.patsearch.value;
	var search1='searchpage';
	
	//alert(srch);
	if(srch!="")
	{
		if(document.frmListProduct.srchby[0].checked==true)
		{
			
			location.href="index.php?prdsearchid="+srch+"&view=searchpage";	
		}
		else if(document.frmListProduct.srchby[1].checked==true)
		{
			location.href="index.php?prdsearchname="+srch+"&view=searchpage";			
		}
	}
	else
	{
		alert("Please Select Product Id or Product Name !!!");
	}
}

function getchar(obj)
{

	if(document.frmListProduct.srchby[0].checked==true)
	{
		if((event.keyCode<48)||(event.keyCode>57))
		{
			if(event.keyCode!=46)
			{
				event.returnValue=false;
			}
		}

	}
	else if(document.frmListProduct.srchby[1].checked==true)
	{
		if(event.keyCode==13)
		{
			productsearch();
		}
	}	
}

</script>

<p>&nbsp;</p>
<form action="" method="post"  name="frmListProduct" id="frmListProduct">
 <center>
   Product Search
 </center>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="ddepot-blueborder">
<tr>
	<td class="hdbg" colspan="2">
    	Search By :<input name="srchby" type="radio" onclick="getclear()"/ >PRODUCT ID 
        <input name="srchby" type="radio" checked="checked" onclick="getclear()"/ >PRODUCT NAME 
        <input name="patsearch" type="text" size="30" onkeypress="getchar(this)" />
        <input type="button" value="Search" id="searchbtn" name="searchbtn" onclick="productsearch()" />
    </td>
</tr>

</table>
   
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="center" id="listTableHeader"> 
  <td class="hdbg">Product ID</td>
   <td class="hdbg">Product Name</td>
   <td class="hdbg">Product SKU(Barcode)</td>
   <td class="hdbg">Price</td>
    <td class="hdbg">Qty In Stock</td>
    <td class="hdbg">Stock Unit</td>
   <td class="hdbg" width="75">Image</td>   
   <td class="hdbg" width="70">Modify</td>
   <td class="hdbg" width="70">Delete</td>
  </tr>
  
	<?
	
		while ($data=mysql_fetch_assoc($results)) 
		{
			$pd_thumbnail = SAVANI_FARM . 'images/product/' . $data['pd_thumbnail'];
		
	?>
    	<tr>
        	<td><? echo $data['PordId']; ?>**<? echo $data['Categorymain']; ?>**<? echo $data['CatagoryId']; ?></td>
            <td><? echo $data['ProdName']; ?></td>
            <td><? echo $data['ProdSKU']; ?>&nbsp;</td>
            <td><? echo $data['PucrPrice']; ?>&nbsp;</td>
            <td><? echo $data['TotBuyQty']; ?>&nbsp;</td>
            <td><? echo $data['StockUnit']; ?>&nbsp;</td>
            <td><img src="<?php echo $pd_thumbnail; ?>"></td>
           <td><a href="javascript:modifyProduct2('<?php echo $data['PordId']; ?>','<?php echo $data['Categorymain']; ?>','<?php echo $data['CatagoryId']; ?>');">Modify</a></td>
           <td><a href="javascript:deleteProduct('<?php echo $data['PordId']; ?>','<?php echo $data['Categorymain']; ?>','<?php echo $data['CatagoryId']; ?>');">Delete</a></td>
        </tr>
    <?		
		}
	
	?>
    <?
  	if($num==0)
  	{
	?>
        <tr> 
        	<td colspan="9" align="center">No Products Yet</td>
        </tr>
 	<? } ?>
  <tr> 
   <td colspan="9">&nbsp;</td>
  </tr>
 
 </table>
 <p>&nbsp;</p>
</form>