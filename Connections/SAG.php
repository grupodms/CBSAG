<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_SAG = "localhost";
$database_SAG = "lg000185_SAG";
$username_SAG = "lg000185_SAG";
$password_SAG = "ZAwe55bano";
#error_reporting(E_ALL ^ E_DEPRECATED);
#$SAG = mysql_pconnect($hostname_SAG, $username_SAG, $password_SAG) or trigger_error(mysql_error(),E_USER_ERROR); 
#error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
$SAG = mysql_connect($hostname_SAG,$username_SAG,$password_SAG);
if (!$SAG) {
    die("No pudo conectarse: " . mysql_error());
}

?>