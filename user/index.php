<?php
session_start(); 
if(!isset($_SESSION['co_id'])){ header('Location: ./../'); exit(); }
if(isset($_GET['logout'])) { unset($_SESSION['co_id']);  header('Location: ./../'); exit(); }
require_once("./../admin/system/config.php"); 
require_once("./../admin/system/functions.php"); 
require_once("./../admin/system/engin.php"); 
$cos_id = $_SESSION['co_id']; 
function select_tab($page,$tab){	if($page==$tab){ echo ' id="sel_div"'; } }
if(isset($_GET['p']) && $_GET['p']!= ''){  $pg = $_GET['p']; } else {  $pg = 'ledger'; }

if(isset($_GET['delete']) && $_GET['delete']>0)
{
	$msg_id = $_GET['delete'];
	$qry = "DELETE  FROM message WHERE id='$msg_id' and `to`='$cos_id'";
	$result = @leo_mysql_query($qry);			
	
	if($result )//if success
	{
	$_SESSION['SUCMSG']='A Message has been successfully deleted';
	session_write_close();
	header("Location: ./?p=inbox&page=".$page);
	exit(); 
	}
	else
	{
	$_SESSION['ERRMSG']='You canot delete this message';
	session_write_close();
	header("Location: ./?p=inbox&page=".$page);
	exit();
	}
}
if(isset($_POST['subject']))
{
	$subject = $_POST['subject'];
	$mesage = $_POST['mesage'];
	$sql_date = date('Y-m-d');

	$qry = "insert into `message` values ('','$cos_id','0','$subject','$mesage','$sql_date','$date','$ip')";
	$result = @leo_mysql_query($qry);
	
	$qry_cust3 = "select * from costomer where costomer_id='$cos_id'";
	$cust_res3 = leo_mysql_query($qry_cust3);
	$customer3 = leo_mysql_fetch_assoc($cust_res3);
 	
	$mailto = $companymail;
	$mailfrom = $customer3['email_id'];
	$subject = $subject;
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: ". $mailfrom."\r\n";
	
	$mailbody = '<u><b> Leogroup.in - Login User Message </b></u> <br>
<table width="200" border="0">
<tr><td> Customer Id </td><td>'.$customer3['costomer_id'].' </td></tr>
<tr><td> Company </td><td>'.$customer3['company'].'</td></tr>
<tr><td> Contact Person </td><td>'.$customer3['contact_person'].'</td></tr>
<tr><td> Address </td><td>'.$customer3['address'].'</td></tr>
<tr><td> Phone No </td><td>'.$customer3['phone_no'].'</td></tr>
<tr><td> Message </td><td>'.$mesage.'</td></tr>
</table>';
	mail($mailto,$subject,$mailbody,$headers);	
	if($result )//if success
	{
	$_SESSION['SUCMSG'] = 'Your Message has been sent successfully.';
	session_write_close();
	header("Location: ./?p=compose");
	exit(); 
	}
	else
	{
	$_SESSION['ERRMSG'] = 'You canot sent message at this time';
	session_write_close();
	header("Location: ./?p=compose");
	exit();
	}
}
if(isset($_POST['new_pwd']))
{
	$old_pwd = $_POST['old_pwd'];
	$new_pwd = $_POST['new_pwd'];
	$con_pwd = $_POST['con_pwd'];
	
	$quer=leo_mysql_query("select * from user where password='$old_pwd' and costomer_id='$cos_id'");
	$fet=leo_mysql_fetch_array($quer);
	$num=leo_mysql_num_rows($quer);
	if($num>0)
	{
		$quer2=leo_mysql_query("select * from user where password='$old_pwd' and costomer_id='$cos_id'");
		$res = leo_mysql_fetch_assoc($quer2);
		if(md5($res['password'])==md5($old_pwd))
		{	
				
			if($new_pwd==$con_pwd)
			{
				$qq=leo_mysql_query("update user set password='$new_pwd' where costomer_id='$cos_id'");
				if($qq)
				{
					$_SESSION['SUCMSG'] = 'Your password has been changed successfully';
				}
			}
			else
			{	$_SESSION['ERRMSG'] = 'Passwords are not matching';	}
		}
		else
		{ 	$_SESSION['ERRMSG'] = 'Invalid old password'; } 
	}
	else
	{ 	$_SESSION['ERRMSG'] = 'Invalid old password'; } 
	
	session_write_close();
	header("Location: ./?p=pwd");
	exit(); 
}
?>
<html>
<head>
<title>-:: Leo Group - The Leaders in Logistics ::-</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../leo.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body{		background: url(../images/main_bg.jpg) #2E88BD; width:100%;	background-repeat: repeat-x;	font-family:Arial, Helvetica, sans-serif; }
a:link{		text-decoration: none;	color: #006699;	}
a:visited{	text-decoration: none;	color: #006699;	}
a:hover{	text-decoration: none;	}
a:active{	text-decoration: none;	}
-->
</style>
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
function delete_mail(val)
{
	var str = 'inbox<?php if(isset($_GET['page']))echo '&page='.$_GET['page']; ?>&delete='+val;
	if(confirm('Are you Sure! '+"\n"+'Do you want delete this message ? '))
	{	goto_href(str); }
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"><table id="Table_01" width="1000"  border="0" cellpadding="0" cellspacing="0">
        <tr class="noprint">
          <td colspan="16"><img src="../images/user_page.jpg" alt="" width="1000" height="100" border="0" usemap="#Map">
            <map name="Map">
              <area shape="rect" coords="455,69,511,92" target="_blank" href="../profile.html">
              <area shape="rect" coords="532,72,597,93" target="_blank" href="../service.html">
              <area shape="rect" coords="623,72,695,95" target="_blank" href="../group.html">
              <area shape="rect" coords="714,69,819,97" target="_blank" href="../infrastructure.html">
              <area shape="rect" coords="836,71,919,95" target="_blank" href="../management.html">
              <area shape="rect" coords="888,16,937,37" target="_blank" href="../index.html">
              <area shape="rect" coords="790,19,862,38" href="?logout">
            </map></td>
        </tr>
        <tr class="noprint">
          <td rowspan="4" valign="top"><img src="../images/index_n_02_sub.jpg" width="33" height="480" alt=""></td>
          <td rowspan="4" valign="top" bgcolor="#4795C5"><img src="../images/index_n_03.jpg" width="9" height="480" alt=""></td>
          <td colspan="12" bgcolor="#296C96"><img src="../images/index_n_04.jpg" width="917" height="5" alt=""></td>
          <td><img src="../images/index_n_05.jpg" width="13" height="5" alt=""></td>
          <td><img src="../images/index_n_06.jpg" width="28" height="5" alt=""></td>
        </tr>
        <tr class="noprint">
          <td><img src="../images/index_n_07.jpg" width="14" height="206" alt=""></td>
          <td colspan="10" align="center" background="../images/top_duc_bg.jpg"><table class="noprint" width="888" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="220" height="160" valign="top" align="left">
                <style>
					.user_btns{ background:url(../admin/theme/images/btn.gif); height:30px; margin-top:3px; cursor:pointer; text-align:center;
						color:#FFFFFF; font-size:12px; font-weight:bold; line-height:27px; border:#fff 1px solid;  }
					#user_tabs div:hover, #hover_btns div:hover{color:#000099; background:url(../admin/theme/images/btnovr.jpg);
					-moz-box-shadow: 2px 2px 2px #000099;  -webkit-box-shadow:2px 2px 2px #ccc;  box-shadow: 2px 2px 2px #ccc;}
					#sel_div { color:#000099; background:url(../admin/theme/images/btnovr.jpg);
					-moz-box-shadow: 2px 2px 2px #000099;  -webkit-box-shadow:2px 2px 2px #ccc;  box-shadow: 2px 2px 2px #ccc;}
					#h_rows:hover{ background:#EBEBEB; cursor:default; }
				</style>  
                <script type="text/javascript">	function goto_href(val){ window.location.href='?p='+val;}</script>             
                <div id="user_tabs" style="width:200px;">
                	<div onClick="goto_href('ledger');" <?php select_tab($pg,'ledger'); ?> class="user_btns">My Ledger</div>
                    <div onClick="goto_href('inbox');" <?php select_tab($pg,'inbox'); ?> class="user_btns">Inbox</div>
                    <div onClick="goto_href('compose');" <?php select_tab($pg,'compose'); ?> class="user_btns">Compose mail</div>
                    <div onClick="alert('This Facility not available !');" <?php /*onClick="goto_href('sms');" select_tab($pg,'sms');*/ ?> class="user_btns">Compose SMS</div>
                    <div onClick="goto_href('pwd');" <?php select_tab($pg,'pwd'); ?> class="user_btns">Change Password</div>
                              </td>
                <td align="center" width="418"  style="font-size:12px;">
            
			<?php
		   $qry_cust = "select * from costomer where costomer_id='$cos_id'";
		   $cust_res = leo_mysql_query($qry_cust);
		   $customer = leo_mysql_fetch_assoc($cust_res);
			
			echo '<div style="height:175px; overflow:auto; vertical-align:middle;">
			<table width="100%" height="100%" border="0">
			<tr><th>
			
			<table class="prof_head" width="100%" style="vertical-align:middle" border="0">
			<tr><th style="font-size:14px;"> Company </th><th style="width:2px;"> : </th>
			<td style="font-size:14px;">'.$customer["company"].'</td></tr>
			<tr><th>Customer Id </th><th style="width:2px;"> : </th>
			<td> '.$customer["costomer_id"].' </td></tr>			
			<tr><th> Contact Person </th><th style="width:2px;"> : </th>
			<td>'.$customer["contact_person"].'</td></tr>
			<tr><th> Address </th><th style="width:2px;"> : </th>
			<td>'.$customer["address"].'</td></tr>
			<tr><th> E-mail </th><th style="width:2px;"> : </th>
			<td>'.$customer["email_id"].'</td></tr>			
			<tr><th> Phone No </th><th style="width:2px;"> : </th>
			<td>'.$customer["phone_no"].' </td></tr></table>
			
			</th></tr></table></div>';

				
				 ?></td>
                <td><table width="230" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center"><img src="../images/side_menu.gif" width="233" height="180" border="0" usemap="#Map3"></td>
                    </tr>
                </table></td>
              </tr>
            </table>
              <map name="Map2">
                <area shape="rect" coords="90,19,196,32" href="../functionality.html">
                <area shape="rect" coords="91,40,209,54" href="../productcatalog.html">
                <area shape="rect" coords="91,63,187,77" href="../newsevents.html">
                <area shape="rect" coords="91,84,193,99" href="../photogallery.html">
                <area shape="rect" coords="92,106,148,121" href="../enquiry.html">
                <area shape="rect" coords="91,126,169,142" href="../contactus.html">
                <area shape="rect" coords="92,151,180,167" href="../tellafriend.html">
              </map>          </td>
          <td><img src="../images/index_n_09.jpg" width="8" height="206" alt=""></td>
          <td rowspan="3" valign="top" bgcolor="#368DC3"><img src="../images/index_n_10.jpg" width="13" height="475" alt=""></td>
          <td rowspan="4" valign="top" style="background:url(../images/index_n_11.jpg) no-repeat #2C87C0;">&nbsp;</td>
        </tr>
        <tr class="noprint">
          <td><img src="../images/index_n_12.jpg" width="14" height="8" alt=""></td>
          <td colspan="9" background="../images/index_n_12.jpg"><img src="../images/index_n_12.jpg" width="14" height="8" alt=""></td>
          <td colspan="2" bgcolor="#2A85BC"><img src="../images/index_n_14.jpg" width="13" height="8" alt=""></td>
        </tr>
        <tr>
          <td class="noprint" valign="top" bgcolor="#90C0D7"><img src="../images/index_n_15.jpg" width="14" height="261" alt=""></td>
          <td colspan="8" align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_bg">
            <tr>
              <td width="9" class="noprint" valign="top" style="border-left:#62A3C9 1px solid; background:#93C1D9;"><img src="../images/index_n_24_l.jpg" width="9" height="261">               </td>
              <td valign="top"><table width="871" border="0" cellspacing="0" cellpadding="0">
                <tr class="noprint">
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td><table width="870" border="0" cellspacing="0" cellpadding="0">
                  <tr><td class="print_bg" style="background:url(../images/index_n_74.jpg) repeat-x #93C1D9;">
       <?php 
	   
	   if(isset($_SESSION['ERRMSG'])) {echo '<div class="red">'.$_SESSION['ERRMSG'].'</div>';  unset($_SESSION['ERRMSG']); }
	   if(isset($_SESSION['SUCMSG'])) {echo '<div class="green">'.$_SESSION['SUCMSG'].'</div>'; unset($_SESSION['SUCMSG']); }
   
	   if($pg == 'ledger'){ require_once('ledger.php'); }
	   else if($pg == 'inbox'){ require_once('inbox.php'); }
	   else if($pg == 'mail'){ require_once('ledger.php'); }
	   else if($pg == 'sms'){ require_once('ledger.php'); }
	   else if($pg == 'pwd'){ require_once('settings.php'); }
	   else if($pg == 'msg'){ require_once('read_msg.php'); }
	   else if($pg == 'compose'){ require_once('compose.php'); }
	   else { require_once('ledger.php'); }	  	   
      
	   ?>
                  </td></tr>                    
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          <td valign="top" bgcolor="#92C0D7" class="noprint"  style="border-right:#62A3C9 1px solid; "><img src="../images/index_n_24.jpg" width="9" height="261" alt=""></td>
          <td colspan="2" class="noprint" valign="top" bgcolor="#8EBED5"><img src="../images/index_n_15_l.jpg" width="14" height="261"></td>
        </tr>        
        <tr class="noprint">
          <td bgcolor="#2887BF">&nbsp;</td>
          <td><img src="../images/underleft.jpg" width="9" height="45" alt=""></td>
          <td colspan="12" align="center" background="../images/key_bottom.jpg"><span class="run_small"><a target="_blank" href="http://webmail.leogroup.in">Check Mail </a>| Disclaimer | Copyright &copy; 2008 www.leogroup.in Developed &amp; Maintained by <a target="_blank" href="http://www.programmersglobal.com" class="links">PROGRAMERS</a></span></td>
          <td style="background:#368DC3;"></td>
          </tr>
        <tr>
          <td><img src="../images/spacer.gif" width="33" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="9" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="14" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="293" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="10" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="8" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="276" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="10" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="10" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="9" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="265" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="9" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="5" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="8" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="13" height="1" alt=""></td>
          <td><img src="../images/spacer.gif" width="28" height="1" alt=""></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>

<map name="Map3">
<area shape="rect" coords="96,36,223,56" target="_blank" href="../productcatalog.html">
<area shape="rect" coords="97,66,205,84" target="_blank" href="../photogallery.html">
<area shape="rect" coords="99,95,183,115" target="_blank" href="../enquiry.html">
<area shape="rect" coords="97,125,189,143" target="_blank" href="../contact.html">
</map>

</body>
</html>