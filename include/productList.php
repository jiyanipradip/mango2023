<!-- New Design Start -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="csss/style.css" type="text/css" rel="stylesheet">
<link href="csss/bootstrap.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
<!-- New Design End -->
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<?php
if (!defined('SAVANI_FARM'))
{
	exit;
}

//echo $_SESSION['Categorymain'];

unset($_SESSION['shipamt44']);

//$pricingtype=$_GET['pricingtype'];
$productsPerRow = 4;
$productsPerPage = 4;
//$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
//$ccatId  = (isset($_GET['cc']) && $_GET['cc'] != '1') ? $_GET['cc'] : 0;
//$Parentid=$_GET['c'];
//$ChildId=$_GET['cc'];

// Below 1 Line Disables INR ,  To Enable INR COMMENT BELOW 1 LIVE -->>> 
//$pricingtype="DOLLOR";
// <<----
 if($pricingtype != '0')
	   	{
		//echo $pricingtype;
		$pricingtype1=$pricingtype;
		}
		else
		{
		$pricingtype1="DOLLOR";
		}
		
if($pricingtype != '0')
{
	if($pricingtype == 'INR')
	{
		$sqlsubquery="WHERE INR != '' and Status='Active'";
	}
	else
	{
		$sqlsubquery="WHERE INR = '' and Status='Active'";
	}

}
else
{
	$sqlsubquery="WHERE INR = '' and Status='Active'";
}

//echo $sqlsubquery; die;
if(isset($manufact))
{
$sql = "SELECT * from productmast where CatagoryId = '$Parentid' AND Categorymain = '$ChildId' AND ProdOwner = '$manufact'  and Status='Active'";
}
else
{
$sql = "SELECT * from productmast $sqlsubquery";
}
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
function fir(a,s,c,b,v,d)
{
	alert(c);
}
function selectprice(doll)
{	
     trachnumitem=document.getElementById('tracknumitems').value;
     //alert(trachnumitem);
     trachnumitem1=document.getElementById('tracknumitems1').value;
     //alert(trachnumitem1);
     if(trachnumitem > 0)
     {
        alert('Please Empty your cart to switch pricing');
        window.location.href="placeanorder.php?flag=Product Catalog&pricingtype="+trachnumitem1;

     }
     else
     {
        window.location.href="placeanorder.php?flag=Product Catalog&pricingtype="+doll;
     }	
			 
}
function  testfun(CategoryMain,SubCatId,PordId,k,pricetype,ShippingCode)
{
	//alert(CategoryMain+"**"+SubCatId+"**"+PordId+"**"+k+"**"+pricetype+"**"+ShippingCode);
	//alert("TEST");
	//return false;

var tracknshipcode=document.getElementById('tracknshipcode').value;
//alert(tracknshipcode);

//return false;
var tracknumitems=document.getElementById('tracknumitems').value;
//alert(tracknumitems);
//return false;

	if((tracknumitems !="0") && (tracknshipcode != ShippingCode))
	{
		alert('Order One Item At A Time');
	}
	else
	{
			var redlenght=document.form1.pricescheme.length;
			//alert(redlenght);
			//return false;
			var radchecked = 0;
				for(i=0;i<redlenght;i++)
				{
				 if(document.form1.pricescheme[i].checked==true)
				 {
				 radchecked=1;
				 }
				 else
				 {
				 }
				}
				if(radchecked==1)
				{
				//alert("TEST");
				//return false;
				
				var tt='txtqty4'+k;
				//alert(tt);
				//return false;
				
				var txtqty4=document.getElementById(tt).value;
				
				//alert(txtqty4);
				//return false;
				//alert("cart.php?action=add"+"&cc="+CategoryMain+"&c="+SubCatId+"&p="+PordId+"&q2="+txtqty4+"&shomini=showmini&pricingtype="+pricetype);
				window.location="cart.php?action=add&cc="+CategoryMain+"&c="+SubCatId+"&p="+PordId+"&q2="+txtqty4+"&shomini=showmini&pricingtype="+pricetype;
				}
				else
				{
					alert('Please Select Pricing INR/$ !');	
					document.getElementById('pricingmethod').style.color='red';
				}


	}

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
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
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
<?
if(isset($_SESSION['MAST'])) 
{
		//echo "welcome ".$MAST;  
}
?>

<form name="form1" method="post">		

<!--<table width="98%" border="0" align="center" cellPadding="1" cellSpacing="1" style="display:none;">
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
    <? 
	/*$sqlmanufact = "SELECT DISTINCT(ProdOwner)  
	        FROM productmast where CatagoryId = '$Parentid' AND Categorymain = '$ChildId' 
			ORDER BY ProdOwner DESC";
			
    $resultmanufact = mysql_query($sqlmanufact) or die(mysql_error());
    //$cat = array();
    while ($rowmanufact = mysql_fetch_assoc($resultmanufact)) 
	{ 
	*/	
	?>
     <option value="<? //echo $rowmanufact['ProdOwner']; ?>" <? //if(isset($manufact)) { if($manufact == $rowmanufact['ProdOwner']) {?> selected <? //} }?>><? //echo $rowmanufact['ProdOwner']; ?></option>
     
     <? //}  ?>
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
</table>-->
<p align="center" class=""><?php echo $pagingLink; ?></p>
<table width="101%" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#99CC00"  bgcolor="#FFFFFF">

<tr>
    	<td colspan="4" align="left" class="hdonebig">
    	  QUEEN KESAR MANGOES</td>
   </tr>
<tr  class="dp-prodboxbg01">
    	<td width="20%" align="left" class="hdshopcartone">
    	  Item    	</td>
   	  <td width="64%" align="left"  class="hdshopcartone">
   	  Description
   	  </td>
	<? /*  <td width="50%" class="dp-prod-matter">Description</td> */ ?>
	  <td width="16%" colspan="2" align="left" valign="top">
      
     
      		<font class="hdshopcartone">Price</font><br>
            <div name="pricingmethod" id="pricingmethod">
              <table><tr><td valign="middle" align="right">
            <input type="radio" name="pricescheme" id="pricescheme" value="INR" 
             <? 
		   if($pricingtype !='0' ){
		   if($pricingtype == "INR") { ?> checked <? } }?>
            onclick="return selectprice('INR');"
            ></td><td valign="middle" align="left"><img src="images/INR.jpg"></td><td valign="middle" align="right">
            <input type="radio" name="pricescheme" id="pricescheme" value="DOLLOR"
            onclick="return selectprice('DOLLOR');"
            <? 
			if($pricingtype !='0' ){
			if($pricingtype == 'DOLLOR') { ?> checked <? } }?>
            ></td><td valign="middle" align="left"><img src="images/DOLLOR.jpg"></td>
           </tr> </table> 
            </div>
            </h3></font>      
            </td>
   </tr>
<?php 
if($pricingtype==='INR')
{
?>
<tr>
<td colspan="3" align="center" valign="top" class="hdshopcartblk">
  <table width="91%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td align="center" valign="middle"><h1>To Place order in Indian Rupees, Please call our India Office @ +91 96 62 30 30 30</h1></td>
    </tr>
    <!--<tr>
      <td align="center" valign="middle"><h1>At Present we are unable to process online payment in Indian  Currency </h1></td>
    </tr>
    <tr>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" valign="middle"><h2>To place an order please contact:</h2></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><h2>Savani Farms<br />
        Suite 203, Mauryansh Elanza,&nbsp;<br />Satellite, Ahmedabad-380 015
        132 Ft. Ring Road,Nr. Shyamal Cross Road, &ndash;<br />
        Satellite, Ahmedabad-380 015 &ndash;<br />
        Gujarat,&nbsp; India.</h2></td>
    </tr>
    <tr>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" valign="middle"><h1>Or call on</h1></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><h2>+91 96 62 30 30 30</h2></td>
    </tr>-->
  </table>
  </td>
  </tr>
 <?
 }
 else
 {
	if ($numProduct > 0 )
	{
		$i = 0;
		$k=0;
		while ($row = dbFetchAssoc($result))
		{
			extract($row);
			if ($pd_thumbnail)
			{
				//$pd_thumbnail = '/'. SAVANI_FARM . 'images/product/' . $pd_thumbnail;
                $pd_thumbnail = SAVANI_FARM . 'images/product/' . $pd_thumbnail;
			}
			else
			{
				$pd_thumbnail = SAVANI_FARM . 'images/no-image-small.png';
			}
			
			//echo $pd_thumbnail; die;
			
			if ($i % $productsPerRow == 0)
			{
				echo '<tr class="dp-prodboxbg01"">';
			}
		// format how we display the price
		$PucrPrice = $PucrPrice;
		?>
<? echo "<tr>";
		echo "<td align=\"left\"><img src=\"$pd_thumbnail\" border=\"0\" height=150 width=150>"; echo "</td>";
		?>
        <!--START COMMENT FOR IMAGE ADD TO CART -->
        
        <!--<a href=\"" . $_SERVER['PHP_SELF'] . "?p=$PordId" . "\">-->
        
        <!-- END COMMENT FOR IMAGE ADD TO CART -->
        
        <td align="left" valign="top"><? /*
        <a href=<? $_SERVER['PHP_SELF'] . "?p=$PordId"?> style="color:#009933"><? echo $ProdName; ?></a> */ ?>
      <font color="#000000"><? echo "<b>".$ProdHead."</b>"; ?></font>
       <br>
       <br>
        <font class="hdshopcartfour"><? echo $ProdName; ?></font>
       <br><br>
        
        <font color="#333333">
        <? echo $ProdDesc;  ?></font>
         <br><br />
            <font color="#333333">
            <?php if($CatagoryId=="10010") {?>
            <?php echo "Free Ground Shipping for NY, NJ, PA Resident for one address only"."<br /><br />"; ?>
            <?php } ?></font>
         <font class="hdshopcartfour">Delivery in the month of May or June Depending on your order priority</font>

         <!--<font class="hdshopcarttwo">SHIPPING:</font>
        <br>
         <font class="hdshopcartthree">
        	<? //echo $SHIPPINGTYPE;  ?>
        </font>-->        </td>
    <? /*    <td class="dp-prod-matter" align="left"><? echo $ProdDesc;  ?></td> */ ?>
		<td colspan="2" align="left" valign="top"><font color="#333333">
        <table border="0" cellpadding="1" cellspacing="1">
         
        <tr><td align="right">
       <? 
	   //echo $pricingtype; die;
	   if($pricingtype != '0')
	   	{
		$pricingtype1=$pricingtype;
		}
		else
		{
		$pricingtype1="DOLLOR";
		}
		?>
        <img src="images/<? echo $pricingtype1;?>.jpg"></td><td valign="middle" align="left">
		<font color="#333333"><strong>$<? echo number_format($SellPrice,2);  ?></strong></td></tr>
        <tr>
          <td colspan="2" align="center"><font color="#333333">Per Box</td>
          </tr>
        </table>
        
        <br>
         <input type="hidden" id="txtqty4<? echo $k;?>" name="txtqty4<? echo $k;?>" 
		 
		 
		 <? if(($PordId == 10002) || ($PordId == 10004) || ($PordId == 10005) || ($PordId == 10006)) { ?>value="<? echo $MinOrder; ?>" <? } else { ?> value="<? echo $MinOrder; ?>" <? } ?> size="3">
			<img src="images/dp-addtocart-btn.gif" onClick="testfun('<? echo $Categorymain; ?>','<? echo $CatagoryId; ?>','<? echo $PordId; ?>','<? echo $k; ?>','<? echo $pricingtype; ?>','<? echo $ShippingCode; ?>')">
            
           </td>
		
		
<?
		$k++;
		
		echo '</tr>';
		?>
<tr><td colspan="3" align="center" valign="center"><hr></td>
	</tr>        
        <?
		
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

<tr>
          	<td align="left"><!--<img src="../images/grouporder-img-1.jpg" width="93" height="114" alt="Group Order" border="0"/>--><img src="images/grouporder-img-1.jpg" width="150" height="150" alt="Group Order" border="0"/></td>
            <!--<td align="left"><font color="#000000"><b>GROUP ORDERS</b></font><br />-->
            <td align="left"><font color="#000000"><b>BULK ORDERS (50+ BOXES ONLY)</b></font><br />
<br />
<!--<font color="#333333"><b>Group orders are accepted for an order size of 100 or more boxes of mangoes.</b><br /><br />-->
        <font color="#333333"><!--<b>Bulk orders are accepted for an order size of 5 or more boxes of 9 mangoes.</b><br /><br />-->


<!--They will have to be picked up at the airport. We are currently delivering bulk orders to Chicago, Los Angeles, Dallas, Newark, New York, Boston, Miami, and Orlando. We are also able to deliver at other airports that are served by major European Airlines.<br /><br />-->

Please call <strong>Mr. KUMAR</strong> on <b>215-767-9888</b> for bulk price or email us at <a href="mailto:savani@savanifarms.com" class="nav-klas">savani@savanifarms.com</a>
<!--Please email us at <a href="mailto:savani@savanifarms.com;drsavani@gmail.com;savanifarms@dentaoffice.com" class="nav-klas">savani@savanifarms.com</a> or call us at <b>1-855-696-2646</b> or call <strong>Mr Kumar</strong> at <b>215-767-9888</b> for more information.</font>--></td>
            <td>&nbsp;</td>
           </tr>
<tr><td colspan="3" align="center" valign="center"><hr></td>
	</tr>    
<tr><td  colspan="3" align="right" valign="middle"><br><br><a href="placeanorder.php?view=1&pricingtype=<? echo $pricingtype; ?>"><b><!--<img src="images/checkout_icon.gif">--></b></a></td>
</tr>
<?
}

?>
<tr><td colspan="3" align="center"  valign="middle">
<table border="1" bordercolor="#999999"><tr><td align="left" class="hdshopcartblk">
  
Please call 1-855-696-2646 in USA or  +91 96 62 30 30 30   in India if you need more information.
</td>
</tr></table>



</td>
</tr>
</table>
<input type="hidden" value="<? echo $numItem; ?>" name="tracknumitems" id="tracknumitems">
<?
$sid = session_id();
$sql12 = "SELECT * From cartdetail ct,productmast  pd
			WHERE ct_session_id = '$sid' AND ct.Prod_Id = pd.PordId AND ct.Categorymain = pd.Categorymain AND ct.Subcategory = pd.CatagoryId";
	
	//echo $sql12;
	$result12 = dbQuery($sql12);
	$row12=mysql_fetch_assoc($result12);
	//echo $row12['ShippingCode'];
?>
<input type="hidden" value="<? echo $row12['ShippingCode']; ?>" name="tracknshipcode" id="tracknshipcode">

<input type="hidden" value="<? echo $pricingtype; ?>" name="tracknumitems1" id="tracknumitems1">
</form>