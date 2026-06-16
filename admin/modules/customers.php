<?php 
// -------- send mail ----------------- 
function send_pwd_mail($company_mail,$message,$to)
{
	
	$mailto=$to;
	$subject="Welcome to Leogroup";
	$mailfrom=$company_mail;	
	
	/////////////////////
	$to=$email;
	$subject="Account password [ www.leogroup.in ]";
	$header = "From:".$companymail;
	$header .= "\nMIME-Version: 1.0";
	$header .= "\nContent-Type: multipart/alternative;";
	$header .= "\n    boundary=\"----=_NextPart_$theboundary\"";
	$header .= "\nX-Priority: 3";
	$header .= "\nX-MSMail-Priority: Normal";
	$body = "This is a multi-part message in MIME format.\n\n";
	$body .= "------=_NextPart_".$theboundary."\nContent-Type: text/plain;\n\n";
	$body .= "\n------=_NextPart_".$theboundary."\nContent-Type: text/html;\n\n";
	$body .= 'You are successfully registerd with leogroup.in .<br /> Your account default password is : <b> '.$password.'</b><br />
	Please login right now and change your password.<hr> Click here to <a href="http://www.leogroup.in" target="_blank" >login</a> to leogroup.in';
	$mail=mail($to, $subject, $body, $header);
	///////////////////////////////////
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: ".$mailfrom."\r\n";
	$headers .= "";
	
	$mailbody= $message;
	
	$a=@mail($mailto,$subject,$mailbody,$headers);
}
// -------- pwd ------------------------ 
function pas_user($v)
{
	$qry=leo_mysql_query("select * from  user where costomer_id='$v'");
	$res=leo_mysql_fetch_assoc($qry);
	if($res)
	{ return $res['password']; }
	else
	{ return ''; }
}

// ----- password generatw function -----------
function createRandomPassword() 
{
	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '';
	while ($i <= 7)
	{	
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$pass = $pass.$tmp;
		$i++;
	}
	return $pass;
}
// ----- upload customer table to database ------------ >

if(isset($_POST['sub_customer'])) 
{
	 if($_FILES['customer_file']['name']==''){ $error[] = "Please upload the file"; }
     else if($_FILES['customer_file']['type']!='text/plain') { $error[] = "Please upload only text files"; }
	 else if($_FILES['customer_file']['name']!='customer.txt' && $_FILES['customer_file']['name']!='CUSTOMER.TXT') { $error[] = "Please upload customer.txt file"; }
	
	if($error)
	{
		$_SESSION['AERRMSG']=$error;
		session_write_close();
		header("location:  ./?p=customers&tab=");
		exit();
	}
	else
	{$cust_ids ='';
		
		$target_path="upload/".$_FILES["customer_file"]["name"];
		 move_uploaded_file($_FILES["customer_file"]["tmp_name"],"upload/".$_FILES["customer_file"]["name"]);
		$lines = file($target_path, FILE_SKIP_EMPTY_LINES);
		
		$qline =''; $c='';
		foreach ($lines as $line)
		{
			$qarr=explode(',',$line);

                        
			if(6== count($qarr))
			{	
				$c_id = clean($qarr[0]);
				$d1=clean($c_id[1]);
				$d2=clean($qarr[2]);
				$d3=clean($qarr[3]);
				$d4=clean($qarr[4]);
				$d5=clean($qarr[5]);
				
				$cust_ids .= "'$c_id',";
				
				$qline.=$c.'("'.$c_id.'","'.$d1.'","'.$d2.'","'.$d3.'","'.$d4.'","'.$d5.'",0)';
				$c=',';
			}
		}
		if($qline!='')
		{ 
		
			$que=leo_mysql_query("DELETE FROM costomer"); 
			$sql = "insert into costomer values ".$qline;
			$ins=leo_mysql_query($sql);
			
			/*foreach($cust_ids as $c_id)
			{
				
				$quu=leo_mysql_query("select status from user where costomer_id='$c_id'");
				$r=leo_mysql_fetch_assoc($quu);
				if($r)
				{
					$rr=leo_mysql_query("update costomer set status='".$r['status']."' where costomer_id='$c_id'");
				}
			}*/
			$cust_ids = rtrim($cust_ids,',');
			$quu=leo_mysql_query("select costomer_id,status from user where costomer_id in ($cust_ids)");
			while($r=leo_mysql_fetch_assoc($quu))
			{
				$rr=leo_mysql_query("update costomer set status='".$r['status']."' where costomer_id='".$r['costomer_id']."'");
			}
				
			
			if($ins)
			{
				$_SESSION['SUCMSG']=" Customer datas has been sucessfully Uploaded ";
				session_write_close();
				header("location:  ./?p=customers&tab=");
				exit();
			}
			else
			{
				$_SESSION['ERRMSG']=leo_mysql_error();
				session_write_close();
				header("location:  ./?p=customers&tab=");
				exit();
			}
		}
		else
		{
			$_SESSION['ERRMSG']= 'Please check the text file';
			session_write_close();
			header("location:  ./?p=customers&tab=");
			exit();
		}
	}
}

### -------------- Send user name and password to users MAIL --------------- >
if(isset($_POST['send_mail_user']))
{
	$to_mail=$_POST['to_mail'];
	$mail_txt = '<h2 style="color:#0033CC;">Welcome to leogroup.in</h2> <br>
	<pre style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">'.$_POST['mail_txt'].'</pre>
	<br><br><p>Further any assistance dont hesitate to email or call us :  <br>
	Ph: '.$company_phone.' <br>
	E-mail : '.$companymail.' <br>
	<a href="http://'.$sitename.'" target="_blank">'.$sitename.'</a>';
	
	$sub='Leogroup.in - Login Password';
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: ".$companymail."\r\n";
	$headers .= "";
	
	$a=@mail($to_mail,$sub,$mail_txt,$headers);
	if($a)
	{ 
	$qry="insert into `customer_mail` (`mid`,`mailto`,`mail_txt`,`status`) values ('','".$to_mail."','".$mail_txt."','1')";
	leo_mysql_query($qry);
	$_SESSION['SUCMSG']=$idcount.' Mail has been send successfully'; }
	else 
	{ 
	$qry="insert into `customer_mail` (`mid`,`mailto`,`mail_txt`,`status`) values ('','".$to_mail."','".$mail_txt."','0')";
	leo_mysql_query($qry);
	$_SESSION['ERRMSG']='You Canot Send mail at this time'; }
	session_write_close();
	header("Location: ?p=customers&tab=find&cust_txt=".$_GET['cust_txt']);
	exit();	
}
### -------------- Send user name and password to users SMS --------------- >
if(isset($_POST['send_cus_sms']))
{	
	$mobile=$_POST['mobile']; 
	$sms_txt=$_POST['sms_txt']; 
	
	$s=sendonesms($mobile,$sms_txt,$smsusername,$smspassword,$smssender,$smsdomain,$priority);
	if($s)
	{ 
	$qry="insert into `customer_sms` (`sid`,`smsto`,`sms_txt`,`status`) values ('','".$mobile."','".$sms_txt."','1')";
	leo_mysql_query($qry);
	$_SESSION['SUCMSG']=' SMS has been send successfully'; } 
	else 
	{ 
	$qry="insert into `customer_sms` (`sid`,`smsto`,`sms_txt`,`status`) values ('','".$mobile."','".$sms_txt."','0')";
	leo_mysql_query($qry);
	$_SESSION['ERRMSG']='You Canot Send SMS at this time'; } 
	session_write_close(); 
	header("Location: ?p=customers&tab=find&cust_txt=".$_GET['cust_txt']); 
	exit();	
} 
### ----------------------- Verification ------------------------------ > 
if(isset($_POST['verify_all'])) 
{ 
	$reurl=$_POST['reurl']; 
	$idcount=0;
	$result = leo_mysql_query("SELECT costomer_id,email_id,phone_no FROM costomer where status=0"); 
	while($row = leo_mysql_fetch_array($result)) 
	{ 
		$c=$row['costomer_id']; 
		$mail=$row['email_id'];
		$phone_no=$row['phone_no'];
		$usr_t=leo_mysql_query("select status from user where costomer_id='$c'");
		$reg_us=leo_mysql_fetch_assoc($usr_t);
		if($reg_us)
		{
			leo_mysql_query("update costomer set status='".$reg_us['status']."' where costomer_id='$c'");
		}
		else
		{
			$password = createRandomPassword();
			$sql="INSERT INTO user VALUES ('$c','$mail','$phone_no','$password',1)";
			$ins=leo_mysql_query($sql);
			if($ins)
			{
			$tt="update costomer set status='1' where costomer_id='$c'";
			$updt=leo_mysql_query($tt);
			$idcount++;
			}
		}
	}

		if($updt)
		{
		$_SESSION['SUCMSG']=$idcount.' Customers Password has been Generated Successfully';
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
		else
		{
		$_SESSION['ERRMSG']=leo_mysql_error();
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
}
if(isset($_POST['generate']))	
{
	$ids=$_POST['checkbox'];
	$idcount=count($_POST['checkbox']);
	$reurl=$_POST['reurl'];
	if($idcount=='' || $idcount==0)
	{
		$_SESSION['ERRMSG']='Please Select a Customer';
		session_write_close();
		header("Location: ".$reurl);
		exit();
	}
	else
	{
		for($i=0;$i<$idcount;$i++)
		{
			$result = leo_mysql_query("SELECT costomer_id,email_id,phone_no FROM costomer WHERE costomer_id='$ids[$i]'");
			$row = leo_mysql_fetch_assoc($result);
			$c=$row['costomer_id'];
			$d=$row['email_id'];
			$phone_no=$row['phone_no'];
			
			$password = createRandomPassword();
			$sql="INSERT INTO user VALUES ('$c','$d','$phone_no','$password',1)";
			$ins=leo_mysql_query($sql);
			if($ins)
			{
			$tt="update costomer set status='1' where costomer_id='$c'";
			$updt=leo_mysql_query($tt);
			}
		}
		if($updt)
		{
		$_SESSION['SUCMSG']=$idcount.' Customers Password has been Generated Successfully';
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
		else
		{
		$_SESSION['ERRMSG']=leo_mysql_error();
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
	}
}

## --------------------------------------------------------------->

#------------------------------------ update  customers------------------------->
if(isset($_POST['updatecustomer']))
{

$mobile=$_POST['mobile'];
$email=$_POST['email'];
$status=$_POST['status'];
$reurl=$_POST['reurl'];

$costomer_id=$_POST['costomer_id'];

	if($error)
	{
		$_SESSION['AERRMSG']=$error;
		$_SESSION['mobile']=$mobile;
		$_SESSION['email']=$email;
		$_SESSION['status']=$status;

		session_write_close();
		header("Location: ./?p=customers&edit=".$costomer_id);
		exit();
	}
	else
	{
	$qry = "update `user` set `email`='$email',`mobile`='$mobile',`status`='$status' where `costomer_id`='$costomer_id'";
	$qry2 = "update `costomer` set `status`='$status' where `costomer_id`='$costomer_id'";
	$result = @leo_mysql_query($qry);
	$result2 = @leo_mysql_query($qry2);
	
		if($result && $result2)//if success
		    {$_SESSION['SUCMSG']='A customer details  has been successfully updated';
		    session_write_close();
		    header("Location: ./?p=customers");
		    exit(); }
		 else
		    {$_SESSION['ERRMSG']='ERROR: '.leo_mysql_error();
		    session_write_close();
		    header("Location: ".$reurl);
		    exit();}#ending update
	}#end post update cust

}



if(isset($_GET['delete']))
	{
$id=$_GET['delete'];

	$qry = "DELETE  FROM costomer WHERE costomer_id='$id' ";

	 $result = @leo_mysql_query($qry);
	 leo_mysql_query("DELETE  FROM user WHERE costomer_id='$id' ");
	 
		if($result )//if success
		    {$_SESSION['SUCMSG']='A customer details  has been successfully deleted';
		    session_write_close();
		    header("Location: ./?p=customers");
		    exit(); }
		 else
		    {$_SESSION['ERRMSG']='Invalid id';
		    session_write_close();
		    header("Location: ./?p=customers");
		    exit();}#ending update
		}#end post delete cust

#------------------------------------ /add,delete,update  customers ------------------------->



// --------------------- Chittilist  ------------------- //
function chitlist()
{
$qry = "SELECT * FROM `chitty_mst`  WHERE status!='closed' and  status!='new' and  status!='hidden' ORDER BY `chitty_no` DESC ";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($chits=leo_mysql_fetch_array($result))
			{
			if (isset($_SESSION['chitty_no']) && $_SESSION['chitty_no']==$chits['chitty_no'])  {$select=' selected '; unset($_SESSION['chitty_no`']);} else {$select="";}
			echo '
				<option '.$select.' value="'.$chits['chitty_no'].'">['.$chits['chitty_no'].'] '.$chits['chitty_name'].'</option>	
				';
			$i=$i+1;
			}
				
		}
	}
	}
// --------------------- /chittilist  ------------------- //

// --------------------- customers  ------------------- //
function customers()
{
$qry="SELECT *  FROM customer_mst  order by customer_name  ASC";
$result = @leo_mysql_query($qry);
	if($result)
	{
	while($cust=leo_mysql_fetch_array($result))
			{
		if (isset($_SESSION['cust_id']) && $_SESSION['cust_id']==$i)  {$select=' selected '; unset($_SESSION['cust_id']);} else {$select="";}
		echo '
		<option ' .$select.'   value="'.$cust['id'].'">'.$cust['customer_name'].' - '.$cust['reg_no'].'</option>
		';	
		}
	}
}

// --------------------- /customers  ------------------- //
// -------------Clear all Unsented Emails----------------//
if(isset($_POST['clear_unsentedmail']))
{
$qry=leo_mysql_query("delete from customer_mail where status='0'");
if($qry)
	{
	$_SESSION['SUCMSG']='All Unsent mails hasbeen deleted';
	session_write_close();
	header("Location: ./?p=customers&tab=unsentmails");
	exit(); 
	}
}
// -------------Clear all Unsented Emails----------------//
// -------------Clear all sented Emails----------------//
if(isset($_POST['clear_sentedmail']))
{
$qry=leo_mysql_query("delete from customer_mail where status='1'");
if($qry)
	{
	$_SESSION['SUCMSG']='All Unsent mails hasbeen deleted';
	session_write_close();
	header("Location: ./?p=customers&tab=sentmails");
	exit(); 
	}
}
// -------------Clear all sented Emails----------------//
// -------------Clear all sented SMS----------------//
if(isset($_POST['clear_sentedsms']))
{
$qry=leo_mysql_query("delete from customer_sms where status='1'");
if($qry)
	{
	$_SESSION['SUCMSG']='All Unsent mails hasbeen deleted';
	session_write_close();
	header("Location: ./?p=customers&tab=sentsms");
	exit(); 
	}
}
// -------------Clear all sented SMS----------------//
// -------------Clear all Unsented SMS----------------//
if(isset($_POST['clear_unsentedsms']))
{
$qry=leo_mysql_query("delete from customer_sms where status='0'");
if($qry)
	{
	$_SESSION['SUCMSG']='All Unsent mails hasbeen deleted';
	session_write_close();
	header("Location: ./?p=customers&tab=unsentsms");
	exit(); 
	}
}
// -------------Clear all Unsented SMS----------------//
$pagename="Manage Customers - ";
include('./theme/header.php');?>
<style>.star { background:url(theme/images/ylwstar.png) repeat-x;  }</style>
<h1>Manage Customers</h1>

<!-- Opening <div left>-->
<div id="leftbar">
<ul>
<!-- <li><a href="./?p=customers&tab=new" <?php activelink('new'); ?>>New Customer</a></li> -->
<li><a href="./?p=customers&tab=" <?php activelink(''); ?>>View / Upload Customers</a></li>
<li><a href="./?p=customers&tab=g_pas" <?php activelink('g_pas'); ?>>Generate Password</a></li>
<li><a href="./?p=customers&tab=find" <?php activelink('find'); ?>>Find Customer</a></li>
<li><a href="./?p=customers&tab=sentmails" <?php activelink('sentmails'); ?>>Sent mails</a></li>
<li><a href="./?p=customers&tab=unsentmails" <?php activelink('unsentmails'); ?>>Unsent mails</a></li>
<?php /*?><li><a href="./?p=customers&tab=sentSMS" <?php activelink('sentSMS'); ?>>Sent SMS</a></li>
<li><a href="./?p=customers&tab=unsentSMS" <?php activelink('unsentSMS'); ?>>Unsent SMS</a></li></ul><?php */?>
<li><a href="javascript:alert('This Facility not available ! ');" <?php activelink('sentsms'); ?>>Sent SMS</a></li>
<li><a href="javascript:alert('This Facility not available ! ');" <?php activelink('unsentsms'); ?>>Unsent SMS</a></li></ul>

</div>
<!-- closing <div left>-->
<!-- Opening <div content>-->
<div id="content" style="">
<?php  
if(isset($_POST['send_sms_pwd']))
{ 
	$scust_id=$_POST['cust_id']; 
	$qry="SELECT * FROM costomer where costomer_id='$scust_id'"; 
	$result = @leo_mysql_query($qry); 
	$cust=leo_mysql_fetch_assoc($result); 
	
	$q_p=leo_mysql_query("select * from user where costomer_id='".$cust['costomer_id']."'"); 
	$p_usr=leo_mysql_fetch_assoc($q_p); 
	if($cust['phone_no']!='') { $phone_no=$cust['phone_no']; } else { $phone_no=$p_usr['mobile']; }
	?> 
	<form action="" method="post"  enctype="multipart/form-data"> 
	<table cellpadding="3" cellspacing="1" cellspacing="0" style="border:#CCCCCC 1px solid;width:100%;margin-bottom:5px;"> 
	<tr><th style="width:200px;">To : </th><td style="border:none;">
    <input name="mobile" class="textbox" type="text" style="width:347px;" value="<?php echo $phone_no; ?>" /></td></tr> 
	<tr><th style="width:200px;" valign="top">Message : </th><td style="border:none;">
    <textarea name="sms_txt" cols="40" class="textbox" rows="5"><?php 
	echo 'Dear '.$cust['company'].','."\n".'Your Customer id : '.$cust['costomer_id']."\n".'Password : '.$p_usr['password'];
	 ?></textarea></td></tr> 
	<tr><th style="width:200px;">&nbsp;</th><td style="border:none;">&nbsp; 
	<input name="send_cus_sms" type="submit" value="Send SMS" class="button" /></td></tr> 
	</table>
	</form>
    <?php 
}
if(isset($_POST['send_mail_pwd']))
{
	$scust_id=$_POST['cust_id']; 
	$qry="SELECT * FROM costomer where costomer_id='$scust_id'"; 
	$result = @leo_mysql_query($qry); 
	$cust=leo_mysql_fetch_assoc($result); 
	
	$q_p=leo_mysql_query("select * from user where costomer_id='".$cust['costomer_id']."'");	
	$p_usr=leo_mysql_fetch_assoc($q_p);
	if($cust['email_id']!='') { $mail=$cust['email_id']; } else { $mail=$p_usr['email']; }
	?>
	<form action="" method="post"  enctype="multipart/form-data">
	<table cellpadding="3" cellspacing="1" cellspacing="0" style="border:#CCCCCC 1px solid; width:100%; margin-bottom:5px;">
	<tr><th style="width:200px;">To : </th><td style="border:none;">
    <input name="to_mail" class="textbox" type="text" style="width:347px;" value="<?php echo $mail; ?>" /></td></tr> 
	<tr><th style="width:200px;" valign="top">Message : </th><td style="border:none;">
    <textarea name="mail_txt" cols="40" class="textbox" rows="7"><?php 
	echo 'Dear Sir/Madam, '."\n\n".'Your Account details are as follows: '."\n\n".'Your Customer id : '.$cust['costomer_id']."\n".'Password : '.$p_usr['password'];
	 ?></textarea></td></tr> 
	<tr><th style="width:200px;">&nbsp;</th><td style="border:none;">&nbsp;
	<input name="send_mail_user" type="submit" value="Send Mail" class="button" /></td></tr>
	</table>
	</form>
    <?php 
}

if(isset($_GET['tab']) && $_GET['tab']=='find')
{ ?>

    <fieldset class="result1"><legend>Search Customers</legend>
    <?php msgs(); ?>
    <form action="" method="get"  enctype="multipart/form-data">
    <input type="hidden" name="p" class="textbox" value="customers" />
    <input type="hidden" name="tab" class="textbox" value="find" />
    <table cellpadding="0" cellspacing="0">
    <tr><th style="width:250px;">Enter the Customer id or Company name : </th><td style="border:none;">
    <input type="text" name="cust_txt" class="textbox" value="<?php if(isset($_GET['cust_txt'])) echo $_GET['cust_txt']; ?>" style="width:250px;" />
    <input type="submit" value="Find" onclick="document.getElementById('hider').style.display='block';" class="button" name="find_cust" /></td>
    <td style="border:none;"><img id="hider" src="theme/images/loader.gif" style="margin-bottom:-5px; display:none; margin-left:10px;" height="20" />
    </td>
    </td></tr></table>
    </form> 
    </fieldset>

	<fieldset  class="addchitty"><legend>Customers</legend>
    <?php msgs(); 
	if(isset($_GET['cust_txt']) && $_GET['cust_txt']!='')
	{
		$find_cust=$_GET['cust_txt'];
		$qry1="SELECT COUNT(*) FROM costomer where costomer_id='$find_cust' or company LIKE '$find_cust%'";
		$result1 = @leo_mysql_query($qry1);	
		$row = mysql_fetch_row($result1); 
		$total_records = $row[0]; 
		$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> 
		<span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; No Customers found 
		 &nbsp; <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; </div>';  }
		else 
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total Customers : '.$total_records.' &nbsp;&nbsp;&nbsp; Pages : '.($next_page-1) .' / '.$total_pages.'</div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		else { 
		$pre_page = ($page-1);		 
		echo '<li><a href="./?p=customers&tab=find&cust_txt='.$find_cust.'&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		if($next_page>$total_pages){ echo "<li>Next page</li>";}
		else {	echo '<li><a href="./?p=customers&tab=find&cust_txt='.$find_cust.'&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
		$qry="SELECT * FROM costomer where costomer_id='$find_cust' or company LIKE '$find_cust%' LIMIT $start_from , $count";
		$result = @leo_mysql_query($qry);
		while($cust=leo_mysql_fetch_array($result))
		{	
			$q_p=leo_mysql_query("select * from user where costomer_id='".$cust['costomer_id']."'");	
			$p_usr=leo_mysql_fetch_assoc($q_p);
			?>
			<form action="" method="post"  enctype="multipart/form-data">
            <input name="cust_id" type="hidden" value="<?php echo $cust['costomer_id']; ?>" />
			<table cellpadding="3" cellspacing="1" cellspacing="0" style="border:#CCCCCC 1px solid; width:100%; margin-bottom:5px;">
            <tr><th style="width:200px;">Customer id : </th><td style="border:none;"><?php echo $cust['costomer_id']; ?></td></tr>
			<tr><th style="width:200px;">Company : </th><td style="border:none;"><?php echo $cust['company']; ?></td></tr>
            <tr><th style="width:200px;">Password : </th><td style="border:none;"><?php echo $p_usr['password']; ?></td></tr>
			<tr><th style="width:200px;" valign="top">Address : </th><td style="border:none;">
			<?php echo $cust['address']; ?></td></tr>
			<tr><th style="width:200px;">E-mail : </th><td style="border:none;"><?php echo $cust['email_id']; ?></td></tr>
			<tr><th style="width:200px;">Mobile : </th><td style="border:none;"><?php echo $cust['phone_no']; ?></td></tr>
            <tr><th style="width:200px;">&nbsp;</th><td style="border:none; text-align:right;">&nbsp;
            <input name="send_sms_pwd" <?php /*?>type="submit"<?php */?> type="button" onclick="alert('This Facility not available');" value="Send SMS" class="button" />
            <input name="send_mail_pwd" type="submit" value="Send Mail" class="button" /></td></tr>
			</table>
			</form>
			<?php
		}
	} ?>
    </fieldset>

<?php
}
else if(isset($_GET['tab']) && $_GET['tab']=='g_pas')
{
// password generaration view starts----------------- ?>
    <fieldset class="result1"><legend>Search Customers</legend>
    <?php msgs(); ?>
    <form action="" method="get"  enctype="multipart/form-data">
    <input type="hidden" name="p" class="textbox" value="customers" />
    <input type="hidden" name="tab" class="textbox" value="g_pas" />
    <table cellpadding="0" cellspacing="0">
    <tr><th style="width:250px;">Enter the Customer id or Company name : </th><td style="border:none;">
    <input type="text" name="cust_txt1" class="textbox" value="<?php if(isset($_GET['cust_txt1'])) echo $_GET['cust_txt1']; ?>" style="width:250px;" />
    <input type="submit" value="Find" onclick="document.getElementById('hider').style.display='block';" class="button" name="find_cust1" /></td>
    <td style="border:none;"><img id="hider" src="theme/images/loader.gif" style="margin-bottom:-5px; display:none; margin-left:10px;" height="20" />
    </td></tr></table>
    </form> 
    </fieldset>

<fieldset class="result1">
<legend>Customers ( Waiting for Password  )</legend>
<?php msgs(); ?>
<form name="form" action="" method="post">
<input type="hidden" name="reurl" value="<?php curPageUrl(); ?>">
<table cellpadding="0" cellspacing="1" width="100%">
<tr><th></th>
<th class="instno">Customer Id </th>
<th class="chittno">Company</th>
<th class="cname">Email</th>
<th class="sttno">Mobile</th>
<th class="action" style="width:45px;">Action</th> </tr><span style="background:url(theme/images/ylwstar.png); width:50px;"></span>
<?php 
if(isset($_GET['cust_txt1'])){$find_cust=$_GET['cust_txt1'];$get_det="(costomer_id='$find_cust' or company LIKE '$find_cust%') and status='0'";}
else {$get_det="status='0'";}
$qry1="SELECT COUNT(*) FROM costomer where $get_det";
//$qry1="SELECT COUNT(*) FROM costomer where status='0'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span>
		 &nbsp; No Customers found &nbsp; <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp; Result pages '.($next_page-1) .' / '.$total_pages.'
		&nbsp; Go to : <select onchange="go_topage(\'?p=customers&tab=g_pas&page=\',this.value);" style="padding:0px; width:50px; height:20px;">'; 
		 	for($pi=1;$pi<=$total_pages;$pi++) { if($page==$pi) $s='selected'; else $s=''; echo "<option $s> $pi </option>"; } echo '</select></div>';}
			 
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);	
		 if(isset($_GET['cust_txt1'])){$cust_txt1='&cust_txt1='.$_GET['cust_txt1'];}else{$cust_txt1='';} 
		 echo '<li><a href="./?p=customers&tab=g_pas&page='.$pre_page.$cust_txt1.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		if(isset($_GET['cust_txt1'])){$cust_txt1='&cust_txt1='.$_GET['cust_txt1']; }else{ $cust_txt1=''; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=g_pas&page='.$next_page.$cust_txt1.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
if(isset($_GET['cust_txt1'])){$find_cust=$_GET['cust_txt1'];$get_det="(costomer_id='$find_cust' or company LIKE '$find_cust%') and status='0'";}
else {$get_det="status='0'";}
$qry="SELECT * FROM costomer where ".$get_det." ORDER BY costomer_id DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
		{
echo '<tr>
<td style="width:20px;"><input type="checkbox" value="'.$cust['costomer_id'].'" name="checkbox[]" id="checkbox[]"></td> 
<td class="instno">'.$cust['costomer_id'].'</td> 
<td class="chittno">'.$cust['company'].'</td> 
<td class="cname">'.$cust['email_id'].'</td> 
<td class="sttno">'.$cust['phone_no'].'</td> 
<td class="prize">
<a href="./?p=customers&delete='.$cust['costomer_id'].'" onclick="return confirm(\'Are you sure ! Do you realy want to delete this ? \');" >Delete</a></td> 
</tr>';
			} 
		} 
	} 
?> 
</table> 
<br /> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr> 
<th><input type="button" onclick="marcarTodos()" value="Select all" class="button"></th> 
<th><input type="submit" name="generate" value="Generate Password" class="button"></th> 
<?php /*?><th><input type="submit" name="delete_all" value="Delete"  onclick="return confirm('Are you sure ! Do you realy want to delete this ?');" class="button"></th> <?php */?>
<th width="460" style="text-align:right;"><?php if($total_records<300) { ?>
<input type="submit" name="verify_all" value="Generate Password for All"  onclick="return confirm('Are you sure ! Do you realy want to Verify all ?');" class="button">
<?php } ?></th> 
</tr> 
</table> 
</form> 
</fieldset> 
<?php // password generaration view ends-----------------
}
else if(isset($_GET['tab']) && $_GET['tab']=='sentmails')
{
?>
<fieldset class="result1">
<legend>Sent Mails</legend> 
<?php msgs(); ?> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr><th width="19%" class="instno">Mail To</th> 
<th width="81%" class="chittno">Details</th> 
 </tr> 
<?php 

	$qry1="SELECT COUNT(*) FROM customer_mail where status='1'";
	$result1 = @leo_mysql_query($qry1);	
	$row = mysql_fetch_row($result1); 
	$total_records = $row[0]; 
	$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> 
		&nbsp;  No Mails Exists &nbsp; <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;Result pages '.($next_page-1) .' / '.$total_pages.'</div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=customers&tab=sentmails&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=sentmails&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
$qry="SELECT * FROM customer_mail  where status='1' ORDER BY mid DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
			{
echo '<tr>
<td class="instno">'.$cust['mailto'].'</td>
<td class="chittno">'.$cust['mail_txt'].'</td>
</td> 
</tr>
';
			}
		}
	}
?>
</table>

</fieldset>
<?php if(leo_mysql_num_rows($result) >0) {?>
<div style="float:left; width:75px; height:30px;  margin-left:5px;">
<form method="post"><input type="submit" name="clear_sentedmail" value="Delete All" class="button" onclick="return confirm('Do you want to clear all');"/></form></div>
<?php } ?>
<?php } 
else if(isset($_GET['tab']) && $_GET['tab']=='unsentmails')
{ ?>
<fieldset class="result1">
<legend>Unsent Mails</legend> 
<?php msgs(); ?> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr><th width="30%" class="instno">Mail To</th> 
<th width="70%" class="chittno">Details</th> 
 </tr> 
<?php 
  $qry1="SELECT COUNT(*) FROM customer_mail where status='0'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span>
		&nbsp;  No Mails Exists &nbsp; <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total Unsent Mails : '.$total_records.' &nbsp;&nbsp;&nbsp;Result pages '.($next_page-1) .' / '.$total_pages.'</div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=customers&tab=unsentmails&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=unsentmails&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
$qry="SELECT * FROM customer_mail  where status='0' ORDER BY mid DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
			{
echo '<tr>
<td class="instno">'.$cust['mailto'].'</td>
<td class="chittno">'.$cust['mail_txt'].'</td>
</tr>';
			}
		}
	}
?>

</table>
</fieldset>
<?php if(leo_mysql_num_rows($result) >0) {?>
<div style="float:left; width:75px; height:30px;  margin-left:5px;">
<form method="post"><input type="submit" name="clear_unsentedmail" value="Delete All" class="button" onclick="return confirm('Do you want to clear all');"/></form></div>
<?php } ?>
<?php } 
else if(isset($_GET['tab']) && $_GET['tab']=='sentsms')
{
?>
<fieldset class="result1">
<legend>Sent SMS</legend> 
<?php msgs(); ?> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr><th width="19%" class="instno">SMS To</th> 
<th width="81%" class="chittno">Details</th> 
 </tr> 
<?php 
  $qry1="SELECT COUNT(*) FROM customer_sms where status='1'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> No SMS Exists</div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;Result pages '.($next_page-1) .' / '.$total_pages.'</div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=customers&tab=sentsms&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=sentsms&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
$qry="SELECT * FROM customer_sms  where status='1' ORDER BY sid DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
			{
echo '<tr>
<td class="instno">'.$cust['smsto'].'</td>
<td class="chittno">'.$cust['sms_txt'].'</td>
</td> 
</tr>
';
			}
		}
	}
?>
</table>

</fieldset>
<?php if(leo_mysql_num_rows($result) >0) {?>
<div style="float:left; width:75px; height:30px;  margin-left:5px;">
<form method="post"><input type="submit" name="clear_sentedsms" value="Delete All" class="button" onclick="return confirm('Do you want to clear all');"/></form></div>
<?php } ?>
<?php } 
else if(isset($_GET['tab']) && $_GET['tab']=='unsentsms')
{
?>
<fieldset class="result1">
<legend>Unsent SMS</legend> 
<?php msgs(); ?> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr><th width="19%" class="instno">SMS To</th> 
<th width="81%" class="chittno">Details</th> 
 </tr> 
<?php 
  $qry1="SELECT COUNT(*) FROM customer_sms where status='0'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> No SMS Exists</div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.' &nbsp;&nbsp;&nbsp;Result pages '.($next_page-1) .' / '.$total_pages.'</div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);	
		 echo '<li><a href="./?p=customers&tab=unsentsms&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=unsentsms&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
$qry="SELECT * FROM customer_sms  where status='0' ORDER BY sid DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
			{
echo '<tr>
<td class="instno">'.$cust['smsto'].'</td>
<td class="chittno">'.$cust['sms_txt'].'</td>
</td> 
</tr>
';
			}
		}
	}
?>
</table>
</fieldset>
<?php if(leo_mysql_num_rows($result) >0) {?>
<div style="float:left; width:75px; height:30px;  margin-left:5px;">
<form method="post"><input type="submit" name="clear_unsentedsms" value="Delete All" class="button" onclick="return confirm('Do you want to clear all');"/></form></div>
<?php } ?>
<?php } 
else if(isset($_GET['edit'])) { ?>
<fieldset class="addchitty"><legend>Update Customer</legend>
<?php msgs();
$id=$_GET['edit'];
$qry= "SELECT * FROM user WHERE costomer_id ='$id' ";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$cust=leo_mysql_fetch_array($result)
?>
<form action="" method="post">
<input type="hidden" name="reurl" value="<?php curPageURL();?>">
<input type="hidden" value="<?php echo $cust['costomer_id']; ?>" name="costomer_id">
<table cellpadding="0" cellspacing="1" width="100%">
<tr><th><font color="#ff0000">*</font> Registration No </th><td><input name="costomer_id" value="<?php if(isset($_SESSION['costomer_id'])){echo $_SESSION['costomer_id']; unset($_SESSION['costomer_id']); } else {echo $cust['costomer_id'];} ?>" readonly="readonly" type="text" class="textbox" ></td></tr>
<tr><th> E-mail</th><td><input id="email" name="email"   value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email']; unset($_SESSION['email']); } else {echo $cust['email'];} ?>" type="text" class="textbox" ></td></tr>
<tr><th> Mobile</th><td><input name="mobile" value="<?php if(isset($_SESSION['mobile'])){echo $_SESSION['mobile']; unset($_SESSION['mobile']); } else {echo $cust['mobile'];} ?>" type="text" class="textbox" ></td></tr>
<tr><th>Status</th><td>
<select name="status" class="textbox">
<?php if(isset($_SESSION['status'])) {$status=$_SESSION['status']; unset($_SESSION['status']); } else {$status=$cust['status'];} ?>
<option <?php if($status=='1'){echo " selected "; } ?>value="1">Active</option>
<option <?php if($status=='0') {echo " selected ";} ?>value="0">Deactive</option>
</select> 
</td>
</tr>
<tr><td></td><td><input name="updatecustomer" value="Update customer" type="submit" class="button"></td>
</tr>
</table>
</form>
</fieldset>

<?php }
else {echo '<div class="warnmsg"> Invalid customer id</div>'; } 
 }} else  if(isset($_GET['tab']) && $_GET['tab']=='new') { ?>
<fieldset class="addchitty"><legend>New Customer</legend>
Please fill the following.
<?php msgs();?>
<form action="" method="post">
<table cellpadding="0" cellspacing="1" width="100%">
<tr><th><font color="#ff0000">*</font> Registration No </th><td><input name="reg_no" value="<?php if(isset($_SESSION['reg_no'])){echo $_SESSION['reg_no']; unset($_SESSION['reg_no']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font> Registration Date</th><td><input id="date" name="joindate"   value="<?php if(isset($_SESSION['joindate'])){echo $_SESSION['joindate']; unset($_SESSION['joindate']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font> Customer Name</th><td><input name="cust_name" value="<?php if(isset($_SESSION['cust_name'])){echo $_SESSION['cust_name']; unset($_SESSION['cust_name']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font> Address</th><td><textarea name="cust_add" class="textarea"><?php if(isset($_SESSION['cust_add'])){echo $_SESSION['cust_add']; unset($_SESSION['cust_add']); } else {echo '';} ?></textarea></td></tr>
<tr><th>Post</th><td><input name="post" value="<?php if(isset($_SESSION['post'])){echo $_SESSION['post']; unset($_SESSION['post']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font> Pin</th><td><input name="pin" value="<?php if(isset($_SESSION['pin'])){echo $_SESSION['pin']; unset($_SESSION['pin']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th>Country</th><td><input name="country" value="<?php if(isset($_SESSION['country'])){echo $_SESSION['country']; unset($_SESSION['country']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th>State</th><td><input name="state" value="<?php if(isset($_SESSION['state'])){echo $_SESSION['state']; unset($_SESSION['state']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th>District</th><td><input name="district" value="<?php if(isset($_SESSION['district'])){echo $_SESSION['district']; unset($_SESSION['district']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font>Phone</th><td><input name="phone" value="<?php if(isset($_SESSION['phone'])){echo $_SESSION['phone']; unset($_SESSION['phone']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th><font color="#ff0000">*</font>Mobile</th><td><input name="mobile" value="<?php if(isset($_SESSION['mobile'])){echo $_SESSION['mobile']; unset($_SESSION['mobile']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th> <font color="#ff0000">*</font>E-mail<font color="#ff0000"></font></th><td><input name="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email']; unset($_SESSION['email']); } else {echo '';} ?>" type="text" class="textbox" ></td></tr>
<tr><th>Status</th><td>
<select name="status" class="textbox">
<option <?php if(isset($_SESSION['status']) && $_SESSION['status']=='active'){echo " selected "; unset($_SESSION['status']); } else {echo '';} ?>value="active">Active</option>
<option <?php if(isset($_SESSION['status']) && $_SESSION['status']=='deactive'){echo " selected "; unset($_SESSION['status']); } else {echo '';} ?>value="deactive">Deactive</option>
</select> 
</td>
</tr>
<tr><td></td><td><input name="addcustomer" value="Add new customer" type="submit" class="button"></td>
</tr>
</table>
</form>
</fieldset>

<?php } else {  ?>
<!-- loading image -->
<div id="load" style="position:absolute;display:none;
position:fixed;   top: 0%;  left: 0%; width:100%;  height:100%;  z-index:1001;
background-color:black;  -moz-opacity:0.6;  opacity:.60; filter: alpha(opacity=60);">
<div style="background:#000000;top:30%; left:40%; position:fixed;"><img height="200" src="theme/images/loads.gif" /></div></div>
<!-- loading image -->

<fieldset class="result1"><legend>Upload Customer File</legend>
<?php msgs(); ?>
<form action="" method="post"  enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0">
<tr><th style="width:200px;"> Upload Customer file : </th><td style="border:none;">
<input type="file" name="customer_file"  class="button">
<input type="submit" value="Upload" class="button" onclick="document.getElementById('load').style.display='block';"  name="sub_customer" />
<small style="color:#0099CC; font-size:11px;">&nbsp; File Name : customer.txt</small>
</td></tr></table>
</form> 
</fieldset>

<fieldset class="result1"><legend>Customers</legend> 
<?php msgs(); ?> 
<table cellpadding="0" cellspacing="1" width="100%"> 
<tr>
<th class="instno">Customer Id </th> 
<th class="chittno">Company</th> 
<th class="cname">Email</th> 
<th class="cname">Password</th> 
<th class="sttno">Mobile</th> 
<th class="prize">Status</th> 
<th class="action" style="width:60px;">Action</th> </tr> 
<?php 
  $qry1="SELECT COUNT(*) FROM costomer";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span>
		 &nbsp; No Customers Ecixts &nbsp; <span class="star"> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;</span> &nbsp; </div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total Records : '.$total_records.' &nbsp;&nbsp;&nbsp; Page : '.($next_page-1) .' / '.$total_pages.' &nbsp;
		Go to : <select onchange="go_topage(\'?p=customers&tab=&page=\',this.value);" style="padding:0px; width:50px; height:20px;">'; 
		 	for($pi=1;$pi<=$total_pages;$pi++) { if($page==$pi) $s='selected'; else $s=''; echo "<option $s> $pi </option>"; } echo '</select></div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=customers&tab=&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=customers&tab=&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}
$qry="SELECT * FROM costomer ORDER BY costomer_id DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($cust=leo_mysql_fetch_array($result))
			{
			if($cust['status']=='1'){$status='Active';}else if($cust['status']=='0') {$status='Deactive'; }
echo '<tr>
<td class="instno">'.$cust['costomer_id'].'</td>
<td class="chittno">'.$cust['company'].'</td>
<td class="cname">'.$cust['email_id'].'</td> 
<td class="cname">'.pas_user($cust['costomer_id']).'</td> 
<td class="sttno">'.$cust['phone_no'].'</td> 
<td class="prize">'.$status.'</td> 
<td class="prize"><a href="./?p=customers&tab=&edit='.$cust['costomer_id'].'">Edit</a> &nbsp; 
<a href="./?p=message&tab=sent&compose&rply='.$cust['costomer_id'].'"><img title="Send a Message" border="0" height="16" src="theme/images/s_icon.png" /></a>
</td>  
</tr>
';
			}
		}
	}
?>
</table>
</fieldset>
<?php } ?>

</div>
<?php include('./theme/footer.php');?>
