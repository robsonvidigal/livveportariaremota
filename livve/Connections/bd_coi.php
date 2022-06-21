<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bd_coi = "localhost";
$database_bd_coi = "coi";
$username_bd_coi = "root";
$password_bd_coi = "callmaceio2012";
$bd_coi = mysql_pconnect($hostname_bd_coi, $username_bd_coi, $password_bd_coi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>