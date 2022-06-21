<?php require_once('../Connections/provider.php'); ?>
<?php
mysql_select_db($database_provider, $provider);
$query_naconsulta = "SELECT * FROM tb_na ORDER BY id DESC";
$naconsulta = mysql_query($query_naconsulta, $provider) or die(mysql_error());
$row_naconsulta = mysql_fetch_assoc($naconsulta);
$totalRows_naconsulta = mysql_num_rows($naconsulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Boletim Operacional ::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 5px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}
a:link {
	color: #8C0209;
	text-decoration: none;
}
a:visited {
	color: #8C0209;
	text-decoration: none;
}
a:hover {
	color: #8C0209;
	text-decoration: underline;
}
a:active {
	color: #8C0209;
	text-decoration: none;
}
.style19 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.style21 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
	font-weight: bold;
}
.style22 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.style46 {font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
-->
</style>

<script type='text/javascript'>
function Fechar() {

fechar = window.open(window.location, "_self");
fechar.close();
} 
setTimeout("javascript:Fechar();",100); //definir o tempo 100 significa 1 segundo

</script>

</head>

<body>
<table width="720" height="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
      <tr>
        <td width="123" align="center" valign="middle"><img src="imagens/logo_casal.png" width="93" height="53" /></td>
        <td width="410" align="center" valign="middle"><div align="center" class="style48">NOTIFICA&Ccedil;&Atilde;O 
          DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
        <td width="159" align="center" valign="middle"><div align="center" class="style48">Call 
          Center </div></td>
      </tr>
    </table>
        <table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="style46">
          <tr>
            <td width="436" align="left" valign="bottom"><span class="style46">SOLICITA&Ccedil;&Atilde;O ENVIADA COM SUCESSO.</span></td>
            <td width="138" align="left" valign="bottom"><a href="/pastadenadigitalcallcenter/na-consulta.php" class="style27"><strong>NOVO REGISTRO</strong></a></td>
            <td width="118" align="left" valign="bottom"><label class="style46"><a href="javascript:window.close()" class="style22">FECHAR JANELA </a></label></td>
          </tr>
        </table>
      <table width="710" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td align="left" valign="baseline"><label class="style46"></label></td>
          </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($naconsulta);
?>