<?php 
session_start(); 
$text = rand(10000,99999); 
$_SESSION["vercode"] = $text; 

$image = imagecreatefromjpeg("images/bg1.jpg");
$txtColor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 5, 5, $text, $txtColor);
header("Content-type: image/jpeg");
imagejpeg($image);
?>
