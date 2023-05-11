<?php
	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\Exception;
	//include 'includes/session.php';
 require_once 'library/config.php';
    $message = "";
	if(isset($_POST['subscription'])){
		//$username = $_POST['username'];
		$email = $_POST['email'];
		 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $message = "Invalid email format";
}
    else {

		//$_SESSION['username'] = $username;
		//$_SESSION['email'] = $email;
        
        




		/*if(!isset($_SESSION['captcha'])){
			require('recaptcha/src/autoload.php');		
			$recaptcha = new \ReCaptcha\ReCaptcha('6LevO1IUAAAAAFCCiOHERRXjh3VrHa5oywciMKcw', new \ReCaptcha\RequestMethod\SocketPost());
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

			if (!$resp->isSuccess()){
		  		$_SESSION['error'] = 'Please answer recaptcha correctly';
		  		header('location: signup.php');	
		  		exit();	
		  	}	
		  	else{
		  		$_SESSION['captcha'] = time() + (10*60);
		  	}

		}*/

		/*if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
			header('location: signup.php');
		}
		else{*/
			//$conn = $pdo->open();
            

            $sqlm ="SELECT COUNT(*) AS numrows FROM subscription WHERE email='$email'";
	       //echo $sqlm; die;
	       $resm=mysql_query($sqlm);
	       $datam=mysql_fetch_assoc($resm);
	       $methdid = $datam['numrows'];
			//$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM subscription WHERE email=:email");
			//$stmt->execute(['email'=>$email]);
			//$row = $stmt->fetch();
			if($methdid > 0){
				//$_SESSION['error'] = 'Email already taken';
                $message = '<div style="color:red;">You Already Subscribed</div>';
				//header('location: index.php');
			}
			else{
                $now = date('Y-m-d H:i:s');
				//$password = password_hash($password, PASSWORD_DEFAULT);

				//generate code
				//$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				//$code=substr(str_shuffle($set), 0, 12);

				try{
					//$stmt = $conn->prepare("INSERT INTO subscription (username, email, date) VALUES (:username, :email, :now)");
					//$stmt->execute(['username'=>$username, 'email'=>$email, 'now'=>$now]);
					//$userid = $conn->lastInsertId();
                    $sqlin = "INSERT INTO subscription (username, email, date) VALUES ('', '$email', '$now')";
                    $resultin = mysql_query($sqlin);

					/*$message = "
						<h2>From: Registering For BreathEZz Learn More.</h2>
						<p>User Details:</p>
						<p>Name: ".$username."</p>
						<p>Email: ".$email."</p>
                        <p><i>*This is a System Generated Email Please do not reply to this email</i></p>
					";*/ 

					//Load phpmailer
		    		//require 'vendor/autoload.php';

		    		//$mail = new PHPMailer(true);                             
				    try {
				        //Server settings
				        /*$mail->isSMTP();                                     
				        //$mail->Host = 'smtp.gmail.com';   
                        //$mail->Host = 'smtp.ipower.com';
				        //$mail->SMTPAuth = true;                               
				        //$mail->Username = 'info@breathezz.com';     
				        //$mail->Password = 'Info@123';
                        //$mail->Host = 'smtp.gmail.com';   
                        $mail->Host = 'smtp.ipower.com';
				        $mail->SMTPAuth = true;                               
				        $mail->Username = 'support@breathezz.com';     
				        $mail->Password = 'Info@123';
				        $mail->SMTPOptions = array(
				            'ssl' => array(
				            'verify_peer' => false,
				            'verify_peer_name' => false,
				            'allow_self_signed' => true
				            )
				        );                         
				        $mail->SMTPSecure = 'ssl';                           
				        $mail->Port = 465;                                   

				        $mail->setFrom('support@breathezz.com');
				        
				        //Recipients
				        $mail->addAddress($email);              
				        $mail->addReplyTo('support@breathezz.com');
				       
				        //Content
				        $mail->isHTML(true);                                  
				        $mail->Subject = 'BreathEZz Learn More Submission Form';
				        $mail->Body    = $message;

				        $mail->send();

				        unset($_SESSION['username']);
				        unset($_SESSION['email']);*/
                       

				        //$_SESSION['success'] = '<div style="color:red;">Your detail has been sent contact to you shortly.</div>';
                        $message = '<div style="color:red;">Your detail has been sent contact to you shortly.</div>';
				        //header('location: index.php');

				    } 
				    catch (Exception $e) {
				        //$_SESSION['error'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
                        $message = '<div style="color:red;">Message could not be sent. Mailer Error: </div>'.$mail->ErrorInfo;
				        //header('location: index.php');
				    }
                    //$_SESSION['success'] = '<div style="color:red;">Message has been sent.</div>';
                    $message = '<div style="color:red;">Subscription Successful.</div>';
                           //header('location: index.php');  

				}
				catch(PDOException $e){
					//$_SESSION['error'] = $e->getMessage();
                    $message = $e->getMessage();
					//header('location: index.php');
				}

				//$pdo->close();

			}

		
    }
	}
	else{
		//$_SESSION['error'] = 'Fill up learn form first';
       //$message = '<div style="color:red;">Fill up learn more form first.</div>';
		//header('location: index.php#learnmore');
	}

?>