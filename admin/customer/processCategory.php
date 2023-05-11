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
        modifycustomer();
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
		case 'modifylocation' :
		modifylocation();
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
    $name  			      = $_POST['txtName'];
    $addid1 				  = $_POST['txtaddid'];
    $parentId    		  = $_POST['hidParentId'];
    $ip_addr 			  = $_SERVER['REMOTE_ADDR'];
    $edit_session=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid				  =$_SESSION['udepot'];
	
	$sql9 				  = "SELECT CatagoryId
	    	     			 FROM catgmaster
				 			 WHERE CatagoryId = '$addid1'";
	$result9 			  = dbQuery($sql9);
	
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
   
	
	$catId 			    = $_POST['cboCategory'];
	$locationid    		= $_POST['txtsubcatid'];
    $name        		= $_POST['txtName'];
    $parentId    		= $_POST['hidParentId'];
    $ip_addr 	 		= $_SERVER['REMOTE_ADDR'];
    $edit_session		=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	$addid		 		=$_SESSION['udepot'];
	// to check category id is available

						$sql9 = "SELECT user_id
		        				 FROM custloc 
								 WHERE user_id = '$locationid'";
						$result9 = dbQuery($sql9);
	
	if (dbNumRows($result9) == 1)
	 {
						header('Location: index.php?view=add&error=' . urlencode('Location Already Added'));	
	 } 
	else
	{
						$sql   = "INSERT INTO custloc(user_id,Location,location_Id) 
        	      		VALUES ('$catId','$name','$locationid')";
			    		$result = mysql_query($sql) or die(mysql_error());
  
  				  		header('Location: index.php?flag=1&catId=' . $parentId);              
	}
}

/*
    Modify a category
*/

function modifycustomer()
{
    $Userid       		= $_GET['Userid'];
    $name        		= $_POST['txtName'];
    $area 				= $_POST['txtarea'];
    $email 			    = $_POST['txtemail'];
	$orderemail        	= $_POST['txtorderemail'];
	

	    				$sql    = "UPDATE userlogin  
    	           				  SET user_name  = '$name', Areacode  = '$area',Email ='$email',Order_Email = '$orderemail' 
        	                      WHERE user_id  = '$Userid'";
        				$result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    					header('Location: index.php');              
}

/*
Modify sub catagory
*/

function modifylocation()
{
    $catId       		= $_GET['catId'];
    $name        		= $_POST['txtName'];
    $id         		= $_POST['txtlocid'];
    
    
    // if uploading a new image
    // remove old image
   
     
    					$sql    = "UPDATE custloc  
        	      				  SET Location  = '$name' WHERE location_Id = '$catId'";
        				$result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    					header('Location: index.php?flag=1');              
}

/*
    Remove a category
*/

function deleteCategory()
{
echo "hiiii";
    if (isset($_GET['catId']) && $_GET['catId'])
	{
        				$catId = $_GET['catId'];
    }
	else
	{
	
    					header('Location: index.php?flag=0');
    }
		$sql="DELETE from userlogin where user_id = $catId";
		$result=mysql_query($sql);   
		header('Location: index.php');

}

/*
DELETE SUB CATEGORY
*/

function deletesubCategory()
{
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
            					WHERE SubCatId = '$catId'";
    					dbQuery($sql);
						header('Location: index.php?flag=1&catId='. $catg);
	}

}

?>