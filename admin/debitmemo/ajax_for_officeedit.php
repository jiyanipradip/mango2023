<?php
//session_start();
require_once '../../library/config.php';
require_once '../library/functions.php';
$txt = $_GET['txt'];
// Escape User Input to help prevent SQL Injection
//$txt = mysql_real_escape_string($txt);
if($txt!="")
{
$query = "select * from invoicemaster order by invoiceno DESC";
$qry_result = mysql_query($query) or die(mysql_error());
       {
	   			$row = mysql_fetch_assoc($qry_result);
   				$code = $row['invoiceno'];
				$sql="UPDATE invoicemaster SET CustId ='$txt' where invoiceno = '$code'";
				$result=mysql_query($sql);
				$sql1="select * from invoicemaster order by invoiceno DESC";
				$result1=mysql_query($sql1);
				$row22=mysql_fetch_assoc($result1);
				
               $display_string =$row22['CustId'];
       }
$k=$row22['CustId'];;
}
?>