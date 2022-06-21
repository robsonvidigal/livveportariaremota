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
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
}
a:link {
	color: #0099FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0099FF;
}
a:hover {
	text-decoration: none;
	color: #00CCFF;
}
a:active {
	text-decoration: none;
	color: #0099FF;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #0033FF;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style1">
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
   print "<a href='$listar' target='_blank'>$listar</a><br>";}
   }
// lista os arquivos se houverem
#if ($arquivos != "") {
#foreach($arquivos as $listar){
   #print " Arquivo: <a href='$listar'>$listar</a><br>";}
   #}
?>
    </span></td>
  </tr>
</table>
</body>
</html>
