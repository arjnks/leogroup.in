<?php

#------------------------------------- /change password ---------------------------------------->
if(isset($_POST['changepassword']))
{
$op=$_POST['op'];
$np=$_POST['np'];
$cnp=$_POST['cnp'];

if($op=='' && $np=='' && $cnp==''){ $error[]="Please fill all fields"; }
	else
	{
		if($op==''){$error[]="Please enter old password"; }
		else if($op!='')
			{
				$qry="SELECT * FROM  login  WHERE  `pass`='".md5($op)."' " ;
				$result=leo_mysql_query($qry);
				if($result) 
				{ 
				if(leo_mysql_num_rows($result) == 0) 
					{
					$error[]="Please enter valid old password"; 
					}	
				}
			}
		
		if($np==''){$error[]="Please enter new password"; }
		if($cnp==''){$error[]="Please confirm new password"; }
		if($np && $cnp)
		{
		if(strcmp($np,$cnp)!=0)
			{
			$error[]="Passwords not matching";
			}
		}
	}
	
	if($error)
	{
	$_SESSION['AERRMSG'] = $error;
	session_write_close();
	header("Location: ./?p=settings&tab=changepwd");
	exit();
	}
	else
	{
	$qry="UPDATE login SET `pass`='".md5($cnp)."' WHERE  `pass`='".md5($op)."' LIMIT 1";
	$result=leo_mysql_query($qry);
	if($result) 
		{ 
		$_SESSION['SUCMSG'] = "Password changed successfully.";
		//unset($_SESSION['adminlogin']);
		header("location: ./?p=settings&tab=changepwd");
		exit();
		}
	else	
		{
		$_SESSION['ERRMSG'] = "Error: ".leo_mysql_error();
		header("location: ./?p=settings&tab=changepwd");
		exit();
		}

	}
}
#------------------------------------- /change password ---------------------------------------->



$pagename="Settings - ";
include('./theme/header.php');?>
<h1>Settings</h1>
<!-- Opening <div left>-->
<div id="leftbar">
<ul>
<li><a href="./?p=settings&tab=changepwd" <?php activelink('changepwd'); ?> >Change Password</a></li>
</ul>
</div>
<!-- closing <div left>-->
<!-- Opening <div content>-->
<div id="content">

<?php if(isset($_GET['tab']) && $_GET['tab']=='changepwd') {?>
<fieldset class="addchitty"><legend>Change Password</legend>
<?php msgs(); ?>
<form method="post" action="" class="members">
<table width="674" cellpadding="0" cellspacing="1">
<tr><th>Old password:</th><td><input type="password" value="" name="op" class="textbox"></td></tr>
<tr><th>New password:</th><td><input type="password" value="" name="np" class="textbox"></td></tr>
<tr><th>Confirm password:</th><td><input type="password" value="" name="cnp" class="textbox"></td></tr>
<tr><td></td><td><input type="submit" value="Change" name="changepassword" class="button"></td></tr>
</table>
</form>

</fieldset>
<?php } ?>
</div>
<?php include('./theme/footer.php');?>
