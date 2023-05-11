<?php
if (!defined('SAVANI_FARM')) {
	exit;
}
//$pricingtype=$_GET['pricingtype'];
$allowship='';
$cartContent = getCartContent();
$numItem = count($cartContent);	
?>
<table width="101%" 
<? if(!isset($showmini)) { ?> border="0" <? } else { ?> border="0"  bgcolor="#FFFFFF" bordercolor="#CCCCCC"<? } ?>cellspacing="0" cellpadding="0" id="minicart" >
 <?php
if ($numItem > 0)
{
?>

<?php
 
	$subTotal = 0;
	for ($i = 0; $i < $numItem; $i++)
	{
		extract($cartContent[$i]);
		$pd_name = "$Qty x $ProdName";
		$url = "index.php?c=$CatagoryId&p=$Prod_Id";
		$subTotal += $SellPrice * $Qty;

	} // END FOR LOOP
?>
<table cellpadding="1" cellspacing="2" border="0">
 <tr>
 	
    <td colspan="2" align="right"><b><a href="placeanorder.php?view=1&pricingtype=DOLLOR" style="color:#A9C583;"><!--Cart :--><? echo $numItem; ?><!--Items--></a>
    </b></td>
 </tr>
 <tr <? if(!isset($showmini)) { ?> style="display:none;" <? } ?>>
 	<td colspan="1"  align="left"><? echo "<img src='images/product/mangoicon.jpg' border=\"0\" height='62' width='75'>"; ?></td>
    <td colspan="1" class="dp-prod-matter" align="left">
	<font color="#A9C583">
    <b>
	<? echo $ProdName; ?><br>
    Product Id :<? echo $PordId; ?><br>
    <?
    if($PordId == '10021')
    {
	$allowship="YES";
	}
	?>
    Qty : <? echo $Qty; ?><br>
    <img src="images\<? echo $pricingtype;?>.jpg"><?php echo number_format(($Qty * $SellPrice),2); ?>
    </b>
    </font>
    </td>
    
    
 </tr>
 

 
  
    
  <tr <? if(!isset($showmini)) { ?> style="display:none;" <? } ?>>
  	<td colspan="2" align="center" class="dp-prod-matter"><b><a href="placeanorder.php?view=1&pricingtype=<? echo $pricingtype; ?>"> Checkout</a></b></td>
 </tr>  
<?php	
}

else
{
?>
<tr>
	<td colspan="2" align="center" valign="middle" class="dp-errormsgcomn"><font color="#A9C583"><b><!--Cart:--></b>0<!--items--></font></td></tr>
<?php
}
?> 
</table>