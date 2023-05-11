<style>
.toporder
{
    padding:14px;
    border: 1px solid #fee119;
    border-radius: 5px;
    color: #008000 !important;
    background: #fee119;
    font-size: 16px;
    font-weight: bold;
}
.dropbtn
{
    padding: 6px 0px 0px 0px;
    line-height: 65px;
    color: #026243;
    text-decoration: none;
}
.nav-dropdown {
  display: none;
  position: absolute;
  background-color: #fee119;
  min-width: 100%;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  
}
.nav-dropdown a {
  color: #026243;
  padding: 22px 9px;
  text-decoration: none;
  display: block;
}
.nav-dropdown a:hover {background-color: #fff119;}
.dropbtn:hover .nav-dropdown {display: block;}
</style>
<?php /*<div style="text-align:center; color:red;"><h5><strong>Dear Mango Lovers<br/>
Due to COVID-19 we are uncertain about Indian Mango Import for 2021. We ask you to register your email and your order. We do not charge your credit card until we ship the product. Will keep you posted on mango import for this season.</strong></h5></div> */ ?>
<?php $cururl = $_SERVER['REQUEST_URI']; ?>
<h4><strong><marquee onmouseover="this.stop();" onmouseout="this.start();">Kesar Mango Season 2022 is now closed!</marquee></strong></h4> 
<?php /*<div style="text-align:right;padding-bottom:3px;">
<a href="https://www.facebook.com/savanifarms" target="_blank" ><img src="imagess/facebook.jpg" width="20px" height="20px"></a>
    <a href="https://www.instagram.com/savanifarms/" target="_blank"><img src="imagess/instagram.jpg" width="20px" height="20px"></a>
    <a href="https://www.linkedin.com/in/savani-farms/" target="_blank"><img src="imagess/linkedin.png" width="20px" height="20px"></a>
    <a href="https://www.youtube.com/channel/UC2iyA-yLxqVbaU8mK-7AdQg" target="_blank" ><img src="imagess/youtube.jpg" width="20px" height="20px"></a></div> */?>

<div id="new-header">
  <div class="container-fluid">
    <div class="new-header-left"> Call Us<br>
      <span><a href="tel:+18556962646">1-855-696-2646</a></span> </div>
    <a href="index.php"><img src="imagesss/header-logo.png" alt="Savani Farm" title="Savani Farm" class="new-header-logo"></a>
    <div class="new-header-right">
      <div class="new-header-links"> 
          <?php if(@$_SESSION['Customer_Id']=='') { ?>
          <a href="login.php">Login</a>
          <?php } else { ?>
          <a href="login.php?logout=true">Logout</a>
          <?php } ?> 
          <?php if(@$_SESSION['Customer_Id']=='') { ?>
          <a href="register.php">Register</a>
          <?php } else { ?>
          <a href="myaccount.php">My Account</a>
          <?php } ?>
          <a href="spongy-tissue-disclaimer-alphonso-mango.php#refundpolicy">Refund Policy</a>
        </div>
        
<?php if($cururl == "/index.php" || $cururl == "/"){ $class1='active';}else{ $class1=''; } ?>
<?php if($cururl == "/aboutus.php"){ $class2='active';}else{ $class2=''; } ?>
<?php if($cururl == "/products.php"){ $class3='active';}else{ $class3=''; } ?>
<?php if($cururl == "/howtocutmango.php"){ $class4='active';}else{ $class4=''; } ?>
<?php if($cururl == "/missionmango.php"){ $class5='active';}else{ $class5=''; } ?>
<?php if($cururl == "/mangoripeningandstoring.php"){ $class6='active';}else{ $class6=''; } ?>
<?php if($cururl == "/recipe.php"){ $class7='active';}else{ $class7=''; } ?>
<?php if($cururl == "/jumbo-kesar-mango-south-florida.php"){ $class8='active';}else{ $class8=''; } ?>
<?php if($cururl == "/contactus.php"){ $class9='active';}else{ $class9=''; } ?>
<?php if($cururl == "/spongy-tissue-disclaimer-alphonso-mango.php"){ $class11='active';}else{ $class11=''; } ?>


        
      <div class="new-like"> 
          <a href="placeanorder.php?flag=Product%20Catalog&pricingtype=DOLLOR" class="toporder">Order Today<!--<img src="imagesss/like.png" alt="Like" title="Like"><span>0</span>--></a> 
          <a class="bag"><img src="imagesss/bag.png" alt="Like" title="Like"><span><?php include('include/miniCart.php'); ?></span>
        <!--<div class="price">$0.00</div>-->
        </a> </div>
    </div>
  </div>
</div>
<div id="new-menu">
  <div class="container-fluid">
    <div class="navigation">
      <div class="nav-container">
        <nav>
          <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
          <ul class="nav-list">
            <li> <a href="index.php" class="<?php echo $class1; ?>">Home</a> </li>
            <li> <a href="aboutus.php" class="<?php echo $class2; ?>">About Us</a> </li>
            <li> <a href="products.php" class="<?php echo $class3; ?>">Products</a> 
              <!--<ul class="nav-dropdown">
                  <li> <a href="#">Link 1</a> </li>
                  <li> <a href="#">Link 2</a> </li>
                  <li> <a href="#">Link 3</a> </li>
                </ul>--> 
            </li>
            <li> <a href="howtocutmango.php" class="<?php echo $class4; ?>">How to cut a Mango</a> </li>
            <li> <a href="missionmango.php" class="<?php echo $class5; ?>">Mission Mango</a></li>
              <li class="dropbtn"> <a href="#">Ripening & Storing </a>
              <ul class="nav-dropdown">
                  <li><a href="mangoripeningandstoring.php" class="<?php echo $class6; ?>">Ripening & Storing</a></li>
                  <li> <a href="spongy-tissue-disclaimer-alphonso-mango.php" class="<?php echo $class11; ?>">Alphonso Disclaimer </a> </li>
                </ul>
            </li>
            <li> <a href="recipe.php" class="<?php echo $class7; ?>">Recipes</a> </li>
            <li> <a href="jumbo-kesar-mango-south-florida.php" class="<?php echo $class8; ?>">Mango Articles</a> </li>
            <li> <a href="contactus.php" class="<?php echo $class9; ?>">Contact Us</a> </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<?php /*<div class="header" id="myHeader">
    <div class="header-top">
        
    <div class="pull-left"> <a href="tel:1-855-696-2646" class="call"><img src="imagess/call.png" alt="Call" Tel="Call"><strong>1-855-696-2646</strong></a> <a href="mailto:savani@savanifarms.com" class="email"><img src="imagess/email.png" alt="Email" title="Email"><strong>savani@savanifarms.com</strong></a> </div>
        
      <div class="pull-right"> 
          <?php if(@$_SESSION['Customer_Id']=='') { ?>
          <a href="login.php" class="register"><img src="imagess/register.png" alt="Login" title="Login">Login</a>
          <?php } else { ?>
          <a href="login.php?logout=true" class="register"><img src="imagess/register.png" alt="Log Out" title="Log Out">Log Out</a>
          <?php } ?>
          
          <?php if(@$_SESSION['Customer_Id']=='') { ?>
          <a href="register.php" class="register"><img src="imagess/register.png" alt="Register" title="Register">Register</a>
          <?php } else { ?>
          <a href="myaccount.php" class="register"><img src="imagess/register.png" alt="Register" title="Register">My Account</a>
          <?php } ?>
          
        <div class="cart-order"> <span class="icon-cart"><img src="imagess/cart.png" alt="Cart" title="Cart"></span> <span>0 Item</span> </div>
          
      </div>
    </div>
    <a href="index.php"><img src="imagess/header-logo.png" alt="Savani Farm" title="Savani Farm" class="logo"></a>
    <div class="menu">
      <div class="pull-left">
        <ul>
          <li style="padding-right:8px;"><a href="index.php" class="active">Home</a></li>
          <li style="padding-right:8px;"><a href="aboutus.php">About Us</a></li>
          <li style="padding-right:8px;"><a href="products.php">Products</a></li>
          <li style="padding-right:8px;"><a href="howtocutmango.php">How to cut a Mango</a></li>
          <li><a href="missionmango.php">Mission Mango</a></li>
        </ul>
      </div>
      <div class="pull-right" style="padding-right:30px;">
        <ul>
          <li><a href="mangoripeningandstoring.php">Ripening & Storing</a></li>
          <li><a href="recipe.php">Recipes</a></li>
          <li><a href="jumbo-kesar-mango-south-florida.php">Mango Articles</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div class="mobile-container">
      <div class="topnav">
        <div id="myLinks"> <a href="index.php" class="active">Home</a> <a href="aboutus.php">About Us</a> <a href="products.php">Products</a> <a href="howtocutmango.php">How to cut a Mango</a> <a href="missionmango.php">Mission Mango</a> <a href="recipe.php">Recipes</a> <a href="mangoripeningandstoring.php">Ripening & Storing</a> <a href="jumbo-kesar-mango-south-florida.php">Mango Articles</a> <a href="contactus.php">Contact Us</a> </div>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"> <i class="fa fa-bars"></i> </a> </div>
    </div>
  </div>
*/ ?>