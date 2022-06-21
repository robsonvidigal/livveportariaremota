<?php require_once('../../../Connections/provider.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
        
  $logoutGoTo = "../areaadministrativa_da_informcao/ocorrencia_inserir.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$MM_restrictGoTo = "../areaadministrativa_da_informcao/ocorrencia_inserir.php";
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

$currentPage = $_SERVER["PHP_SELF"];

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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO novarec (id_re, noid, newsrec, ip) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_re'], "int"),
                       GetSQLValueString($_POST['noid'], "int"),
                       GetSQLValueString($_POST['newsrec'], "text"),
                       GetSQLValueString($_POST['ip'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_na SET situacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "na_digital_ralatorio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_con_sit = "-1";
if (isset($_GET['prioridade'])) {
  $colname_con_sit = (get_magic_quotes_gpc()) ? $_GET['prioridade'] : addslashes($_GET['prioridade']);
}
mysql_select_db($database_provider, $provider);
$query_con_sit = sprintf("SELECT * FROM tb_na WHERE tb_na.prioridade='FIO / RAMAL DE SERVIÇO PARTIDO' AND tb_na.situacao='EM ANDAMENTO' ORDER BY distrito ASC", $colname_con_sit);
$con_sit = mysql_query($query_con_sit, $provider) or die(mysql_error());
$row_con_sit = mysql_fetch_assoc($con_sit);
$totalRows_con_sit = mysql_num_rows($con_sit);

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuario = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $provider) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$colname_novarec = "-1";
if (isset($_GET['id'])) {
  $colname_novarec = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_novarec = sprintf("SELECT * FROM novarec WHERE noid = %s ORDER BY id_re DESC", $colname_novarec);
$novarec = mysql_query($query_novarec, $provider) or die(mysql_error());
$row_novarec = mysql_fetch_assoc($novarec);
$totalRows_novarec = mysql_num_rows($novarec);

?>
<?php $ip = $_SERVER["REMOTE_ADDR"]; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NA Emergencial emitida em <?php		$data_title = date ("d-m-Y");		$hora_title = date ("H:i:s");		echo"$data_title às $hora_title";				 ?></title>
<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 10px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #FFFFFF;
}
a:link {
        color: #FF0000;
        text-decoration: none;
}
a:visited {
        color: #FF0000;
        text-decoration: none;
}
a:hover {
        color: #FF0000;
        text-decoration: none;
}
a:active {
        color: #FF0000;
        text-decoration: none;
}
.style26 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        font-weight: bold;
}
.style29 {font-size: 8px}
.style46 {
        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style52 {
        color: #000000;
        font-size: 10px;
}
.style38 {font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #FF0000;
        font-weight: bold;
}
.style57 {font-size: 24px}
.style58 {color: #FF0000}
.style59 {
	color: #0000FF;
	font-weight: bold;
}
.style67 {font-size: 9}
.style68 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<script language="JavaScript">
/* 
Créditos do script
Criado por: Miguel Angel Alvarez
site: http://www.criarweb.com/artigos/475.php
Acesso: 02/10/2016
 */
function selecionar_todo(){ 
   for (i=0;i<document.form1.elements.length;i++) 
      if(document.form1.elements[i].type == "checkbox")	
         document.form1.elements[i].checked=1 
} 

function deselecionar_todo(){ 
   for (i=0;i<document.form1.elements.length;i++) 
      if(document.form1.elements[i].type == "checkbox")	
         document.form1.elements[i].checked=0 
} 
</script>
</head>

<body>
<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
  <tr>
    <td class="style48"><div align="center" class="style57">Relat&oacute;rio de Servi&ccedil;os - Emergencial - Fio Partido </div></td>
  </tr>
</table><br />
<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
  <tr>
    <td width="100" align="center" valign="middle"><a href="na_digital_ralatorio.php?prioridade=" class="style68">Inicio</a></td>
    <td width="100" align="center" valign="middle"><a href="na_digital_ralatorio_emergencial_fio_partido.php?prioridade=" class="style68">Fio Partido </a></td>
    <td width="100" align="center" valign="middle"><a href="na_digital_ralatorio_emergencial.php?prioridade=" class="style68">Emergencial</a></td>
    <td width="100" align="center" valign="middle"><a href="na_digital_ralatorio_comercial.php?prioridade=" class="style68">Comercial</a></td>
    <td width="100" align="center" valign="middle"><a href="na_digital_ralatorio_comercial_agendamento_religa&ccedil;&atilde;o.php?prioridade=" class="style68">Agendamento</a></td>
    <td width="320" align="center" valign="middle"><span class="style67"></span></td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right" valign="middle"><input name="imprimir" type="button" class="style46" onclick="window.print();" value="Imprimir" /></td>
    </tr>
  </table>
<table width="720" height="306" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
  <td height="306" align="center" valign="middle"><?php do { ?>
    <table width="720" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right" valign="middle"><label><span class="style46">
              <input name="id_re" type="hidden" value="" />
              <input name="MM_update" type="hidden" value="form1" />
              <input name="id3" type="hidden" value="<?php echo $row_con_sit['id']; ?>" />
              <input name="id" type="hidden" value="<?php echo $row_con_sit['id']; ?>" />
              <input name="MM_insert" type="hidden" value="form1" />
              <input name="ip" type="hidden" id="ip" value="| Passada solicita&ccedil;&atilde;o por <?php echo $row_usuario['login']; ?>" />
              <input name="noid" type="hidden" value="<?php echo $row_con_sit['id']; ?>" />
              <input name="newsrec" type="hidden" value="<?php echo "" . date("d/m/y H:i:s") . "";?>" />
              </span></label>
        
            <br />
          </p></td>
      </tr>
    </table>
    <table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
    <tr>
      <td width="123">&nbsp;</td>
      <td width="410" align="center" valign="middle"><div align="center" class="style48">NOTIFICA&Ccedil;&Atilde;O 
        DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
      <td width="159" align="center" valign="middle"><div align="center" class="style48">Call 
        Center </div></td>
    </tr>
  </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="71" align="left" valign="top"><span class="style50">N&Uacute;MERO NA:</span></td>
          <td width="633" align="left" valign="baseline" class="style52"><?php echo $row_con_sit['id']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="75" align="left" valign="top"><span class="style50">TELEATENDENTE:</span></td>
          <td width="119" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['teleatendente']; ?></td>
          <td width="23" align="left" valign="top"><span class="style50">PA:</span></td>
          <td width="140" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['pa']; ?></td>
          <td width="31" align="left" valign="top"><span class="style50">HORA:</span></td>
          <td width="130" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['hora']; ?></td>
          <td width="28" align="left" valign="top"><span class="style50">DATA:</span></td>
          <td width="146" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['data']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="70" align="left" valign="top"><span class="style50">C&Oacute;D CLIENTE: </span></td>
          <td width="133" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['cod_cliente']; ?></td>
          <td width="76" align="left" valign="top"><span class="style50">RG/INSC. EST.:</span></td>
          <td width="137" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['rg']; ?></td>
          <td width="49" align="left" valign="top"><span class="style50">CPF/CNPJ:</span></td>
          <td width="231" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['cpf']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="46" height="14" align="left" valign="top"><span class="style50">NOME:</span></td>
          <td width="328" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['nome_cli']; ?></td>
          <td width="70" align="left" valign="top"><span class="style50"><strong>C&Oacute;D &Uacute;NICO:</strong></span></td>
          <td width="77" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['uc']; ?></td>
          <td width="47" align="left" valign="top"><span class="style50">MEDIDOR:</span></td>
          <td width="128" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['medidor']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="61" align="left" valign="top"><span class="style50">ENDERE&Ccedil;O:</span></td>
          <td width="643" align="left" valign="middle" class="style46"><?php echo $row_con_sit['endereco']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="42" align="left" valign="top"><span class="style50">BAIRRO:</span></td>
          <td width="151" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['bairro']; ?></td>
          <td width="53" align="left" valign="top"><span class="style50">DISTRITO:</span></td>
          <td width="182" align="left" valign="baseline" class="style58 style46"><span class="style59"><?php echo $row_con_sit['distrito']; ?></span></td>
          <td width="58" align="left" valign="top"><span class="style50">MUN&Iacute;CIPIO:</span></td>
          <td width="210" align="left" valign="baseline" class="style46"><?php echo $row_con_sit['municipio']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="53" align="left" valign="top"><span class="style50">CELULAR:</span></td>
          <td width="126" class="style46"><?php echo $row_con_sit['celular']; ?></td>
          <td width="82" align="left" valign="top"><span class="style50">TELEFONE FIXO:</span></td>
          <td width="439" class="style46"><?php echo $row_con_sit['telefone']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="28" align="left" valign="top"><span class="style50">O.S.</span></td>
          <td width="238" align="left" valign="baseline"><span class="style; ?></span></td>
              <td align="left" valign="top"><span class="style38"></span>
          <label class="style46" co['os_nub']; ?><?php echo $row_con_sit['os_nub']; ?></label></td>
          <td width="50" align="left" valign="top"><span class="style50">SERVI&Ccedil;O:</span></td>
          <td width="384" align="left" valign="baseline" class="style46" crioridade']; ?><span class="style58"><strong><?php echo $row_con_sit['prioridade']; ?></strong></span></td>
        </tr>
      </table>
    <table width="710" height="49" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="68" height="49" align="left" valign="top"><span class="style26 style29"><span class="style50">OCORR&Ecirc;NCIA:</span></span></td>
          <td width="636" align="left" valign="top" class="style46" ccorrencia']; ?><?php echo $row_con_sit['ocorrencia']; ?></td>
        </tr>
        </table>
<?php } while ($row_con_sit = mysql_fetch_assoc($con_sit)); ?>
    <table width="720" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td align="center" valign="baseline"></label></td>
        </tr>
</table></td>
</tr>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
   <td class="style46">Relat&oacute;rio emitido por <?php echo $row_usuario['login']; ?> em
     		<?php
				$data = date ("d/m/Y");
				$hora = date ("H:i:s");
					echo"$data às $hora"; 
				?>
   </td>
 </tr>
</table>
</form>
</body>
</html>