<?php require_once 'library/config.php';
require_once 'library/encrypt1.php';

function doLogin()
{
	$c= $_POST['c1'];
	$p= $_POST['q1'];
	$q2= $_POST['p1'];
	$errorMessage = '';
	$userName = $_POST['txtuserid'];
	//echo $$userName;
	
	$password = $_POST['txtpass'];
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} /* else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} */else {
		$sql = "SELECT user_id
		        FROM userlogin 
				WHERE user_name = '$userName'";	
				echo $sql; die;			
	$result=mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) == 1) {		
		$sql1="SELECT user_id,user_password
		        FROM userlogin 
				WHERE  user_name = '$userName'";
		$result1 = mysql_query($sql1);
		$data1=mysql_fetch_assoc($result1);
		if ((mysql_num_rows($result1) == 1) && ($data1['user_password']== $password)) { 
			$row = mysql_fetch_assoc($result);
			$_SESSION['dentadepot_user_id'] = $row['user_id'];
			$_SESSION['udepot']=$userName;
			$_SESSION['masterkey']=$userName;
			$_SESSION['MAST']=$userName;
			$sql = "UPDATE userlogin 
			        SET user_last_login = NOW() 
					WHERE user_id = '{$row['user_id']}'";
			mysql_query($sql);
			if(isset($_SESSION['MKEYTMP']))
			{
			     header("Location: cart.php?action=list&cartlist=cartlist");
				 exit;
			}
			header("Location: cart.php?action=list");
			exit;
			
			} else {
			$errorMessage = 'Wrong username or password';
		}		
		}
	}
	return $errorMessage;
}






function doLoginstepwise()
{
	$errorMessage = '';
	$userName = $_POST['txtuserid'];
	//echo $userName;
	$password = $_POST['txtpass'];
	$password=ENCRYPT_DECRYPT($password);
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} /* else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} */else {
		$sqlcust = "SELECT custid,bill_email
		        FROM custmast 
				WHERE bill_email = '$userName' AND password = '$password'";	
		$resultcust=mysql_query($sqlcust);
			
		if($userName=="deepak@denta.com")
		{
			header("Location: placeanorder.php?step=1&loginid=".$userName);
			exit;
		}
		if(mysql_num_rows($resultcust) == 1)				
		 { 
			$_SESSION['dentadepot_user_id'] = $row['user_id'];
			$_SESSION['udepot']=$userName;
			$_SESSION['masterkey']=$userName;
			$_SESSION['MAST']=$userName;
			$_SESSION['Customer_Id']=$custid;
			if(isset($_SESSION['MKEYTMP']))
			{
				 //echo $_SESSION['MKEYTMP']."in if";die;
				 header("Location: placeanorder.php?step=1&loginid=".$userName);
				 exit;
			}
			//echo $_SESSION['MKEYTMP']."not in if";die;
			header("Location: placeanorder.php?step=1&loginid=".$userName);
			exit;
			
			} else {
			$errorMessage = 'Wrong username or password';
		}		
		
	}
	return $errorMessage;
}
function addUser()
{
//echo "hiiiiiii";die;
    $userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	$passwordre = $_POST['txtPasswordre'];
	$areacode = $_POST['txtareacode'];
	$txtPhone = $_POST['txtPhone'];
	$txtext = $_POST['txtext'];
	$email = $_POST['txtemail'];
	$orderemail = $_POST['txtorderemail'];
	$confirmation = $_POST['txtemailconfirm'];
	$lid = $_POST['lid'];
	
	
	
	
	$new_password = md5($password); // 30 april updated .... will encrypt password to md5 format
	$c= $_POST['c1'];
	$p= $_POST['q1'];
	$q2= $_POST['p1'];
	
	$sql = "SELECT user_name
	        FROM userlogin
			WHERE user_name = '$userName'";
	$result = mysql_query($sql);
	
	if ((mysql_num_rows($result) == 1)) {
		header('Location: newuser.php?view=add&loginid='.$lid.'&error=' . urlencode('Username already taken. Choose another one'));	
	} else if($password != $passwordre)
	{
	    header('Location: newuser.php?view=add&loginid='.$lid.'&error=' . urlencode('Password doesnt match')); 
	}else
	{			
		$sql   = "INSERT INTO userlogin (custid,user_name, user_password, user_regdate,Areacode,phone,ext,Email,Order_Email,Confirmation)
		          VALUES ('$lid','$userName', '$passwordre', NOW(),'$areacode','$txtPhone','$txtext','$email','$orderemail','$confirmation')";
		mysql_query($sql);
		header("Location: indexsample.php?c1=$c&q1=$p&p1=$q2");	
	}
}


function UpdateUser()
{
	$userid = $_POST['txtUserId'];
	//echo strlen($userid);die;
	$password = $_POST['txtPassword'];
	$areacode = $_POST['txtareacode'];
	$email = $_POST['txtemail'];
	$orderemail = $_POST['txtorderemail'];
	$txtPhone = $_POST['txtPhone'];
	$txtext = $_POST['txtext'];
	$sql = "UPDATE userlogin SET user_password = '$password',Areacode = '$areacode',Email = '$email',Order_Email = '$orderemail',phone = '$txtPhone',ext = '$txtext' where `userlogin`.`user_id` = $userid";
	//echo $sql;die;
	mysql_query($sql);
	header("Location: index.php?modifycustomer=modifycustomer&Userid=".$userid."&errorMessage=Your Informations Are Modified");	

}




?>