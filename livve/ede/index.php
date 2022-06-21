<?php require_once('../Connections/logados.php'); ?>
<?php
mysql_select_db($database_logados, $logados);
$query_logpresente = "SELECT ip FROM usersonline ORDER BY ip ASC";
$logpresente = mysql_query($query_logpresente, $logados) or die(mysql_error());
$row_logpresente = mysql_fetch_assoc($logpresente);
$totalRows_logpresente = mysql_num_rows($logpresente);

//Config:
$local ="localhost";
$user ="root"; //Usuário do DataBase
$senha="callmaceio2012"; //Senha do DataBase
$db ="contador"; //DataBase
$tempmins = 5; //minutos para inatividade de um usuário
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Refresh" content="180"/>
<title>:: INFORMATIVOS DIVERSOS ::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
}
a:link {
	color: #0033FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0033FF;
}
a:hover {
	text-decoration: none;
	color: #0033FF;
}
a:active {
	text-decoration: none;
	color: #0033FF;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #0033FF;
}
-->
</style></head>

<body>
<table width="767" height="105" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="757"><img src="../imagens/infdiv.png" width="767" height="105" /></td>
  </tr>
</table>
<table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="46" height="25">&nbsp;</td>
    <td width="335">&nbsp;</td>
    <td width="386" rowspan="3" align="right" valign="top"><table width="318" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><span class="style2">
          <?php

//C&oacute;digo:
$ip=$_SERVER['REMOTE_ADDR']; //pega o IP do visitante
$res = mysql_connect("$local", "$user", "$senha") or die ("Erro de conex&atilde;o"); //conecta com o DB
mysql_select_db($db,$res); //seleciona o DB
if(mysql_num_rows(mysql_query("SELECT * FROM usersonline WHERE ip='".$ip."'"))>0) { //verifica se o ip ja esta no DB
//ja que ele est&aacute; &eacute; necessario dar um update no time para que ele n&atilde;o seja deletado rapdamente
mysql_query('UPDATE usersonline SET time="'.time().'" WHERE ip="'.$ip.'"');
} else {
//ele n&atilde;o est&aacute; no DB, ent&atilde;o prescisamos inseri-lo
mysql_query('INSERT INTO usersonline (ip,time) VALUES ("'.$ip.'","'.time().'")');
}
mysql_query('DELETE FROM usersonline WHERE time<'.(time()-($tempmins*60))); //deleta os ips com mais de 5 minutos
echo mysql_num_rows(mysql_query("SELECT * FROM usersonline")).' usu&aacute;rios online'; //Mostra na pagina os usuarios online

?>
        </span></td>
        <td height="28" align="right" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td width="174" align="right" valign="top" class="style2">&nbsp;</td>
        <td width="119" align="right" valign="top"><span class="style2">
          <?php do { ?>
            <img src="../imagens/icone_usuario.jpg" width="18" height="18" /> <?php echo $row_logpresente['ip']; ?><br>
            <?php } while ($row_logpresente = mysql_fetch_assoc($logpresente)); ?></span></td>
        <td width="21" height="28" align="right" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="style1">
      <?php
// pega o endere&ccedil;o do diret&oacute;rio
$diretorio = getcwd(); 
// abre o diret&oacute;rio
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado &eacute; uma pasta
   		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item &agrave; vari&aacute;vel de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item &agrave; vari&aacute;vel de arquivos
			$arquivos[]=$listar;
		}
   }
}

// lista as pastas se houverem
if ($pastas != "" ) { 
foreach($pastas as $listar){
   print "<a href='$listar'>$listar</a><br><p>";}
   }
// lista os arquivos se houverem
#if ($arquivos != "") {
#foreach($arquivos as $listar){
   #print " Arquivo: <a href='$listar'>$listar</a><br>";}
   #}
?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($logpresente);
?>
