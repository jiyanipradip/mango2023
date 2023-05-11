<?php require_once 'head.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Savanifarms</title>
    
<!-- New Design Start -->
<link href="csss/style.css" type="text/css" rel="stylesheet">
<link href="csss/bootstrap.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
<!-- New Design End -->
    
<script type="text/javascript" src="AC_RunActiveContent.js"></script>
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
</head>
    
    
<body>
<div id="main-wraper">
<div class="container top">
    
  <?php include("header.php"); ?>
    
    <div class="inner-banner">
      <div class="inner-relative"> <span class="inner-banner-title">Track Orders</span> </div>
      <img src="imagess/inner-banner.jpg" alt="" style="width:100%;"> </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          
          <?php  include('trackyourordersmiddle.php'); ?>
          
      </div>
    </div>
  </div>
            
  <?php include("footer.php"); ?>
            
</div>
<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
</body>
    

<?php /* <body onload="MM_preloadImages('../images/home_btn_ovr.gif','../images/products_btn_ovr.gif','../images/recipes_btn_ovr.gif','../images/contactus_btn_ovr.gif','../images/register_btn_ovr.gif','../images/aboutus_btn_ovr.gif','../images/howtocutmango_btn_over.gif')">

<table width="1081" border="0" cellpadding="0" cellspacing="0" class="maintable">
  <tr>
    <td align="left" valign="top"><?php  include('top.php'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php  include('banner.php'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="1081" border="0" cellspacing="0" cellpadding="0" class="tableclr">
      <tr>
        <td align="center" valign="top"><?php  include('trackyourordersmiddle.php'); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><?php  include('bottom.php'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body> */ ?>
</html>
