<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_provider = "localhost";
$database_provider = "provider";
$username_provider = "root";
$password_provider = "callmaceio2012";
$provider = mysql_pconnect($hostname_provider, $username_provider, $password_provider) or trigger_error(mysql_error(),E_USER_ERROR); 
?>