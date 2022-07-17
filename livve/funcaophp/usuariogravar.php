<?php

    include_once("../connect/connection.php");

    //Recebendo dados da index atraves do comando POST
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
	$profissao = $_POST['profissao'];
	$h_registro = $_POST['h_registro'];
    $d_registro = $_POST['d_registro'];
    $ip_registro = $_POST['ip_registro'];

    //Armazenando comando SQL
    $sql = "INSERT INTO usuarios (nome, email, sexo, profissao, h_registro, d_registro, ip_registro) 
            values ('$nome', '$email', '$sexo', '$profissao', '$h_registro', '$d_registro', '$ip_registro')";

    //Salvando dados
    $salvar = mysqli_query($conexao, $sql);

    //Confirmação de cadastro ou dublicidade de cadastro (email)

    $linhas = mysqli_affected_rows($conexao);

    mysqli_close($conexao);
?>
