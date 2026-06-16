<?php
    $host     =  "localhost";
    $uname    =  "leogroup_stockup";
    $pwd      =  "oZ?E!iup$)Th";  
    $dbname   =  "leogroup_stock";
	$db_con   = new PDO("mysql:host=$host;dbname=$dbname", $uname, $pwd);
    $db_con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>