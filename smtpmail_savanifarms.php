<?
require_once "PHPMailer-master/class.phpmailer.php";
require_once "PHPMailer-master/PHPMailerAutoload.php";
$stream = imap_open("{mail.dentaoffice.com:143/novalidate-cert}Sent", 'savanifarms@dentaoffice.com', 'Mango_1234') or die('Cannot connect: ' . print_r(imap_errors(), true));
$check = imap_check($stream) or die('Cannot connect: ' . print_r(imap_errors(), true));
die;

$to='samir.dentaweb@gmail.com';
//$to = $txtEmailID;
$from="savanifarms@dentaoffice.com";
$subject="Savani Farms";
$message .= '<table border="0" cellpadding="3" cellspacing="1">';        
$message .= '<tr><td align="center"><a href="http://www.savanifarms.com"><img src="http://savanifarms.com/E-mail.jpg"/></a></td></tr>';
$message .= '</table>';



$mail = new PHPMailer;
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->SMTPDebug = 0;
$mail->Host = 'mail.savanifarms.com';
$mail->Port = 587;
//$mail->Port = 465;
$mail->Username = 'savanifarms@dentaoffice.com';
$mail->Password = 'Mango_1234';
$mail->SMTPAuth = true;
$mail->From = $from;
$mail->FromName = "Savani Farms";
$mail->addAddress($to);
//$mail->AddAdress('mysmile@dentaweb.com', 'Dentaweb LLC');
//$mail->AddBCC('samirvparikh@gmail.com', 'Dentaweb LLC');
$mail->addReplyTo($from, "Reply Savani Farms");

$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $message;
$mail->AltBody = "";
//echo "<pre>";
//print_r($mail); die;
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo; die;
} 
else
{
    $imapStream = imap_open("{mail.dentaoffice.com:143/novalidate-cert}Sent", $mail->Username, $mail->Password) or die('Cannot connect: ' . print_r(imap_errors(), true));
    imap_append($imapStream, "{mail.dentaoffice.com:143}Sent", $mail->getSentMIMEMessage(), "\\Seen");
    imap_close($imapStream);
    echo 'SUCCESS<br>';
}
die;

$stream = imap_open("{mail.dentaweb.com:143/novalidate-cert}Sent", 'invoice@dentaweb.com', '3NzcC22K6U') or die('Cannot connect: ' . print_r(imap_errors(), true));
$check = imap_check($stream) or die('Cannot connect: ' . print_r(imap_errors(), true));
//echo "Msg Count before append: ". $check->Nmsgs . "\n<br>";
imap_append($stream, "{mail.dentaweb.com:143/novalidate-cert}Sent"
                   , "From: $from\r\n"
                   . "To: $to\r\n"
                   . "Subject: $subject\r\n"
                   . "\r\n"
                   . " $mail->Body \r\n"
                   ) or die('Cannot connect: ' . print_r(imap_errors(), true));
$check = imap_check($stream) or die('Cannot connect: ' . print_r(imap_errors(), true));
//echo "Msg Count after append : ". $check->Nmsgs . "\n";
imap_close($stream);
?>
