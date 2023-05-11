<?php 
if ($_SERVER['HTTPS']!="on") {
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location:$redirect"); 
}
require_once 'head.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<title>Buy Indian Mangoes Online | Queen Kesar Mango | Gift Mango USA-Savanifarms</title>
<meta name="description" content="Indian Mangoes Online - King of Mangoes 'Queen Kesar Mangoes' are available. You can buy and gift Indian Mangoes online at savanifarms.com">
<meta name="keywords" content="Indian mangoes, Indian mango, buy Indian mango, queen kesar mango, kesar mango, gift mangoes USA, buy Indian mangoes online ,online mango">
<meta name="author" content="pradip" >
<meta name="google-site-verification" content="jE3xpLXgrOfoJdjv2Hk1aAiXFRvb3e_QDXHjWgLUrgE" />
<script type="text/javascript" src="AC_RunActiveContent.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73941693-1', 'auto');
  ga('send', 'pageview');
</script>
</head>

<body onload="MM_preloadImages('../images/home_btn_ovr.gif','../images/products_btn_ovr.gif','../images/recipes_btn_ovr.gif','../images/contactus_btn_ovr.gif','../images/register_btn_ovr.gif','../images/aboutus_btn_ovr.gif','../images/howtocutmango_btn_over.gif')">

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
        <td align="center" valign="top"><?php include('indexmiddle.php'); //include('closed_season_middle_2016.php');?></td>
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

</body>
</html>
