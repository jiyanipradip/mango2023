<?
require_once '../../../library/config.php';
require_once '../../library/functions.php';
if(isset($invno))
{
$invno = $invno;
}
if(isset($addbarcode))
{
if($_POST['addbarcode'])
{
	$barcode=$_POST['barcode'];
	$code=$_POST['code'];
	$sql="UPDATE productmast SET ProdSKU = '$barcode' where PordId = '$code'";
	//echo $sql;
	$result=mysql_query($sql);
	//echo "Barcode Successfully Added";
	?> <script>
    ('<? echo $barcode; ?>','<? echo $catId; ?>','<? echo $srno1; ?>');
	function getback(barcode,catId,invno)
	{
	if(barcode == '')
	{
	 alert('Please Add Barocde');
	}
	else
	{

	window.location.href='refresh_carecredit1.php?catId=' + catId + '&barcode=' + barcode + '&invno=' + invno;
	}	
	}
	
	</script>
<?
}
}
if(isset($submit))
{
if($_POST['submit'])
{
$k='a';
}
}  
if(isset($submit2))
 {
if($_POST['submit2'])
{
	$k = 'b';

//die;
}
//include("refresh_carecredit1.php");
}
if(isset($btnAddProduct))
{
	if($_POST['btnAddProduct'])
	{
		  
	$ParentId      		    = addslashes($_POST['grname']);
	$catId      		    = addslashes($_POST['offname1']);
    $prid                   = addslashes($_POST['txtid']);
	$name                   = addslashes($_POST['txtName']);
	$price                  = str_replace(',', '', (double)$_POST['txtPrice']);addslashes($_POST['txtPrice']);
	$qty                    = (int)$_POST['txtQty'];
	$sku                    = addslashes($_POST['txtprodsku']);
   	$stock        			= addslashes($_POST['txtstockunit']);
     $ip_addr 				 = $_SERVER['REMOTE_ADDR'];
     $edit_session			 =$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	 $addid					 =$_SESSION['udepot'];
	 //$images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/');

//	$mainImage = $images['image'];
	//$thumbnail = $images['thumbnail'];
	
				 			 $sql9 = "SELECT PordId
	        						  FROM productmast
									  WHERE PordId = '$prid' AND CatagoryId ='$catId'";
									 // echo $sql9;die;
							 $result9 = dbQuery($sql9);
							 
	if($prid == '')
	{
			 header('Location: index.php?view=add&catId='.$ParentId.'&ccatId='.$catId.'&error=' . urlencode('Please Enter Valid Product ID'));
			 	exit;
	
	}
	if (dbNumRows($result9) == 1)
	{	
			//echo "hello";
							 header('Location: index.php?view=add&catId='.$ParentId.'&ccatId='.$catId.'&error=' . urlencode('Product ID already taken For This Sub Category. Choose another one'));	
	}								
	else
	{
			$sqlproduct =  "INSERT INTO productmast 
						(PordId,CatagoryId, ProdName,PucrPrice,TotBuyQty,
						ProdSKU,StockUnit,ADD_ID,EDIT_ID,ADD_SESSION,EDIT_SESSION,Categorymain)
				VALUES ('$prid','$catId','$name',$price,$qty,
						'$sku','$stock','$addid','','$edit_session','','$ParentId'
						)";

			//echo $sqlproduct;
			$result = dbQuery($sqlproduct);
	 //		header('Location: index.php?catId='.$catId.'&ccatId='.$ParentId);
	echo "Product Successfully Added";
	}							
//header("Location: index.php?catId='$catId'");	


	}

}
?><head>
<link href="<?php echo SAVANI_FARM;?>admin/include/admin.css" rel="stylesheet" type="text/css">

</head><body background="../../images/DentaDepot-LOGO-Globerotating-right2left-feb.fla">
<form name="form1" id="form1" method="post">
<table border="1" class="ddepot-blueborder">
<tr>
	<td colspan="2" align="center">SEARCH PRODUCT
    </td></tr>
        <td align="right">Search Product</td><td align="left"><input type="text" name="txtid" id="txtid"></td>
     </tr>
     <tr>
     <td colspan="2" align="center"><input type="submit" value="Search" name="submit"></td>
    </tr>
</tr>
</table>
</form>
<?
if(isset($k) && ($k=='a'))
{
$name= $_POST['txtid'];
$sql11="SELECT * from productmast where ProdName LIKE '%$name%'";
//echo $sql11;
$result = mysql_query($sql11);
//$data=mysql_fetch_assoc($result);
if (dbNumRows($result) > 0) {
	$i = 0;
	?>
    <script language="javascript">
	function getback(barcode,catId,invno)
	{
	if(barcode == '')
	{
	 alert('Please Add Barocde');
	}
	else
	{
	window.location.href='refresh_carecredit1.php?catId=' + catId + '&barcode=' + barcode + '&invno=' + invno;
	}	
	}
function handleHttpResponse() {
if (http.readyState == 4) {
if(http.status==200) {
var results=http.responseText;
//alert(results);
document.getElementById('offname').innerHTML = results;
//alert(results);
}
}
}
function ajax_fun(txt) {
//alert("hellooo");
var url = "ajax_for_office1.php?txt="; // The server-side script
var sId = txt; 
//document.getElementById("grname").value;
//alert(sId);
//alert(url + escape(sId));
http.open("GET", url + escape(sId), true);


http.onreadystatechange = handleHttpResponse;
http.send(null);
}

function ajax_fun_addoffice()
{

	if(document.getElementById("grname").value!=0 && document.getElementById("offname").value!=0)
	{
	
	
		var url = "ajax_for_addoffice.php?txt="; // The server-side script
		var sId = document.getElementById("grname").value;
		var offname = document.getElementById("offname").value;
		
		http.open("GET", url + escape(sId)+"&offname="+escape(offname), true);
			
		http.onreadystatechange = handleHttpResponse_off;
		http.send(null);
	}
	else
	{
		alert("Please select information properly");
	}	
}

function getHTTPObject() {
var xmlhttp;

if(window.XMLHttpRequest){
xmlhttp = new XMLHttpRequest();
}
else if (window.ActiveXObject){
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
if (!xmlhttp){
xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}

}
return xmlhttp;
}

var http = getHTTPObject(); // We create the HTTP Object
</script>
 <form name="addbarcode" method="post">
    <table border="1" class="ddepot-blueborder"><tr><td width="252" align="right">   

     <div id="offname">
     </div>
     
     </td></tr>
     </table>
     </form>
    <form name="form2" id="form2" method="post">
<table border="1" class="ddepot-blueborder">   
<tr>
            		<td>Category</td><td>Sub Category</td><td>Product Name </td><td>Product Id</td><td>Barcode</td><td>Modify</td>
</tr> 
    <?
	while($row = dbFetchAssoc($result)) {
		extract($row);
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
		?>
			<tr>
            	<td><? echo $Categorymain; ?> &nbsp;</td><td><? echo $CatagoryId; ?> &nbsp;</td><td>
				<a href="javascript:getback('<? echo $ProdSKU; ?>','<? echo $catId; ?>','<? echo $invno; ?>');"><? echo $invno; ?><? echo $ProdName; ?></a> &nbsp;</td><td><? echo $PordId; ?> &nbsp;</td><td><? echo $ProdSKU; ?> &nbsp;</td><td><input type="hidden" name="grname" id="grname" value="<? echo $PordId; ?>">
                <a href="javascript:ajax_fun('<? echo $PordId; ?>');">
                modify</a></td>
            </tr>
                    
	<?
	}
	}
	?>
	<tr><td colspan="6" align="center"><input type="hidden" name="h1n1"><input type="submit" name="submit2" value="Add Product"></tr></table></form>
   
	<?
	//die;
}
?>

<?
if(isset($k) && ($k=='b'))
{
$catId = (isset($_GET['catId']) && $_GET['catId'] > 0) ? $_GET['catId'] : 0;


//categoryList2 is define for list of subCategory when change category
//$categoryList2 = buildCategoryOptionsmy($ccatId,$catId);
//$numCategory2     = count($categoryList2);
$ccatId = (isset($_GET['ccatId']) && $_GET['ccatId'] > 0) ? $_GET['ccatId'] : 0;
$categoryList = buildCategoryOptions1($catId);
$numCategory     = count($categoryList);
?>
<script language="javascript">
function handleHttpResponse() {
if (http.readyState == 4) {
if(http.status==200) {
var results=http.responseText;
//alert(results);
document.getElementById('offname').innerHTML = results;
//alert(results);
}
}
}
function ajax_fun() {
//alert("hellooo");
var url = "ajax_for_office.php?txt="; // The server-side script
var sId = document.getElementById("grname").value;
//alert(sId);
//alert(url + escape(sId));
http.open("GET", url + escape(sId), true);


http.onreadystatechange = handleHttpResponse;
http.send(null);
}

function ajax_fun_addoffice()
{

	if(document.getElementById("grname").value!=0 && document.getElementById("offname").value!=0)
	{
	
	
		var url = "ajax_for_addoffice.php?txt="; // The server-side script
		var sId = document.getElementById("grname").value;
		var offname = document.getElementById("offname").value;
		
		http.open("GET", url + escape(sId)+"&offname="+escape(offname), true);
			
		http.onreadystatechange = handleHttpResponse_off;
		http.send(null);
	}
	else
	{
		alert("Please select information properly");
	}	
}

function getHTTPObject() {
var xmlhttp;

if(window.XMLHttpRequest){
xmlhttp = new XMLHttpRequest();
}
else if (window.ActiveXObject){
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
if (!xmlhttp){
xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}

}
return xmlhttp;
}

var http = getHTTPObject(); // We create the HTTP Object
</script>
<form method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">

<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ddepot-blueborder">
    <tr>
      <td colspan="2" class="hdbg">Add Product Master</td>
    </tr>
    <tr><td colspan="1" align="left"> Category </td><td>
    <select name="grname" id="grname" onChange="ajax_fun()">
   
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
                    <option value="<? echo $code; ?>" <?php if ($ccatId==$code){echo "selected";}?>><? echo $name.$code; ?></option>
                <? 
                        }
                    $i++;
                    }
                ?>
                </select>
    
    
   </td></tr>
  <tr> 
   <td width="150" class="label">Sub Category</td>
   <td class="content" id="content"> 
    
                <div id="offname"></div>
                
    
    &nbsp;</td>
	
	<tr> 
   <td width="150" class="label">Product ID</td>
   <td class="content"> <input name="txtid" type="text" class="box" id="txtid" size="50" maxlength="100"></td>
  </tr>
 
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="50" maxlength="100"></td>
  </tr>
 <tr> 
   <td width="150" class="label">Product SKU</td>
   <td class="content"> <input name="txtprodsku" type="text" id="txtprodsku" class="box"> 
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" id="txtPrice" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity In Stock</td>
   <td class="content"><input name="txtQty" type="text" id="txtQty" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Stock Unit</td>
   <td class="content"> <input name="txtstockunit" type="text" id="txtstockunit" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);">
    </td>
  </tr>
 
  
  <?
 // 29 may bacool updated
 ?>
 
  
  
  
    
  <tr><td colspan="2" align="center">
  <input name="btnAddProduct" type="submit" id="btnAddProduct" value="Add Product" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="javascript:history.go(-1)" class="box">  
</td></tr>
 </table>
 </form>
<? } 
?>

  