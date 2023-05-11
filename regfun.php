<?php 
ob_start();
require_once 'library/config.php';
require_once 'library/encrypt1.php';

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];
$fname= $_POST['fname'];
//echo $fname;
$lname= $_POST['lname'];
//echo $lname;
$bill_st1= $_POST['bill_st1'];
//echo $bill_st2;
$bill_st2= $_POST['bill_st2'];
//$bill_st3= $_POST['bill_st3'];
$bill_city= $_POST['bill_city'];
$bill_state= $_POST['bill_state'];
$bill_zip= $_POST['bill_zip'];
$bill_country= $_POST['bill_country'];
$bill_phone= $_POST['bill_phone'];
$bill_fax= $_POST['bill_fax'];
//$bill_faxship=$_POST['bill_faxship'];
$bill_email= $_POST['bill_email'];
//echo $bill_email; die;
$bill_emailpass= $_POST['bill_emailpass'];
$bill_emailpass = ENCRYPT_DECRYPT($bill_emailpass);
$bill_emailpassconfirm= $_POST['bill_emailpassconfirm'];
$comment=$_POST['comment'];

if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  
{ 
     header('Location: register.php?errorMessage= Incorrect Captcha !!!'); 
}
else
{ 
    $sqlcust="select * from custmast where bill_email = '$bill_email'";
    $resultcust=mysql_query($sqlcust);
    if(mysql_num_rows($resultcust) == 0)
    {
        $name = $fname." ".$lname;
        $sql    = "INSERT INTO `custmast` (
        `fname` ,
        `lname` ,
        `bill_st1` ,
        `bill_st2` ,
        `bill_city` ,
        `bill_state` ,
        `bill_zip` ,
        `bill_country` ,
        `bill_phone` ,
        `bill_fax`,
        `bill_email` , 
        `password`,
        `comment`
        )
        VALUES (
        '".addslashes($fname)."', '".addslashes($lname)."', '".addslashes($bill_st1)."', '".addslashes($bill_st2)."', '".addslashes($bill_city)."',
        '".addslashes($bill_state)."', '".$bill_zip."', '".addslashes($bill_country)."', '".$bill_phone."', '".$bill_fax."','".addslashes($bill_email)."','".addslashes($bill_emailpass)."','".addslashes($comment)."')";				  
        //echo $sql; die;
        $result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
        //header('Location: index.php');  

        $to =$bill_email;
        //$from="savanifarms@dentaoffice.com";
        $from="info@savanifarms.com";

        $message="NAME: ".$name."<br>";
        $message.="PHONE: ".$bill_phone."<br>";
        $message.="EMAIL: ".$bill_email."<br>";
        //$message.="COMPANY: ".$comp."\n\r";
        $message.="ADDRESS 1: ".$bill_st1."<br>";
        $message.="ADDRESS 2: ".$bill_st2."<br>";
        $message.="CITY: ".$bill_city."<br>";
        $message.="STATE: ".$bill_state."<br>";
        $message.="ZIP: ".$bill_zip."<br>";
        //$message.="FAX: ".$fax."\n\r";
        $message.="COMMENT: ".$comment."<br>";
        $headers .="MIME-Version: 1.0\r\n";
        $headers .="Content-Type: text/html; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
        $headers .="Content-Transfer-Encoding: 8bit\r\n";
        $headers .= "From: ".$from.">\r\n"; 

        mail($to,"SUB: REGISTRATION RECVD AT SAVANI FARMS",$message,$headers);
        //mail("savanifarms@dentaoffice.com","SUB: REGISTRATION RECVD AT SAVANI FARMS",$message,$headers);
        mail($bill_email,"SUB: REGISTRATION CONFIRMATION AT SAVANI FARMS",$message,$headers);
        // COUPONE CODE SENT BY EMAIL FOR NEW CUSTOMER REGISTER.......
        $htmlContent = file_get_contents("email_template/email_template.html");
        mail($to,"SAVANI FARMS",$htmlContent,$headers);

        header('Location: register.php?errorMessage=Thank you for Registering with Savanifarms&flag=0');  
    }
	else
	{
		header('Location: register.php?errorMessage='.$bill_email.' is already used&flag=1'); 
	}          
}
?>