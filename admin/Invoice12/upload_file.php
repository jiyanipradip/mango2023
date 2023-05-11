<?php
require_once '../../library/config.php';
die;
$k = $srno - ($num + 5);
$k = $k +1;
//echo $num;die;
for($i = $k; $i <= $srno;$i++)
{

 	$catId = $_GET['catId'];
	//$v='barcode'.$code[$i];
	
	$selfordate="select * from invoicemaster where invoiceno = $invoiceno";
	$resultfordate=mysql_query($selfordate);
	$rowfordate=mysql_fetch_assoc($resultfordate);
	$appdate = $rowfordate['CustId'];
	if($appdate == '')
	{
		//

		$appdate = date('Y-m-d');
		//echo $appdate."hiii";die;
	}
	$sqlfinalsearch="select * from invoice where CustId = $catId AND invoiceno = $invoiceno AND srno = $i";
	$resultfinalsearch=mysql_query($sqlfinalsearch);
	if(mysql_num_rows($resultfinalsearch) ==1)
	{
	$v='qtytext'.$i;
	$v1='ppricetext'.$i;
	$qty = $_POST[$v];
	$price =  $_POST[$v1];
	$sql="UPDATE invoice SET qty = $qty,Prodprice = $price,invdate = '$appdate' where CustId = $catId AND invoiceno = $invoiceno AND srno = $i";
	//echo $sql."<br>";
	$result=mysql_query($sql);
	}
	else
	{
	}
//die;
}
$supply = $_POST['supply'];
	$continfo = $_POST['continfo'];
$sql="UPDATE invoicemaster SET invfor = '$supply',contact = '$continfo' where invoiceno = $invoiceno";
	//echo $sql."<br>";die;
	$result=mysql_query($sql);

header('Location: index.php?view=list');
			exit;
/*
	//$v='barcode'.$code[$i];

	//echo $v;
	//$_SESSION['code'] = $code[$i];
	$c='fleImage'.$code[$i];
	$images = uploadProductImage($c, SRV_ROOT . 'images/product/'.$docid.'/');
	///echo "<br>in";
	//print_r($images);
	//md5echo "<br>";
	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	$doctorid 	= $_POST[$v];
	//$Doc_Id = $_SESSION['dentadepot_user_id'];
	$sqlcheckforduplicate="select * from dtlproffessional where Doc_Id=$docid AND CODE = '$code[$i]'";
	$resultcheckforupdate=mysql_query($sqlcheckforduplicate);
	$rowcheckforupdate=mysql_fetch_assoc($resultcheckforupdate);
	if(mysql_num_rows($resultcheckforupdate) == 1)
	{
	//echo $mainImage."kk<br>"; 
		if ($mainImage != '')
		{
		$mainImage = $images['image'];
		$thumbnail = $images['thumbnail'];
		}
		else
		{
		
		$mainImage = '';
		$thumbnail = 'Upload_File';
		}
		 $ip_addr 				 = $_SERVER['REMOTE_ADDR'];
     	$edit_session			 =$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	 	$addid					 =$_SESSION['CREDENTIALS'];
		
		$sql = "UPDATE dtlproffessional SET Doc_Id = $docid,Code = $code[$i],Ans = '$doctorid',Upload_File =  '$mainImage',
		 EDIT_ID = '$addid',EDIT_SESSION = '$edit_session' where Doc_Id = $docid AND Code = '$code[$i]'";
		//echo $sql ;
		 // echo "hibacool";die;

		$result=mysql_query($sql);
	}
	else
	{
	 $ip_addr 				 = $_SERVER['REMOTE_ADDR'];
     $edit_session			 =$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	 $addid					 =$_SESSION['CREDENTIALS'];
	$sql = "Insert into dtlproffessional(Doc_Id,Code,Ans,Upload_File,ADD_ID,ADD_SESSION) values($docid,'$code[$i]','$doctorid','$mainImage','$addid','$edit_session')";
	$result=mysql_query($sql);
	//echo $sql;
	//  echo "hibacool";die;

	}
	}
	if($i == $num)
	{
		header('Location: indexdoctor.php?modify=modify&docid='.$docid);
			exit;
	}
*/