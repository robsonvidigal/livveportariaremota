<?php

    include_once("../connect/connection.php");

	//Inserindo filtro de pesquisa
	$filtro = isset($_GET['filtro'])?$_GET['filtro']:"";

    //Consulta
    $sql = "SELECT * FROM usuarios WHERE profissao LIKE '%$filtro%' ORDER BY nome";
    $consulta = mysqli_query($conexao, $sql);
    $registros = mysqli_num_rows($consulta);

?>