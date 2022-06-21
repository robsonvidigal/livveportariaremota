<?php
require('class.mysql.php');
require('config.inc.php');

$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

$estado = $_POST['estado'];

session_start();
if(!$_SESSION[usu_nick]){
	exit();	
}

$nick = $_SESSION[usu_nick];
		
//para evitar problemas com javascript
$estado = str_replace('"',' ',$estado);
$estado = str_replace(';','',$estado);
$estado = str_replace('(','',$estado);
$estado = str_replace(')','',$estado);
$estado = str_replace("'"," ",$estado);
$estado = str_replace('|','',$estado);

//atualiza o estado
$sql = new Mysql;
$sql->Consulta("UPDATE $tabela_usu SET frase='$estado' WHERE nick='$nick' LIMIT 1"); 
?>