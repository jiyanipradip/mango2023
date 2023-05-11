<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">

.ds_box {
	background-color: #FFF;
	border: 1px solid #3B8DB5;
	position: absolute;
	z-index: 32767;
}

.ds_tbl {
	background-color: #5FB7E5;
}

.ds_head {
	background-color: #DBF3FF;
	color: #0F6FA2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	text-align: center;
	letter-spacing: 1px;
}

.ds_subhead {
	background-color: #B5E3FB;
	color: #000;
	font-size: 10px;
	font-weight: bold;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	width: 12px;
}

.ds_cell {
	background-color: #FFFFF2;
	color: #000;
	font-size: 10px;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	padding: 3px;
	cursor: pointer;
}

.ds_cell:hover {
	background-color: #DEF0FF;
} /* This hover code won't work for IE */

</style>
</head>
<body  >

<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
<tr><td id="ds_calclass">
</td></tr>
</table>

<script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.
var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
	return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
	var tmp = el.offsetLeft;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetLeft;
		el = el.offsetParent;
	}
	return tmp;
}
function ds_gettop(el) {
	var tmp = el.offsetTop;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetTop;
		el = el.offsetParent;
	}
	return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
	ds_ob = '';
}
function ds_ob_flush() {
	ds_oe.innerHTML = ds_ob;
	ds_ob_clean();
}
function ds_echo(t) {
	ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'January', 'February', 'March', 'April', 'May', 'June',
'July', 'August', 'September', 'October', 'November', 'December'
]; // You can translate it for your language.

var ds_daynames = [
'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
	return '<table cellpadding="2" cellspacing="2" class="ds_tbl">'
	     + '<tr>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();">&lt;&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();">&lt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">CLOSE</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">&gt;</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">&gt;&gt;</td>'		 
		 + '</tr>'
	     + '<tr>'
		 + '<td colspan="7" class="ds_head">' + t + '</td>'
		 + '</tr>'
		 + '<tr>';
}

function ds_template_day_row(t) {
	return '<td class="ds_subhead">' + t + '</td>';
	// Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
	return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
	return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
	return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
	// Define width the day row.
}

function ds_template_main_below() {
	
	var dtobj = new Date();
	mnth = dtobj.getMonth()+1;
	yr = dtobj.getFullYear();
	
	//alert(mnth);
	//alert(yr);
	
	for(var i=1;i<=12;i++)
			{
				mnth=mnth+1;
				if(mnth>12)
				{
					mnth=1;
					yr=yr+1;
				}
				//alert(mnth+"--"+yr);
				var temp=temp+'<option value='+mnth+'*'+yr+'*'+i+'>'+ds_monthnames[mnth-1]+' '+yr+'</option>';
				//alert(temp);
			}
	
	return '</tr>' + '<tr>' + '<td colspan=7 align=center>'
		+ ' <select id=cb_date onChange=ds_cb_change()>'		
		+ '<option value=select>Go to another month</option>'+ 
						
				temp+	
			
			'</select> ' 
		+ '</td>' + 
		'</tr>'
	     + '</table>';
}

function ds_cb_change()
{
	
	var fl_date=document.getElementById('cb_date').value;
	//alert(fl_date);
	if(fl_date!='select')
	{
		var tmnth;
		var tyr;
		var tmnthyr=fl_date.split("*");
		tmnth=tmnthyr[0];
		tyr=tmnthyr[1];
		ds_draw_calendar(tmnth, tyr);
		var index1=tmnthyr[2];
		//alert(index1);
		document.getElementById('cb_date').selectedIndex=index1;
	}
	else
	{
		//alert("pls select the month first..!!!");
	}
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
	// First clean the output buffer.
	//ds_ob_clean();
	// Here we go, do the header
	ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
	for (i = 0; i < 7; i ++) {
		ds_echo (ds_template_day_row(ds_daynames[i]));
	}
	// Make a date object.
	var ds_dc_date = new Date();
	
	ds_dc_date.setFullYear(y);
	ds_dc_date.setDate(1);
	ds_dc_date.setMonth(m - 1);
	if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
		days = 31;
	} else if (m == 4 || m == 6 || m == 9 || m == 11) {
		days = 30;
	} else {
		days = (y % 4 == 0) ? 29 : 28;
	}
	var first_day = ds_dc_date.getDay();
	var first_loop = 1;
	// Start the first week
	ds_echo (ds_template_new_week());
	// If sunday is not the first day of the month, make a blank cell...
	if (first_day != 0) {
		ds_echo (ds_template_blank_cell(first_day));
	}
	var j = first_day;
	for (i = 0; i < days; i ++) {
		// Today is sunday, make a new week.
		// If this sunday is the first day of the month,
		// we've made a new row for you already.
		if (j == 0 && !first_loop) {
			// New week!!
			ds_echo (ds_template_new_week());
		}
		// Make a row of that day!
		ds_echo (ds_template_day(i + 1, m, y));
		// This is not first loop anymore...
		first_loop = 0;
		// What is the next day?
		j ++;
		j %= 7;
	}
	// Do the footer
	ds_echo (ds_template_main_below());
	// And let's display..
	ds_ob_flush();
	// Scroll it into view.
	//ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t,type1) {
	// Set the element to set...
	ds_element = t;
	// Make a new date, and set the current month and year.
	var ds_sh_date = new Date();
	ds_c_month = ds_sh_date.getMonth() + 1;
	ds_c_year = ds_sh_date.getFullYear();
	// Draw the calendar
	ds_draw_calendar(ds_c_month, ds_c_year);
	// To change the position properly, we must show it first.
	ds_ce.style.display = '';
	// Move the calendar container!
	the_left = ds_getleft(t);
	the_top = ds_gettop(t) + t.offsetHeight;
	ds_ce.style.left = the_left + 'px';
	ds_ce.style.top = the_top + 'px';
	// Scroll it into view.
	//ds_ce.scrollIntoView();
	document.form1.locate1.value=type1;
}

// Hide the calendar.
function ds_hi() {
	ds_ce.style.display = 'none';
}

function ds_self()
{
location.href="appointproc.php"
}
// Moves to the next month...
function ds_nm() {
	// Increase the current month.
	ds_c_month ++;
	// We have passed December, let's go to the next year.
	// Increase the current year, and set the current month to January.
	if (ds_c_month > 12) {
		ds_c_month = 1; 
		ds_c_year++;
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
	ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
	// We have passed January, let's go back to the previous year.
	// Decrease the current year, and set the current month to December.
	if (ds_c_month < 1) {
		ds_c_month = 12; 
		ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
	// Increase the current year.
	ds_c_year++;
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
	// Decrease the current year.
	ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.
	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	return y + '-' + m2 + '-' + d2;
}
function ds_format_date1(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.
	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	
	var m_names = new Array("01", "02", "03",
"04", "05", "06", "07", "08", "09",
"10", "11", "12");
var d = new Date();
var curr_date = d.getDate();
var curr_month = d.getMonth();
var curr_year = d.getFullYear();
if(curr_date<10)
{
	curr_date="0"+curr_date;
}
var mydate=curr_year + "-" + m_names[curr_month] + "-" + curr_date;
	
	var seledate=y + '-' + m2 + '-' + d2;
	
	var laterdate = new Date(y,m2,d2); 
var earlierdate = new Date(curr_year,m_names[curr_month],curr_date); 
	var daysdiff = timeDifference(laterdate,earlierdate);
	
	if(daysdiff<1)
	{
		return y + '-' + m2 + '-' + d2;
	}
	else
	{
		alert("YOU CAN NOT REVIEW FUTURE DATE...THANKS!!!!");
		return mydate;
	}	
		
}


function timeDifference(laterdate,earlierdate) {
var difference = laterdate.getTime() - earlierdate.getTime();

var daysDifference = Math.floor(difference/1000/60/60/24);
difference -= daysDifference*1000*60*60*24
var hoursDifference = Math.floor(difference/1000/60/60);
difference -= hoursDifference*1000*60*60
var minutesDifference = Math.floor(difference/1000/60);
difference -= minutesDifference*1000*60
var secondsDifference = Math.floor(difference/1000);
return daysDifference;
//alert('difference = ' + daysDifference + ' day/s ' + hoursDifference + ' hour/s ' + minutesDifference + ' minute/s ' + secondsDifference + ' second/s ');
}




// When the user clicks the day.
function ds_onclick(d, m, y) {
	// Hide the calendar.

	ds_hi();
	// Set the value of it, if we can.
	if (typeof(ds_element.value) != 'undefined') {
		ds_element.value = ds_format_date(d, m, y);
		//alert("RRR1");
		viewProduct1forlist(0);
		if (document.form1.locate1.value=='reviewreport')
		{
		location.href="reviewreport.php?todaydate2="+(ds_format_date1(d, m, y));
		}
		///location.href="procactivity.php?todaydate1="+(ds_format_date(d, m, y))+"&file1=reviewreport.php";
	// Maybe we want to set the HTML in it.
	} else if (typeof(ds_element.innerHTML) != 'undefined') {
//		alert("RRR2");
		ds_element.innerHTML = ds_format_date(d, m, y);

		if (document.form1.locate1.value=="reviewreport")
		{
		location.href="reviewreport.php?todaydate2="+(ds_format_date1(d, m, y));
		}/* else
		{
		location.href="procactivity.php?todaydate1="+(ds_format_date(d, m, y))+"&file1=reviewreport.php";
		}	 */
	// I don't know how should we display it, just alert it to user.
	} else {
		//alert (ds_format_date(d, m, y));
		

					//alert("RRR");
		if (document.form1.locate1.value=='reviewreport')
		{
		location.href="reviewreport.php?todaydate2="+(ds_format_date1(d, m, y));
		}/* else{
			location.href="procactivity.php?todaydate1="+(ds_format_date(d, m, y))+"&file1=reviewreport.php";
			} */
	}
}

// And here is the end.

// ]]> -->
</script>


<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


</body>
</html>
