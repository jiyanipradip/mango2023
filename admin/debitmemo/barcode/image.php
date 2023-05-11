<?php
  
  define (__TRACE_ENABLED__, false);
  define (__DEBUG_ENABLED__, false);
  
  require_once("barcode.php");  
  //require("i25object.php");
  //require("c39object.php");
  //require("c128aobject.php");
  require_once("c128bobject.php");
  //require("c128cobject.php");
              			   
  if (!isset($style))  $style   = BCD_DEFAULT_STYLE;
  if (!isset($width))  $width   = BCD_DEFAULT_WIDTH;
  if (!isset($height)) $height  = BCD_DEFAULT_HEIGHT;
  if (!isset($xres))   $xres    = BCD_DEFAULT_XRES;
  if (!isset($font))   $font    = BCD_DEFAULT_FONT;
  			    
  switch ($type)
  {
    case "I25":
			  $obj = new I25Object($width, $height, $style, $code);
			  break;
    case "C39":
			  $obj = new C39Object($width, $height, $style, $code);
			  break;
    case "C128A":
			  $obj = new C128AObject($width, $height, $style, $code);
			  break;
    case "C128B":
			  $obj = new C128BObject($width, $height, $style, $code);
			  break;
    case "C128C":
              $obj = new C128CObject($width, $height, $style, $code);
			  break;
	default:
			echo "Need bar code type ex. C39";
			$obj = false;
  }
   
  if ($obj) {
      $obj->SetFont($font);   
      $obj->DrawObject($xres);
  	  $obj->FlushObject();
  	  $obj->DestroyObject();
  	  unset($obj);  /* clean */
  }
?>