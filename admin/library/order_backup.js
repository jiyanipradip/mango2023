// JavaScript Document

function viewOrder()
{
	statusList = window.document.frmOrderList.cboOrderStatus;
	status     = statusList.options[statusList.selectedIndex].value;	
	
	if (status != '') {
		window.location.href = 'index.php?status=' + status;
	} else {
		window.location.href = 'index.php';
	}
}

function modifyOrderStatus(orderId)
{
	statusList = window.document.frmOrder.cboOrderStatus;
	status     = statusList.options[statusList.selectedIndex].value;
	window.location.href = 'processOrder.php?action=modify&oid=' + orderId + '&status=' + status;
}

function deleteOrder(orderId)
{

}
function viewProduct1forlist(n,m,o)
{
//alert("hiiii");
n = frmOrderList.cboOrderType.value;
m = frmOrderList.product.value;
var a = document.frmOrderList.appdate.value;
var  b = document.frmOrderList.appdate1.value;
//alert(a);
//alert(b);
//alert(n);
	window.location.href = 'index.php?flag=1&catId='+n+'&appdate='+ a +'&appdate1='+ b+'&product='+m;;
		
}