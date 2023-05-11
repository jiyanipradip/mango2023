<?php
/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkUser()
{
	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['dentadepot_user_id'])) {
		header('Location: ' . SAVANI_FARM . 'admin/login.php');
		exit;
	}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
}
function doLogin()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';

	$userName = $_POST['txtUserName'];
	
	//echo $userName;
	$password = $_POST['txtPassword'];
	
	//echo $userName."-".$password; die;
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	}
	else if ($password == '')
	{
		$errorMessage = 'You must enter the password';
	} 
	else
	{
		// check the database and see if the username and password combo do match
		$sql     = "SELECT user_id
		            FROM tbl_user 
				    WHERE user_name = '$userName'";
		$result  =  dbQuery($sql);
	
		if (dbNumRows($result) == 1)
		{
		// 29 april updated bacool...
			$sql1   ="SELECT user_id,user_password
					 FROM tbl_user 
					 WHERE  user_name = '$userName'";
			$result1 = mysql_query($sql1);
			$data1=mysql_fetch_assoc($result1);
			if ((dbNumRows($result1) == 1) && ($data1['user_password']== md5($password)))
			{ // updated by bacool 30 april && part 
				$row = dbFetchAssoc($result);
					$_SESSION['dentadepot_user_id'] = $row['user_id'];
					$_SESSION['udepot']=$userName;
			// log the time when the user last login
				$sql = "UPDATE tbl_user 
						SET user_last_login = NOW() 
						WHERE user_id = '{$row['user_id']}'";
				dbQuery($sql);
				if (isset($_SESSION['login_return_url']))
				{
							header('Location: ' . $_SESSION['login_return_url']);
							exit;
				}
				else
				{
							header('Location: index.php');
							exit;
				}
			}
			else
			{
						$errorMessage = 'Wrong username or password';
			}		
		}
	}
	return $errorMessage;
}

/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['dentadepot_user_id']))
	{
		unset($_SESSION['dentadepot_user_id']);
		session_destroy();
		session_unregister('dentadepot_user_id');
	}
		
	header('Location: login.php');
	exit;
}
/*
	If you want to be able to add products to the first level category
	replace the above function with the one below
*/
function buildCategoryOptions($ccatId,$catId)
{
			if($catId == '')
			{
				echo "if";
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
			
			}
			else
			{
				echo "else";
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
			}
			
			die;
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
	
			$categories = array();
			while($row = dbFetchArray($result))
			{
			list($id, $name) = $row;
		
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('ID'=>$id,'name' => $name, 'children' => array());
				} 
			}	
	
					// build combo box options
					$list = '';
					foreach ($categories as $key => $value)
					 {
						$name     = $value['name'];
						$children = $value['children'];
						$list .= "<option value=\"$key\"";
						if ($key == $catId)
						{
							$list.= " selected";
						}
			
							$list .= ">$name</option>\r\n";
							foreach ($children as $child) {
							$list .= "<option value=\"{$child['id']}\"";
							if ($child['id'] == $catId)
							{
								$list.= " selected";
							}
			
					$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
					}
	}
	
	return $list;
}
function buildCategoryOptionsmy($ccatId,$catId)
{
		if($catId == '')
		{
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
		
		}
		else
		{
			$sql = "SELECT *
					FROM subcatgmaster  where CatagoryId = $catId AND SubCatId = $ccatId
					ORDER BY SubCatId";
		}
		$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());

		$cat = array();
		while ($row = mysql_fetch_assoc($result))
		{
			extract($row);
			$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $CatagoryId,
					 'code'  => $SubCatId,
					 'name'  => $SubCatName);

		}
	return $cat;	
}


function buildCategoryOptionsmy2134($ccatId,$catId)
{
		if($catId == '')
		{
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
		
		}
		else
		{
			$sql = "SELECT *
					FROM subcatgmaster  where CatagoryId = $ccatId AND SubCatId = '$catId'
					ORDER BY SubCatId";
		
		}
		$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());

		$cat = array();
		while ($row = mysql_fetch_assoc($result))
		{
			extract($row);
			$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $CatagoryId,
					 'code'  => $SubCatId,
					 'name'  => $SubCatName);

		}
	return $cat;	
}
function buildCategoryOptionsmyproduct($ccatId,$catId)
{
		if($catId == '')
		{
			$sql = "SELECT *
					FROM productmast  where Categorymain = 'bacool'
					ORDER BY PordId";
		
		}
		else
		{
			$sql = "SELECT *
					FROM productmast  where Categorymain = $ccatId and CatagoryId = $catId
					ORDER BY PordId";
		}
		
		$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());

		$cat = array();
		while ($row = mysql_fetch_assoc($result))
		{
			extract($row);
			$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $PordId,
					 'code'  => $PordId,
					 'name'  => $ProdName);

		}
	return $cat;	
}
function buildCategoryOptionsnew($catId)
{
			
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND c.CatagoryId = '$catId'
					ORDER BY SubCatId";
			
			
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
	
			$categories = array();
			while($row = dbFetchArray($result))
			{
			list($id, $name) = $row;
		
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('ID'=>$id,'name' => $name, 'children' => array());
				} 
			}	
	
					// build combo box options
					$list = '';
					foreach ($categories as $key => $value)
					 {
						$name     = $value['name'];
						$children = $value['children'];
						$list .= "<option value=\"$key\"";
						if ($key == $catId)
						{
							$list.= " selected";
						}
			
							$list .= ">$name</option>\r\n";
							foreach ($children as $child) {
							$list .= "<option value=\"{$child['id']}\"";
							if ($child['id'] == $catId)
							{
								$list.= " selected";
							}
			
					$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
					}
	}
	
	return $list;
}
// ******************  FOR ACCOUNT FIRST SELECTION BOX OF USERNAMES
function buildUserOptions($catId)
{
	
			$sql = "SELECT c.location_Id , Location,c.user_id
					FROM userlogin s,custloc c where s.user_id = c.user_id and s.user_id='$catId'
					ORDER BY s.user_id";
			
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id, $name) = $row;
		
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
					// build combo box options
			$list = '';
			foreach ($categories as $key => $value) {
			$name     = $value['name'];
			$children = $value['children'];
			$list .= "<option value=\"$key\"";
			if ($key == $catId)
			{
				$list.= " selected";
			}
			$list .= ">$name</option>\r\n";
			foreach ($children as $child)
			{
				$list .= "<option value=\"{$child['id']}\"";
				if ($child['id'] == $catId)
				{
					$list.= " selected";
				}
			
			$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
			}
	}
	
	return $list;
}
//****************** FOR LOCATION *********************
function buildlocationOptions2($Userid = 0)
{
	
			$sql = "SELECT user_id,user_name
					FROM userlogin 
					ORDER BY user_id";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
				 {
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				 } 
			}	
			// build combo box options
			$list = '';
			foreach ($categories as $key => $value)
			{
				$name     = $value['name'];
				$children = $value['children'];
				$list .= "<option value=\"$key\"";
				if ($key == $Userid)
				{
					$list.= " selected";
				}
			
				$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
					$list .= "<option value=\"{$child['id']}\"";
					if ($child['id'] == $Userid)
					{
						$list.= " selected";
					}
			
				$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
	}
	
	return $list;
}
// *************   FOR ADD ACCOUNT *******************
function buildlocationOptions9($catId)
{
	
			$sql = "SELECT user_id,user_name
					FROM userlogin where user_id = '$catId'
					ORDER BY user_id";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
				 {
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				 } 
			}	
	
			// build combo box options
			$list = '';
			foreach ($categories as $key => $value)
			{
				$name     = $value['name'];
				$children = $value['children'];
				$list .= "<option value=\"$key\"";
				if ($key == $catId)
				{
					$list.= " selected";
				}
			
				$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
					$list .= "<option value=\"{$child['id']}\"";
					if ($child['id'] == $Userid)
					{
						$list.= " selected";
					}
						$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
			}
	
	return $list;
}
// *****************
function buildlocationOptions19($catId)
{
	
			$sql = "SELECT location_Id,Location
					FROM custloc where user_id = '$catId'
					ORDER BY user_id";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
			 	{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
	
			// build combo box options
			$list = '';
			foreach ($categories as $key => $value)
			{
				$name     = $value['name'];
				$children = $value['children'];
				$list .= "<option value=\"$key\"";
				if ($key == $catId)
				{
					$list.= " selected";
				}
					$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
					$list .= "<option value=\"{$child['id']}\"";
					if ($child['id'] == $catId)
					{
						$list.= " selected";
					}
						$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
		}
	
	return $list;
}
// BUILT CATEGORY LIST FOR CATEGORY MASTER
/*
function buildCategoryOptions1($catId)
{
	
			$sql = "SELECT CatagoryId,CatagoryName
					FROM catgmaster
					ORDER BY CatagoryId";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
				// build combo box options
				$list = '';
				foreach ($categories as $key => $value)
				{
					$name     = $value['name'];
					$children = $value['children'];
					$list .= "<option value=\"$key\"";
					if ($key == $catId)
					{
						$list.= " selected";
					}
			
						$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
						$list .= "<option value=\"{$child['id']}\"";
						if ($child['id'] == $catId)
						{
							$list.= " selected";
						}
						$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
			}
	
	return $list;
}
//
*/
function buildCategoryOptions1()
{
			$sql = "SELECT CatagoryId,CatagoryName
					FROM catgmaster
					ORDER BY CatagoryId";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
    $cat = array();
    while ($row = mysql_fetch_assoc($result)) {
		extract($row);
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $CatagoryId,
		              'code'  => $CatagoryId,
					   'name'  => $CatagoryName);

    }
	return $cat;			
}
function buildcustomerselection()
{
			$sql = "SELECT * 
					FROM custmast
					ORDER BY custid ";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
    $cat = array();
    while ($row = mysql_fetch_assoc($result)) {
		extract($row);
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $custid,
		              'code'  => $custid,
					   'name'  => $name." : ".$fname);

    }
	return $cat;			
}
function buildcustomerselectionforlist()
{
			
			$sql = "SELECT * 
					FROM custmast
					ORDER BY custid ";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
    $cat = array();
    while ($row = mysql_fetch_assoc($result)) {
		extract($row);
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $custid,
		              'code'  => $custid,
					   'name'  => $name." : ".$fname
					   );

    }
	return $cat;			
}
function buildvenderselectionforlist()
{
			
			$sql = "SELECT * 
					FROM vendormast 
					ORDER BY vendorid";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
    $cat = array();
    while ($row = mysql_fetch_assoc($result)) {
		extract($row);
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $vendorid,
		              'code'  => $vendorid,
					   'name'  => $name." : ".$fname
					   );

    }
	return $cat;			
}
function buildCategoryOptionsforsubcategory($catId,$ChildId)
{
	
			$sql = "SELECT SubCatId,SubCatName
					FROM subcatgmaster where CatagoryId = '$catId'
					ORDER BY SubCatId";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
				// build combo box options
				$list = '';
				foreach ($categories as $key => $value)
				{
					$name     = $value['name'];
					$children = $value['children'];
					$list .= "<option value=\"$key\"";
					if ($key == $ChildId)
					{
						$list.= " selected";
					}
			
						$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
						$list .= "<option value=\"{$child['id']}\"";
						if ($child['id'] == $catId)
						{
							$list.= " selected";
						}
						$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
			}
	
	return $list;
}
function buildcustomer($Userid = 0)
{
	
			$sql = "SELECT user_id,user_name
					FROM userlogin 
					ORDER BY user_id";
			$result = dbQuery($sql) or die('Cannot get User. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
				{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
				// build combo box options
				$list = '';
				foreach ($categories as $key => $value) {
				$name     = $value['name'];
				$children = $value['children'];
				$list .= "<option value=\"$key\"";
				if ($key == $Userid)
				{
					$list.= " selected";
				}
					$list .= ">$name</option>\r\n";
				foreach ($children as $child)
				{
					$list .= "<option value=\"{$child['id']}\"";
					if ($child['id'] == $catId)
					{
						$list.= " selected";
					}
						$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
				}
	}
	
return $list;
}
// for viewlocations.php
function builduserlocationwiseaccounts($Userid = 0)
{
	     if(isset($_SESSION['MAST']))
		 {
		 	$MAST = $_SESSION['MAST'];
			$sql = "SELECT Location_ID,Location_Name 
					FROM user_acc WHERE Username = '$MAST'  ORDER BY Location_ID";
			$result = dbQuery($sql) or die('Cannot get User. ' . mysql_error());
		}
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id,$name) = $row;
		 		{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
		// build combo box options
					$list = '';
					foreach ($categories as $key => $value)
					{
						$name     = $value['name'];
						$children = $value['children'];
						$list .= "<option value=\"$key\"";
						if ($key == $Userid)
						{
							$list.= " selected";
						}
							$list .= ">$name</option>\r\n";
							foreach ($children as $child)
							{
								$list .= "<option value=\"{$child['id']}\"";
								if ($child['id'] == $catId)
								{
									$list.= " selected";
								}
									$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
							}
					}
return $list;
}
function buildCategoryOptions2($ccatId = 0)
{
	
			$sql = "SELECT CatagoryId,CatagoryName
					FROM catgmaster
					ORDER BY CatagoryId";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
					list($id,$name) = $row;
				 	{
						// we create a new array for each top level categories
						$categories[$id] = array('name' => $name, 'children' => array());
					} 
			}	
						// build combo box options
						$list = '';
						foreach ($categories as $key => $value)
						{
							$name     = $value['name'];
							$children = $value['children'];
							$list .= "<option value=\"$key\"";
							if ($key == $ccatId)
							{
								$list.= " selected";
							}
								$list .= ">$name</option>\r\n";
							foreach ($children as $child)
							{
								$list .= "<option value=\"{$child['id']}\"";
								if ($child['id'] == $ccatId)
								{
									$list.= " selected";
								}
									$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
							}
						}
	
return $list;
}
function buildCategoryOptions9($catId)
{
			$sql = "SELECT SubCatId, SubCatName
					FROM subcatgmaster
					ORDER BY SubCatId";
			$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
			$categories = array();
			while($row = dbFetchArray($result))
			{
				list($id, $name) = $row;
				{
					// we create a new array for each top level categories
					$categories[$id] = array('name' => $name, 'children' => array());
				} 
			}	
					// build combo box options
					$list = '';
					foreach ($categories as $key => $value)
					{
						$name     = $value['name'];
						$children = $value['children'];
						$list .= "<option value=\"$key\"";
						if ($key == $catId)
						{
							$list.= " selected";
						}
							$list .= ">$name</option>\r\n";
						foreach ($children as $child)
						{
							$list .= "<option value=\"{$child['id']}\"";
							if ($child['id'] == $catId)
							{
								$list.= " selected";
							}
								$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
						}
					}
return $list;
}
/*
	Create a thumbnail of $srcFile and save it to $destFile.
	The thumbnail will be $width pixels.
*/
function createThumbnail($srcFile, $destFile, $width, $quality = 75)
{
	$thumbnail = '';
	if (file_exists($srcFile)  && isset($destFile))
	{
		$size        = getimagesize($srcFile);
		$w           = number_format($width, 0, ',', '');
		$h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');
		$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
	}
	
	// return the thumbnail file name on sucess or blank on fail
	return basename($thumbnail);
}

/*
	Copy an image to a destination file. The destination
	image size will be $w X $h pixels
*/


function copyImage($srcFile, $destFile, $w, $h, $quality = 75)
{   
	//copy($srcFile,$destFile);
     $tmpSrc     = pathinfo(strtolower($srcFile));
     $tmpDest    = pathinfo(strtolower($destFile));
     $size       = getimagesize($srcFile);
    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg")
    {
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } elseif ($tmpDest['extension'] == "png") {
       $dest = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } 
	elseif ($tmpDest['extension'] == "bmp") {
	//echo "hi".$srcFile;die;
       $destFile  = substr_replace($destFile, 'bmp', -3);
      $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } 
	else {
      return false;
    }
	//echo $size[2];die;
    switch($size[2])
	
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
		   case 6:   
		       //BMP
		   $src = imagecreatefrombmp($srcFile);
           break;
       default:
           return false;
           break;
    }

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile,$quality);
           break;
       case 3:
           imagepng($dest,$destFile);
		              break;

		  case 6:
          imagejpeg($dest,$destFile);
    }
    return $destFile; 

}
  function ConvertBMP2GD($src, $dest = false) {
      if (!($src_f = fopen($src, "rb"))) {
          return false;
      }
      if (!($dest_f = fopen($dest, "wb"))) {
          return false;
      }
      $header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f, 14));
      $info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", fread($src_f, 40));
      
      extract($info);
      extract($header);
      
      if ($type != 0x4D42) {
          // signature "BM"
          return false;
      }
      
      $palette_size = $offset - 54;
      $ncolor = $palette_size / 4;
      $gd_header = "";
      // true-color vs. palette
      $gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
      $gd_header .= pack("n2", $width, $height);
      $gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
      if ($palette_size) {
          $gd_header .= pack("n", $ncolor);
      }
      // no transparency
      $gd_header .= "\xFF\xFF\xFF\xFF";
      
      fwrite($dest_f, $gd_header);
      
      if ($palette_size) {
          $palette = fread($src_f, $palette_size);
          $gd_palette = "";
          $j = 0;
          while ($j < $palette_size) {
              $b = $palette{$j++};
              $g = $palette{$j++};
              $r = $palette{$j++};
              $a = $palette{$j++};
              $gd_palette .= "$r$g$b$a";
          }
          $gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
          fwrite($dest_f, $gd_palette);
      }
      
      $scan_line_size = (($bits * $width) + 7) >> 3;
      $scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;
      
      for ($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
          // BMP stores scan lines starting from bottom
          fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));
          $scan_line = fread($src_f, $scan_line_size);
          if ($bits == 24) {
              $gd_scan_line = "";
              $j = 0;
              while ($j < $scan_line_size) {
                  $b = $scan_line{$j++};
                  $g = $scan_line{$j++};
                  $r = $scan_line{$j++};
                  $gd_scan_line .= "\x00$r$g$b";
              }
          } elseif ($bits == 8) {
              $gd_scan_line = $scan_line;
          } elseif ($bits == 4) {
              $gd_scan_line = "";
              $j = 0;
              while ($j < $scan_line_size) {
                  $byte = ord($scan_line{$j++});
                  $p1 = chr($byte >> 4);
                  $p2 = chr($byte & 0x0F);
                  $gd_scan_line .= "$p1$p2";
              }
              $gd_scan_line = substr($gd_scan_line, 0, $width);
          } elseif ($bits == 1) {
              $gd_scan_line = "";
              $j = 0;
              while ($j < $scan_line_size) {
                  $byte = ord($scan_line{$j++});
                  $p1 = chr((int)(($byte & 0x80) != 0));
                  $p2 = chr((int)(($byte & 0x40) != 0));
                  $p3 = chr((int)(($byte & 0x20) != 0));
                  $p4 = chr((int)(($byte & 0x10) != 0));
                  $p5 = chr((int)(($byte & 0x08) != 0));
                  $p6 = chr((int)(($byte & 0x04) != 0));
                  $p7 = chr((int)(($byte & 0x02) != 0));
                  $p8 = chr((int)(($byte & 0x01) != 0));
                  $gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
              }
              $gd_scan_line = substr($gd_scan_line, 0, $width);
          }
          
          fwrite($dest_f, $gd_scan_line);
      }
      fclose($src_f);
      fclose($dest_f);
      return true;
  }

  function imagebmp($im, $fn = false){
    if (!$im) return false;
           
    if ($fn === false) $fn = 'php://output';
    $f = fopen ($fn, "w");
    if (!$f) return false;
           
    //Image dimensions
    $biWidth = imagesx ($im);
    $biHeight = imagesy ($im);
    $biBPLine = $biWidth * 3;
    $biStride = ($biBPLine + 3) & ~3;
    $biSizeImage = $biStride * $biHeight;
    $bfOffBits = 54;
    $bfSize = $bfOffBits + $biSizeImage;
           
    //BITMAPFILEHEADER
    fwrite ($f, 'BM', 2);
    fwrite ($f, pack ('VvvV', $bfSize, 0, 0, $bfOffBits));
           
    //BITMAPINFO (BITMAPINFOHEADER)
    fwrite ($f, pack ('VVVvvVVVVVV', 40, $biWidth, $biHeight, 1, 24, 0, $biSizeImage, 0, 0, 0, 0));
           
    $numpad = $biStride - $biBPLine;
    for ($y = $biHeight - 1; $y >= 0; --$y)
    {
        for ($x = 0; $x < $biWidth; ++$x)
        {
            $col = imagecolorat ($im, $x, $y);
            fwrite ($f, pack ('V', $col), 3);
        }
        for ($i = 0; $i < $numpad; ++$i)
            fwrite ($f, pack ('C', 0));
    }
    fclose($f);
    return true;
  }
  
  function imagecreatefrombmp($filename) {

      $tmp_name = tempnam("./temp_files", "GD");
      if (ConvertBMP2GD($filename, $tmp_name)) {
          $img = imagecreatefromgd($tmp_name);
		 // echo $tmp_name;die;
          unlink($tmp_name);
          return $img;
		 // die;
      }
      return false;
  }
/*
	Create the paging links
*/
function getPagingNav($sql, $pageNum, $rowsPerPage, $queryString = '')
{
	$result  = mysql_query($sql) or die('Error, query failed. ' . mysql_error());
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$numrows = $row['numrows'];
	// how many pages we have when using paging?
	$maxPage = ceil($numrows/$rowsPerPage);
	$self = $_SERVER['PHP_SELF'];
	// creating 'previous' and 'next' link
	// plus 'first page' and 'last page' link
	
	// print 'previous' link only if we're not
	// on page one
	if ($pageNum > 1)
	{
		$page = $pageNum - 1;
		$prev = " <a href=\"$self?page=$page{$queryString}\">[Prev]</a> ";
	
		$first = " <a href=\"$self?page=1{$queryString}\">[First Page]</a> ";
	}
	else
	{
		$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
		$first = ' [First Page] '; // nor 'first page' link
	}
	
	// print 'next' link only if we're not
	// on the last page
	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <a href=\"$self?page=$page{$queryString}\">[Next]</a> ";
	
		$last = " <a href=\"$self?page=$maxPage{$queryString}{$queryString}\">[Last Page]</a> ";
	}
	else
	{
		$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
		$last = ' [Last Page] '; // nor 'last page' link
	}
	
	// return the page navigation link
	return $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last; 
}
?>