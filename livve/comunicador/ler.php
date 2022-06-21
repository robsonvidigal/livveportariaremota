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
	print 'Erro ao ler mensagens, por favor reinicie o chat.';
	exit();	
}

if(empty($_SESSION['Ultimo_id'])){
	$_SESSION['Ultimo_id'] = 0;
}

$ultimo_id = $_SESSION['Ultimo_id'];
$nick = $_SESSION['usu_nick'];

$sql = new Mysql;

//atualiza tempo usuário
$sql->Consulta("UPDATE $tabela_usu SET tempo='$tempo_usu' WHERE nick = '$nick' LIMIT 1"); 

//ler as mensagens
$query = $sql->Consulta("SELECT id,reservado,usuario,msg,falacom,cor,hora
FROM $tabela_msg 
WHERE usuario != '$nick' AND id > $ultimo_id ORDER BY id ASC"); 
while ($linha = mysql_fetch_array($query)){  

	$hora = $linha['hora'];
	
	$usuario = $linha['usuario'];
	$mensagem = $linha['msg'];
	$reservado = $linha['reservado'];
	$cor = $linha['cor'];
	$falacom = $linha['falacom'];
	
	
	$_SESSION['Ultimo_id'] = $linha['id'];
	
	$mensagem = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", "<a href=\"\\0\" target='_blank'>\\0</a>", $mensagem);

/*	
       // ATENÇÃO .. NICK SOU SEMPRE EU
       // dirigi-me a ele no reservado	
	if(($usuario == $nick) && ($reservado != 0)) {
		$classe = 'reservado';
                           }else{
		$classe = 'publico';
	               }	  */

/*		                        
      // dirigiu-se a min no reservado		
	if(($falacom == $nick) && ($reservado != 0)) {
		$classe = 'reservado';	
                           }else{
		$classe = 'publico';
	               }	  */
	               
      // dirigi-me a ele fora do reservado	
	if(($usuario == $nick) && ($reservado == 0)) {
		$classe = 'separador';			
                           }else{
		$classe = 'publico';
	               }	
      // dirigiu-se a min fora do reservado	    
     if(($falacom == $nick) && ($reservado == 0)) {
		$classe = 'separador';	
		             }else{
		$classe = 'publico';
	               }	
	
	$ver = $falacom;
	if($ver == $nick){
		$ver = 'voc&ecirc;';
	}
	
	$usuario = htmlentities($usuario);
		
	if(($reservado != 0) && ($falacom == $nick)){
	             $classe = 'reservado';
		print '<div class="'.$classe.'">(<i>'.$hora.'</i>) <b><font color="'.$cor.'">'.$usuario.'</font></b> <i>reservadamente fala com</i> <b>'.$ver.'</b>: '.$mensagem.'<br></div>';
	                           }

	if(($reservado != 0) && ($usuario == $nick)){
	             $classe = 'reservado';
		print '<div class="'.$classe.'">(<i>'.$hora.'</i>) <b><font color="'.$cor.'">'.$usuario.'</font></b> <i>reservadamente fala com</i> <b>'.$ver.'</b>: '.$mensagem.'<br></div>';
	                          }
	                                                   
		if($reservado == 0){
			print '<div class="'.$classe.'">(<i>'.$hora.'</i>) <b><font color="'.$cor.'">'.$usuario.'</font></b> <i>fala com</i> <b>'.$ver.'</b>: '.$mensagem.'<br></div>';
		}
			
}
ob_end_flush();
?>