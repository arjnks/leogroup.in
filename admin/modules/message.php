<?php
#---------------------------------------------- templates starts here --------------------------->

if(isset($_POST['newtemplate']) || isset($_POST['savetemplate']) )
{
$tmpl_name=$_POST['name'];
$tmpl_title=$_POST['title'];
$tmpl_message=$_POST['message'];
$tmpl_status=$_POST['status'];
$visitors=$_POST['visitors'];
$reurl=$_POST['reurl'];

if($tmpl_name=='' && $tmpl_title=='' &&   $tmpl_message=='' ){ $error[]="Please Fill all fields"; }
else {  if($tmpl_name=='' ){ $error[]="Template name is empty"; }
		if($tmpl_title=='' ){ $error[]="Title field is empty"; }
   		if($tmpl_message=='' ){ $error[]="Message is empty"; }	
	}
	if($error)
	{
		$_SESSION['AERRMSG']=$error;
		$_SESSION['name']=$tmpl_name;
		$_SESSION['title']=$tmpl_title;
		$_SESSION['message']=$tmpl_message;
		$_SESSION['visitors']=$visitors;
		$_SESSION['status']=$tmpl_status;
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	
	}
	else
	{
$date=time();

	if(isset($_POST['newtemplate']))
	{
		 $qry="insert into templates(`tmpl_name`,`tmpl_title`,`tmpl_content`,`tmpl_attachment`,`tmpl_status`,`tmpl_date`,`tmpl_type`,`visitors`) values ('$tmpl_name','$tmpl_title','$tmpl_message','$tmpl_attachment','$tmpl_status','$date','mail','$visitors')";
		$result=@leo_mysql_query($qry);
		if($result){
		$_SESSION['SUCMSG']="A new template saved successfully";
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}
		else{
		$_SESSION['ERRMSG']="Error:".leo_mysql_error();
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}

	}
	else
	if(isset($_POST['savetemplate']))
	{
		$tmpl_id=$_POST['tmpl_id'];
		$qry="update templates set `tmpl_name`='$tmpl_name',`tmpl_title`='$tmpl_title',`tmpl_content`='$tmpl_message',`tmpl_attachment`='$tmpl_attachment',
`tmpl_status`='$tmpl_status',`tmpl_date`='$date',`visitors`='$visitors' where `tmpl_id`='$tmpl_id' limit 1";
		$result=@leo_mysql_query($qry);
		if($result){
		$_SESSION['SUCMSG']="A  template has been saved successfully";
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}
		else{
		$_SESSION['ERRMSG']="Error:".leo_mysql_error();
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}

	}
	
}

}

if(isset($_GET['delete_tmpl']))
	{
		$tmpl_id=$_GET['delete_tmpl'];
		$qry="delete from templates  where `tmpl_id`='$tmpl_id' limit 1";
		$result=@leo_mysql_query($qry);
		if($result){
		$_SESSION['SUCMSG']="A  template has been deleted successfully";
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}
		else{
		$_SESSION['ERRMSG']="Error:".leo_mysql_error();
		session_write_close();
		header("Location: ./?p=message&tab=mailtemplates");
		exit();	}

	}
	
	
if(isset($_POST['delete_msg']))
	{
		$del_msg = $_POST['del_msg'];
		$qry="delete from message  where `id`='$del_msg' limit 1";
		$result=@leo_mysql_query($qry);
		if($result){
		$_SESSION['SUCMSG']="A  Message has been deleted successfully";
		session_write_close();
		header("Location: ./?p=message&tab=".$_GET['tab']."&page=".$_GET['page']);
		exit();	}
		else{
		$_SESSION['ERRMSG']="Error:".leo_mysql_error();
		session_write_close();
		header("Location: ./?p=message&tab=".$_GET['tab']."&page=".$_GET['page']);
		exit();	}

	}
	
	  
#---------------------------------------------- templates ends here --------------------------->

if(isset($_POST['send_msg']))
{
	$reurl = $_POST['reurl'];
	$cos_id = $_POST['cust_id'];
    $subject = $_POST['title'];
	$mesage = $_POST['message'];
	$mail_to = $_POST['to'];
	$sql_date = date('Y-m-d');
	
	
	if($subject=='' ){ $error[]="Enter the Subject"; }
	if($mesage=='' ){ $error[]="Enter your Message"; }	
	
	if($error)
	{
		$_SESSION['AERRMSG']=$error;
		$_SESSION['title']=$subject;
		$_SESSION['message']=$mesage;
		session_write_close();
		header("Location: ".$reurl);
		exit();	
	}
	else
	{
		
	
		$qry = "insert into `message` values ('','0','$cos_id','$subject','$mesage','$sql_date','$date','$ip')";
		$result = @leo_mysql_query($qry);
		
		$qry_cust3 = "select * from costomer where costomer_id='$cos_id'";
		$cust_res3 = leo_mysql_query($qry_cust3);
		$customer3 = leo_mysql_fetch_assoc($cust_res3);
	 
		$mailto = $mail_to;
		$mailfrom = $companymail;
		$subject = $subject;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: ". $mailfrom."\r\n";
		
		/*$mailbody = '<u><b> Leogroup.in - Login User Message </b></u> <br>
	<table width="200" border="0">
	<tr><td> Customer Id </td><td>'.$customer3['costomer_id'].' </td></tr>
	<tr><td> Customer </td><td>'.$customer3['company'].'</td></tr>
	<tr><td> Contact Person </td><td>'.$customer3['contact_person'].'</td></tr>
	<tr><td> Address </td><td>'.$customer3['address'].'</td></tr>
	<tr><td> Phone No </td><td>'.$customer3['phone_no'].'</td></tr>
	<tr><td> Message </td><td>'.$mesage.'</td></tr>
	</table>';*/
	
		$mailbody = $mesage;
		mail($mailto,$subject,$mailbody,$headers);	
		if($result )//if success
		{
		$_SESSION['SUCMSG'] = 'Your Message has been sent successfully.';
		session_write_close();
		header("Location: ".$reurl);
		exit(); 
		}
		else
		{
		$_SESSION['ERRMSG'] = 'You canot sent message at this time';
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
	}
}

#---------------------------------------------- Resend starts here --------------------------->
if(isset($_POST['resend']) || isset($_POST['delete'])) 
{
$date=time();
$ids=$_POST['checkbox'];
$idcount=count( $_POST['checkbox']);
$reurl=$_POST['reurl'];
$theboundary = md5(uniqid(""));
$header = "From:".$companymail;
$header .= "\nMIME-Version: 1.0";
$header .= "\nContent-Type: multipart/alternative;";
$header .= "\n        boundary=\"----=_NextPart_$theboundary\"";
$header .= "\nX-Priority: 3";
$header .= "\nX-MSMail-Priority: Normal";
		                                        
$body = "This is a multi-part message in MIME format.\n\n";
$body .= "------=_NextPart_".$theboundary."\nContent-Type: text/plain;\n\n";
$body .= "\n------=_NextPart_".$theboundary."\nContent-Type: text/html;\n\n";
if($idcount==''){$error[]="please select atleast one ";}

	if($error)
	{
	$_SESSION['AERRMSG']=$error;
	session_write_close();
	header("Location: ".$reurl);
	exit();	
	}

	else
	{



		if(isset($_POST['resend']))	
		{	
			$j=1;
			for($i=0; $i<$idcount; $i++)
			{
			$qry1="select * from emaillog where id='$ids[$i]'";
			$result1=@leo_mysql_query($qry1);
				while($data1=leo_mysql_fetch_array($result1))
				{
 $body .= '<table cellpadding="0" cellspacing="0" >
		<tr><td><h2>'.$data1['title'].'</h2></td></tr>
		<tr><td>
		'.$data1['message'].'
		</td></tr>
		<tr><td>
		For any  help about  please contact  us. <br>
		Phone:'.$phone.'<br>email:'.$companymail.'
		</td></tr>
		</table>';

				$mail=mail($data1['email'],$data1['title'],$body,$header);
					if($mail) 
					{
					$qry2="update emaillog set `status`='1', `date`='$date' where id='".$data1['id']."'";
					$result2=@leo_mysql_query($qry2);
					if($result2) { $j=$j+1;}
					}
					else
					{
					$qry2="update emaillog set `status`='0', `date`='$date' where id='".$data1['id']."'";
					$result2=@leo_mysql_query($qry2);
					}
				}
			}
			$_SESSION['SUCMSG']=($j-1) .' Message has been sent successfully';
			session_write_close();
			header("Location: ".$reurl);
			exit();
		}

#---------------------------------------------- Resend ends here --------------------------->

#---------------------------------------------- delete Starts here --------------------------->

	if(isset($_POST['delete']))
	{
		$j=1;
		for($i=0; $i<$idcount; $i++)
		{
		$qry="delete from message where id='$ids[$i]'";
		$result=@leo_mysql_query($qry);
		if($result) {$j=$j+1;}
		}
		$_SESSION['SUCMSG']=($j-1) .' Message has been delete successfully';
		session_write_close();
		header("Location: ".$reurl);
		exit();
	}

#---------------------------------------------- delete ends here --------------------------->
	}
}

if(isset($_POST['rply_msg']))
{
	$customer = $_POST['customer'];
	header("Location: ?p=message&tab=".$_GET['tab']."&compose&rply=".$customer);
	exit();
}


if(isset($_POST['sendmail'])) 
{
$customers=$_POST['customers'];
$tmpl_id=$_POST['tmpl_id'];
$reurl=$_POST['reurl'];
$date=time();
$j=1;
$sql_date = date('Y-m-d');

$qry="select * from templates where tmpl_id='$tmpl_id' limit 1";
$result=@leo_mysql_query($qry);
if(leo_mysql_num_rows($result)>=1)
{
$rows=leo_mysql_fetch_array($result);
$title=$rows['tmpl_title'];
$message=$rows['tmpl_content'];
$attachment=$rows['tmpl_attachment'];
}

$subject=$title." [ ".$sitename." ]";

$theboundary = md5(uniqid(""));
$header = "From:".$companymail;
$header .= "\nMIME-Version: 1.0";
$header .= "\nContent-Type: multipart/alternative;";
$header .= "\n        boundary=\"----=_NextPart_$theboundary\"";
$header .= "\nX-Priority: 3";
$header .= "\nX-MSMail-Priority: Normal";
		                                        
$body = "This is a multi-part message in MIME format.\n\n";
$body .= "------=_NextPart_".$theboundary."\nContent-Type: text/plain;\n\n";
$body .= "\n------=_NextPart_".$theboundary."\nContent-Type: text/html;\n\n";
$body .="Dear Sir/Madam, <br />".$message;

	if($customers!=0)
	{
		
		$qry = "insert into `message` values ('','0','$customers','$subject','$message','$sql_date','$date','$ip')";
		$result = @leo_mysql_query($qry);
		
		$qry_cust3 = "select * from costomer where costomer_id='$customers'";
		$cust_res3 = leo_mysql_query($qry_cust3);
		$customer3 = leo_mysql_fetch_assoc($cust_res3);
		$to_email = $customer3['email_id'];
		
		if($to_email=='')
		{
			$qry34 = "select email from user where costomer_id='$customers'  limit 1";
			$result34=@leo_mysql_query($qry34);
			$rows34 = leo_mysql_fetch_assoc($result34);
			$to_email = $rows34['email'];
		}
	
		$mail=mail($to_email,$subject, $body, $header);
		if($result )//if success
		{
		$_SESSION['SUCMSG'] = 'Your Message has been sent successfully.';
		session_write_close();
		header("Location: ".$reurl);
		exit(); 
		}
		else
		{
		$_SESSION['ERRMSG'] = 'You canot sent message at this time';
		session_write_close();
		header("Location: ".$reurl);
		exit();
		}
					
	}
	else  
	{ 
		$cc = 0;
		$qry2="select costomer_id,email_id from costomer where status='1'";
		$result2=@leo_mysql_query($qry2);
		while($data2=leo_mysql_fetch_array($result2))
		{
			$qry = "insert into `message` values ('','0','".$data2['costomer_id']."','$subject','$message','$sql_date','$date','$ip')";
			$result = @leo_mysql_query($qry);
			
			$to_email = $data2['email_id'];
			if($to_email=='')
			{
				$qry34 = "select email from user where costomer_id='".$data2['costomer_id']."'  limit 1";
				$result34=@leo_mysql_query($qry34);
				$rows34 = leo_mysql_fetch_assoc($result34);
				$to_email = $rows34['email'];
			}
			
			$mail=mail($to_email,$subject, $body, $header);
			if($result )//if success
			{	$cc++;	}
			else
			{
			/*$_SESSION['ERRMSG'] = 'You canot sent message at this time';
			session_write_close();
			header("Location: ".$reurl);
			exit();*/
			}
		}
		if($cc==0){ $_SESSION['ERRMSG'] = 'You canot sent messages at this time'; }
		else { $_SESSION['SUCMSG']= $cc .' Message has been sent successfully'; } 
		session_write_close();
		header("Location: ".$reurl);
		exit();
	}
}

// --------------------- Chittilist  ------------------- //
function chitlist()
{
$qry = "SELECT * FROM `chit`";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($chits=leo_mysql_fetch_array($result))
			{
			if (isset($_SESSION['chitty_no']) && $_SESSION['chitty_no']==$chits['chit_id'])  {$select=' selected ';unset($_SESSION['chitty_no']);} else {$select="";}
			echo '
				<option '.$select.' value="'.$chits['chit_id'].'">['.$chits['chit_id'].'] '.$chits['chit_name'].'</option>	
				';
			$i=$i+1;
			}
				
		}
	}
}
// --------------------- /chittilist  ------------------- //

// --------------------- templatelist  ------------------- //
function tmpl_list()
{
$qry = "SELECT * FROM `templates`  WHERE tmpl_status='active' and  tmpl_type='mail' ORDER BY `tmpl_id` DESC ";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
		{
		$i=1;
		while($tmpls=leo_mysql_fetch_array($result))
			{
			echo '<option '.$select.' value="'.$tmpls['tmpl_id'].'">'.$tmpls['tmpl_name'].'</option>	
				';
			$i=$i+1;
			}
				
		}
	}
}
// --------------------- /templatelist  ------------------- //


$pagename="Customer Messages - ";
include('./theme/header.php');?>
<h1>Customer Messages</h1>
<!-- Opening <div left>-->
<div id="leftbar">
<ul>
<li><a href="./?p=message&tab=" <?php activelink(''); ?> >Send  Template Message</a></li>
<li><a href="./?p=message&tab=sent" <?php activelink('sent'); ?>>Inbox</a></li>
<li><a href="./?p=message&tab=unsent" <?php activelink('unsent'); ?>>Sent Messages</a></li>
<li><a href="./?p=message&tab=mailtemplates" <?php activelink('mailtemplates'); ?>>Mail Templates</a></li>
</ul>
</div>
<!-- closing <div left>-->
<!-- Opening <div content>-->
<div id="content">

<?php if(isset($_GET['read_mail'])) 
{ 
$read_mail = $_GET['read_mail'];
$qry="SELECT * FROM `message` where `id`='$read_mail'";
$result = @leo_mysql_query($qry);
$res = leo_mysql_fetch_assoc($result);
if($res){

if(isset($_GET['admin'])) { $qry_cust = "select * from costomer where costomer_id='".$res['to']."'"; }
else{ $qry_cust = "select * from costomer where costomer_id='".$res['from']."'"; }

$cust_res = leo_mysql_query($qry_cust);
$customer = leo_mysql_fetch_assoc($cust_res);
?>
<fieldset class="addchitty"><legend>View Message </legend>
<form action="" method="post" >
<input name="del_msg" type="hidden" value="<?php echo $res['id']; ?>" />
<input name="customer" type="hidden" value="<?php echo $customer['costomer_id']; ?>" />
<table cellpadding="0" cellspacing="2" width="100%" class="addchitty">
<tr><th style="width:150px;">Customer Id : </th><td><?php echo $customer['costomer_id']; ?></td></tr>
<tr><th style="width:150px;">Company : </th><td><?php echo $customer['company']; ?></td></tr>

<tr><th style="width:150px;">Subject : </th><td><?php echo $res['subject']; ?></td></tr>
<tr><th valign="top">Message : </th><td><?php echo $res['message']; ?></td></tr>
<tr><th>Date : </th><td><?php echo date('d - M, Y',$res['time']); ?></td></tr>
<tr><th>Time : </th><td><?php echo date('h:i a ',$res['time']); ?></td></tr>
<tr><th>Ip : </th><td><?php echo $res['ip']; ?></td></tr>
<tr><td></td><td>
<?php if(!isset($_GET['admin'])) { ?>
<input type="submit" value="Reply" name="rply_msg" class="button"><?php } ?> 
<input type="submit" value="Delete" onclick="return confirm('Are you sure ! Do you realy want to delete this ?');" name="delete_msg" class="button"></td></tr>
</table>
<?php } else { echo' <div class="warnmsg">Invlid Message id</div>';} ?>
</form>
</fieldset>
<?php } ?>








<?php if(isset($_GET['compose'])) {  ?>
<fieldset class="addchitty"><legend>Compose Message</legend>
<?php msgs(); ?>
<form action="" method="post" >
<input type="hidden" value="<?php curPageURL();?>" name="reurl">
<?php
$company = ""; $email = "";

if(isset($_GET['rply'])) 
{ 
	$custmr = $_GET['rply'];
	$qry = "select company,email_id from costomer where costomer_id='$custmr'  limit 1";
	$result=@leo_mysql_query($qry);
	$rows = leo_mysql_fetch_assoc($result);
	$company = $rows['company']; $email = $rows['email_id'];
	if($email=='')
	{
		$qry3 = "select email from user where costomer_id='$custmr'  limit 1";
		$result3=@leo_mysql_query($qry3);
		$rows3 = leo_mysql_fetch_assoc($result3);
		$email = $rows3['email'];
	}
}
 	
?>
<input type="hidden" value="<?php echo $custmr;?>" name="cust_id">
<table cellpadding="0" cellspacing="2" width="100%" class="addchitty">
<tr><th style="width:100px;">To : </th><td><input type="text" style="width:500px;" name="to" value="<?php if(isset($_SESSION['to'])){echo $_SESSION['to'];unset($_SESSION['to']);} else { echo $email; }?>" class="textbox"></td></tr>
<tr><th style="width:100px;">Company : </th><td><input type="text" readonly style="width:500px;" name="title" value="<?php echo $company; ?>" class="textbox"></td></tr>
<tr><th style="width:100px;">Subject : </th><td><input type="text" style="width:500px;" name="title" value="<?php if(isset($_SESSION['title'])){echo $_SESSION['title'];unset($_SESSION['title']);}?>" class="textbox"></td></tr>
<tr><th valign="top">Message </th><td><textarea style="width:500px; height:150px;" class="textarea" name="message"><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);}?></textarea></td></tr>
<tr><td></td><td><input type="submit" value="Send" name="send_msg" class="button"></td></tr>
</table>
</form>
</fieldset>
<?php }?>














<?php if(isset($_GET['tab']) && $_GET['tab']=='intimation') { include('./modules/intimation.php'); }
else  if(isset($_GET['tab']) && $_GET['tab']=='unsent') {?>

<!--  unsent mails -->
<fieldset class="result1"><legend>Sent Messages</legend>
<?php msgs() ?>
<form name="form" action="" method="post">
<input type="hidden" name="reurl" value="<?php curPageUrl(); ?>">
<table cellpadding="0" cellspacing="1" width="100%">
<tr>
<th></th>
<th >Company</th>
<th >Subject</th>
<th >Message</th>
<th style="width:80px;">Date</th>
<th style="width:60px;">Time</th>
<th style="width:60px;">Action</th>
</tr>
<?php 

  $qry1="SELECT COUNT(*) FROM `message` where `from`='0'";
			$result1 = @leo_mysql_query($qry1);	
			$row = mysql_fetch_row($result1); 
			$total_records = $row[0]; 
			$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> No Messages Exists</div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.'&nbsp; &nbsp;|&nbsp; &nbsp;  Page(s) '.($next_page-1) .' / '.$total_pages.' </div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{ 
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=message&tab=unsent&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=message&tab=unsent&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}

$qry="SELECT * FROM `message` where `from`='0' ORDER BY date DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
	{
	$n = (($count*$page)-$count)+1;
while($res=leo_mysql_fetch_array($result))
		{
		$c_name = customer('company',$res['to']);
echo '<tr>
<td style="width:20px;"><input type="checkbox" value="'.$res['id'].'" name="checkbox[]" id="checkbox[]"></td>
<td class=""> '.$c_name.'</td>
<td class=""> '.$res['subject'].'</td>
<td class="">'.smalltext($res['message'],40).'</td>
<td class="">'.date('d - M, Y',$res['time']).'</td>
<td class="">'.date('h:i a ',$res['time']).'</td>
<td class="">
<a href="?p=message&tab=unsent&page='.$page.'&read_mail='.$res['id'].'&admin">View</a></td></tr>'; 

}
}
}
?>
</table>
<br />
<table cellpadding="0" cellspacing="1" width="100%">
<tr>
<th><input type="button" onClick="marcarTodos()" value="Select all" class="button"></th>
<?php /*?><th><input type="submit" name="resend" value="Resend" class="button"></th><?php */?>
<th><input type="submit" name="delete" value="Delete"  onclick="return confirm('Are you sure ! Do you realy want to delete this ?');" class="button"></th>
<th width="550"></th>
</tr>
</table>
</form>
</fieldset>
<!--  unsent mails -->

<?php } else if(isset($_GET['tab']) && $_GET['tab']=='sent') {?>

<!--   sent mails -->
<fieldset class="result1"><legend>Inbox Messages</legend>
<?php msgs() ?>
<form name="form" action="" method="post">
<input type="hidden" name="reurl" value="<?php curPageUrl(); ?>">
<table cellpadding="0" cellspacing="1" width="100%">
<tr>
<th></th>
<th style="width:130px;">Company</th>
<th style="width:130px;">Subject</th>
<th >Message</th>
<th style="width:80px;">Date</th>
<th style="width:60px;">Time</th>
<th style="width:60px;">Action</th>
</tr>
<?php 
$n = (($count*$page)-$count)+1;

$qry1="SELECT COUNT(*) FROM `message` where `to`='0'";
$result1 = @leo_mysql_query($qry1);	
$row = mysql_fetch_row($result1); 
$total_records = $row[0]; 
$total_pages = ceil($total_records / $count);
	
		if($total_records=="0"){echo '</table><div class="warnmsg"> No Messages Exists</div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.'&nbsp; &nbsp;|&nbsp; &nbsp;  Page(s) : '.($next_page-1) .' / '.$total_pages.' </div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{ 
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=message&tab=sent&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=message&tab=sent&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}if(!isset($mails['chitty_no']) || $mails['chitty_no']=='0'){$chitty='All chitty';} else{$chitty=$mails['chitty_no'];}


$qry="SELECT * FROM `message` where `to`='0'  order by date desc LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
	{
	
		while($res=leo_mysql_fetch_array($result))
		{
		$c_name = customer('company',$res['from']);
echo '<tr>
<td style="width:20px;"><input type="checkbox" value="'.$res['id'].'" name="checkbox[]" id="checkbox[]"></td>
<td class="">'.$c_name.'</td>
<td class="">'.$res['subject'].'</td>
<td class="">'.smalltext($res['message'],40).'</td>
<td class="">'.date('d - M, Y',$res['time']).'</td>
<td class="">'.date('h:i a ',$res['time']).'</td>
<td class=""><a href="?p=message&tab=sent&page='.$page.'&read_mail='.$res['id'].'">View</a></td> 
</tr>';			
		}
	}
}
?>
</table>
<br />
<table cellpadding="0" cellspacing="1" width="100%">
<tr>
<th><input type="button" onClick="marcarTodos()" value="Select all" class="button"></th>
<th><input type="submit" name="delete" value="Delete" class="button"  onclick="return confirm('Are you sure ! Do you realy want to delete this ?');"></th>
<th width="550"></th>
</tr>
</table></form>
</fieldset>
<!--  / sent mails -->
<?php  }  else if(isset($_GET['tab']) && $_GET['tab']=='mailtemplates') {
if(isset($_GET['edit'])) {?>

<!--  mails templates-->
<!--  edit mail template-->
<fieldset class="addchitty"><legend>Edit template <?php echo $_GET['edit'];?> </legend>
<?php msgs(); ?>
<form action="" method="post" >
<input type="hidden" value="<?php curPageURL();?>" name="reurl">
<input type="hidden" value="<?php echo $_GET['edit'];?>" name="tmpl_id">
<?php
$tmpl_id=$_GET['edit'];
$qry="select * from templates where tmpl_id='$tmpl_id'  limit 1";
$result=@leo_mysql_query($qry);
if(leo_mysql_num_rows($result)>=1)
{
$rows=leo_mysql_fetch_array($result);
?>
<table cellpadding="0" cellspacing="2" width="100%" class="addchitty">
<th>Template Name</th><td><input type="text" name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];unset($_SESSION['name']);} else {echo $rows['tmpl_name'];}?>" class="textbox"></td></tr>
<th>Message title</th><td><input type="text" name="title" value="<?php if(isset($_SESSION['title'])){echo $_SESSION['title'];unset($_SESSION['title']);} else {echo $rows['tmpl_title'];}?>" class="textbox"></td></tr>
<th>Message </th><td><textarea style="width:400px; height:150px;" class="textarea" name="message"><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);} else {echo $rows['tmpl_content'];}?></textarea></td></tr>
<th>Status </th><td>
<select name="status" style="width:150px;">
<?php if(isset($_SESSION['status'])){$status=$_SESSION['status'];unset($_SESSION['status']);} else { $status=$rows['tmpl_status']; } ?>
<option value="active" <?php if($status=='active'){echo ' selected' ;}?>>Active</option>
<option value="blocked" <?php if($status=='blocked'){echo ' selected' ;}?>>Block</option>
</select>
<?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);} else {echo "";}?></textarea></td></tr>
<tr><td></td><td><input type="submit" value="Save it" name="savetemplate" class="button"></td></tr>
</table>
<?php } else { echo' <div class="warnmsg">Invlid template id</div>';} ?>
</form>
</fieldset>
<!--  /edit mail template-->

<?php } else {?>
<!--  new mail template-->
<fieldset class="addchitty"><legend>New Message template</legend>
<?php msgs(); ?>
<form action="" method="post" >
<input type="hidden" value="<?php curPageURL();?>" name="reurl">
<table cellpadding="0" cellspacing="2" width="100%" class="addchitty">
<th>Template Name</th><td><input type="text" name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];unset($_SESSION['name']);} else {echo "";}?>" class="textbox"></td></tr>
<th>Message title</th><td><input type="text" name="title" value="<?php if(isset($_SESSION['title'])){echo $_SESSION['title'];unset($_SESSION['title']);} else {echo "";}?>" class="textbox"></td></tr>
<th>Message </th><td><textarea style="width:400px; height:150px;" class="textarea" name="message"><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);} else {echo "";}?></textarea></td></tr>
<th>Status </th><td>
<select name="status" style="width:150px;">
<option value="active" <?php if(isset($_SESSION['status']) && $_SESSION['status']=='active'){echo ' selected' ;unset($_SESSION['status']);} else {echo "";}?>>Active</option>
<option value="blocked" <?php if(isset($_SESSION['status']) && $_SESSION['status']=='blocked'){echo ' selected' ;unset($_SESSION['status']);} else {echo "";}?>>Block</option>
</select>
<?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);} else {echo "";}?></textarea></td></tr>
<tr><td></td><td><input type="submit" value="Create New" name="newtemplate" class="button"></td></tr>
</table>
</form>
</fieldset>
<!--  /new mail template-->
<?php }?>
<br />
<fieldset class="addchitty"><legend>All Templates</legend>
<table cellpadding="0" cellspacing="1" width="100%" class="result1">
<tr>
<th style="width:150px;">Name</th>
<th style="width:200px;">Title</th>
<th style="width:130px;">Status</th>
<th style="width:100px;">Date</th>
<th style="width:80px;">Action</th>
</tr>
<?php  $qry1="SELECT COUNT(*) FROM templates where tmpl_type='mail'  ORDER BY tmpl_id DESC";
		$result1 = @leo_mysql_query($qry1);	
		$row = mysql_fetch_row($result1); 
		$total_records = $row[0]; 
		$total_pages = ceil($total_records / $count);
		
		if($total_records=="0"){echo '</table><div class="warnmsg"> No  Templates</div>';  }
		else	
		{ 
		echo ' <div class="pageprag">';
		if($total_records!="0") { echo'<div class="left">Total : '.$total_records.'&nbsp; &nbsp;|&nbsp; &nbsp;  Page(s) '.($next_page-1) .' / '.$total_pages.' </div>';}
		echo'<ul >';
		if(isset($_GET['page']))
		{ 
		 if($_GET['page']=='0' || $_GET['page']=='' || $_GET['page']=='1')  { echo '<li>Previous Page</li>'; $start_from="0"; }
		 else { 
		 $pre_page = ($page-1);		 
		 echo '<li><a href="./?p=message&tab=mailtemplates&page='.$pre_page.'">Previous Page</a></li>';}
		}
		else
		{ echo '<li>Previous Page</li>'; $start_from="0"; }
		 if($next_page>$total_pages){ echo "<li>Next page</li>";}
		 else {	echo '<li><a href="./?p=message&tab=mailtemplates&page='.$next_page.'">Next Page</a></li>';}
		echo ' </ul></div>';
		}if(!isset($mails['chitty_no']) || $mails['chitty_no']=='0'){$chitty='All chitty';} else{$chitty=$mails['chitty_no'];}


$qry="SELECT * FROM templates where tmpl_type='mail'  ORDER BY tmpl_id DESC LIMIT $start_from , $count";
$result = @leo_mysql_query($qry);
	if($result)
	{
	if(leo_mysql_num_rows($result) >0) 
	{
	
while($tmpls=leo_mysql_fetch_array($result))
	{
echo '<tr><td class="">'.$tmpls['tmpl_name'].'</td><td class="">'.shorttext($tmpls['tmpl_title']).'</td>
<td class="">'.$tmpls['tmpl_status'].'</td>
<td class="">'.date('M d, Y',$tmpls['tmpl_date']).'</td> 
<td class=""><a href="./?p=message&tab=mailtemplates&edit='.$tmpls['tmpl_id'].'">Edit</a> | 
<a href="./?p=message&tab=mailtemplates&delete_tmpl='.$tmpls['tmpl_id'].'" onclick="return confirm(\'Are you sure ! Do you realy want to delete this template ? \');">Delete</a></td>
</tr>
';	}
  }
}
?>
</table>
</fieldset>
<!--  /mails templates-->
<?php } else {?>

<!-- New mails-->
<fieldset class="addchitty"><legend>Send new Message</legend>
<?php msgs(); ?>
<form action="" method="post" >
<input type="hidden" value="<?php curPageURL();?>" name="reurl">
<table cellpadding="0" cellspacing="2" width="100%" class="addchitty">
<tr><th >Customers : </th><td ><select name="customers" style="width:220px;"><option value="0" >All Customers</option><?php customer_lists(); ?></select> </td></tr>
<tr><th >Select a Template </th><td ><select name="tmpl_id" style="width:220px;"><?php tmpl_list(); ?></select> </td></tr>
<tr><td></td><td><input type="submit" value="Send Message" name="sendmail" class="button"></td></tr>
</table>
</form>
</fieldset>
<!-- /New mails-->
<?php }?>

</div>
<?php include('./theme/footer.php');?>
