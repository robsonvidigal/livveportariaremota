<?php
require('class.mysql.php');
require('config.inc.php');

$gmtDate = gmdate("D, d M Y H:i:s"); 

header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

session_start();
if(!$_SESSION[usu_nick]){
	exit();	
}

$reser = $_POST['ireser'];
$falacom = $_POST['ifalacom'];
$cor = $_POST['icor'];
$nick = $_SESSION[usu_nick];


$nomeimg = $_FILES['imagem']['name'];
$tamanho = $_FILES['imagem']['size'];
$tipo = $_FILES['imagem']['type'];
$img = $_FILES['imagem']['tmp_name'];
		
$novonome = date('dmyhis');
switch($tipo){
	case 'image/jpeg': $ext = '.jpg'; break;
	case 'image/pjpeg': $ext = '.jpg';  break;
	case 'image/gif': $ext = '.gif'; break;
	case 'image/x-png': $ext = '.png'; break;
}

$diretorio = 'img_enviada/'.$novonome.$ext;

if(($tipo != 'image/jpeg') && ($tipo != 'image/pjpeg') && ($tipo != 'image/gif') && ($tipo != 'image/x-png')) {
	print '<script type="text/javascript"> parent.document.getElementById("interacao").innerHTML = "Tipo de arquivo inválido,<br>somente JPG, GIF ou PNG."; parent.avisaimg(2);</script>';	
}elseif($tamanho==0){
	print '<script type="text/javascript"> parent.document.getElementById("interacao").innerHTML = "Selecione uma imagem."; parent.avisaimg(2);</script>';
}elseif($tamanho > 302000){
	print '<script type="text/javascript"> parent.document.getElementById("interacao").innerHTML = "Arquivo maior que 300KB."; parent.avisaimg(2);</script>';
}else{	
	if(copy($img,$diretorio)){ 
		$tamanho = $tamanho/1024;
		$tamanho = ceil($tamanho);
	
		$mensagem = 'envia imagem:&nbsp;<font color="#006699">'.$nomeimg.' ('.$tamanho.'KB)</font>&nbsp;&nbsp;<a href="'.$diretorio.'" target="_blank"><img src="'.$diretorio.'" width="70" height="70" align="absmiddle" border="1"><font color="#FF0000">Abrir imagem</font></a>';
		//cadastra a mensagem
		$sql = new Mysql;
		
		$sql->Consulta("INSERT INTO $tabela_msg
		(reservado,usuario,cor,msg,falacom,tempo)
		VALUES 
		('$reser','$nick','$cor','$mensagem','$falacom','$tempo_msg')"); 
		print '<script type="text/javascript"> parent.document.getElementById("interacao").innerHTML = "Imagem enviada."; parent.avisaimg(1); </script>';
		
	}else{
		print '<script type="text/javascript"> parent.document.getElementById("interacao").innerHTML = "Erro ao copiar imagem.; parent.avisaimg(2);</script>';
	}		
}
?>