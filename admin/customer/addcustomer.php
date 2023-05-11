<?
$errorMessage = '&nbsp;';
require_once('functions.php');
if (isset($_POST['txtUserName']))
//if (isset($_POST['txtdocuserid'])) 
{
	$result = addUser();
	if ($result != '') {
		$errorMessage = $result;
		
	}
			header("Location: index.php");	

}

$msg="";
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>
<form method="post" name="frmadd" id="frmadd"><?php echo $errorMessage; ?><? echo $msg;?>
          
          <table width="91%" border="0" align="center" cellpadding="2" cellspacing="0" class="ddepot-blueborder">
            <tr>
              <td align="center" colspan="2" class="hdbg"> Customer Profile </td>
            <tr>
              <td width="52%" align="right"> Login Name </td>
              <td width="48%" align="left">
                <input name="txtUserName" type="text" class="box" id="txtUserName" size="20" maxlength="20"></td>
            </tr>
            <tr>
              <td align="right">Password</td>
              <td align="left">
                <input name="txtPassword" type="password" class="box" id="txtPassword" value="" size="20" maxlength="20"></td>
            </tr>
            <tr>
              <td align="right">Re Enter Password</td>
              <td align="left">
                <input name="txtPasswordre" type="password" class="box" id="txtPasswordre" value="" size="20" maxlength="20"></td>
              <input type="hidden" name='c1' <? if(isset($c1)) { ?> value='<? echo $c1?>' <? } ?>>
              <input type="hidden" name='q1' <? if(isset($c1)) { ?> value='<? echo $q1?>' <? } ?>>
              <input type="hidden" name='p1' <? if(isset($c1)) { ?> value='<? echo $p1?>' <? } ?>>
            </tr>
            <tr>
              <td align="right">Area Code, Phone Number And Extension</td>
              <td align="left" class="aos-br-comn-blackhd">
                <input name="txtareacode" type="text" class="box" id="txtareacode" value="" size="5" maxlength="5">
                <input name="txtPhone" type="text" class="box" id="txtPhone" value="" size="10" maxlength="10">
                 Ext :<input name="txtext" type="text" class="box" id="txtext" value="" size="3" maxlength="3"></td>
            </tr>
            <tr>
              <td align="right"> Contact E mail Address </td>
              <td align="left">
                <input name="txtemail" type="text" class="box" id="txtemail" value="" size="60" maxlength="60"></td>
            </tr>
			<tr>
              <td align="right">Order Confirmation E mail Address </td>
              <td align="left">
                <input name="txtorderemail" type="text" class="box" id="txtorderemail" value="" size="60" maxlength="60"></td>
            </tr>
            <tr>
              <td align="right"> Please E mail Order Confirmation </td>
              <td align="left">
                <input name="txtemailconfirm" type="checkbox" class="box" id="txtemailconfirm" value="" size="20" maxlength="20"></td>
            </tr>
            <tr>
              <td height="53" colspan="2" class="hdbg">
                <input name="btnAddUser" type="submit" id="btnAddUser" value="Submit Profile">
             </td></tr>
          </table> 
		  </form>    