<?php

    //Inicio da conexção do database
    $hostname = "localhost";
    $database = "db_boletim";
    $username = "root";
    $password = "callmaceio2012";
    $db_boletim = mysql_pconnect ($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERRO);

?>