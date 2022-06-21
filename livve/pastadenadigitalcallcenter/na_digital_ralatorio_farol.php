<?php require_once('../../Connections/bd_servicos.php'); ?>
<?php require_once('../../Connections/provider.php'); ?>
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


mysql_select_db($database_bd_servicos, $bd_servicos);
$query_agendamento = "SELECT * FROM tb_servico ORDER BY id ASC";
$agendamento = mysql_query($query_agendamento, $bd_servicos) or die(mysql_error());
$row_agendamento = mysql_fetch_assoc($agendamento);
$totalRows_agendamento = mysql_num_rows($agendamento);

$colname_con_sit = "-1";
if (isset($_GET['prioridade'])) {
  $colname_con_sit = (get_magic_quotes_gpc()) ? $_GET['prioridade'] : addslashes($_GET['prioridade']);
}
mysql_select_db($database_provider, $provider);
$query_con_sit = sprintf("SELECT * FROM tb_na WHERE 
(((tb_na.prioridade)='INSTALA��O DE MEDIDOR' Or 
(tb_na.prioridade)='VISTORIA P/ LIGACAO NOVA' Or 
(tb_na.prioridade)='VISTORIA P/ NOVA SOLIC. DE FORN.' Or 
(tb_na.prioridade)='LIGA��O PROVIS�RIA' Or 
(tb_na.prioridade)='SUBSTITUICAO DE MEDIDOR' Or 
(tb_na.prioridade)='MUDAN�A DE RAMAL' Or 
(tb_na.prioridade)='MUDAN�A DO TIPO DE LIGA��O' Or 
(tb_na.prioridade)='RETIRADA DE MEDIDOR' Or 
(tb_na.prioridade)='RESULTADO DO LAUDO DE AFERI��O' Or 
(tb_na.prioridade)='REFATURAMENTO - CANCELAMENTO  FD' Or 
(tb_na.prioridade)='SOLIC. DE AFERI��O DO MEDIDO' Or 
(tb_na.prioridade)='SELAGEM DA CAIXA DE MEDIDOR' Or 
(tb_na.prioridade)='DESLIG. P ENCERRAMENTO FORNECIM' Or 
(tb_na.prioridade)='INSPE��O DE ROTINA' Or 
(tb_na.prioridade)='VISTORIA DE AUTO-RELIGA��O (CORT P/ D�B)' Or 
(tb_na.prioridade)='TRANSFERENCIA DE NOME' Or 
(tb_na.prioridade)='RELIGA��O NORMAL DE CORTADO' Or 
(tb_na.prioridade)='RELIGA��O URGENCIA DE CORTADO' Or 
(tb_na.prioridade)='RELIGA��O AUTOM�TICA' Or 
(tb_na.prioridade)='RETIRAR RAMAL' Or 
(tb_na.prioridade)='PODAGEM DE ARVORE' Or 
(tb_na.prioridade)='CONFIRMA��O LEITURA' Or 
(tb_na.prioridade)='AN�LISE DE CANCELAMENTO DE FATURA' Or 
(tb_na.prioridade)='ANALISE TRANSFER�NCIA DE D�BITO' Or 
(tb_na.prioridade)='INFORMA��ES GERAIS' Or 
(tb_na.prioridade)='EXTENS�O DE REDE DE AT E BT' Or 
(tb_na.prioridade)='DESLOCAMENTO DE POSTE' Or 
(tb_na.prioridade)='COBERTURA DE CABOS � ORCAMENTO' Or 
(tb_na.prioridade)='MUDAN�A DE LOCAL DO MEDIDOR' Or 
(tb_na.prioridade)='SOLIC. ENVIO INFORMA��O AO CLIENTE' Or 
(tb_na.prioridade)='CORRE��O DADOS CADASTRAIS' Or 
(tb_na.prioridade)='OUTROS SERVI�OS' Or 
(tb_na.prioridade)='DANOS ELET. QUEIMA DE APARELHO' Or 
(tb_na.prioridade)='RELIGA��O DE URGENCIA' Or 
(tb_na.prioridade)='REFATURAMENTO - CANCELAMENTO FD' Or 
(tb_na.prioridade)='LIGA��O NOVA' Or 
(tb_na.prioridade)='SOLIC. INSPE��O EM UNIDADE CONSUMIDORA' Or 
(tb_na.prioridade)='ENVIO DE FATURA DESLIGMAMENTO') AND ((tb_na.situacao)='EM ANDAMENTO')) ORDER BY distrito ASC", $colname_con_sit);
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
<title>NA Comercial emitida em <?php		$data_title = date ("d-m-Y");		$hora_title = date ("H:i:s");		echo"$data_title �s $hora_title";				 ?></title>
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
.style57 {font-size: 24px}
.style58 {color: #FF0000}
.style59 {
	color: #0000FF;
	font-weight: bold;
	font-size: 12px;
}
.style69 {font-size: 12px}
.style70 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style71 {
	color: #FF0000;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript">
/* 
Cr�ditos do script
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
    <td class="style48"><div align="center" class="style57">Relat&oacute;rio de Servi&ccedil;o - &Aacute;GUA 04 </div></td>
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
          <td width="61" align="left" valign="top"><span class="style50">N&Uacute;MERO NA:</span></td>
          <td width="643" align="left" valign="baseline" class="style52 style69"><?php echo $row_con_sit['id']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="75" align="left" valign="top"><span class="style50">TELEATENDENTE:</span></td>
          <td width="155" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['teleatendente']; ?></td>
          <td width="16" align="left" valign="top"><span class="style50">PA:</span></td>
          <td width="131" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['pa']; ?></td>
          <td width="30" align="left" valign="top"><span class="style50">HORA:</span></td>
          <td width="121" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['hora']; ?></td>
          <td width="27" align="left" valign="top"><span class="style50">DATA:</span></td>
          <td width="137" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['data']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="64" align="left" valign="top">&nbsp;</td>
          <td width="141" align="left" valign="baseline" class="style70">&nbsp;</td>
          <td width="70" align="left" valign="top"><span class="style50">RG/INSC. EST.:</span></td>
          <td width="141" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['rg']; ?></td>
          <td width="49" align="left" valign="top"><span class="style50">CPF/CNPJ:</span></td>
          <td width="231" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['cpf']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="33" height="14" align="left" valign="top"><span class="style50">NOME:</span></td>
          <td width="338" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['nome_cli']; ?></td>
          <td width="59" align="left" valign="top"><span class="style50"><strong>MATR&Iacute;CULA:</strong></span></td>
          <td width="89" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['uc']; ?></td>
          <td width="47" align="left" valign="top"><span class="style50">HITR&Ocirc;METRO:</span></td>
          <td width="130" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['medidor']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="52" align="left" valign="top"><span class="style50">ENDERE&Ccedil;O:</span></td>
          <td width="652" align="left" valign="middle" class="style70"><?php echo $row_con_sit['endereco']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="42" align="left" valign="top"><span class="style50">BAIRRO:</span></td>
          <td width="151" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['bairro']; ?></td>
          <td width="50" align="left" valign="top"><span class="style50">UNIDADE:</span></td>
          <td width="185" align="left" valign="baseline" class="style58 style46"><span class="style59"><?php echo $row_con_sit['distrito']; ?></span></td>
          <td width="58" align="left" valign="top"><span class="style50">MUN&Iacute;CIPIO:</span></td>
          <td width="210" align="left" valign="baseline" class="style70"><?php echo $row_con_sit['municipio']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="53" align="left" valign="top"><span class="style50">CELULAR:</span></td>
          <td width="126" class="style70"><?php echo $row_con_sit['celular']; ?></td>
          <td width="82" align="left" valign="top"><span class="style50">TELEFONE FIXO:</span></td>
          <td width="439" class="style70"><?php echo $row_con_sit['telefone']; ?></td>
        </tr>
      </table>
    <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="22" align="left" valign="top"><span class="style50">R.A.</span></td>
          <td width="244" align="left" valign="baseline"><span class="style69"><span class="style; ?></span></td>
              <td align="left" valign="top"></span>
            <span class="style69">
            <label class="style70" co['os_nub']; ?><?php echo $row_con_sit['os_nub']; ?></label>
            </span></td>
          <td width="45" align="left" valign="top"><span class="style50">SERVI&Ccedil;O:</span></td>
          <td width="389" align="left" valign="baseline" class="style46" crioridade']; ?><span class="style71"><?php echo $row_con_sit['prioridade']; ?></span></td>
        </tr>
      </table>
    <table width="710" height="49" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td width="68" height="49" align="left" valign="top"><span class="style26 style29"><span class="style50">OCORR&Ecirc;NCIA:</span></span></td>
          <td width="636" align="left" valign="top" class="style70" ccorrencia']; ?><?php echo $row_con_sit['ocorrencia']; ?></td>
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
					echo"$data �s $hora"; 
				?>
   </td>
 </tr>
</table>
</form>
</body>
</html>