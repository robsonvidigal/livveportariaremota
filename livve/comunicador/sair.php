<?php
require('class.mysql.php');
require('config.inc.php');
$horasaida = date('H:i:s');

session_start();

$nick = $_SESSION[usu_nick]; 

$sql = new Mysql;

$sql->Consulta("INSERT INTO $tabela_msg
(reservado,usuario,cor,msg,falacom,tempo,horasaida)
VALUES 
('0','$nick','#006699','saiu da sala.','Todos','$tempo_msg','$horasaida')"); 

$sql->Consulta("DELETE FROM $tabela_usu  WHERE nick='$nick' LIMIT 1"); 
			
@session_destroy();
header('Location:index.php'); 
?>