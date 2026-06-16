<?php
session_start();
require_once('../admin/system/config.php'); 
require_once('../admin/system/functions.php'); 
if(isset($_POST['uname']))
{ 

//echo "su";
	$uname = clean($_POST['uname']);
	$pwd = clean($_POST['pwd']);
	$captxt = $_POST['captxt'];
	
	
	
		$quer=leo_mysql_query("select * from user where costomer_id='$uname' and password='$pwd' and status=1");
		//echo "select * from user where costomer_id='$uname' and password='$pwd' and status=1";
		//exit;
		$num=leo_mysql_num_rows($quer);
		if($num>0)
		{
			$res = leo_mysql_fetch_assoc($quer);
			if(md5($res['password'])==md5($pwd))
			{
				session_regenerate_id();
				$_SESSION['co_id'] = $uname;
				session_write_close();
				header("location:./");
			}
			else{ header("location:../"); }
		}
		else
		{
			header("location:../");
		}
	
}
else if(isset($_GET['forgot_mail']))
{
	$forgot_mail=$_GET['forgot_mail'];
	$cpt=$_GET['cpt'];
	if($cpt!=$_SESSION['security_number']) 
	{ 
		echo 'error';
	}
	else
	{
		$quer=leo_mysql_query("select * from user where email='$forgot_mail' and status=1");
		$num=leo_mysql_fetch_assoc($quer);
		if(!$num)
		{
			$quer22=leo_mysql_query("select costomer_id from costomer where email_id='$forgot_mail' and status=1");
			$num22=leo_mysql_fetch_assoc($quer22);
			
			$quer=leo_mysql_query("select * from user where costomer_id='".$num22['costomer_id']."' and status=1");
			$num=leo_mysql_fetch_assoc($quer);
		}
		if($num)
		{
			$subject = "Here's your password : From LEO GROUP";
			$mailfrom = $companymail;
			
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: ". $mailfrom."\r\n";
			$headers .= "";
			
			$mailbody= '<h2 style="color:#0033CC;">Reset Password</h2>
			<div style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
			<p>Dear Sir/Madam,     <br />  <br /> 
			Your Account details are as follows: </p>
			<p>Customer id : '.$num['costomer_id'].' </p>
			<p>Password: '.$num['password'].' </p>
			<p>&nbsp;</p>
			<p>Further any assistance dont hesitate to email or call us :  <br>
			Ph: '.$company_phone.' <br>
			E-mail : '.$companymail.' <br>
			<a href="http://'.$sitename.'" target="_blank">'.$sitename.'</a> </p>
			</div>';
			
			$a=@mail($forgot_mail,$subject,$mailbody,$headers);
			if($a) { echo 1; }
			else { echo 'mail faild'; }
		}
		else
		{
			echo 'not exists';
		}
	}
}
else if(isset($_GET['new_log']))
{
	$cus_id=$_GET['new_log'];
	$cpt=$_GET['cpt'];
	if($cpt!=$_SESSION['security_number']) 
	{ 
		echo 'error';
	}
	else
	{
		$quer=leo_mysql_query("select * from user where costomer_id='$cus_id' and status=1");
		$num=leo_mysql_fetch_assoc($quer);
		if($num)
		{
			if($num['email']!='')
			{
				$subject="Welcome to Leogroup";
				$mailfrom=$companymail;
				
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: ". $mailfrom."\r\n";
				$headers .= "";
				
				$mailbody= '<h2 style="color:#0033CC;">Welcome to leogroup.in</h2>
				<div style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
				<p>Dear Sir/Madam,     <br />  <br /> 
				Your Account details are as follows: </p>
				<p>Customer id : '.$num['costomer_id'].' </p>
				<p>Password: '.$num['password'].' </p>
				<p>&nbsp;</p>
				<p>Further any assistance dont hesitate to email or call us :  <br>
				Ph: '.$company_phone.' <br>
				E-mail : '.$companymail.' <br>
				<a href="http://'.$sitename.'" target="_blank">'.$sitename.'</a> </p>
				</div>';
				
				$a=@mail($num['email'],$subject,$mailbody,$headers);
				if($a) { echo 1; }
				else if($num['mobile']=='') { echo 'mail faild'; }
			}
			/*if($num['mobile']!='')
			{
				$sms_txt="Please notedown your security password for Leogroup.in members login - Customer id : ".$num['costomer_id'].", Password : ".$num['password'].", for any assistance please contact us : ".$company_phone;
				$s=sendsms_acc($num['mobile'],$sms_txt,$smsusername,$smspassword,$smssender,$smsdomain,$priority);
				if($s!=0)
				{ echo '2'; }
				else if($num['email']=='') { echo 'sms faild'; }
				else { echo 'faild all'; }
			}*/
			else
			{ echo 'empty'; }
		}
		else
		{
			echo 'not exists';
		}
	}
}
?>