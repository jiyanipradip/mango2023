<?php require_once 'library/config.php';

$zipcodechkout = $_POST['zipcodechkout'];

$methodchkout = $_POST['methodchkout'];

$typechkout = $_POST['typechkout'];

	
	$sqlm ="select * from shipmethod where METHODID='$methodchkout'";
	$resm=mysql_query($sqlm);
	$datam=mysql_fetch_assoc($resm);
	$methdid = $datam['METHODID'];
	
	$sqlshipzone ="select * from shipzone where ZIPCODE='$zipcodechkout'";
	$resshipzone=mysql_query($sqlshipzone);
	$data=mysql_fetch_assoc($resshipzone);
	
	$shipzone_days = $data['DAYS'];
	$num_tot=mysql_num_rows($resshipzone);
	echo $shipzone_days."*".$num_tot."*".$methdid; 
?>