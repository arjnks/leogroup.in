<?php
if(isset($_POST['login']))
{
 $username=clean($_POST['username']);
 $password=clean($_POST['password']);
 $captcha=$_POST["captxt"];


	if($username=='' && $password=='' && $captcha=='')
	{$error[]="Please fill all fields";}
	else
	{
	 if($username==''){$error[]="Please type Username";}
	 if($password==''){$error[]="Please type Password";}
	 if($captcha==''){$error[] = 'Please fill captcha';}
	 else
	 {
		if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captxt'])) != $_SESSION['captcha']) 
		{$error[] = "Invalid captcha";}
	 }
	 }
 
 if($error)
 {
 $_SESSION['AERRMSG']=$error;
 session_write_close() ;
 header("location: ./");
 }
 else
 {
		$qry="SELECT * FROM login WHERE `user_name`='$username' AND `pass`='".md5($password)."'";
		$result=leo_mysql_query($qry);
		
		//Check whether the query was successful or not
		if($result) 
		{
		
			if(leo_mysql_num_rows($result) == 1) 
			{
				//Login Successful
				$rows=leo_mysql_fetch_array($result);
				session_regenerate_id();
				$_SESSION['adminlogin'][0] = "true";
				$_SESSION['adminlogin']['id']=$rows['id'];
				$_SESSION['adminlogin']['user_name']=$rows['user_name'];	
				session_write_close();
				header("Location: ./");
				exit();
				}
			else 
				{
				//Login failed
					$_SESSION['ERRMSG'] = 'Invalid username or passowrd ,please try again';
					session_write_close();
					header("Location: ./");
					exit();
				}
		}
		else
		 {
				$_SESSION['ERRMSG'] = 'Error : '.leo_mysql_error();
				session_write_close();
				header("Location: ./");
				exit();
		}
 }
 }

$pagename="Login - ";
include('./theme/header.php'); ?>
<div style="margin-top:75px; color:#FFFFFF; ">
<fieldset class="login" style=""><legend>&nbsp;&nbsp;Login&nbsp;</legend>
<div class="logfrm">
Please fill the following.
<?php msgs();?>
<form method="post" action="">
<table cellpaddin="0" cellspacing="2" style="margin:5px;background:#85A9B7; padding:5px;">
<tr><th><label>user name : </label></th><td><input type="text" name="username"  value="" class="textbox"></td></tr>
<tr><th><label>Password : </label></th><td><input type="password" name="password" value=""  class="textbox" ></td></tr>
<tr><th><span class="mand">*</span><label>Confirmation Code</label> </th><td >
<?php
/*$resp = null;
$error = null;
echo recaptcha_get_html($publickey, $error);
*/
?>
<img src="captcha/captcha.php" title="Change Image" id="captcha" /><br />
<table style="margin-left:-2px;"><tr><td><input name="captxt" type="text"  class="textboxc" /></td><td>
<a href="#" onclick="
    document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
    document.getElementById('captcha-form').focus();"
    id="change-image"><img border="0" src="captcha/refresh.png" /></a></td></tr></table>
</td></tr>
<tr><td height="32"></td>
<td><input type="submit" value="Ok" name="login" class="button"></td></tr>
</table>
</form></div>
</fieldset>
</div>
<br />
<?php include('./theme/footer.php'); ?>
