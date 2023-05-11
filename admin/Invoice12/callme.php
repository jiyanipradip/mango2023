<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function newWindow(file,window)
 	{
	
	//alert('HH');
	WindowName="MyPopUpWindow";

settings=
"toolbar=no,location=no,directories=no,"+
"status=no,menubar=no,scrollbars=yes,"+
"resizable=no,width=400,height=400";
   
    	msgWindow=open(file,window,settings);
    	if (msgWindow.opener == null) msgWindow.opener = self;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body onload="newWindow('popup1.php?view=edit&oid=<? echo $oid; ?>&catId=<? echo $catId; ?>','window');">
</body>
</html>
