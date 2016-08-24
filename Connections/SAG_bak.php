<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Canainpa = "localhost";
$database_Canainpa = "lg000185_SAG";
$username_Canainpa = "lg000185_SAG";
$password_Canainpa = "ZAwe55bano";
#echo $hostname_Canainpa."<BR>";
#echo $database_Canainpa."<BR>";
#echo $username_Canainpa."<BR>";
#echo $password_Canainpa."<BR>";


$Canainpa = mysql_connect($hostname_Canainpa,$username_Canainpa,$password_Canainpa);
	
	if($Canainpa)
	{
	$Canainpa2=mysql_select_db($database_Canainpa,$Canainpa);

	if (!$Canainpa2)
	{


	}
	

	 
	}
	else
	{
	echo "Error al conectar";
	echo mysql_error();
	$Canainpa = mysql_pconnect($hostname_Canainpa, $username_Canainpa, $password_Canainpa) or trigger_error(mysql_error(),E_USER_ERROR);
	}
	
	
	

	



?>