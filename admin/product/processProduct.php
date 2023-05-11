<?php
require_once '../../library/config.php';
require_once '../library/functions.php';
checkUser();
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	case 'addProduct' :
		addProduct();
		break;
	case 'modifyProduct' :
		modifyProduct();
		break;
	case 'deleteProduct' :
		deleteProduct();
		break;
	case 'deleteImage' :
		deleteImage();
		break;
    default :
	    // if action is not defined or unknown
		// move to main product page
		header('Location: index.php');
}
function addProduct()
{
    
	$ParentId      		    = addslashes($_POST['cboCategory2']);
	$catId      		    = addslashes($_POST['cboCategory']);
    $prid                   = addslashes($_POST['txtid']);
	$name                   = addslashes($_POST['txtName']);
	$description            = addslashes($_POST['mtxDescription']);
	$price                  = str_replace(',', '', (double)$_POST['txtPrice']);addslashes($_POST['txtPrice']);
	$qty                    = (int)$_POST['txtQty'];
	$brand                  = addslashes($_POST['txtbname']);
    $generic      		    = addslashes($_POST['txtgname']);
	$page					= addslashes($_POST['txtppage']);
	$sku                    = addslashes($_POST['txtprodsku']);
    $searchword             = addslashes($_POST['txtseachword']);
	$searchdescription		= addslashes($_POST['txtsearchdesc']);
	$prodowner     		    = addslashes($_POST['txtprodowener']);
   	$stock        			= addslashes($_POST['txtstockunit']);
	$totalunit       		= (int)$_POST['txtaltunit'];
	$unit        			= (int)$_POST['txtbunit'];
	$deci         			= (int)$_POST['txtdeci'];
	$currentstock        	= (int)$_POST['txtcurrstock'];
	$minstock        		= (int)$_POST['txtminstock'];
	$maxstock               = (int)$_POST['txtmaxstock'];
	$outstock               = (int)$_POST['txtoutstock'];
	$toselqty        		= (int)$_POST['txttoselqty'];
	$toselprice         	= addslashes($_POST['txtsellprice']);

	  $j=0;
	 $finalstr="";
	for($k=0;$k<strlen($toselprice);$k++)
	{
		if(is_numeric($toselprice[$k]) || $toselprice[$k]=="." || $toselprice[$k]=="-")
		{
			$finalstr.=$toselprice[$k];
			$j++;
		}	
	}
	 $onsaleprice        	 = $_POST['txtonsaleprice'];
	  $j=0;
	 $finalstronsaleprice="";
	for($k=0;$k<strlen($onsaleprice);$k++)
	{
		if(is_numeric($onsaleprice[$k]) || $onsaleprice[$k]=="." || $onsaleprice[$k]=="-")
		{
			$finalstronsaleprice.=$onsaleprice[$k];
			$j++;
		}	
	}
	 $qtypricing        	 = $_POST['txtQtypricing'];
	  $j=0;
	 $finalqtypricing="";
	for($k=0;$k<strlen($qtypricing);$k++)
	{
		if(is_numeric($qtypricing[$k]))
		{
			$finalqtypricing.=$qtypricing[$k];
			$j++;
		}	
	}
	 $pricecoment            = (int)$_POST['txtqtyPricecomment'];
	 $pricingscheme          = (int)$_POST['txtpricingscheme'];
	 $texable                = addslashes($_POST['txttaxable']);
   	 $code                   = addslashes($_POST['txtcode']);
	 $prpmotion              = addslashes($_POST['txtpromotion']);
	 $auction                = addslashes($_POST['txtauction']);
	 $handaling       		 = addslashes($_POST['txthandaling']);
	 $shipcharge         	 = addslashes($_POST['txtshippingcharge']);
	 $shipcode         		 = addslashes($_POST['txtshippingcode']);
	 $shipunit         		 = addslashes($_POST['txtshippingunit']);
	 $dimension         	 = addslashes($_POST['txtboxdimension']);
	 $grossweight        	 = addslashes($_POST['txtgrossweight']);
	 $netweight        	     = addslashes($_POST['txtnetweight']);
	 $abccode        		 = addslashes($_POST['txtabccode']);
	 $fsncode        		 = addslashes($_POST['txtfsncode']);
	 $location        		 = addslashes($_POST['txtlocation']);
	 $fgoogle        		 = addslashes($_POST['txtfgoogle']);
	 $fbrand        		 = addslashes($_POST['txtfgooglebrand']);
	 $fprodtype        		 = addslashes($_POST['txtfgoogleprodtype']);
	 $fcondition        	 = addslashes($_POST['txtfgooglecondition']);
     $ip_addr 				 = $_SERVER['REMOTE_ADDR'];
     $edit_session			 =$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	 $addid					 =$_SESSION['udepot'];
	 $images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
				 			 $sql9 = "SELECT PordId
	        						  FROM productmast
									  WHERE PordId = '$prid' AND CatagoryId ='$catId'";
									 // echo $sql9;die;
							 $result9 = dbQuery($sql9);
							 
	if($prid == '')
	{
			 header('Location: index.php?view=add&catId='.$ParentId.'&ccatId='.$catId.'&error=' . urlencode('Please Enter Valid Product ID'));
			 	exit;
	
	}
	if (dbNumRows($result9) == 1)
	{	
			//echo "hello";
							 header('Location: index.php?view=add&catId='.$ParentId.'&ccatId='.$catId.'&error=' . urlencode('Product ID already taken For This Sub Category. Choose another one'));	
	}								
	else
	{
							$sqlproduct   =    "INSERT INTO productmast 
										(PordId,CatagoryId, ProdName,ProdDesc,PucrPrice,TotBuyQty,image,pd_thumbnail,
										BrandName,GenericName,ProdPage,ProdSKU,SearchWord,SearchDesc,ProdOwner,
										StockUnit,AltUnit,BillUnit,Deci,CurStock,MinStock,MaxStock,OutStock,
										TotSelQty,SellPrice,OnSalePrice,QtyPricing,QtyPricingComment,PricingScheme,
										Taxable,TaxCode,Promotion,Auction,HandlingCharge,ShippingCharge,ShippingCode,ShippingUnit,
										BoxDimensions,GrossWeight,NetWeight,ABCCode,FSNCode,location,Froogle,FroogleBrand,FroogleProdType,
										FroogleCondition,ADD_ID,EDIT_ID,ADD_SESSION,EDIT_SESSION,Categorymain)
	          					VALUES ('$prid','$catId','$name','$description',$price,$qty,'$mainImage','$thumbnail',
			  		 					'$brand','$generic','$page','$sku','$searchword','$searchdescription','$prodowner',
					 					'$stock','$totalunit','$unit','$deci','$currentstock','$minstock','$maxstock','$outstock',
					 					'$toselqty','$finalstr','$finalstronsaleprice','$finalqtypricing','$pricecoment','$pricingscheme',
					 					'$texable','$code','$prpmotion','$auction','$handaling','$shipcharge','$shipcode','$shipunit',
					 					'$dimension','$grossweight','$netweight','$abccode','$fsncode','$location','$fgoogle','$fbrand','$fprodtype',
					 					'$fcondition','$addid','','$edit_session','','$ParentId'
					 					)";

							$result = dbQuery($sqlproduct);
	 header('Location: index.php?catId='.$catId.'&ccatId='.$ParentId);
}							
//header("Location: index.php?catId='$catId'");	

}
/*
	Upload an image and return the uploaded image name 
*/
function uploadProductImage($inputName, $uploadDir)
{
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';
	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];
		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";
		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']); 
		// make sure the image width does not exceed the
		// maximum allowed width
		if (LIMIT_PRODUCT_WIDTH && $width > MAX_PRODUCT_IMAGE_WIDTH) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_PRODUCT_IMAGE_WIDTH);
			$imagePath = $result;
		} else {
			$result = copy($image['tmp_name'], $uploadDir . $imagePath);
		}	
		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, THUMBNAIL_WIDTH);
			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}	
		} else {
			// the product cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}
		
	}
	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}
/*
	Modify a product
*/
function modifyProduct()
{

	$categorymain     = 	addslashes($_POST['cboCategory2']);
    $catId       			 = addslashes($_POST['cboCategory']);
	$categorymainhidden     = 	addslashes($_POST['cboCategory2hidden']);
    $catIdhidden       			 = addslashes($_POST['cboCategoryhidden']);

	$productId   			 = addslashes($_GET['productId']);
	$prid        			 = addslashes($_POST['txtid']);
    $name        			 = addslashes($_POST['txtName']);
	$price       			 = str_replace(',', '', $_POST['txtPrice']);
	$qty         			 = addslashes($_POST['txtQty']);
	 $sku                    = addslashes($_POST['txtprodsku']);
     $stock        			 = addslashes($_POST['txtstockunit']);
	 $ip_addr = $_SERVER['REMOTE_ADDR'];
     $edit_session=$ip_addr."*".date("Y-m-d")."*".date("H:i:s");
	 $addid=$_SESSION['udepot'];
	 
	 $images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/');
 	 $mainImage = $images['image'];
	 $thumbnail = $images['thumbnail'];
	 if ($mainImage != '') {
		_deleteImage($productId);
		$mainImage = "'$mainImage'";
		$thumbnail = "'$thumbnail'";
	}
	else
	{
		
		$mainImage = 'image';
		$thumbnail = 'pd_thumbnail';
	}
	$sql   = "UPDATE productmast 
	          SET Categorymain='$categorymain',CatagoryId = '$catId',PordId='$prid', ProdName = '$name', PucrPrice = '$price', 
			  TotBuyQty = '$qty', image = $mainImage, pd_thumbnail = $thumbnail,				                        
			ProdSKU ='$sku',StockUnit = '$stock',EDIT_ID ='$addid',EDIT_SESSION ='$edit_session' 
			WHERE PordId = '$productId' AND Categorymain='$categorymainhidden' AND CatagoryId = '$catIdhidden'";  
		$result = dbQuery($sql);
	    header('Location: index.php?ccatId='.$categorymain.'&catId='.$catId);			  
}

/*
	Remove a product
*/
function deleteProduct()
{
		//window.location.href = 'processProduct.php?action=deleteProduct&productId=' + productId + '&catId=' + catId + '&scatid='+ scatid +;

	if (isset($_GET['catId']) && $_GET['catId'])
	{
		$catId = $_GET['catId'];
	}
	if (isset($_GET['scatid']) && $_GET['scatid'])
	{
		$scatid = $_GET['scatid'];
	}
	
	
	if (isset($_GET['productId']) && $_GET['productId'])
	{
		$productId = $_GET['productId'];
	}
	else
	{
		header('Location: index.php');
	}
		$sql = "SELECT image, pd_thumbnail
	        FROM productmast
			WHERE PordId = '$productId' AND Categorymain = '$catId' AND CatagoryId = '$scatid'";
			
		$result = dbQuery($sql);
		$row    = dbFetchAssoc($result);
		// remove the product image and thumbnail
		if ($row['image'])
		{
		unlink(SRV_ROOT . 'images/product/' . $row['image']);
		unlink(SRV_ROOT . 'images/product/' . $row['pd_thumbnail']);
		}
		// remove the product from database;
		$sql = "DELETE FROM productmast 
	  	      WHERE PordId = '$productId' AND Categorymain = '$catId' AND CatagoryId = '$scatid'";
		dbQuery($sql);
		header('Location: index.php?ccatId=' . $_GET['catId'].'&catId='.$_GET['scatid']);
}
/*
	Remove a product image
*/
function deleteImage()
{
	if (isset($_GET['productId']) && $_GET['productId'])
	{
		$productId = (int)$_GET['productId'];
	}
	else
	{
		header('Location: index.php');
	}
	$deleted = _deleteImage($productId);
	// update the image and thumbnail name in the database
	$sql = "UPDATE productmast
			SET image = '', pd_thumbnail = ''
			WHERE PordId = '$productId'";
	dbQuery($sql);		
	header("Location: index.php?view=modify&productId=$productId");
}
function _deleteImage($productId)
{
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;
	$sql = "SELECT image, pd_thumbnail 
	        FROM productmast
			WHERE PordId = '$productId'";
	$result = dbQuery($sql) or die('Cannot delete product image. ' . mysql_error());
	if (dbNumRows($result))
	{
		$row = dbFetchAssoc($result);
		extract($row);
		if ($image && $pd_thumbnail)
		{
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/product/$image");
			$deleted = @unlink(SRV_ROOT . "images/product/$pd_thumbnail");
		}
	}
	return $deleted;
}
?>