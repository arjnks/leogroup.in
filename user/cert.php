 

<body style="background-image:url(images/main_bg.jpg);">
  <style>
   .content_box {
	border: 5px solid #CCCCCC;
	padding: 10px;
}

.abtsubmit{
	BORDER-RIGHT:  #46B 1px outset;
	BORDER-TOP:  #46B 1px outset; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 10pt; 
	BORDER-LEFT: #46B 1px outset;
	COLOR: #005e5e;
	BORDER-BOTTOM: #46B 1px outset;
	FONT-FAMILY: Arial;
	BACKGROUND-COLOR: #ddf5f5;
}
	#footer{text-align:right; font-family:Arial;background:url(../images/inner/001.gif);padding:5px;font-size:10px;}
	#footer1{ font-family:Arial, Helvetica, sans-serif; font-size:10px;}
.title {
	background: #4174a6 url('images/backgrounds/c_bar_primary.gif');
	height: 25px;
	color: #ffffff;
	font-size: 14px;
	margin: 0px;
	padding-left:5px; line-height:25px; text-transform:uppercase;
}

.subtitle {
	background: #eaeaea;
	color: #4987c5;
	font-size: 14px;
	font-weight: bold;
	margin: 1px 0px;
	padding: 5px 0px 5px 3px;
	border-top: 1px solid #dddddd;
	border-bottom: 1px solid #dddddd;
}
.row_even,.browsing_result_table_body_even,.seller_result_table_body_even
	{
	padding: 7px 5px;
	background: #f7f7f7;
	font-size: 14px;
	color: #666666;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.row_odd,.browsing_result_table_body_odd,.seller_result_table_body_odd {
	padding: 7px 5px;
	background: #ffffff;
	font-size: 14px;
	color: #666666;
}
   .white_content {
     display: none;
     position: fixed;
     top: 0px;
     left: 0px;
	 bottom:0px;
	 right:0px;
	 
     width:100%;
     height:100%;
	 
     z-index:1002;
     overflow: auto;	 
   }
   .black_overlay{
     display: none; 
     position: fixed;
     top: 0%;
     left: 0%;
     width: 100%;
     height: 100%;
     background-color:#666666;
     z-index:1001;
     -moz-opacity: 0.8;
     opacity:.80;
     filter: alpha(opacity=80);
   }

</style>

<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }	
</script>


<?php
//error_reporting(0);
include_once("phpmailer/PHPMailerAutoload.php");
//$i='';

		if(isset($_POST['send']))
		{
$regno = $_POST['regno'];			
			$studreg = $_POST['chkcert1'];
			$_SESSION['regn_no'] = $regno;
			$regg_22 = $regno;
 // 			echo '<script language="javascript">alert("'.$studreg.'"); </script>';


				 	
			//$qry1 = leo_mysql_query("select * from certificate where stud_reg='$regg_22'");
$pdf_url="";
			if($_POST['chkcert1']=="1") 
			 {

				$i = 1;
				 
  echo 	$qryup="update `certificate` set `cert1status`=`cert1status`+1  where `stud_reg`='$regno'"; 
		     
		$result1=leo_mysql_query($qryup);
						echo "updated";
					$cert55 = "certf$i";

		$pdf_url = $pdf_url."<br> http://www.ipakerala.com/certificateverification/admin/pdfcertificates/certf1/$regg_22.pdf";
				 	//include("pdfcertificate01.php");
				 					
				// echo "pdf 01 file created...";	
				// clearstatcache();
	            // break;
				 	}

				 if ($_POST['chkcert5']==5) {
				 	
				 	$i = 5;
				 	$cert55 = "certf$i";

				 	echo 	$qryup5="update `certificate` set `cert5status`=`cert5status`+1 where `stud_reg`='$regno'"; 
		     	$pdf_url = $pdf_url."<br> http://www.ipakerala.com/certificateverification/admin/pdfcertificates/certf5/$regg_22.pdf";
						$result5=leo_mysql_query($qryup5);

				  		//include("pdfcertificate05.php");
				 		echo "pdf 05 file created...";
				 	
				 }



				 if ($_POST['chkcert6']==6) {
				 	$i = 6;		
				 	$cert55 = "certf$i";		 				  						 	
				 	echo 	$qryup6="update `certificate` set `cert6status`=`cert6status`+1 where `stud_reg`='$regno'"; 
		     
						$result6=leo_mysql_query($qryup6);
	$pdf_url = $pdf_url."<br> http://www.ipakerala.com/certificateverification/admin/pdfcertificates/certf6/$regg_22.pdf";
				  		//include("pdfcertificate06.php");
				 		echo "pdf 06 file created...";		

				   }

				   if ($_POST['chkcert7']==7) {
				 	$i = 7;			
				 	$cert55 = "certf$i";					   	
				   	echo 	$qryup7="update `certificate` set `cert7status`=`cert7status`+1 where `stud_reg`='$regno'"; 
		     
						$result7=leo_mysql_query($qryup7);
	$pdf_url = $pdf_url."<br> http://www.ipakerala.com/certificateverification/admin/pdfcertificates/certf7/$regg_22.pdf";
				 		//include("pdfcertificate07.php");
				 		//echo "pdf 07 file created...";	
 					 		
				 }

				 if($_POST['chkcert8']==8) {
				 	$i = 8;	
				 	$cert55 = "certf$i";						 	
				 	echo 	$qryup8="update `certificate` set `cert8status`=`cert8status`+1 where `stud_reg`='$regno'"; 
		     
						$result8=leo_mysql_query($qryup8);
	$pdf_url = $pdf_url."<br> http://www.ipakerala.com/certificateverification/admin/pdfcertificates/certf8/$regg_22.pdf";
				 		//include("pdfcertificate08.php");
				 		//echo "pdf 08 file created...";	 		
				 }

				 else{

				     }	

	    $df=leo_mysql_query("select * from stud_detail where regno='$regno'");
	
		// $fg=leo_mysql_fetch_array($df);
		// {


	 	//	$_SESSION['valid_regno']=$_POST['regno'];
			// }


		while ($fg1=leo_mysql_fetch_array($df))
		{				
			$fname 	 	= $fg1['fname'];
			$lname      = $fg1['lname'];
			$email 		= $fg1['email'];
			$cnno       = $fg1['cn_no'];
			$regstrn_no = $fg1['regno']; 
			$mobile 	= $fg1['mob'];
			$address 	= $fg1['c_address'];
	//		$mailto     = "programerstest@gmail.com";
			  
			$fullname = $fg1['fname'];

			// $message    .= "Congratulations!!! Your course completion certificate is available to download. Thank you.";
			// $message   .= "Download the certificate from links below</br>";	
								
			// $message   .='<iframe src="http://www.ipakerala.com/modified/certificateverification/admin/pdfcertificates/'.$cert55.'/'.$regno.'.pdf"  width="720" height="500px;"></iframe></div>';		

			// $message   .= "http://www.ipakerala.com/modified/certificateverification/admin/pdfcertificates/'.$cert55.'/'.$regno.'.pdf";

	//		unlink($pdf_url);

			$subject    = "Certificate download";
			$headers  	= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: ipakerala.com\r\n";
//			$headers .= "Cc: ipakerala.com";

			$mailbody = '<html><head><title> IPA Kerala </title></head><body>
  <table width="1317" height="588" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="52">&nbsp;</td>
      <td width="20">&nbsp;</td>
      <td width="39">&nbsp;</td>
    </tr>
    <tr>
      <td height="54">&nbsp;</td>
      <td width="20">&nbsp;</td>
      <td width="1202">&nbsp;</td>
      <td width="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" rowspan="3"><p class="style2"><strong>From,</strong></p>
        <p class="style2">IPA Kerala,</p>
        <p class="style2">2nd Floor, ATLAS Building,</p>
        <p class="style2"> Near Jayalakshmi Silks, Thrissur - 680 001</p>
        <p class="style2"> Kerala, India.</p>        
        <p class="style2"> Ph:0487 2386610, 2386609. </p>
        <p class="style2"> E-mail : info@ipakerala.com </p>
        <p class="style2">&nbsp;</p>
        <p class="style2"><strong>Subject</strong> :Course Certificate ,</p>
        <p class="style2">&nbsp;</p>
        <p class="style2"><strong>Dear '.$fname. ' '.$lname.' ,</strong></p>
        <p class="style2">Greetings From IPA Kerala,</p>
       <p class="style2"><strong>Your mobile number is '.$mobile.' ,</strong></p>
      <p class="style2"> Congratulations!! Your certificate with offline registration number: '.$cnno .'  and student registration number: '.$regstrn_no.' available on our website. Please click the link to view or check by email.</p>
      <p class="style2"> Click Here: '.$pdf_url.' &nbsp;</p>
      <p class="style2">If you have any questions, please feel free to contact us or visit www.ipakerala.com</p>
      <p class="style2">&nbsp;</p>
      <p class="style2"><strong>With Kind Regards,</strong></p>
      <p class="style2"><strong>IPA Kerala</strong></p>
      <p class="style2">&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p align="left" class="style1">*** This is an automatically generated email, please do not reply ***</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </body></html>';				

	}			
			  $a=@mail($email,$subject,$mailbody,$headers);
			  
			  if($a)
				{
			echo "Mail sent";
//	        echo delete($pdf_url);
//			echo '<script type="text/javascript">alert("Your mail send successfully");</script>';
					?>
						<script type="text/javascript">
					    window.location.href="<?php echo './?p=cert&tab=pdf&pdf='.$regg_22;?>";
					    </script>
		    		<?php			
				}
				else
				{
					 echo "Mail Not  sent";
					//echo '<script type="text/javascript">alert("You canot send mail at this time");</script>';
					?>
					<script type="text/javascript">
				    window.location.href="<?php echo './?p=cert';?>";
				    </script>
					<?php
				}

			if(strlen($mobile)==10) {

				$message = urlencode("Dear ".$fname." ".$lname.", Congratulations!! Your certificate is available on our website. Please click the link to view or check by email. Click Here: ".$pdf_url.". Please contact us for further details. or visit www.ipakerala.com");

	//			$message   .= "http://www.ipakerala.com/modified/certificateverification/admin/?p=cert&tab=pdf&pdf=.$regg_22;";
			// $message   .= urlencode('<br/> <iframe src="http://www.ipakerala.com/certificateverification/admin/pdfcertificates/'.$cert55.'/'.$regno.'.pdf"  width="720" height="500px;"></iframe></div>');

				$pushid2 = @file_get_contents("http://programerssms.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=e57023ed682d83a41d25acb650c877da&message=$message&senderId=PROGRA&routeId=1&mobileNos=$mobile&smsContentType=english ");

			}
		}


#-----------Certification Validation code --------------------> 

if(isset($_POST['findcert']))
{

	// if($_SESSION['branch']!=0)
	// {
	//   	$sub_qry2=" and branch='".$_SESSION['branch']."'";}
	//    else
	//    {$sub_qry2="";}	  
	  
	 	$reg=$_POST['regno'];
	 	$_SESSION['valid_regno']=$_POST['regno'];
	    $df=leo_mysql_query("select * from stud_detail where cn_no='$reg'");
	
	
		$fg=@leo_mysql_fetch_array($df);
	
	 	$regg_22 = $fg['regno'];

	
	if($regg_22=='')
	{$error[]="please enter the reg no";}
	else 
	if(!$fg)
	{$error[]="please enter the valid reg no";}
	
	if(isset($error))
	{
	$_SESSION['AERRMSG']=$error;
	session_write_close();
	?>
	<script type="text/javascript">
	window.location.href="./?p=cert";
    </script>
    <?php
	//header("location:  ./?p=cert");
	exit();
	}
	else
	{
	 $certss=leo_mysql_query("select * from stud_detail where cn_no='$reg'");
	
		$crt=leo_mysql_fetch_assoc($certss);
	 $valz=$crt['certificate'];
	
	if($valz=='1')
	{
	
	?>
    <script type="text/javascript">
    window.location.href="<?php echo './?p=cert&tab=pdf&pdf='.$regg_22;?>";
    </script>
    <?php
	//header("location:./?p=cert&tab=pdf&pdf=".$reg);
	}
	if($valz=='0')
	{
		
	?>
    <script type="text/javascript">
	window.location.href="./?p=cert&tab=no";
    </script>
    <?php
	//header("location:./?p=cert&tab=no");
	}
	}
}


if(isset($_POST['findbtn']))
{
	$batch=$_POST['batch'];
	?>
   		 <script type="text/javascript">
    	 window.location.href="<?php echo './?p=crtf&batch='.$batch;?>";
     	 </script>
    <?php
	//header("location: ./?p=crtf&batch=".$batch);	
}

if(isset($_GET['op'])=='add')
{
	$up="update stud_detail set certificate='1' where id='".$_GET['sid']."'";
	leo_mysql_query($up);
}

	if(isset($_POST['addbtn']))
	{
		$stud_reg=$_POST['regno1'];
		$id=$_POST['id'];
		$marklist_id=$_POST['unqiue_id_mark'];
		$father=$_POST['father'];
		$fullcourse=$_POST['fullcourse'];
		$course=$_POST['course'];
		$name=$_POST['name'];
		$durfrom=$_POST['durfrom'];
		$durto=$_POST['durto'];
		$grade=$_POST['grade'];
		$status=$_POST['status'];
		$status=$_POST['status'];
		
		if($stud_reg=='' && $marklist_id=='' && $father=='' &&  $fullname=='' && $course=='' && $name=='' && $durfrom=='' && $durto=='' && $grade=='' && $status=='')
		{
			$error[]="Please fill all fields";
		}
			else
			{
				if($stud_reg==''){$error[]="Enter the Reg no";}
				if($marklist_id==''){$error[]="Enter the marklist id";}
				if($father==''){$error[]="Enter the father's name";}
				if($fullcourse==''){$error[]="Enter the full name of the course";}
				if($course==''){$error[]="Enter the course";}
				if($name==''){$error[]="Enter the name";}
				if($durfrom==''){$error[]="Enter the course duration from";}
				if($durto==''){$error[]="Enter the course duration to";}
				if($grade==''){$error[]="Enter the grade";}
				if($status==''){$error[]="Select the status";}
				if($status=='Not Approved'){$error[]="Certificate is not approved for the student";}
			}
			if(isset($error))
			{
				$_SESSION['AERRMSG']=$error;
				$_SESSION['regno1']=$stud_reg;
				$_SESSION['unqiue_id_mark']=$marklist_id;
				$_SESSION['father']=$father;
				$_SESSION['fullcourse']=$fullcourse;
				$_SESSION['course']=$course;
				$_SESSION['name']=$name;
				$_SESSION['durfrom']=$durfrom;
				$_SESSION['durto']=$durto;
				$_SESSION['grade']=$grade;
				$_SESSION['status']=$status;
				session_write_close();
			?>
						
			<script type="text/javascript">
	            var id=document.addform.id.value;
	            {window.location.href="?p=crtf&sid="$id"&op=enable";}
	        </script>
			<?php	            
	        }
	        else
			{
				include("pdfcreatornew.php");
				$ups="update stud_detail set certificate='1' where regno='$stud_reg'";
				leo_mysql_query($ups);
				//$_SESSION['SUCMSG']=" A certificate  has been generated";
				session_write_close();
				header("location:  ./?p=crtf&tab=view&tab=thank&name='$name'");
		//		exit();
			}
		}
	
	$pagename="Online Examination System-";
	include('./theme/header.php');
?>
<link href="modules/calendar/calendar.css" rel="stylesheet" type="text/css">
<h1>Certificate Validation</h1>
<div id="leftbar">
    <ul>
    <li> <a href="?p=cert" <?php activelink('cert'); ?> >Certificate Validation</a></li>
    <li> <!--<a href="?p=crtf&tab=addnew" <?php // activelink('addnew'); ?> >Add New</a>--></li>
    </ul>
</div>
<div  style="height:50px; float:left;">
<?php
#-------------- Delete news----------------->
if(isset($_GET['delete']))
 { 
echo '<div class="errormsg">
Do you realy want to delete this student
<br /><br />
<form  action="" method="post">
<input type="hidden" value="'.$_GET['delete'].'" name="id">
<input type="submit" value="Yes" name="delete" class="button">
<input type="button" value="no" name="no" onClick="window.location=\'?p=crtf\'" class="button">
</form></div>';
 }
#-------------- /Delete news----------------->


 if(isset($_GET['op']) && $_GET['op']=='enable')
 {
	$id=$_GET['sid'];
?>
    <fieldset class="addalbum">
	<legend>Certificate</legend>
	<?php msgs(); 
	 $sels="select * from stud_detail where id='$id'";
	$gh=leo_mysql_query($sels);
	$jo=leo_mysql_fetch_assoc($gh);
	$regno=$jo['regno'];
	$course=$jo['course'];
	$selsv="select * from marklist where regno='$regno'";
	$ghv=leo_mysql_query($selsv);
	$jov=leo_mysql_fetch_assoc($ghv);
	$unqiue_id_mark=$jov['unqiue_id_mark'];
	$grade=$jov['grade']; 
	$bselsv="select * from course where id='$course'";
	$bghv=leo_mysql_query($bselsv);
	$bjov=leo_mysql_fetch_assoc($bghv);
	$course=$bjov['course_name'];
	$fullcourse=$bjov['Full_name'];
	 ?>
    	<form method="post" name="addform">
	 	
        <table style="font-size:13px;"  width="100%" border="0">
          
          <tr>
              <input class="textbox" name="id" type="hidden" id="id" value="<?php echo $jo['id'];?>">
            <th width="33%">Name : <span style="color:#FF0000">*</span> </th>
          <td><label>
              <input class="textbox" name="name" type="text" id="name" value="<?php echo $jo['fname'].' '.$jo['lname'];?>">
            </label></td>
          </tr>
          
          <tr>
          
            <th valign="top">Reg No : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="regno1" id="regno1" value="<?php echo $regno;?>"></td>
          </tr>
          <tr>
          
            <th valign="top">Marklist # : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="unqiue_id_mark" id="unqiue_id_mark" value="<?php echo $unqiue_id_mark;?>"></td>
          </tr>
          <tr>
            
            <th valign="top">Fathers Name : <span style="color:#FF0000">*</span> </th>
            <td width="67%"><input  class="textbox" type="text" name="father" id="father" value="<?php echo $jo['father'];?>"></td>
          </tr>
          
          <tr>
           
            <th valign="top">Full Course : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="fullcourse" id="fullcourse" value="<?php echo $fullcourse; ?>"></td>
          </tr>
          <tr>
           
            <th valign="top">Course : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="course" id="course" value="<?php echo $course; ?>"></td>
          </tr>
          <tr>
            
            <th valign="top">Course From : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="durfrom" id="durfrom" value="<?php echo $jo['joindate'];?>"></td>
          </tr>
          <tr>
            
            <th valign="top">Course To : <span style="color:#FF0000">*</span> </th>
            <?php
				$var=explode('-',$jo['joindate']);
				$mm=$var[1]+$bjov['duration'];
				$year=$var[2];
				if($mm>12){
					$yy=floor($mm/12);
					$mm=$mm%12;
					$year=$year+$yy;
					
				}
				$nedat=$var[0].'-'.$mm.'-'.$year;
			?>
            <td><input class="textbox" type="text" name="durto" id="durto" value="<?php echo $nedat;?>"></td>
          </tr>
          <tr>
            
            <th valign="top">Grade : <span style="color:#FF0000">*</span> </th>
            <td><input class="textbox" type="text" name="grade" id="grade" value="<?php echo $grade;?>"></td>
          </tr>
          
          
        <tr>
        <th>Date of issue : <span style="color:#FF0000">*</span> </th>
        <td>sfgsfg</td>
        </tr>
         
          <tr>
           
            <th>Status : <span style="color:#FF0000">*</span> </th>
            <td><label>
              <select style="width:204px;" name="status">
                <?php
					if(isset($_SESSION['status'])) { $exm=$_SESSION['status']; unset($_SESSION['status']);} else { echo $exm=$status;}
				?>
                <option value="Not Approved">Not Approved</option>
                <option value="Approved">Approved</option>
              </select>
            </label></td>
          </tr>
          <tr>
          
            <td height="38">&nbsp;</td>
            <td><label>
              <input type="submit" name="addbtn" value="Add">
            </label></td>
          </tr>
        </table>
	  
      </form>
	</fieldset>
    </div>
<?php
}

else if(isset($_GET['tab']))
{

 if($_GET['tab']=='addnew') 
 {   ?>

	<fieldset class="addalbum"><legend>Add Certificate</legend>
	<?php msgs(); ?>
     <form method="post">
	<table cellpadding="0" cellspacing="0" class="album">
	<tr><th style="width:100px;">
	<script type="text/javascript">
	function rtnfnd()
	{
	var k=document.getElementById('catf').value;
	var brch=document.getElementById('branch').value;
	var bat=document.getElementById('batch').value;
	var cor=document.getElementById('course').value;
	
	if(k=='0')
	if(k=='0' && brch=='0' && bat=='0' && cor=='0')
	{
	alert("Please select any find option");
	return false;
	}
	else
	{ return true; }
	}
	
	function rtnfndf()
	{
	var t=document.getElementById('ttxt').value;
		if(t=='')
		{
		alert("Please Enter the value");
		return false;
		}
		else
		{
		return true;
		}
	}
	
	
	function fch(k)
	{
	if(k==0)
	{
	alert("Please select a Criteria");
	document.getElementById('sltst').innerHTML='<input name="findbtn" type="submit" value="Find" class="button" />';
	}
	else
	{
	document.getElementById('sltst').innerHTML='<label  style="font-size:11px;">'+k+'&nbsp;:&nbsp;</label><input id="ttxt" style="width:130px;" name="fndtxt" type="text" />&nbsp;<input name="findbtn" onclick="return rtnfndf();" type="submit" value="Find" class="button" />';
	}
	}
	
	</script>
    <label  style="font-size:11px;">Select Criteria : </label>
    <select id="catf" style="width:100px;" onchange="fch(this.value);" name="catf" class="textbox" >
    <option value="0">...Select...</option>
    <option value="Reg no">Reg no</option>
    <option value="Name">Name</option>
   
    <option value="E-mail">E-mail</option>
    <option value="Mobile">Mobile</option>
    <option value="District">District</option>
    </select>
    </th>
  
     <th id="sltst"><input name="findbtn" onclick="return rtnfnd();" type="submit" value="Find" class="button" /></th>
	</tr>
    </table>
    </form>
    <br />
    <?php 
   if(isset($_POST['findbtn']))
	{
	$cat=$_POST['catf'];
		
		
		//$live=$_POST['live'];
		if(isset($_POST['fndtxt'])) 
			{   $tval=$_POST['fndtxt']; }
		
		if($cat=='Reg no')
		{$whr1='regno="'.$tval.'"';}
		else if($cat=='Name')
		{$whr1='fname="'.$tval.'"';}
		
		else if($cat=='E-mail')
		{$whr1='email="'.$tval.'"';}
		else if($cat=='Mobile')
		{$whr1='mob="'.$tval.'"';}
		
		else
		{$whr1='';}
		
		$whrcndtn=$whr1;
		
		
	
		$cqry1q='SELECT * FROM stud_detail where '.$whrcndtn;
		$cresult = @leo_mysql_query($cqry1q);
		$jo = leo_mysql_fetch_assoc($cresult);
		$course=$jo['course'];
		$cqry1qf="SELECT * FROM course where id='$course'";
		$cresultf = @leo_mysql_query($cqry1qf);
		$jof = leo_mysql_fetch_assoc($cresultf);
		$fullcourse=$jof['Full_name'];
		$course=$jof['course_name'];
		
	}
	?>

<?php 
	}

	 if(isset($_GET['tab']) && $_GET['tab']=='pdf')
	 {
	     $regno=$_GET['pdf'];
	     $path = "pdfclass/pfiles/".$regno.".pdf";
	     $find_c_no=leo_mysql_query("select * from stud_detail where regno='$regno'");
	     $arrr=leo_mysql_fetch_array($find_c_no);
	     $cc_nn_no=$arrr['cn_no'];

	
	if(!file_exists($path))
	{
	echo '
		<fieldset class="addalbum">
 			<legend>Certificate</legend>
		 		<table  align="center" cellpadding="6" class="content_box" width="70%">
					<tbody >
				  <tr class="c8">	<td colspan="2" class="contentfont"  align="center"><strong ><div align="center">sorry...</div></strong></td>
                  </tr>
                   <tr >	<td colspan="2" class="contentfont"  align="center"><strong ><div align="center">Certificate not prepared</div></strong></td>
                  </tr>
                   <tr >	<td colspan="2"  id="footer1"align="center">IPAKERALA Online Exam - Powered by <a href="http://www.programmersglobal.com" class="powered">PROGRAMERS</a></td></tr>
					</tbody>
				</table>
    		</div>
		</fieldset>
    ';
	}
	else
	{
	//echo '<iframe src="pdfclass/pfiles/'.$regno.'.pdf"  width="720" height="500px;"></iframe></div>';
	//echo '<img src="../../images/c2.jpg" />';
	 
		$sql2h = "SELECT stud_detail.*,stud_detail.id,course.id,course.* FROM stud_detail,course where stud_detail.cn_no='".$cc_nn_no."' and course.id=stud_detail.course";
		$datagf 	= leo_mysql_query($sql2h);
		$dh			= leo_mysql_fetch_array($datagf);
		if($dh['certificate']=='1'){
		$stud_reg2 	= $dh['regno'];
	
		$seldf 		= leo_mysql_query("select * from stud_detail where regno='".$stud_reg2."'");
		$df         = leo_mysql_fetch_array($seldf);
		
		$course_id	= $df['course'];
		$offer_subjects = $df['offer_subjects'];	
		$qry 		= leo_mysql_query("select * from certificate where ( stud_reg='".$dh['regno']."')");
        $arr 		= leo_mysql_fetch_array($qry);
		
                
		$qry5 		= leo_mysql_query("select * from course where id='$course_id'");
		$arr5 		= leo_mysql_fetch_array($qry5);
		
		//$course_subjects=$arr5['subject'].','.$offer_subjects;
		$course_subjects=$arr5['subject'].$offer_subjects;
		
		//$course_subjects=$arr5['subject'];
				
		$subjects 	= str_replace(","," /",$course_subjects);
		
		//remove last //
		$subjects2 	= rtrim($subjects,'/');
	?>


            <script type="text/javascript" src="../../js/jquery-1.8.2.js"></script>
            <script type="text/javascript" src="../../js/jQuery.print.js"></script>
            <script type="text/javascript">
				$(function() {
				$("#hrefPrint").click(function() {
				// Print the DIV.
				$("#printdiv").print();
				return (false);
				});
				});
			</script>

	<style type="text/css">
	#page{ max-height:1444px;}
	
	</style>
	</div>

        <form method="post" name="form" action="" style="float:center; padding-left:600px;">
		   	<input type="hidden" name="regno" value="<?=$dh['regno'];?>" >
		   <!-- <input type="submit" name="send" value="Send via SMS/Mail"> </td>-->
		</form>
 
<?php 

//	echo '<script> alert ('.$arr['certf1'].'); </script>';

    if($arr['certf1'] != '0') { 

    	?>   

   <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">

  		<div style="clear:both; width:960px; height:auto; background:url(../../verify/images/ipa_header_05.png) no-repeat top center ; padding-top:230px;">
            
                <div style="float:center; padding-left:350px; width:200px;">
                
                    <?php echo '<img src="upload/'.$dh['photo'].'" style="width:175px; height:200px;""  />';  ?>
                     <img src="../../images/approval_01.png" alt="" style="position:absolute; margin-left:-120px; margin-top:140px;" />
                    
                </div>
                
                <div style="float:right; width:880px; line-height:50px; color:#000000;margin-right: 30px;">
 
                            <p style="font-size:18px;">IC Number : <?=$dh['regno'];?></p>
  
                <p style="font-size:18px; text-align: left; padding-left:80px;"> This is to certify that ________________<?php echo '<b><u>'.$dh['fname'].'</u></b>';?>_______________________  </p>
                <p style="font-size:18px; text-align: left; padding-left:80px;"> has successfully completed an intensive training in Manual and Computerised Accounting and has accquired a good working experience in the following areas of Practical Financial Accounting. </p>  
			<div class="content" style="padding-left: 230px;">
			   <div style="color:#000000; border: 1px solid black; width:350px; padding-left: 20px; padding-right: 20px; margin:20px; font-size:14px; line-height: 10px;">
			   						<p>Accounts Management &nbsp; &nbsp; &nbsp; &nbsp; IFRS </p>
			   						<p>Inventory Management &nbsp; &nbsp; &nbsp; &nbsp; Advanced Tally ERP 9.0 </p>
			   						<p>Tax Management &nbsp; &nbsp; &nbsp; &nbsp; Tally certification from TIL </p>
				<p>Payroll Management &nbsp; &nbsp; &nbsp; &nbsp; MOS certification in MS-Excel </p>
				<p>MIS Management &nbsp; &nbsp; &nbsp; &nbsp; Advcanced Quickbooks </p>
				<p> &nbsp; &nbsp; &nbsp; &nbsp; SAP Business One Consultants </p>
				<p> &nbsp; &nbsp; &nbsp; &nbsp; SAP End User Training </p>
	                </div> 
            </div>  

            	</div>

	        <table name="auths" style="width:800px;font-size:16px;">
	        	<tr>
					<td class="img-responsive pull-left" style="padding-left:20px;">
			           <img src="../../verify/images/seal.jpg" width="140" height="140">
			           <span class="seal"  style="padding-left:20px;">  Office Seal  </span>
			        </td>

				    <td class="issdate" width="350" style="padding-left:100px;padding-top:140px;">
				       Date Of Issue
				    </td>
					<td class="img-responsive pull-left" style="padding-left:100px;">
			           <img src="../../verify/images/single_hologram.png" width="100" height="100">
			        </td>

				  	<td class="sign" style="padding-left:200px;">
				  	<img src="../../verify/images/sign_director.jpg" width="190" height="140">
				  		 Director
				  	</td>                    
	        	</tr>                    
	     	</table>  
     	</div>  

	    <div style="clear:both;height:auto; background:url(../../verify/images/ipa_footer_2.png) no-repeat top center ; padding-top:200px;">             
	             
	    </div>
	</div>
  <br/> 
    <div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
 <?php
}
 ?>                
        
    
   <?php if($arr['certf2'] != '0') { 


   	?>      
        
    <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">

      <div style="clear:both; width:997px; height:auto; background:url(../../verify/images/cert2.jpg) no-repeat; background-size: 960px; padding-top:200px;">

                <div style="float:left; width:200px; text-align:justify;">
                
                    <?php echo '<img  src="upload/'.$dh['photo'].'" style="width:175px; height:200px;""  />';  ?>
                    
                    <img src="../../images/approval_01.png" alt="" style="position:absolute; margin-left:-120px; margin-top:140px;" />
                    
                </div>
                
             <div style="float:right; width:650px; line-height:50px; color:#000000;margin-right: 30px;">
                
                    <table style="width: 100%; border: none;">
                    
                        <tr>
                            <td style="font-size:15px;">Credential belongs to</td>
                            <td>:</td>
                            <td><span style="text-transform:uppercase; font-weight:bold; font-size:15px;"><?php echo $dh['cert_name']; ?> &nbsp; ( <?php echo $dh['regno']; ?> )</span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                        <tr>
                            <td style="font-size:15px; width:175px;">Issued by</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo "IPA";?></span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                         <tr>
                            <td style="font-size:15px;">Issued on</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo $arr['date'];?></span></td>
                        </tr>
                           <tr style="height: 25px;"></tr>
                 
                        <tr>
                            <td style="font-size:15px;">Certifications</td>
                            <td>:</td>
                           <td>
                             <span style="font-weight:bold; font-size:15px;"><?php  echo 'SAP Business One Business User'; ?></span>
                            </td>
                        </tr>
                     
                     
                                             
                    </table>
            
                
                </div>
            
            </div>
             
             
    
        </div>

        <br/>
    <div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>     
              
     <?php if($arr['certf3'] != '0') { ?>   
            
        <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">

            <div style="clear:both; width:997px; height:auto; background:url(../../verify/images/cert1.jpg) no-repeat; background-size: 960px; padding-top:200px;">
           
                <div style="float:left; width:200px; text-align:justify;">
                
                    <?php echo '<img  src="upload/'.$dh['photo'].'" style="width:175px; height:200px;""  />';  ?>
                    
                    <img src="../../images/approval_01.png" alt="" style="position:absolute; margin-left:-120px; margin-top:140px;" />
                    
                </div>
                
                <div style="float:right; width:650px; line-height:50px; color:#000000;margin-right: 30px;">
                
                    <table style="width: 100%; border: none;">
                    
                        <tr>
                            <td style="font-size:15px;">Credential belongs to</td>
                            <td>:</td>
                            <td><span style="text-transform:uppercase; font-weight:bold; font-size:15px;"><?php echo $dh['cert_name']; ?> &nbsp; ( <?php echo $dh['regno']; ?> )</span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                        <tr>
                            <td style="font-size:15px; width:175px;">Issued by</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo "IPA";?></span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                         <tr>
                            <td style="font-size:15px;">Issued on</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo $arr['date'];?></span></td>
                        </tr>
                           <tr style="height: 25px;"></tr>
                 
                        <tr>
                            <td style="font-size:15px;">Certifications</td>
                            <td>:</td>
                
                            <td>
                             <span style="font-weight:bold; font-size:15px;"><?php  echo 'SAP Business One Consultant'; ?></span>
                            </td>
                        </tr>
                    
            
                      
                    </table>
            
                
                </div>
            
            </div>
             
    
        </div>
      <br/>
    <div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
   <?php } ?>   
      
      
      
      
   <?php if($arr['certf4'] != '0') { ?>  
           
    <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">   

        <div style="clear:both; width:997px; height:auto; background:url(../../verify/images/cert3.jpg) no-repeat ; background-size: 960px; padding-top:200px;">
            
                <div style="float:left; width:200px; text-align:justify;">
                
                    <?php echo '<img  src="upload/'.$dh['photo'].'" style="width:175px; height:200px;""  />';  ?>
                    
                    <img src="../../images/approval_01.png" alt="" style="position:absolute; margin-left:-120px; margin-top:140px;" />
                    
                    
                </div>
                
                <div style="float:right; width:650px; line-height:50px; color:#000000;margin-right: 30px;">
                
                    <table style="width: 100%; border: none;">
                    
                        <tr>
                            <td style="font-size:15px;">Credential belongs to</td>
                            <td>:</td>
                            <td><span style="text-transform:uppercase; font-weight:bold; font-size:15px;"><?php echo $dh['cert_name']; ?> &nbsp; ( <?php echo $dh['regno']; ?> )</span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                        <tr>
                            <td style="font-size:15px; width:175px;">Issued by</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo "IPA";?></span></td>
                        </tr>
                        <tr style="height: 25px;"></tr>
                         <tr>
                            <td style="font-size:15px;">Issued on</td>
                            <td>:</td>
                            <td><span style="font-weight:bold; font-size:15px;"><?php echo $arr['date'];?></span></td>
                        </tr>
                           <tr style="height: 25px;"></tr>
                 
                        <tr>
                            <td style="font-size:15px;">Certifications</td>
                            <td>:</td>
                            <td>
                             <span style="font-weight:bold; font-size:15px;"><?php  echo 'SAP End User Training'; ?></span>
                            </td>
                        </tr>
               
                      
                    </table>
            
                
                </div>
            
            </div>
             
          
    
        </div>
<br/>
  	<div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>


   <?php if($arr['certf5'] != '0') { ?>      

    <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">

    	<div style="clear:both; width:960px; height:auto; background:url(../../verify/images/gst_cert_header.png) no-repeat top center ; padding-top:230px;">

           <div style="float:right; width:880px; line-height:50px; color:#000000;margin-right: 30px;">
           	        <p style="font-size:18px; text-align: right;">IC Number :  <?=$dh['regno'];?></p>
                	<h2 class="topic" style="color:red;font-size:22px;"> <b> Certificate of Participation </b> </h2>
 

  
        	<p style="font-size:18px;  text-align: center;"> This is to certify that </p><p style="font-size:18px; text-align: center;">_____________<?php echo '<b><u>'.$dh['fname'].'</u></b>';?>_____________</p>
                <p style="font-size:18px; text-align: center;"> has participated and successfully completed</p>
                <p style="font-size:18px; text-align: center;"> an intensive training practical in </p> 
           <h2 class="topic" style="color:red;font-size:22px;padding-right:30px;"> <b> GST [India]  </b> </h2>
      		<p style="font-size:18px; text-align: center;"> and has accquired practical knowledge related to </p>  
       		<p style="font-size:18px; text-align: center;"> GST Calculations | GST Accounting | GST Return Filing </p>
       		<p style="font-size:18px; text-align: center;"> from our  Institute </p>

	       		
		        <table name="auths" style="width:800px;font-size:16px;">
		        	<tr>
						<td class="img-responsive pull-left" style="padding-left:20px;">
				           <img src="../../verify/images/seal.jpg" width="140" height="140">
				           <span class="seal"  style="padding-left:20px;">  Office Seal  </span>
				        </td>

					    <td class="issdate" width="300" style="padding-left:150px;padding-top:140px;">
					       Date Of Issue
					    </td>

					  	<td class="sign" style="padding-left:200px;">
					  	<img src="../../verify/images/sign_director.jpg" width="190" height="140">
					  		 Authorized signatory
					  	</td>                    
		        	</tr>                    
		     	</table>   

            </div>

        </div>       
                
     <div style="clear:both;height:auto; background:url(../../verify/images/gst_cert_footer.png) no-repeat top center ; padding-top:200px;">             
	             
	</div>

           
    </div>

        <br>
  	<div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>  



   <?php if($arr['certf6'] != '0') { ?>      
        

    <div id="printdiv"<div style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;"> 

    	<div style="clear:both; width:960px; height:auto; background:url(../../verify/images/gulf_vat_header.png) no-repeat top center ; padding-top:230px;">
        
                <div style="float:right; width:880px; line-height:50px; color:#000000;margin-right: 30px;">
		 
		           <p style="font-size:18px; text-align: right;">Certificate ID : <?php echo $dh['regno']; ?> </p>
                	<h2 class="topic" style="color:red;font-size:22px;"> <u> <b> Certificate of Participation </b> </u> </h2>		  

		            <p style="font-size:18px;text-align: center;"> This is to certify that</p> 
		            <p style="font-size:18px; text-align: center;"> ___________<?php echo '<b><u>'.$dh['fname'].'</u></b>';?>__________  </p>
		            <p style="font-size:18px; text-align: center;">has participated and successfully completed </p>   
		            <p style="font-size:16px; text-align: center;">an intensive practical Training in <p>

           		<h2 class="topic" style="font-size:24px;padding-right:30px;"> <b> GULF VAT  </b> </h2>
             		<p style="font-size:18px;  text-align: center;"> and has accquired practical knowledge related to </p>  
       				<p style="font-size:18px; text-align: center;"> VAT Calculations | VAT Accounting | VAT Return Filing </p>
       				<p style="font-size:18px; text-align: center;"> from our  Institute </p>

	        	<table name="auths" style="width:800px;font-size:16px;">
		        	<tr>
						<td class="img-responsive pull-left" style="padding-left:20px;">
				           <img src="../../verify/images/seal.jpg" width="140" height="140">
				           <span class="seal"  style="padding-left:20px;">  Office Seal  </span>
				        </td>

					    <td class="issdate" width="300" style="padding-left:150px;padding-top:140px;">
					       Date Of Issue
					    </td>

					  	<td class="sign" style="padding-left:200px;">
					  	<img src="../../verify/images/sign_director.jpg" width="190" height="140">
					  		 Authorized signatory
					  	</td>                    
		        	</tr>                    
	     		</table>   
		   

		        </div>

            </div>       
                
		     <div style="clear:both;height:auto; background:url(../../verify/images/gulf_vat_footer.png) no-repeat top center ; padding-top:310px;">             
			             
			</div>

           
    
        </div>
    <br/>
  	<div style="text-align:center; margin-top:25px;">	
   	 	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>  
        

   <?php if($arr['certf7'] != '0') { ?>      
        

    <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">   

   		<div style="clear:both; width:960px; height:auto; background:url(../../verify/images/fico_cert_header.png) no-repeat top center ; padding-top:230px;">
        
                <div style="float:right; width:880px; line-height:50px; color:#000000;margin-right: 30px;">
		 
		           <p style="font-size:18px; text-align: right;">Certificate ID : <?php echo $dh['regno']; ?> </p>
		  
		            <p style="font-size:20px; text-align: center;"> We hereby confirm that </p>
		            <p style="font-size:20px; text-align: center;">___________<?php echo '<b><u>'.$dh['fname'].'</u></b>';?>___________  </p>
		            <p style="font-size:20px; text-align: left; padding-left:200px;"> has attended and completed the below courses  </p>   
		           <p style="font-size:20px; text-align: center;">  SAP Overview  </p>
		           <p style="font-size:20px; text-align: center;">  SAP FI and CO Overview </p>
					<p style="font-size:20px; text-align: center;">  Creating Balance Sheet and Profit & Loss in SAP </p> 
					<p style="font-size:20px; text-align: center;">  Certificate obtained via SAP Student Academy Program, 2017 </p>
		        </div>

            </div>       
                
		     <div style="clear:both;height:auto; background:url(../../verify/images/fico_cert_footer.png) no-repeat top center ; padding-top:250px;">             	             
			</div>

           
    
        </div>
        <br/>
  	<div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>  



   <?php if($arr['certf8'] != '0') { ?>      
    <div id="printdiv" style="border:solid 1px #CCCCCC; border-radius:5px; overflow:hidden; padding:25px; width: 910px;">     

    	<div style="clear:both; width:960px; height:auto; background:url(../../verify/images/fico_cert_header.png) no-repeat top center ; padding-top:230px;">

              <div style="float:right; width:880px; line-height:50px; color:#000000;margin-right: 30px;">
		 
		           <p style="font-size:18px; text-align: right;">Certificate ID : <?php echo $dh['regno']; ?> </p>
		  
		            <p style="font-size:20px; text-align: center;"> We hereby confirm that </p>
		            <p style="font-size:20px; text-align: center;">___________<?php echo '<b><u>'.$dh['fname'].'</u></b>';?>___________  </p>
		            <p style="font-size:20px; text-align: left; padding-left:200px;"> has attended and completed the below courses  </p>   
		         <p style="font-size:20px; text-align: center;">SAP Overview (including MM and SD)  </p>
		           <p style="font-size:20px; text-align: center;">  SAP FI and CO Overview </p>
					<p style="font-size:20px; text-align: center;">  Creating Balance Sheet and Profit & Loss in SAP </p> 
					<p style="font-size:20px; text-align: center;">  Certificate obtained via SAP Student Academy Program, 2017 </p>
		        </div>


            </div>       
                
		     <div style="clear:both;height:auto; background:url(../../verify/images/fico_cert_footer.png) no-repeat top center ; padding-top:260px;">             	             
			</div>
          
        </div>
        <br/>
  	<div style="text-align:center; margin-top:25px;">	
    	<a href="#" id="hrefPrint" ><img src="../../verify/images/print_button.png" alt="" width="75" /></a>
    </div>
     <?php } ?>  

	 <!--<div style="clear:both; width:950px; margin-top:50px; height:1357px; background:url(../../images/c2.jpg) no-repeat ;background-size:950px; margin-left:20px;" align="center">
	 
			 <div style="clear:both; width:950px;height:227px;">&nbsp;</div>
			 <div style="clear:both; width:950px;height:36px; text-align:center; font-size:25px; color:#000000; font-weight:bold;">
				 <?php // echo $dh['Full_name']; ?>
			 </div>
			 
			 <div style="clear:both; width:950px;height:45px;  text-align:center;">&nbsp;</div>
			 
			 <div style="clear:both; width:950px;height:120px;text-align:center; vertical-align:middle; display:table-cell;">
			 <?php // echo '<img  src="upload/'.$dh['photo'].'" />'; ?>
			 </div>
			 
			 <div style="clear:both; width:950px;height:100px; text-align:center;">&nbsp;</div>
			 
			 <div style="clear:both; width:950px;height:36px; font-family:Helvetica,Arial,sans-serif; text-align:center; font-size:15px; color:#272727; font-weight:600;">
				 IC Number : <?php //echo $dh['cn_no'];?>
			 </div>
			 
			 <div style="clear:both; width:950px;height:65px;">&nbsp;</div>
			 <div style="clear:both; width:570px;height:28px; color:#000000;  font-family:Helvetica,Arial,sans-serif; font-size:17px;margin-left:160px; text-align:center; font-weight:bold; "><i><?php // echo $dh['cert_name'];?></i></div>
			 
			 <div style="clear:both; width:950px;height:220px; ">&nbsp;</div>
			 
			 <div style="clear:both; margin-top:70px;  margin-left:21px;width:950px;min-height:40px;">
			 <?php
				/*$qry=leo_mysql_query("select * from certificate where stud_reg='".$dh['regno']."'");
				$arr=leo_mysql_fetch_array($qry);
				$c_sub=explode(',',$arr['subjects']);
				
				$cc_count=count($c_sub)-1;
				for($c=0;$c<=$cc_count;$c++)
				{*/
			?>
				<div style="clear:both;">
					<div style="float:left; width:106px; height:20px;">&nbsp;</div>
					<div style="float:left; width:27px; height:20px; <?php?> font-size:34px; margin-left:-2px;">*</div>
					<div style="float:left; width:405px; font-weight:bold; font-family:Times New Roman; text-align:left; font-size:18px; color:#696768; height:25px; margin-left:15px; color:#3F4F52;">
					 &nbsp;<?php // echo $c_sub[$c];?></div>
				</div>
			<?php
				 // }
				?>
			 	
			 </div>
	 </div>
	  <div style=" float:left;width:290px; margin-left:20px; height:40px;font-weight:bold;text-align:center; margin-top:-240px;font-weight:bold; color:#000000; font-family:Helvetica, sans-serif; font-size:17px; "><img src="theme/images/seal.jpg" width="100px;"/></div>
	  
	 <div style=" float:left; margin-left:460px; height:40px;font-weight:bold;text-align:center; margin-top:-155px;font-weight:bold; color:#000000; font-family:Helvetica, sans-serif; font-size:17px; "><?php // echo $arr['date'];?></div>
	 
	 <div style=" float:left; margin-left:630px;height:40px;font-weight:bold;text-align:center; margin-top:-175px;font-weight:bold; color:#000000; font-family:Helvetica, sans-serif; font-size:17px;"><img src="theme/images/valid.jpg" width="80px;"/></div>
	 
	 <div style=" float:left; margin-left:800px;height:40px;font-weight:bold;text-align:center; margin-top:-190px;font-weight:bold; color:#000000; font-family:Helvetica, sans-serif; font-size:17px;"><img src="theme/images/sign_director.jpg" width="100px;"/></div>-->
	 
	 <!--<div style="width:950px; height:20px; margin-top:-160px; font-weight:bold; color:#000000; font-family:Helvetica, sans-serif; font-size:17px; text-align:center;"><?php echo $arr['date'];?></div>-->

	 
	 <?php
		}
    }
	 }
	 }
//	 }
else{
	?>
    <fieldset class="addalbum">
	<legend>Certificate Validation</legend>
	<?php msgs();  ?>
	
    <br />
     <form method="post" name="from">
		<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enter the Offline Reg no: &nbsp;&nbsp;&nbsp;<input type="text" name="regno" class="textbox" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="findcert" value="Find Certificate"  class="button"/></center>
	
    </form>
	
<?php
	
echo '</fieldset></div>';
}
?>

</div>


</body>
