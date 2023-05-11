<?php
//session_start();
require_once '../../library/config.php';
require_once '../library/functions.php';
$txt1 = $_GET['txt'];
// Escape User Input to help prevent SQL Injection
//$txt = mysql_real_escape_string($txt);
if($txt1!="")
{
$query = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$txt1'
					ORDER BY SubCatId";
$qry_result = mysql_query($query) or die(mysql_error());
$display_string ="<select name=offname1 id=offname1 class=forselect><option value=0>--SELECT OFFICE--</option>";

       while($row = mysql_fetch_assoc($qry_result))
       {
	   			
   				$code = $row['SubCatId'];
               $display_string .=  "<option value='$code'>" . $row['SubCatName'] . "</option>";
       }
$display_string = $display_string . "</select>";
echo $display_string;
}
?>