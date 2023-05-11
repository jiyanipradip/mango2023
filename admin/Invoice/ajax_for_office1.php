<?php
//session_start();
require_once '../../library/config.php';
require_once '../library/functions.php';
$txt1 = $_GET['txt'];
// Escape User Input to help prevent SQL Injection
//$txt = mysql_real_escape_string($txt);
if($txt1!="")
{
$query = "SELECT * from productmast where PordId='$txt1'";
$qry_result = mysql_query($query) or die(mysql_error());
$display_string ="<lable>Id:</lable>";
$display_string1 ="Name:";
$display_string2 ="&nbsp;SKU:";

       while($row = mysql_fetch_assoc($qry_result))
       {
	   			
   				$code = $row['PordId'];
				$name = $row['ProdName'];
				$barcode = $row['ProdSKU'];
               $display_string .="<input type=text name='code' id='code' value='$code' size=15 maxsize=15>";
               $display_string1 .="<input type=text value='$name' size=15 maxsize=15>";
               $display_string2 .="<input type=text name='barcode' id='barcode' value='$barcode' size=15 maxsize=15>";

       }
$display_string = $display_string ;
$display_string1 = $display_string1 ;
$display_string2 = $display_string2 ;

//echo "<tr><td>".$display_string."</td></tr><tr><td>".$display_string1."</td></tr><tr><td>".$display_string2."</td></tr>";
echo "<p>".$display_string;
echo "<p>".$display_string1;
echo "<p>".$display_string2;
echo "<p><input type=submit name=addbarcode id=addbarcode value=Add Barcode>";



}
?>