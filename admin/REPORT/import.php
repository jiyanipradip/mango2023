<?php
include("../../library/config.php");
error_reporting(E_ALL);
$data = array();
  
function add_person( $SRNO, $OrderNo, $TRACKINGNO, $TOTALSHIPMENTPRICE,$Weight )
{
  global $data;
  $data []= array('SRNO' => $SRNO,'OrderNo' => $OrderNo,'TRACKINGNO' => $TRACKINGNO,'TOTALSHIPMENTPRICE' => $TOTALSHIPMENTPRICE,'Weight' => $Weight);
}
  
  if ($_FILES['file']['tmp_name']!='')
  {
  $dom = DOMDocument::load( $_FILES['file']['tmp_name'] );
  $rows = $dom->getElementsByTagName( 'Row' );
  $first_row = true;
  foreach ($rows as $row)
  {
  if ( !$first_row )
  {
  $SRNO = "";
  $OrderNo = "";
  $TRACKINGNO = "";
  $TOTALSHIPMENTPRICE = "";
  $Weight = "";
  
  $index = 1;
  $cells = $row->getElementsByTagName( 'Cell' );
  foreach( $cells as $cell )
  { 
  $ind = $cell->getAttribute( 'Index' );
  if ( $ind != null ) $index = $ind;
  
  if ( $index == 1 ) $SRNO = $cell->nodeValue;
  if ( $index == 2 ) $OrderNo = $cell->nodeValue;
  if ( $index == 3 ) $TRACKINGNO = $cell->nodeValue;
  if ( $index == 4 ) $TOTALSHIPMENTPRICE = $cell->nodeValue;
  if ( $index == 5 ) $Weight = $cell->nodeValue;
  
  $index += 1;
  }
  add_person( $SRNO, $OrderNo, $TRACKINGNO, $TOTALSHIPMENTPRICE,$Weight );
  }
  $first_row = false;
  }
  }
  ?>
  <html>
<body>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
  <table width="600">
  <tr>
  <td>Names file:</td>
  <td><input type="file" name="file" /></td>
  <td><input type="submit" value="Upload" /></td>
  </tr>
  </table>
  </form>

  <table>
  <tr>
  <th>SRNO</th>
  <th>OrderNo</th>
  <th>TRACKINGNO</th>
  <th>TOTALSHIPMENTPRICE</th>
  <th>Weight</th>
  </tr>
  <?php foreach( $data as $row ) 
  { 
    $sql = "SELECT * FROM orderdata WHERE invoiceno = '".$row['OrderNo']."'";
	$result = mysql_query($sql);
	$resultset = mysql_fetch_assoc($result);
	extract($resultset);
	if($invoiceno==$row['OrderNo'])
	{
	  if($shipping_tracking!='')
	  {
	   $shipping_tracking1 = $shipping_tracking.','.$row['TRACKINGNO'];
	   $actual_shipping1 = $actual_shipping + number_format($row['TOTALSHIPMENTPRICE'],2);
	  }
	  else
	  { 
	   $shipping_tracking1 = $row['TRACKINGNO'];
	   $actual_shipping1 = number_format($row['TOTALSHIPMENTPRICE'],2);
	  } 
	  $sql = "UPDATE orderdata
            SET 
			    od_status = 'Shipped', 
				email_sent = 'Yes', 
				shipping_tracking = '".$shipping_tracking1."',
				actual_shipping = '".$actual_shipping1."'				
            WHERE Order_Id = $Order_Id";
	  echo "<br><br>".$sql;	
	  $to = $Ship_Email_Id;
		$from = "admin@savanifarms.com";
		$subject = "Shipping Tracking Number";
	
		$message = '
	<html>
	  <body>
		  <p><b>Dear '.$Ship_FName.' '.$Ship_LName.'</b> <br><br>
			 Your Reference Number to track shipping is '.$shipping_tracking1.'</p>
			 <br>
			 <p>To track your shipment please <a="https://www.fedex.com/fedextrack/index.html?tracknumbers='.$shipping_tracking1.'&cntry_code=us">Click Here</a></p>
			 <p>If you are not able to find it then please check manually on www.fedex.com with given reference number.</p>
		  <br><br> Regards<br> Admin <br> Savani Farms
	  </body>
	</html>';

		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		//mail($to, $subject, $message, $headers);
		//mail("pinkesh@dentaoffice.com", $subject, $message, $headers);	
      //$result = mysql_query($sql);
	}
  ?>
  <tr>
  <td><?php echo( $row['SRNO'] ); ?></td>
  <td><?php echo( $row['OrderNo'] ); ?></td>
  <td><?php echo( $row['TRACKINGNO'] ); ?></td>
  <td><?php echo( $row['TOTALSHIPMENTPRICE'] ); ?></td>
  <td><?php echo( $row['Weight'] ); ?></td>
  </tr>
  <?php } ?>
  </table>
  </body>
  </html>