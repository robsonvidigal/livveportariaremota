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

$MM_restrictGoTo = "../areaadministrativa_da_informcao/login.php";
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
?><?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE login SET nome=%s, matricula=%s, login=%s, senha=md5(%s), nivel=%s, inicio=%s, fim=%s, supervisor=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['matricula'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nivel'], "text"),
                       GetSQLValueString($_POST['inicio'], "text"),
                       GetSQLValueString($_POST['fim'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "trocarsenha-pass-ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_trocadesenha = "-1";
if (isset($_GET['id'])) {
  $colname_trocadesenha = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_trocadesenha = sprintf("SELECT * FROM login WHERE id = %s", $colname_trocadesenha);
$trocadesenha = mysql_query($query_trocadesenha, $provider) or die(mysql_error());
$row_trocadesenha = mysql_fetch_assoc($trocadesenha);
$totalRows_trocadesenha = mysql_num_rows($trocadesenha);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>:: Trocar senha ::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003466;
}
a:link {
	color: #CCCCCC;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #CCCCCC;
}
a:hover {
	text-decoration: underline;
	color: #FFFFFF;
}
a:active {
	text-decoration: none;
	color: #FFFFFF;
}
.style40 {
	font-size: 12px;
	color: #8C0209;
	font-family: Georgia, "Times New Roman", Times, serif;
}
-->
</style>

<script language="JavaScript">
function validaCampoObrigatorio(form1){
            var erro=0;
            var legenda;
            var obrigatorio;           
            for (i=0;i<form1.length;i++){
                        obrigatorio = form1[i].lang;
                        if (obrigatorio==1){
                                   if (form1[i].value == ""){
                                               var nome = form1[i].name;
                                               mudarCorCampo(form1[i], 'red');
                                               legenda=document.getElementById(nome);
                                               legenda.style.color="red";
                                               erro++;
                                   }
                        }
            }
            if(erro>=1){
                        alert("Existe(m) " + erro + " campo(s) obrigatório(s) vazio(s)! ")
                        return false;
            } else
                        return true;
}

function mudarCorCampo(elemento, cor){
            elemento.style.backgroundColor=cor;
}
</script>
</head>

<body>
<table width="302" height="83" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th valign="top" scope="col"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table width="253" align="center">
          
          <tr valign="baseline">
            <td width="59" align="center" nowrap class="style1 style40">SENHA:</td>
            <td width="214" valign="baseline"><input type="password" name="senha" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td colspan="2" align="center" nowrap><input type="submit" value="TROCAR SENHA"></td>
          </tr>
        </table>
        <input type="hidden" name="nome" value="<?php echo $row_trocadesenha['nome']; ?>">
        <input type="hidden" name="matricula" value="<?php echo $row_trocadesenha['matricula']; ?>">
        <input type="hidden" name="login" value="<?php echo $row_trocadesenha['login']; ?>">
        <input type="hidden" name="nivel" value="<?php echo $row_trocadesenha['nivel']; ?>">
        <input type="hidden" name="inicio" value="<?php echo $row_trocadesenha['inicio']; ?>">
        <input type="hidden" name="fim" value="<?php echo $row_trocadesenha['fim']; ?>">
        <input type="hidden" name="supervisor" value="<?php echo $row_trocadesenha['supervisor']; ?>">
        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="id" value="<?php echo $row_trocadesenha['id']; ?>">
    </form>
    </th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($trocadesenha);

?>