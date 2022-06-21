<?php
require('class.mysql.php');
require('config.inc.php');

$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

$estilo = $_POST['estilo'];

session_start();
if(!$_SESSION[usu_nick]){
	exit();	
}

$nick = $_SESSION[usu_nick];
		
//para evitar problemas com javascript
$estilo = str_replace('"',' ',$estilo);
$estilo = str_replace(';','',$estilo);
$estilo = str_replace('(','',$estilo);
$estilo = str_replace(')','',$estilo);
$estilo = str_replace("'"," ",$estilo);
$estilo = str_replace('|','',$estilo);

//atualiza o estilo
$sql = new Mysql;
$sql->Consulta("UPDATE $tabela_usu SET estilo='$estilo' WHERE nick='$nick' LIMIT 1"); 
?>