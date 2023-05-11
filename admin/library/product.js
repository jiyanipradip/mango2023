// JavaScript Document
function viewProduct()
{

	with (window.document.frmListProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
		}
	}
}
function viewProductmastmodify(productId)
{
	with (window.document.frmAddProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?view=modify&ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value + '&productId='+productId;
		}
	}
}
function callme(catId)
{
	//alert('hiiii');
	window.location.href='index.php?view=add&oid=178&barcode1=1&catId=' + catId +'&callme=callme';

}

function viewProductadd()
{
//alert(custId);

	with (window.document.frmAddProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			//window.location.href = 'index.php?ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
			window.location.href = 'index.php?view=add&ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
		}
	}
}
/*
function viewProductaddd(custId)
{
//alert(custId);
	with (window.document.frmAddProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			//window.location.href = 'index.php?ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
			window.location.href = 'index.php?view=add&ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value + '&custId=' + custId.value;
		}
	}
}

function viewProductadddd(custId)
{

	with (window.document.frmAddProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			//window.location.href = 'index.php?ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
			window.location.href = 'index.php?view=add&ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value + '&prodid=' + cboCategory3.options[cboCategory3.selectedIndex].value + '&custId=' + custId.value;
		}
	}
}*/
function viewProduct321(productId,ccatId)
{
	
	with (window.document.frmAddProduct) {
		if (cboCategory2.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {			//alert(productId);

			window.location.href = 'index.php?view=modify&productId= '+productId+'&ccatId=' + cboCategory2.options[cboCategory2.selectedIndex].value;
		}
	}
}



function addaccount(user_id)
{
	//alert("hiiiii");
	window.location.href = 'index.php?view=add&catId=' + user_id;
}






function viewProduct1()
{
	
	with (window.document.frmListProduct) {
		if (cboCategory.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?ccatId='+cboCategory2.options[cboCategory2.selectedIndex].value+'&catId='+cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}

function viewProduct311()
{
	
	with (window.document.frmAddProduct) {
		if (cboCategory.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			//alert('hiiiiiiiiiiiii');
			window.location.href = 'index.php?view=modify&productId='+ PordId + '&ccatId='+cboCategory2.options[cboCategory2.selectedIndex].value+'&catId='+cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}


function checkAddProductForm()
{
	with (window.document.frmAddProduct) {
		if (cboCategory.selectedIndex == 0) {
			alert('Choose the product category');
			cboCategory.focus();
			return;
		} else if (isEmpty(txtName, 'Enter Product name')) {
			return;
		} 
		
		
		
		
		
		else {
			submit();
		}
	}
}

function addcontract(ccatId)
{
	
	window.location.href = 'index.php?view=add&catId=' + ccatId + '&addme=addme';
	
}
function addProduct(catId,ccatId)
{
	
	window.location.href = 'index.php?view=add&catId=' + ccatId + '&ccatId=' +catId;
	
}

function modifyaccount(Acc_Id)
{
	window.location.href = 'index.php?view=modify&productId=' + Acc_Id;
}






function modifyProduct(productId,cboCategory2,cboCategory)
{
	//alert(cboCategory2);
	window.location.href = 'index.php?view=modify&productId=' +productId +'&ccatId='+cboCategory2 + '&catId='+cboCategory;
}
function modifyProduct2(productId,cboCategory2,cboCategory)
{
	window.location.href = 'index.php?view=searchmodify&productId=' +productId +'&ccatId='+cboCategory2 + '&catId='+cboCategory;
}

function deleteProduct(productId,catId,scatid)
{
	if (confirm('Delete this product?')) {
		window.location.href = 'processProduct.php?action=deleteProduct&productId=' + productId + '&catId=' + catId + '&scatid='+ scatid;
	}
}

function deleteImage(productId)
{
	if (confirm('Delete this image')) {
		window.location.href = 'processProduct.php?action=deleteImage&productId=' + productId;
	}
}