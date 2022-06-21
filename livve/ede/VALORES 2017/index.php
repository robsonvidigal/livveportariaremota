<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	color: #0066FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0066FF;
}
a:hover {
	text-decoration: none;
	color: #0066FF;
}
a:active {
	text-decoration: none;
	color: #0066FF;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body>
<table width="767" height="105" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="757" background="../../imagens/infdiv.png">&nbsp;</td>
  </tr>
</table>
<table width="767" height="124" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="46" height="43">&nbsp;</td>
    <td width="335">&nbsp;</td>
    <td width="386" rowspan="4" align="right" valign="top"><table width="250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="230">&nbsp;</td>
        <td width="20">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" valign="middle"><a href="../index.php" class="style2">:. Voltar .:</a></td>
        <td align="right" valign="middle"><a href="../index.php" class="style2"></a> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td align="left" valign="middle"><span class="style1">ARQUIVOS:</span></td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td align="left" valign="middle"><span class="style2">
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
#if ($pastas != "" ) { 
#foreach($pastas as $listar){
 #  print "<a href='$listar'>$listar</a><br><br>";}
  # }
// lista os arquivos se houverem
if ($arquivos != "") {
foreach($arquivos as $listar){
   print "<a href='$listar' target='_blank'>$listar</a><br><br>";}
   }
?>
    </span></td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
