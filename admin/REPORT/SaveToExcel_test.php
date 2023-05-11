<?php
$temp=$_POST['datatodisplay'];
//echo $temp;die;
$temp =str_replace("**********",'"',$temp);

$ourFileName = "savanifarmorderdata.txt";
//echo $ourFileName;die;
$fp = fopen($ourFileName, 'w+');
fwrite($fp,$temp);
fclose($fp);

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Content-Type: application/force-download");//to force fully download
//header("Content-Type: text/plain");
header( "Content-Disposition: attachment; filename=".basename($ourFileName));

header( "Content-Description: File Transfer");
readfile($ourFileName);
//$pageContent = file_get_contents($ourFileName);
//echo $pageContent;
//unlink($ourFileName);
die;

?>
