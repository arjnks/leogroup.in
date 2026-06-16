<?php
error_reporting(0);
require_once __DIR__ . '/secure_init.php';

//--------------connecting db server-------------//
$connection = leo_mysql_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
if(!$connection) {die('Failed to connect to server: ' . leo_mysql_error()); }
//--------------connecting db-------------//
$db = leo_mysql_select_db($_ENV['DB_NAME']);
if(!$db) {die("Unable to select database");}
//--------------Uploading folder settings (don't change)-------------//
$uploaddir = '../../uploads/';	
$viewdir = './../uploads/';
$upload_folder='./../uploads/';	
//-------------no. rows of items -------------//
$count='30';
if(isset($_GET['p']) && $_GET['p']=='customers' && isset($_GET['tab']) && $_GET['tab']=='g_pas'){ $count='100';} // 100 no of lines for customer view page
// --------- set indian time ------------------------------//
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$date = time();
$ip = $_SERVER['REMOTE_ADDR']; 

//------------- company details  -------------//  
$companymail = "info@leogroup.in";
$company_phone = "+91 487 2422869, 2421653 ";
$company_mobile = ""; 
$sitename = "www.leogroup.in";

//-------------- sms settings -------------// 

$smsusername=urlencode(""); 
$smspassword=urlencode(""); 
$smssender=urlencode(""); 
$smsdomain="sms.kuruvy.com"; 
$priority=2; 

?>