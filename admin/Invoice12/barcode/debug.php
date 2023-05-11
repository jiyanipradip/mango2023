<?


define(__DEBUG_HOST__, "localhost");
define(__DEBUG_PORT__, "9999");

define(__TRACE_HOST__, "localhost");
define(__TRACE_PORT__, "9999");

define(__TIMEOUT__, 3);
						   
function __TRACE__ ($str) {
if (__TRACE_ENABLED__) {
	$errno  = 0;
	$errstr = "no error";
	
	$fp = @fsockopen(__TRACE_HOST__, __TRACE_PORT__, &$errno, &$errstr, __TIMEOUT__);
	
	if ($fp)
	{
	   @fputs($fp, $str);
	   @fclose($fp);
	}
 }
}	
	
function __DEBUG__ ($str) {
if (__DEBUG_ENABLED__) {
	$errno  = 0;
	$errstr = "no error";
	
	$fp = @fsockopen(__DEBUG_HOST__, __DEGUB_PORT__, &$errno, &$errstr, __TIMEOUT__);
	
	if ($fp)
	{
	   @fputs($fp, $str);
	   @fclose($fp);
	} 
 }
}

?>