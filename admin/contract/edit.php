<?
require_once '../../library/config.php';
require_once '../library/functions.php';

$sql = "INSERT INTO contractmaster(
`contact` 
)
VALUES(
'1'
)";
$result=mysql_query($sql);
	 		header('Location: index.php?view=edit&catId='.$catId);

?>
