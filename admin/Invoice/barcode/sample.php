<? 
define (__TRACE_ENABLED__, false);
define (__DEBUG_ENABLED__, false);
	   
require_once("barcode.php");		   
 //require("i25object.php");//FOR NUMERIC TEXT ONLY
 //require("c39object.php");//ITS FOR ALPHA NUMERIC TEXT
 //require("c128aobject.php");
 require_once("c128bobject.php");// FOR ALPHANUMERIC TEXT
 //require("c128cobject.php");
 
 
 //$barcodetext="cHin10"; // to specify the text for barcode.....
//echo $barcodetext;

 						  
/* Default value */

if (!isset($output))  $output   = "png"; 
if (!isset($barcode)) $barcode  = $barcodetext;
if (!isset($type))    $type     = "C128B";
if (!isset($width))   $width    = "180";// default 460
if (!isset($height))  $height   = "85";//default 120

//if (!isset($width))   $width    = "320";// default 460
//if (!isset($height))  $height   = "80";//default 120
if (!isset($xres))    $xres     = "1";
if (!isset($font))    $font     = "3";//default 5
/*********************************/ 
		
if (isset($barcode) && strlen($barcode)>0) {    
  $style  = BCS_ALIGN_CENTER;					       
  //$style |= ($output  == "png" ) ? BCS_IMAGE_PNG  : 0; 
  $style |=  BCS_IMAGE_JPEG; 
  $style |= BCS_BORDER; 
  $style |= BCS_DRAW_TEXT; 
  $style |= BCS_STRETCH_TEXT; 
  //$style |= ($negative== "on"  ) ? BCS_REVERSE_COLOR  : 0; 		
									
/*if (isset($barcode) && strlen($barcode)>0) {    
  $style  = BCS_ALIGN_CENTER;					       
  $style |= ($output  == "png" ) ? BCS_IMAGE_PNG  : 0; 
  $style |= ($output  == "jpeg") ? BCS_IMAGE_JPEG : 0; 
  $style |= ($border  == "on"  ) ? BCS_BORDER 	  : 0; 
  $style |= ($drawtext== "on"  ) ? BCS_DRAW_TEXT  : 0; 
  $style |= ($stretchtext== "on" ) ? BCS_STRETCH_TEXT  : 0; 
  $style |= ($negative== "on"  ) ? BCS_REVERSE_COLOR  : 0; */
  
  switch ($type)
  {
    case "I25":
			  $obj = new I25Object(250, 120, $style, $barcode);
			  break;
    case "C39":
			  $obj = new C39Object(250, 120, $style, $barcode);
			  break;
    case "C128A":
			  $obj = new C128AObject(250, 120, $style, $barcode);
			  break;
    case "C128B":
			  $obj = new C128BObject(180,85, $style, $barcode);
			  //$obj = new C128BObject(250, 120, $style, $barcode);
			  break;
    case "C128C":
                          $obj = new C128CObject(250, 120, $style, $barcode);
			  break;
	default:
			$obj = false;
  }
  if ($obj) {
     if ($obj->DrawObject($xres)) {
         echo "<table align='center'><tr><td><img src='barcode/image.php?code=".$barcode."&style=".$style."&type=".$type."&width=".$width."&height=".$height."&xres=".$xres."&font=".$font."'></td></tr></table>";
     } else echo "<table align='center'><tr><td><font color='#FF0000'>".($obj->GetError())."</font></td></tr></table>";
  }
}
unset($xres);
unset($barcode);
//unset($xres);
//unset($xres);
?>

