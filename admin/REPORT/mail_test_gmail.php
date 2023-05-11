<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
$tab = "Your Order:\n\r";
$tab .="Sr No.\n\r";
$tab .="Item.\n\r";
$tab .="Qty.\n\r";
$tab .="Unit Price.\n\r";
$tab .="Total.\n\r";

	$tab="<table width=570 border=0  align=center cellpadding=5 cellspacing=1 class=ddepot-blueborder bgcolor=#FFFFFF style=color:#FFFFFF;>
	
	<tr id=infoTableHeader> 
	<td colspan=5 class=hdbg bgcolor=6096f0><font color=#333333>Your Order&nbsp;</td>
	</tr>
	<tr align=center class=label> 
	<td bgcolor=dcf0ff><font color=#333333><b>Sr No.&nbsp;</td>
	<td bgcolor=dcf0ff><font color=#333333><b>Item&nbsp;</td>
	<td bgcolor=dcf0ff><font color=#333333><b>Qty&nbsp;</td>
	<td bgcolor=dcf0ff><font color=#333333><b>Unit Price&nbsp;</td>
	<td bgcolor=dcf0ff><font color=#333333><b>Total&nbsp;</td>
	</tr>";
	
	$k=$k."<tr class=content> 
	<td bgcolor=f0f0f0><font color=#333333>""</td>
	<td align=left bgcolor=f0f0f0><font color=#000000>"
	"<br><font class=hdshopcartfour>"
	"
	<br><br><font color=#333333>""<br><br>
	</td>
	<td bgcolor=f0f0f0><font color=#333333>""<br>BOX</td>
	<td align=right bgcolor=f0f0f0><font color=#333333>$""/Per Box</td>
	<td align=right bgcolor=f0f0f0><font color=#333333>$""</td>
	</tr>";
	"<tr class=content>
	<td height=37 colspan=5 align=center valign=middle bgcolor=f0f0f0><font color=#333333>Please call 1-855-696-2646 in USA or +91 96 62 30 30 30 in India if you need more information.</td>
	</tr>
	</table>";
	
$tablecont=$tab.$m;
$from="savanifarms@dentaoffice.com";			
$subject="SavaniFarms Orderconfirmation Mail";

$headers .="MIME-Version: 1.0\r\n";
$headers .="Content-Type: text/html; charset=iso-8859-1\r\n";
$headers .="Content-Transfer-Encoding: 8bit\r\n";
$headers .="From: $from";
mail("deepak.dentaweb@gmail.com", $subject, $tablecont, $headers);
?>
</body>
</html>
