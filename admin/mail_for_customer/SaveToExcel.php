<?php
/*header("Content-type: text/plain; name='excel'");
header("Content-Disposition: filename=export.xls");
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");*/

header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: filename=test.xls");
header("Pragma: no-cache");


function strip_only_tags($str, $tags, $stripContent=false) {
    $content = '';
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) {
        if ($stripContent)
             $content = '(.+</'.$tag.'(>|\s[^>]*>)|)';
         $str = preg_replace('#</?'.$tag.'(>|\s[^>]*>)'.$content.'#is', '', $str);
    }
    return $str;
}


$temp=$_REQUEST['datatodisplay'];
//echo $temp;die;
$tags1="<a>";
$c1=strip_only_tags($temp, $tags1, '');

?>
<html>
<head>
<style type="text/css">

<!--

body {
	background-color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #000000;
}



-->

</style>
</head>
<body><?=$c1;?>
</body>
</html>