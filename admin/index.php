<?php
session_start();
require_once("./system/config.php"); 
require_once("./system/functions.php");
require_once("./system/engin.php");
require_once("./modules/classes.php");
if(!isset($_SESSION['adminlogin'])) {include('./modules/login.php');}
else {
if(isset($_GET['p']) && $_GET['p']=='message'){ include('./modules/message.php');}
else if(isset($_GET['p']) && $_GET['p']=='customers'){ include('./modules/customers.php');}
else if(isset($_GET['p']) && $_GET['p']=='ledger'){ include('./modules/ledger.php');}

else if(isset($_GET['p']) && $_GET['p']=='ledgertest'){ include('./modules/ledgertest.php');}

else if(isset($_GET['p']) && $_GET['p']=='sendmail'){ include('./modules/sendmails.php');}
else if(isset($_GET['p']) && $_GET['p']=='sendsms'){ include('./modules/sendsms.php');}
else if(isset($_GET['p']) && $_GET['p']=='settings'){ include('./modules/settings.php');}
else if(isset($_GET['p']) && $_GET['p']=='logout'){ logout();}
else { include('./modules/home.php');}
}
?>
