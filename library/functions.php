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
	$password = $_POST['txtPassword'];
	
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
		//session_unregister('dentadepot_user_id');
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
			if($catId == '' && $ccatId != '')
			{
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
			
			}
			else
			
			{
			$sql = "SELECT SubCatId, SubCatName,c.CatagoryId
					FROM subcatgmaster s,catgmaster c where s.CatagoryId = c.CatagoryId AND s.CatagoryId = '$ccatId'
					ORDER BY SubCatId";
			}
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
//
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
    } else {
      return false;
    }
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
    }
    return $destFile; 

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