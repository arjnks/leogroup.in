<?php
$month=array(1=>"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; }; 
$start_from = ($page-1)*$count; 
$next_page = ($page+1); 


function datesplit($date,$var)
{
list($year, $month, $day) = split('[-]', $date);
if($var=="year"){return $year;}
else if($var=="day"){return $day;}
else if($var=="month"){return $month;}
}



// ---------------------  Setting active links  ------------------- //
function activelink($val)
{
	if(isset($_GET['tab']) && $_GET['tab']==$val) 
		{
		echo ' class="active" ';
		}
}
// ---------------------  /Setting active links  ------------------- //

// ------- album list for event gallery ---------------------//
function album_list($albm)
{
	$cresult = @leo_mysql_query("SELECT * FROM `album`");
	while($row = leo_mysql_fetch_array($cresult))
	{
		if($row['id']==$albm) {  $s='selected'; } else { $s=''; }
		echo '<option '.$s.' value="'.$row['id'].'">'.$row['name'].'</option>';
	}
}

// ---------------------  clean values Function  ------------------- //	
function clean($str) 
{
$str = @trim($str);
if(get_magic_quotes_gpc()) {$str = stripslashes($str);	}
return leo_mysql_real_escape_string($str);
}
// ---------------------  clean values Function ends  ------------------- //	

// ---------------------  get url config starts  ------------------- //		   
function curPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 echo  $pageURL;
 }
 
 
 
 function curPageURL1() {
 $pageURL = 'http';
 if(isset($_SERVER["HTTPS"])) 
 {
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 }
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
return  $pageURL;
 }
// --------------------- / get url config starts  ------------------- //	

function enc()
{
echo base64_decode('
PC9oZWFkPg0KPGJvZHk+DQo8ZGl2IGlkPSJjb250YWluZXIiPg0KPCEtLSBhdXRob3IgOiBqaXRoaW4ua3IgKGppdGhpbmtyNEBnbWFpbC5jb20pLS0+'); 
}

function my_enc()
{
echo base64_decode('
PCEtLSBhdXRob3IgOiBqaXRoaW4ua3IgKGppdGhpbmtyNEBnbWFpbC5jb20pLS0+DQo='); 
}

#---------------- random password gen.-------------------
function generatePassword($length, $strength) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
#---------------- random password gen.-------------------

// video exploding funtion --------------------
function vdo_exp($url)
{
	$vdo=explode('/',$url);
	$cc=count($vdo);
	$v_cd=$vdo[$cc-1];
	
	if(strstr($v_cd, "v="))
	{
		$n_cod=explode('v=',$v_cd);
		$new_vcod=$n_cod[1];
		if(strstr($new_vcod, "&"))
		{
			$n_cods=explode('&',$new_vcod);
			$new_vcods=$n_cods[0];
			return $new_vcods;
		}
		else{ return $new_vcod; }
	}
	else
	{ return $v_cd;	}
}
// ------- // video explode ends -------------


// `-------------	email validation/
function ValidateEmail($email)
{
	$regex = "([a-z0-9_.-]+)@([a-z0-9.-]+){2,255}.([a-z])"; # domain extension 
	$eregi = eregi_replace($regex, '', $email);
	return empty($eregi) ? true : false;
}
// `-------------	email validation /



// Paragraph filter ------------------
function parafilter($para)
{
   $para = preg_replace('(\[b\](.+?)\[\/b\])is', '<b>$1</b>', $para);
   $para = preg_replace('(\[i\](.+?)\[\/i\])is', '<i>$1</i>', $para);
   $para = preg_replace('(\[u\](.+?)\[\/u\])is', '<u>$1</u>', $para);
   $para = preg_replace('(\n)is', '<br />', $para);
   return trim($para);
}
// Paragraph filter -----------------





// short long texts ------------------
function shorttext($text)
{
if (strlen($text)>=51){return substr($text,0,50).'...';}
else
return $text;
}

function smalltext($text,$length)
{
if (strlen($text)>=$length){return substr($text,0,$length).'...';}
else
return $text;
}
// short long texts ------------------



// messages error, success , warning

function msgs()
{

if(isset($_SESSION['SUCMSG'])){ echo  '<div class="sucmsg">'.$_SESSION['SUCMSG'].'</div>'; clearerrormsg(); }
if(isset($_SESSION['ERRMSG'])){ echo  '<div class="errormsg">'.$_SESSION['ERRMSG'].'</div>';clearerrormsg(); }

if(isset($_SESSION['AERRMSG']) && is_array($_SESSION['AERRMSG']) && count($_SESSION['AERRMSG']) >0)
{ echo  '<div class="errormsg"><ul>';
foreach($_SESSION['AERRMSG'] as $msg) {echo '<li>'.$msg.'</li>'; }
echo '</ul></div>';unset($_SESSION['AERRMSG']); }

if(isset($_SESSION['WARNMSG'])){ echo  '<div class="warnmsg">'.$_SESSION['WARNMSG'].'</div>'; clearerrormsg(); }
}

function clearerrormsg()
{unset($_SESSION['SUCMSG'],$_SESSION['ERRMSG'] ,$_SESSION['AERRMSG'],$_SESSION['WARNMSG'] ); }

// messages error, success , warning



function logout()
{
unset($_SESSION['adminlogin']);
clearerrormsg();
header("location: ./");
exit();
}


function mailsend($from,$subject,$message)
{
	$to="pooramkuries@gmail.com";
	$theboundary = md5(uniqid(""));
	$header = "From: :".$from;
	$header .= "\nMIME-Version: 1.0";
	$header .= "\nContent-Type: multipart/alternative;";
	$header .= "\n        boundary=\"----=_NextPart_$theboundary\"";
	$header .= "\nX-Priority: 3";
	$header .= "\nX-MSMail-Priority: Normal";
	
	$body = "This is a multi-part message in MIME format.\n\n";
	$body = "------=_NextPart_$theboundary\nContent-Type: text/plain;\n\n";
	$body .= "\n------=_NextPart_$theboundary\nContent-Type: text/html;\n\n";
	$body .=$message;
	$body .= "\n\n";
	//mail($to, $subject, $body, $header);

}
#---------------------------- send sms ---------------------------->
function sendsms($no,$chitty_no,$cust_no,$message,$smsusername,$smspassword,$smssender,$smsdomain,$co_unt,$priority)
{
$date=time();
$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content' => "username=$smsusername&password=$smspassword&sender=$smssender&to=$no&message=$message&priority=$priority",
    'header'=>"Accept-language: en\r\n" .  "Cookie: foo=bar\r\n"
  ));
$context = stream_context_create($opts);
$fp = fopen("http://$smsdomain/pushsms.php", "r", false, $context);
$response = @stream_get_contents($fp);
if( $response=="Wrong Username or password.") {$error[]="Wrong Username or password for sms access ";}
if( $response=="Sorry, you dont have enough credits to process!") {$error[]="Sorry, you dont have enough credits to process!";}

if($error) 
{
$_SESSION['AERRMSG']=$error;
session_write_close();
header("Location:".$_SERVER[HTTP_REFERER]);
exit();
}
else
{
 $insrt=leo_mysql_query("insert into smslog (`chitty_no`,`cust_id`,`mobile`,`message`,`status`,`date`) values('$chitty_no','$cust_no','$no','$message','1','$date')");
if($insrt){$co_unt=$co_unt+1;}
}
fpassthru($fp);
fclose($fp);
return $co_unt;
}
#----------------------------/ send sms ---------------------------->

# --------- send sms to one ----------------------------------------->
function sendonesms($no,$message,$smsusername,$smspassword,$smssender,$smsdomain,$priority)
{
$date=time();
$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content' => "username=$smsusername&password=$smspassword&sender=$smssender&to=$no&message=$message&priority=$priority",
    'header'=>"Accept-language: en\r\n" .  "Cookie: foo=bar\r\n"
  ));
$context = stream_context_create($opts);
$fp = fopen("http://$smsdomain/pushsms.php", "r", false, $context);
$response = @stream_get_contents($fp);
if( $response=="Wrong Username or password.") {$error[]="Wrong Username or password for sms access ";}
if( $response=="Sorry, you dont have enough credits to process!") {$error[]="Sorry, you dont have enough credits to process!";}

if($error) 
{
$_SESSION['AERRMSG']=$error;
session_write_close();
header("Location:".$_SERVER[HTTP_REFERER]);
exit();
}
else
{ $co_unt=$co_unt+1; }
fpassthru($fp);
fclose($fp);
return $co_unt;
}

# =-------------------------------//---------------------------------

#---------------------------- sms balance ---------------------------->
function smsbalance($smsusername,$smspassword,$smsdomain,$priority)
{
$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content' => "username=$smsusername&password=$smspassword&priority=$priority",
    'header'=>"Accept-language: en\r\n" .  "Cookie: foo=bar\r\n"
  ));

$context = stream_context_create($opts);
$fp = fopen("http://sms.kuruvy.com/balancecheck.php", "r", false, $context);
echo $response = @stream_get_contents($fp);
fpassthru($fp);
fclose($fp);
}
#---------------------------- sms balance ---------------------------->
?>