<?php 
require_once 'head.php';
error_reporting(E_ALL ^ E_NOTICE);
require_once 'library/encrypt1.php';
require_once('functions.php');
$rowsPerPage = 10;
if (!isset($_SESSION['Customer_Id']) || $_SESSION['Customer_Id'] <= 0) {
			header('Location: login.php');
		}
$sql = "SELECT o.Order_Id, o.Ship_FName, Ship_LName, Order_Date,o.Order_Tot,o.shipping_tracking,o.email_sent,o.od_status
               	    FROM orderdata o, ordermaster oi, productmast p 
		WHERE oi.prod_id = p.PordId and o.Order_Id = oi.Order_Id AND o.Customer_Id = '".$_SESSION['Customer_Id']."'
		GROUP BY Order_Id
		ORDER BY Order_Id DESC";
		//echo $sql;
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);
$errorMessage   = (isset($_GET['error1']) && $_GET['error1'] != '') ? $_GET['error1'] : '&nbsp;';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Savanifarms</title>
    
<!-- New Design Start -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link href="cssss/style.css" rel="stylesheet" type="text/css">
<link href="cssss/responsive.css" rel="stylesheet" type="text/css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500&display=swap" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="application/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="application/javascript"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<!-- New Design End -->
    
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<script>


</script>
</head>
<body>
<div class="new-wraper">
<?php include('header.php'); ?>
    <div class="inner-banner">
      <!--<div class="inner-relative"> <span class="inner-banner-title">My Order</span> </div>-->
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div><p>&nbsp;</p>
<div id="main-wraper">
<div class="container top">
    

    

  </div>
    <?php //include('header.php'); ?>
<table class="table-responsive" width="100%" border="0" cellpadding="0" cellspacing="0" class="maintable"> 
<tr> 
  <!--<td align="left" valign="top"><?php  //include('top.php'); ?></td> -->
    <td><?php //include('header.php'); ?></td>
</tr> 
<tr> 
  <td>&nbsp;</td> 
</tr> 
<tr> 
  <td align="center" valign="top"><?php  //include('banner.php'); ?></td> 
</tr> 
<tr> 
  <td>&nbsp;</td> 
</tr> 
<tr> 
  <td align="center" valign="top"><table width="1081" border="0" cellspacing="0" cellpadding="0" class="tableclr"> 
      <tr> 
        <td align="center" valign="top"> <table width="1063" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td colspan="3" align="center" valign="top"><img src="images/spacer.gif" width="1" height="10" /></td> 
            </tr> 
            <tr> 
              <td colspan="2" align="center" valign="top"> <form action="" method="post" name="frmadd" id="frmadd"> 
                  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" class="ddepot-blueborder"> 
                    <tr> 
                      <td  height="37" colspan="2" align="center" valign="middle"><a href="myaccount.php" style="text-decoration:none;">Edit Profile</a> | <a href="addshipping.php" style="text-decoration:none;">Add Shipping</a> | <a href="myorder.php" style="text-decoration:none;">Order History</a> | <a href="changepassword.php" style="text-decoration:none;">Change Password</a></td> 
                    </tr> 
					<tr> 
                      <td  height="37" colspan="2" align="left" valign="middle" class="hdone">Order History</td> 
                    </tr> 
                    <?php 
		    if($msg!='')
		    {
		  ?> 
                    <tr> 
                      <td  height="37" colspan="2" align="center" valign="middle" class="hdbold"><?php echo $msg;?></td> 
                    </tr> 
                    <?php
		    }
		  ?> 
                    <tr class="dp-prodboxbg01"> 
                      <td width="100%" align="right" valign="middle" class="aos-br-comn-blackhd"> 
					    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="ddepot-blueborder">
  <tr align="left"> 
   <td width="60" class="hdbg">Order #</td>
   <td class="hdbg">Customer Name</td>
   <td width="60" class="hdbg">Amount</td>
   <td width="150" class="hdbg">Shipping Reference</td>
   <td width="150" class="hdbg">Order Time</td>
   <td width="70" class="hdbg">Status</td>
   <td width="60" class="hdbg">View</td>
  </tr>
  <?php 
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$name = $Ship_FName . ' ' . $Ship_LName;
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
;

		$i += 1;
?>
  <tr align="left" class="<?php  echo $class; ?>"> 
   <td width="60"><a href="orderdetails.php?oid=<?php  echo $Order_Id; ?>"><?php  echo $Order_Id; ?></a></td>
   <td><?php  echo $name ?></td>
   <td width="60"><?php  echo $Order_Tot;?></td>
   <td width="150" class="hdbg"><?php  echo $shipping_tracking;?></td>
   <td width="150"><?php  echo $Order_Date; ?></td>
   <td width="70"><?php  echo $od_status; ?></td>
   <td width="60" class="hdbg"><a href="orderdetails.php?oid=<?php  echo $Order_Id; ?>">View</a></td>
  </tr>
  <?php 
	} // end while

?>
  <tr> 
   <td colspan="7" align="center">
   <?php  
   echo $pagingLink;
   ?></td>
  </tr>
<?php 
} else {
?>
  <tr> 
   <td colspan="7" align="center">No Orders Found </td>
  </tr>
  <?php 
}
?>
 </table>
					  </td> 
                    </tr> 
                    <tr class="dp-prodboxbg01"> 
                      <td align="center" valign="middle" colspan="2">&nbsp;</td> 
                    </tr> 
                  </table> 
                </form></td> 
              <td width="335" align="center" valign="top"><table width="335" border="0" cellspacing="0" cellpadding="0"> 
                  <tr> 
                    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="5" /></td> 
                  </tr> 
                  <!--<tr> 
                    <td align="center" valign="top"><a href="trackyourorders.php"><img src="images/trackyourorder.jpg" width="335" height="84" /></a></td> 
                  </tr> 
                  <tr> 
                    <td><img src="images/spacer.gif" width="1" height="10" /></td> 
                  </tr> 
                  <tr> 
                    <td align="center" valign="top"><a href="missionmango.php"><img src="images/mango_img4.jpg" alt="Mango" width="330" height="347" border="0" /></a></td> 
                  </tr> -->
                </table></td> 
            </tr> 
          </table></td> 
      </tr> 
    </table> 
<tr> 
        <td>&nbsp;</td> 
      </tr> 
      <!--<tr> 
        <td align="left" valign="top"><?php  //include('bottom.php'); ?></td> 
      </tr> -->
      <tr> 
        <td>&nbsp;</td> 
      </tr> 
    </table>
    <?php include('footer.php'); ?>
    </div>
    </div>
    </body>
</html>
