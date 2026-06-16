<?php
session_start();
$captcha=$_SESSION['security_number2'];
error_reporting(0);
if ($captcha==$_POST["capt"])
 {
	$email=$_POST["email"];
	$name=$_POST["name"];
	$phn=$_POST["phn"];
	$msg=$_POST["msg"];
// More headers
   $headers = "From:". $email." . "."\r\n" ."CC: sidharthram@leogroup.in";
	mail("sidharthram@leogroup.in","Enquiry from $name",$phn."\n".$msg,$headers);
	echo "Email send Success fully";
}
else
 echo "1";
?>