<?php require_once('../Connections/provider.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../areaadministrativa_da_informcao/operadoresesistemas_inserir.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_naconsulta = "-1";
if (isset($_GET['id'])) {
  $colname_naconsulta = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_naconsulta = sprintf("SELECT * FROM tb_na WHERE id = %s", $colname_naconsulta);
$naconsulta = mysql_query($query_naconsulta, $provider) or die(mysql_error());
$row_naconsulta = mysql_fetch_assoc($naconsulta);
$totalRows_naconsulta = mysql_num_rows($naconsulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>N.A. DIGITAL</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000099;
	text-decoration: none;
}
a:visited {
	color: #000099;
	text-decoration: none;
}
a:hover {
	color: #000099;
	text-decoration: underline;
}
a:active {
	color: #000099;
	text-decoration: none;
}
.style19 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.style21 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
}
.style23 {
	font-size: 10px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #000099;
}
-->
</style>

<script type='text/javascript'>
function Fechar() {

fechar = window.open(window.location, "_self");
fechar.close();
} 
setTimeout("javascript:Fechar();",100); //definir o tempo 1000 significa 1 segundo

</script>

</head>

<body>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr valign="baseline">
    <td width="684" height="67" align="left" nowrap="nowrap"><table width="680" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="123" align="center" valign="middle"><img src="imagens/logo_casal.png" width="93" height="53" /></td>
        <td width="410" align="center" valign="middle"><div align="center" class="style19">NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
        <td width="159" align="center" valign="middle"><div align="center" class="style19">Call Center </div></td>
      </tr>
    </table>
      <table width="680" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td width="519" valign="middle"><span class="style21">ALTERA&Ccedil;&Atilde;O REALIZADA COM SUCESSO. </span></td>
          <td width="155" valign="middle"><input type="button" name="btFechar" value="Fechar" onclick="javascript:window.close()";" /></td>
        </tr>
	<tr>
          <td width="519" valign="middle"></span></td>
          <td width="155" valign="middle"></td>
        </tr>
    </table></td>
  </tr>
  <tr valign="baseline">
    <td height="19" align="left" valign="top" nowrap="nowrap">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($naconsulta);
?>