<?php
require_once '../../library/config.php';
require_once '../library/functions.php';
checkUser();
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'add' :
        addCategory();
        break; 
    case 'modify' :
        modifyCategory();
        break;
    case 'delete' :
        deleteCategory();
        break;
	case 'deletesub' :
        deletesubCategory();
        break;
    case 'deleteImage' :
        deleteImage();
        break;
    case 'addsubcatagory' :
	   addsubCategory();
        break;
		case 'modifysubcategory' :
		modifysubCategory();
		break;
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}
/*
    Add a category
*/
function addCategory()
{
    $name  			      =addslashes($_POST['txtName']); 
    $addid1 			  =addslashes($_POST['txtaddid']);
    $parentId    		  =addslashes($_POST['hidParentId']);
    $ip_addr 			  = $_SERVER['REMOTE_ADDR'];
    $edit_session=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid				  =$_SESSION['udepot'];
	
			$sql9  = "SELECT CatagoryId
	    	     	  FROM catgmaster
				 	  WHERE CatagoryId = '$addid1'";
			$result9 = dbQuery($sql9);
	if (dbNumRows($result9) == 1)
	{
	    	header('Location: index.php?view=add&error=' . urlencode('CatagoryId already taken. Choose another one'));	
	} 
	else
	{
	    	 $sql = "INSERT INTO catgmaster(CatagoryName,CatagoryId,ADD_ID,EDIT_ID,ADD_SESSION,EDIT_SESSION) 
                     VALUES ('$name','$addid1','$addid','','$edit_session','$edit_session')";
			 $result = mysql_query($sql) or die(mysql_error());
			 header('Location: index.php?flag=0&catId=' . $parentId);              
	}
}
/*
add subcatagory 1st may bacool
*/
function addsubCategory()
{
	$catId 			    = addslashes($_POST['cboCategory']);
	$subcatid    		= addslashes($_POST['txtsubcatid']);
    $name        		= addslashes($_POST['txtName']);
    $parentId    		= addslashes($_POST['hidParentId']);
    $ip_addr 	 		= $_SERVER['REMOTE_ADDR'];
    $edit_session		=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid		 		=$_SESSION['udepot'];
	// to check category id is available
	
$categoryid = addslashes($_POST['hidParentId']);

						$sql9 = "SELECT SubCatId
		        				 FROM subcatgmaster
								 WHERE SubCatId = '$subcatid' AND CatagoryId = '$categoryid'";
						$result9 = dbQuery($sql9);
	//echo $sql9;die;
	if (dbNumRows($result9) == 1)
	 {
						header('Location: index.php?view=addsubcatagory&parentId='.$categoryid.'&error=' . urlencode('SUB CatagoryId already taken. Choose another one'));	
	 } 
	else
	{
						$sql   = "INSERT INTO subcatgmaster(CatagoryId,SubCatId,SubCatName,ADD_ID,EDIT_ID,ADD_DATE_TIME,EDIT_DATE_TIME)
        	      				  VALUES ('$catId','$subcatid','$name','$addid','','$edit_session','')";
			    		$result = mysql_query($sql) or die(mysql_error());
   				  		header('Location: index.php?flag=1&catId=' . $catId);              
	}
}
/*
    Modify a category
*/
function modifyCategory()
{
    $catId       		= addslashes($_GET['catId']);
    $name        		= addslashes($_POST['txtName']);
    $addid1 			= addslashes($_POST['txtaddid']);
    $ip_addr 			= $_SERVER['REMOTE_ADDR'];
    $edit_session		=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid				=$_SESSION['udepot'];

	    				$sql    = "UPDATE catgmaster 
    	           				  SET CatagoryName= '$name', CatagoryId='$addid1', EDIT_ID='$addid', ADD_SESSION='$edit_session', 							                                  EDIT_SESSION='$edit_session' WHERE CatagoryId = '$catId'";
        				$result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    					header('Location: index.php?flag=0');              
}
/*
Modify sub catagory
*/
function modifysubCategory()
{
	
    $catId       		= addslashes($_GET['catId']);
    $name        		= addslashes($_POST['txtName']);
    $description 		= addslashes($_POST['txtaddid']);
    $ip_addr 			= $_SERVER['REMOTE_ADDR'];
    $edit_session		=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid				=$_SESSION['udepot'];
    
	
	//$scatid= $scat;
	
    // if uploading a new image
    // remove old image
     
    					$sql    = "UPDATE subcatgmaster 
        	      				  SET SubCatName = '$name',SubCatId = '$description',EDIT_ID='$addid',EDIT_DATE_TIME='$edit_session'
               	                  WHERE SubCatId = '$description' AND CatagoryId ='$catId'";
								  //echo $sql;die;
								  
        				$result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    					header('Location: index.php?flag=1&catId='.$catId);              
						
						
}
/*
    Remove a category
*/
function deleteCategory()
{
    if (isset($_GET['catId']) && $_GET['catId'])
	{
        				$catId = $_GET['catId'];
    }
	else
	{
	
    					header('Location: index.php?flag=0');
    }
    					$sql3="select * from subcatgmaster where CatagoryId= '$catId'";
						$result3 = mysql_query($sql3);
						$data1=mysql_fetch_assoc($result3);
						$prod= $data1['SubCatId'];
						$sql2 = "select * FROM productmast 
            	 				 WHERE CatagoryId= '$prod'";
   						$result2 = mysql_query($sql2);
	
	if (dbNumRows($result2) == 1)
	{
						header('Location: index.php?flag=0&error1=' . urlencode('there are products in this category...'));	
	}
	else if (dbNumRows($result3) == 1) 
	{
						header('Location: index.php?flag=0&error1=' . urlencode('there are sub categories in this category..'));
	}
	else
	{
	    				$sql = "DELETE FROM catgmaster 
            					WHERE CatagoryId= '$catId'";
    					dbQuery($sql);
    
    					header('Location: index.php?flag=0');
	}
}

/*
DELETE SUB CATEGORY
*/

function deletesubCategory()
{
	
   if (isset($_GET['scatidt']))
	{
    	 				$scatid = $_GET['scatidt'];
    } 
    if (isset($_GET['catId']) && $_GET['catId'])
	{
    	 				$catId = $_GET['catId'];
    } 
	else
	{
	     				header('Location: index.php');
    }
    					$sql5 = "select * from subcatgmaster WHERE SubCatId = '$catId'";
						$result = mysql_query($sql5);
						$data1=mysql_fetch_assoc($result);
						$catg=$data1['CatagoryId'];
						$subcatg=$data1['SubCatId'];
						$sql = "select * FROM productmast 
            			WHERE CatagoryId = '$subcatg'";
    					$result5 = mysql_query($sql);;
	if (dbNumRows($result5) == 1)
	{
						header('Location: index.php?flag=1&error=' . urlencode('there are products in this category...'));	
	}
	else
	{
    					$sql = "DELETE FROM subcatgmaster 
            					WHERE  CatagoryId = '$catId' and SubCatId = '$scatid'";
    					//echo $sql;die;
						dbQuery($sql);
						header('Location: index.php?flag=1&catId='. $catId);
	}
}
?>