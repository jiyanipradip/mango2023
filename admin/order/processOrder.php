<?php 
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'modify' :
        modifyOrder();
        break;
	case 'updateorder' :
	    UpdateOrder();
		break;
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}



function modifyOrder()
{
	if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0
	    || !isset($_GET['status']) || $_GET['status'] == '') {
		header('Location: index.php');
	}
	
	$orderId = (int)$_GET['oid'];
	$status  = $_GET['status'];
    
    $sql = "UPDATE tbl_order
            SET od_status = '$status', od_last_update = NOW()
            WHERE od_id = $orderId";
    $result = dbQuery($sql);
	header("Location: index.php?view=list&status=$status");    
}

function UpdateOrder()
{
	if (!isset($_GET['orderId']) || (int)$_GET['orderId'] <= 0
	    || !isset($_GET['status']) || $_GET['status'] == '') {
		header('Location: index.php');
	}
	$email='No';
	$orderId = (int)$_GET['orderId'];
	$status  = $_GET['status'];
	$email  = $_GET['email'];
	$shipping  = $_GET['shipping'];
	$actual_shipping  = $_GET['actual_shipping'];
	if($email=='Yes' && $shipping!='')
	{
		$sql = "SELECT Ship_Email_Id,Ship_FName,Ship_LName FROM orderdata WHERE Order_Id = '$orderId'";
		$result = dbQuery($sql);
		extract(dbFetchAssoc($result));
		
        $to = 'pradip.dentaweb@gmail.com';
		//$to = $email;
        //$to = $Ship_Email_Id;
		$from = "admin@savanifarms.com";
		$subject = "Shipping Tracking Number";
	
		$message = '
	<html>
	  <body>
		  <p><b>Dear '.$Ship_FName.' '.$Ship_LName.'</b> <br><br>
			 Your Reference Number to track shipping is '.$shipping.'</p>
			 <br>
			 <p>To track your shipment please <a="https://www.fedex.com/fedextrack/index.html?tracknumbers='.$shipping.'&cntry_code=us">Click Here</a></p>
			 <p>If you are not able to find it then please check manually on www.fedex.com with given reference number.</p>
		  <br><br> Regards<br> Admin <br> Savani Farms
	  </body>
	</html>';

		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		mail($to, $subject, $message, $headers);
		//mail("pinkesh@dentaoffice.com", $subject, $message, $headers);
		//mail("deepak.dentaweb@gmail.com", $subject, $message, $headers);
		mail("pradip.dentaweb@gmail.com", $subject, $message, $headers);
        mail("jigneshr.dentaweb@gmail.com", $subject, $message, $headers);
    }	
	$sql = "SELECT Ship_Email_Id,Ship_FName,Ship_LName,invoiceno FROM orderdata WHERE Order_Id = '$orderId'";
		$result = dbQuery($sql);
		extract(dbFetchAssoc($result));
		
		$to = $Ship_Email_Id;
        //$to = $email;
		$from = "admin@savanifarms.com";
		$subject = "Order Status Update";
		
		$message = '
	<html>
	  <body>
		  <p><b>Dear '.$Ship_FName.' '.$Ship_LName.'</b> <br><br>
			  Your Order Number '.$invoiceno.' is '.$status.'</p>
		  <br><br> Regards<br> Admin <br> Savani Farms
	  </body>
	</html>';

		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		mail($to, $subject, $message, $headers);
		//mail("deepak.dentaweb@gmail.com", $subject, $message, $headers);
		mail("pradip.dentaweb@gmail.com", $subject, $message, $headers);
        mail("jigneshr.dentaweb@gmail.com", $subject, $message, $headers);
		//mail("pinkesh@dentaoffice.com", $subject, $message, $headers);
		mail("savanifarms@dentaoffice.com", $subject, $message, $headers);
    $sql = "UPDATE orderdata
            SET 
			    od_status = '$status', 
				email_sent = '$email',
				actual_shipping = '$actual_shipping', 
				shipping_tracking = '$shipping'				
            WHERE Order_Id = $orderId";
    $result = dbQuery($sql);
	header("Location: index.php?view=list");    
}
?>