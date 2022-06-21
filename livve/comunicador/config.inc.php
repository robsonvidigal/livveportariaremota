<?php 
/* Chat em ajax X-Chat
   Autor do Chat: Hedi Carlos Minin
   http://www.xlinkweb.com.br

  chat x-chat em ajax versуo xq 1.0
  Demonstraчуo e download em: http://guia.xq.com.br/chat2/
  
 */

$tempovida = time(); //tempo atual
$tempo_usu = time() + 2880;//tempo em que o usuario fica no banco de dados
$tempo_msg = time() + 2880;//tempo em que as mensagens ficam no banco de dados
//tabelas
$tabela_msg = 'chat_msg';
$tabela_usu = 'chat_usu';
//configuraчѕes gerais
$rodape = '';
$titulo = '';
$maxusu = 20;

//funcoes
function sql_inject($campo){
	$campo = get_magic_quotes_gpc() == 0 ? addslashes($campo) : $campo;
	$campo = strip_tags($campo);
	return preg_replace("@(--|\#|\*|;|=)@s", "", $campo); 
}
?>