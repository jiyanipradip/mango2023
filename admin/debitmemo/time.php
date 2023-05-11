<script language="javascript">
function setme(e)
{
alert(e);
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
var url = "ajax_for_officeedit.php?txt="; // The server-side script
var sId = txt; 
//document.getElementById("appdate").value;
//alert(sId);
//alert(url + escape(sId));
http.open("GET", url + escape(sId), true);


http.onreadystatechange = handleHttpResponse;
http.send(null);
}

function ajax_fun_addoffice()
{

	if(document.getElementById("appdate").value!=0 && document.getElementById("offname").value!=0)
	{
	
	
		var url = "ajax_for_addoffice.php?txt="; // The server-side script
		var sId = document.getElementById("appdate").value;
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
</script>
<input name="appdate" type="text" id="appdate" title="CLICK HERE TO SELECT THE DATE" onClick="ds_sh(this,'no','','')" onchange="setme();" size="10" maxlength="10" <? if($rowno['netamt'] == '') { ?> <? if(isset($k)) { ?> value="<? echo $k; ?>" <? } else { ?>value="<? echo date("Y-m-d"); ?>" <? } ?> <? } else { ?> value="<? echo $rowno['netamt']; ?>" <? } ?>
     readonly="yes" ><? include('calreviewreportedit.php');?> 
