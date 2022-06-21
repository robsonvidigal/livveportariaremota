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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tb_na WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($deleteSQL, $provider) or die(mysql_error());

  $deleteGoTo = "visualizanumerosdena-para-excluir.php?pesquisar=CONCLU%CDDA";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

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
<title>:: Boletim Operacional ::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
	text-decoration: none;
}
a:visited {
	color: #FFFFFF;
	text-decoration: none;
}
a:hover {
	color: #FFFFFF;
	text-decoration: underline;
}
a:active {
	color: #FFFFFF;
	text-decoration: none;
}
.style19 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.style24 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style29 {font-size: 8px}
.style30 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style31 {color: #FF0000;
	font-weight: bold;
}
.style33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 6px; }
.style38 {font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="710" align="left">
    <tr valign="baseline">
      <td width="768" height="57" align="left" nowrap="nowrap"><table width="700" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="123" align="center" valign="middle"><img src="imagens/logo_casal.png" width="93" height="53" /></td>
            <td width="410" align="center" valign="middle"><div align="center" class="style19">NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
            <td width="159" align="center" valign="middle"><div align="center" class="style19">Call Center </div></td>
          </tr>
      </table>
        
      </td>
    </tr>
    <tr valign="baseline">
      <td height="242" align="left" valign="top" nowrap="nowrap"><table width="680" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td width="67" height="20" align="left" valign="top"><span class="style30">N&Uacute;MERO NA:</span></td>
          <td colspan="7"><span class="style28"><span class="style31"><?php echo $row_naconsulta['id']; ?></span>
                <label></label>
          </span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">TELEATENDETE:</span></td>
          <td width="120"><input name="teleatendente"type="text" id="teleatendente" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['teleatendente']; ?>" size="20" xml:lang="1" /></td>
          <td width="68" align="left" valign="top"><span class="style30">PA:</span></td>
          <td width="112"><input name="pa" type="text" value="<?php echo $row_naconsulta['pa']; ?>" size="10" /></td>
          <td width="42" align="left" valign="top"><span class="style30">HORA:</span></td>
          <td width="78"><input name="hora" type="text" value="<?php echo $row_naconsulta['hora']; ?>" size="10" /></td>
          <td width="47" align="left" valign="top"><span class="style30">DATA:</span></td>
          <td width="158"><input name="data" type="text" value="<?php echo $row_naconsulta['data']; ?>" size="10" /></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top"><span class="style30">RG/INSC. EST.:</span></td>
          <td colspan="2"><input name="rg" type="text" value="<?php echo $row_naconsulta['rg']; ?>" size="21" /></td>
          <td align="left" valign="top"><span class="style30">CPF/CNPJ:</span></td>
          <td colspan="2"><input name="cpf" type="text" value="<?php echo $row_naconsulta['cpf']; ?>" size="18" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">NOME:</span></td>
          <td colspan="3"><input name="nome_cli" type="text" id="nome_cli" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['nome_cli']; ?>" size="50" xml:lang="1" /></td>
          <td align="left" valign="top"><span class="style33">MATR&Iacute;CULA :</span></td>
          <td><input name="uc" type="text" id="uc" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['uc']; ?>" size="10" xml:lang="1" /></td>
          <td align="left" valign="top" class="style30"><span class="style30">HITR&Ocirc;METRO</span>:</td>
          <td><input name="medidor" type="text" value="<?php echo $row_naconsulta['medidor']; ?>" size="10" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">ENDERE&Ccedil;O:</span></td>
          <td colspan="7"><input name="endereco" type="text" value="<?php echo $row_naconsulta['endereco']; ?>" size="95" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">BAIRRO:</span></td>
          <td><input name="bairro" type="text" value="<?php echo $row_naconsulta['bairro']; ?>" size="20" /></td>
          <td align="left" valign="top" class="style30">UNIDADE:</td>
          <td colspan="2"><label>
            <input name="textfield3" type="text" value="<?php echo $row_naconsulta['distrito']; ?>" size="20" />
          </label></td>
          <td align="left" valign="top"><span class="style30">MUN&Iacute;CIPIO:</span></td>
          <td colspan="2"><input name="municipio" type="text" id="municipio" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['municipio']; ?>" size="21" xml:lang="1" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">TELEFONES:</span></td>
          <td colspan="7"><input name="celular" type="text" id="celular" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['celular']; ?>" size="10" xml:lang="1" />
              <span class="style28">OU</span>
              <input name="telefone" type="text" value="<?php echo $row_naconsulta['telefone']; ?>" size="10" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style30">R.A.</span></td>
          <td><span class="style38"><?php echo $row_naconsulta['os_nub']; ?></span></td>
          <td align="left" valign="top"><span class="style30">SERVI&Ccedil;O:</span></td>
          <td colspan="5"><input name="prioridade" type="text" id="prioridade" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_naconsulta['prioridade']; ?>" size="43" xml:lang="1" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="style26 style29">OCORR&Ecirc;NCIA:</span></td>
          <td colspan="7"><span class="style24">
            <textarea name="ocorrencia" cols="60" rows="5"><?php echo $row_naconsulta['ocorrencia']; ?></textarea>
          </span></td>
        </tr>
        <tr>
          <td colspan="8" align="left"><table width="535" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="159"><label>
                <input type="submit" name="Submit" value="CONFIMAR EXCLUS&Atilde;O" />
              </label></td>
              <td width="376"><label>
                <input name="textfield" type="text" value="<?php echo $row_resp_consulta['id']; ?>" />
                <input name="textfield2" type="text" value="<?php echo $row_resp_consulta['consulta']; ?>" />
              </label></td>
            </tr>
          </table>          
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
<input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>;<?php echo $_GET['id']; ?>" />

</form>
</body>
</html>
<?php
mysql_free_result($naconsulta);
?>