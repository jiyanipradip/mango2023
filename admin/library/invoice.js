function viewProduct()
{
//alert("hiiii");
//alert(cboCategory.selectedIndex);
//alert(cboCategory.options[cboCategory.selectedIndex].value);
	with(window.document.frmOrder) {
		if (cboCategory.selectedIndex == 0) {
		//alert("hi");
			window.location.href = 'index.php?flag=1';
		} else {
		//alert("hello");
			window.location.href = 'index.php?flag=1&catId=' + cboCategory.options[cboCategory.selectedIndex].value;
		}
	}
}

function save1(a)
{
//alert('h');
var invfor = document.frmOrder.supply.value;
var contact = document.frmOrder.continfo.value;
window.location.href = 'modify/unset.php?a=' + a + '&suply=' + invfor + '&contact=' + contact; 
}
function viewProduct1forlist(n,m,o)
{
//alert("hiiii");
//n = frmOrderList.cboCategory.selectedIndex.value;
//alert(n.value);	
var a = document.frmOrderList.appdate.value;
var  b = document.frmOrderList.appdate1.value;
//alert(a);
//alert(b);
//alert(n);
	window.location.href = 'index.php?flag=1&catId='+ n.value +'&appdate='+ a +'&appdate1='+ b;;
		
}
function viewProduct21(barcode,oid,srno,sid)
{
//alert('hi');
var bar = barcode.value;
//alert(barcode);
//alert(document.frmOrder.cboCategory.selectedIndex);
	with (window.document.frmOrder) {
	//alert("hi");
		if (cboCategory.selectedIndex == 0) {
			//alert("hello");
			window.location.href = 'index.php?flag=1';
		} else {
		//alert("no hello");
			window.location.href = 'index.php?view=modify&oid=' + oid.value + '&catId=' + cboCategory.options[cboCategory.selectedIndex].value + '&barcode=' + bar + '&goqty=goqty&srno1=' + srno + '&sid=' + sid + '&invno=' +srno;
		}
	}
}

function enterqtymodify(q,m,n,o,sid)
{
	//alert('hi');
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify/quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&sid=' + sid;	
}
function enterqty1modify(q,m,n,o,sid)
{
	//alert('hi');
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	var sid=sid;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify/unitprice.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&sid=' +sid;	
}
function enterqty2modify(q,m,n,o,p,sid)
{
	//alert('hh');
	var q = q.value;
	var srno = m;
	var cat	= n;	
	var bar = o;
	var si	= p;
	var sid = sid;	
	//var l = l;
	//alert('quantity.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar);	
	window.location.href='modify/taxperc.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&si=' + si + '&sid=' + sid;
}
function deleteCategoryformodify(q,m,n,p)
{
	//var q = q.value;
	var srno = q;
	var cat	= m;	
	var bar = n;
	var inv = p;
	//var si	= o;
	window.location.href='modify/deleterow.php?q=' + q + '&srno=' + srno + '&cat=' + cat + '&bar=' + bar + '&invoice=' + p;

}
function deleteCategoryfordelete(q,k)
{
	//alert('hh');
	//var q = q.value;
	var cat	= q;	
	//var si	= m;
	var inv = k;
	window.location.href='modify/deleteinvoice.php?cat=' + cat + '&inv=' + k;

}
function callme(catId)
{
	//alert('hiiii');
	window.location.href='index.php?view=edit&oid=178&barcode1=1&catId=' + catId +'&callme=callme';

}

function callme1(catId,srno1,sid)
{
	//alert('hiiii');
	window.location.href='index.php?view=modify&oid=178&barcode=1&catId=' + catId + '&callme=callme&srno2=' + srno1 + '&sid=' + sid;

}
function callmenow(catId,invno)
{
//	alert(catId);
	//	alert(srno1);
	//	alert(sid);

	//alert(catId);

	//var sid = windows.document.frmOrder.hiddensid.value;
	//alert(sid);
	window.location.href='index.php?view=modify&oid=178&barcode=1&catId=' + catId + '&callme=callme&invno=' + invno;

}
function callmenowcreditmemo(catId,invno)
{
//	alert(catId);
	//	alert(srno1);
	//	alert(sid);

	//alert(catId);

	//var sid = windows.document.frmOrder.hiddensid.value;
	//alert(sid);
	window.location.href='index.php?view=modify&oid=178&barcode=1&catId=' + catId + '&callme=callme&memono=' + invno;

}