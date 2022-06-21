<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bd_casal = "localhost";
$database_bd_casal = "provider";
$username_bd_casal = "root";
$password_bd_casal = "callmaceio2012";
$bd_casal = mysql_pconnect($hostname_bd_casal, $username_bd_casal, $password_bd_casal) or trigger_error(mysql_error(),E_USER_ERROR); 
?>