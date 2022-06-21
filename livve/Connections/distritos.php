<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_servico = "localhost";
$database_servico = "combobox";
$username_servico = "root";
$password_servico = "callmaceio2012";
$servico = mysql_pconnect($hostname_servico, $username_servico, $password_servico) or trigger_error(mysql_error(),E_USER_ERROR); 
?>