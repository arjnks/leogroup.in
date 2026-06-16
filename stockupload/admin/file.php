<?php

error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
session_start();
include('../include/db.php');
//include('../include/login_check.php');

$date=date("y-m-d");
$time=date("h:i:m");

 $f	=	$_POST['file'];

		
		
		echo  $file			     =	 $_FILES['.$f.'];
			  $file_name		 =	 $file['name'];
			  $file_temp_name	 =	 $file['tmp_name'];
			  $error			 =	 $file['error'];
			  $type			     =	 $file['type'];
			  $size			     =	 $file['size'];
			  $save_path		 =	 "upload".$file_name; 
		
/*	 if($_FILES['customer_file']['name']==''){ $error[] = "Please upload the file"; }
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
*/
	?>