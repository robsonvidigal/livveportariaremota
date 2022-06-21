<?php
require('class.mysql.php');
require('config.inc.php');

ob_start();
$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

session_start();
if(!$_SESSION['usu_nick']){
	print 'Erro ao ler usuários, por favor reinicie o chat.';
	exit();	
}

$nick = $_SESSION['usu_nick'];
$aspas = '"';
$cerq = '#';
$sql = new Mysql;
//deleta usuários antigos
$sql->Consulta("DELETE FROM $tabela_usu  WHERE tempo < $tempovida"); 
//deleta mensagens antigas
$sql->Consulta("DELETE FROM $tabela_msg  WHERE tempo < $tempovida"); 

//seleciona usuários
$query = $sql->Consulta("SELECT id,nick,frase,cor FROM $tabela_usu ORDER BY id ASC"); 
while ($linha = mysql_fetch_array($query)){  

	$alt = '';
	$usuario = $linha['nick'];
	$frase = $linha['frase'];
	$id = $linha['id'];
	$cor = $linha['cor'];
	
	/*
	if($frase != ''){
		$alt = 'title="'.$frase.'"';
	}  */
	
		if(($frase != '2') && ($frase != '3')){
		print '<img src="icones/on.gif" title="Conectado">&nbsp;';
		$title = 'Conectado';
	}
	if($frase == '2'){
		print '<img src="icones/voltoja.gif" title="Volto logo">&nbsp;';
		$title = 'Volto logo';
	}
	if($frase == '3'){
		print '<img src="icones/ausente.gif" title="Ausente">&nbsp;';
		$title = 'Ausente';
	}
	
	
	$usuario = htmlentities($usuario);
	print "&nbsp;&nbsp;<a href=".$cerq." onClick=".$aspas."javascript:falarcom('".$usuario."','".$frase."','".$id."');".$aspas." ".$alt."><font color=".$cor.">".$usuario."</font></a><br>";
}

ob_end_flush();
?>