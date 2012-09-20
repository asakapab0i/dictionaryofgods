<?php

$host = "localhost";
$loginame = "root";
$logpassword = "";
$db_name = "dictionary";


mysql_connect("$host", "$loginame", "$logpassword") or die("cannot connect");
mysql_select_db("$db_name") or die("cannot select DB");
?>
