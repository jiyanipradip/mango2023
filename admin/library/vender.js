// JavaScript Document
function viewProduct()
{
//alert(cboCategory.selectedIndex);
	with (window.document.frmListCategory) {
		if (cboCategory.selectedIndex == 0) {
			window.location.href = 'index.php?flag=1';
		} else {
			window.location.href = 'index.php?flag=1&catId=' + cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}

// JavaScript Document
function viewcustomer()
{
//alert(cboCategory.selectedIndex);
	with (window.document.frmListCategory) {
		if (cboCategory.selectedIndex == 0) {
			window.location.href = 'index.php?flag=1';
		} else {
			window.location.href = 'index.php?flag=1&Userid=' + cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}


function checkCategoryForm()
{
    with (window.document.frmCategory) {
		if (isEmpty(txtName, 'Enter category name')) {
			return;
		} else {
			submit();
		}
	}
}

function addCategory(parentId)
{
	targetUrl = 'index.php?flag=0&view=add';
	if (parentId != 0) {
		targetUrl += '&parentId=' + parentId;
	}
	
	window.location.href = targetUrl;
}



function addsubCategory(parentId)
{   
	targetUrl = 'index.php?flag=1&view=addsubcatagory';
	if (parentId != 0) {
		targetUrl += '&parentId=' + parentId;
	}
	
	window.location.href = targetUrl;
}


//
function addlocation(Userid)
{   
	targetUrl = 'index.php?flag=1&view=addsubcatagory';
	if (Userid != 0) {
		targetUrl += '&Userid=' + Userid;
	}
	
	window.location.href = targetUrl;
}

//




function modifyCategory(catId)
{
	window.location.href = 'index.php?flag=0&view=modify&catId=' + catId;
}
// MODIFY LOCATION
function modifycustomer(Userid)
{
	window.location.href = 'index.php?flag=0&view=modify&Userid=' + Userid;
}

function modifyvenderrmaster(Userid)
{
	window.location.href = 'index.php?flag=0&view=modify&Userid=' + Userid;
}

//


function modifysubCategory(catId,scatid)
{	
	window.location.href = 'index.php?flag=1&view=modifysubCategory&catId=' + catId+"&scatid="+scatid;
}
function modifyLocation(catId)
{
	window.location.href = 'index.php?flag=1&view=modifylocation&catId=' + catId;
}





function deleteCategory(catId)
{
	   // alert('hiiiiiiiii');
	if (confirm('delete '+ catId +'?')) {
		if (confirm('Are you sure'))
		{
		window.location.href = 'processCategory.php?action=delete&catId=' + catId;
		}
	}
}
function deletevender(catId)
{
	   // alert('hiiiiiiiii');
	if (confirm('delete '+ catId +'?')) {
		if (confirm('Are you sure'))
		{
		window.location.href = 'processVender.php?action=delete&catId=' + catId;
		}
	}
}
function deletesubCategory(catId,scatid)
{
	  
	if (confirm('delete '+ scatid +'?')) {
	if (confirm('are you sure ???'))
	{		 
	window.location.href = 'processCategory.php?action=deletesub&catId=' +  catId+"&scatidt="+scatid;
	//alert(window.location.href);
	}
	}
}
function deleteImage(catId)
{
	if (confirm('delete '+ catId +'?')) {
		if (confirm('are you sure ???'))
		{
		window.location.href = 'processCategory.php?action=deleteImage&catId=' + catId;
		}
	}
}