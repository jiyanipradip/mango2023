<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="javascript">
function load(file,target) {
    if (target != '')
        target.window.location.href = file;
    else
        window.location.href = file;
window.close();		
}
</script>
<?
 //echo $invno; ?>
<?
//die;

?><body onLoad="load('../index.php?view=modify&oid=178&barcode2=<? echo $barcode; ?>&catId=<? echo $catId; ?>&invno=<? echo $invno; ?>',top.opener)"  >
</body>
</html>
