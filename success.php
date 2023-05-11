<?php 
require_once 'library/config.php';

// if no order id defined in the session
// redirect to main page
if (!isset($_SESSION['orderId'])) {
	
	//echo "hiiiii";die;
	header('Location: ' . SAVANI_FARM);
	exit;
}
$pageTitle   = 'Checkout Completed Successfully';
require_once 'include/header.php';
//unset($_SESSION['orderId']);

unset($_SESSION['shipamtses']);	
unset($_SESSION['cbomethod1ses']);	
unset($_SESSION['radiotype1ses']);

$orderId=$_SESSION['orderId'];
$orderno=$_SESSION['orderno'];
//$orderno=$_GET['orderno'];
?>
<style>
	.product-cart {
    	width: 100%;
    	float: left;
    	border-bottom: 1px solid #ccc;
    	padding-bottom: 15px;
    	margin-bottom: 15px;
	}
	h1{color:#FFAE00; font-size:26px;}
	h5{color:#D76C0D;}
	h6{color:#000; text-transform: uppercase; font-size:14px;}
	p{color:#666;}

	.btn-primary{background: #1473e6; border:none;}
	.btn-primary:hover{background: #0d66d0;}
	.product-cart label{font-size:14px; font-weight: normal; color:#666;}
	.cart-pay {
    width: 100%;
    padding-bottom: 5px;
}
.cart-pay-amount {
    font-weight: bold;
    padding-bottom: 5px;
}
.cart-pay-amount label{font-weight: bold;}
.w50{width:40px;}
.close-icon{vertical-align: text-top;}
.w100{width:100%;}
.m15{margin-top:15px;}
h4 {
    color: #D76C0D;
}
h2{color:#FFAE00; font-size:22px;}
.w150{width:150px;}
table tr th{
	border:1px solid #5cb85c;
	padding:10px;
	background: #5cb85c;
	color:#fff;
}
table tr td{
	border:1px solid #ccc;
	/*padding:10px;*/
}
.red{color:#f00;}
.orange{color:#D76C0D;}
.btn-success{border:none;}
.border-none tr td{border:none;}
</style>


	<div class="table">
	<table width="100%">
		<tr>
			<td>Thank you for shopping with us! Delivery in the month of May or June Depending on your order Priority Your Order No Is : <?php echo $orderno; ?><br>To continue shopping please <a href="index.php">click here</a></td>
		</tr>
		<tr>
			<td style="text-align: center;"><h2>Your Order</h2></td>
		</tr>
        <?php include('inv.php'); ?>
</table>
</div>

<?php unset($_SESSION['orderId']); unset($_SESSION['orderno']); ?>
        
    

<?php /*<p>&nbsp;</p><table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" class="whitbg">
   <tr> 
      <td align="left" valign="top" class="hdbg"> <table width="100%" border="1" cellspacing="0" cellpadding="0" class="whitbg">
            <tr> 
               <td align="center" class="hdbg"> <p>&nbsp;</p>
                        <p>Thank you for shopping with us! Delivery in the month of May or June Depending on your order Priority<br>Your Order No Is : <?php echo $orderno; ?><br>To continue shopping please <a href="index.php">click 
                            here</a></p>
              <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
   <tr><td><?php include('inv.php'); ?></td></tr>
</table>
<?php unset($_SESSION['orderId']); unset($_SESSION['orderno']); ?>
<br>
<br>
 */ ?>