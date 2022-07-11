<?php

    //Inicio da conexção do database
    $hostname = "localhost";
    $user = "root";
    $password = "callmaceio2012";
    $database = "db_boletim";
    $conexao = mysqli_connect($hostname, $user, $password, $database);

    //Erro de conexão
    if (!$conexao) {
        echo "Falha na conexão com Banco de Dados!";
    }    

?>