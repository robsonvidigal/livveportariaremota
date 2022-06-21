<?php require_once('../Connections/provider.php'); ?>
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
<?php require_once('../Connections/provider.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO novarec (id_re, noid, ip, in_situacao, newsrec) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_re'], "int"),
                       GetSQLValueString($_POST['noid'], "int"),
                       GetSQLValueString($_POST['ip'], "text"),
					   GetSQLValueString($_POST['in_situacao'], "text"),
                       GetSQLValueString($_POST['newsrec'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE tb_na SET soma=%s, ocorrencia=%s, situacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['soma'], "int"),
                       GetSQLValueString($_POST['ocorrencia'], "text"),
                       GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "naparaconsulta-ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
<?php
$dataHora = date("d/m/Y H:i:s");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: U.C. <?php echo $row_naconsulta['uc']; ?>, Serviço: <?php echo $row_naconsulta['prioridade']; ?>, O.S. <?php echo $row_naconsulta['os_nub']; ?> ::</title>

<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 5px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #FFFFFF;
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
.style46 {        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style51 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.style52 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: #FF0000; }
.style53 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FF0000; }
-->
</style>
</head>

<body>
<table width="720" height="361" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="middle"><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
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
            <td width="71" align="left" valign="top" class="style50">N&Uacute;MERO NA:</td>
            <td width="633" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['id']; ?></td>
          </tr>
        </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="75" align="left" valign="top" class="style46"><strong>TELEATENDENTE:</strong></td>
            <td width="119" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['teleatendente']; ?></td>
            <td width="23" align="left" valign="top" class="style51">PA:</td>
            <td width="140" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['pa']; ?></td>
            <td width="31" align="left" valign="top" class="style51">HORA:</td>
            <td width="130" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['hora']; ?></td>
            <td width="28" align="left" valign="top" class="style51">DATA:</td>
            <td width="146" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['data']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="95" align="left" valign="top" class="style51">C&Oacute;D CLIENTE: </td>
            <td width="146" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['cod_cliente']; ?></td>
            <td width="92" align="left" valign="top" class="style51">RG/INSC. EST.:</td>
            <td width="112" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['rg']; ?></td>
            <td width="70" align="left" valign="top" class="style51">CPF/CNPJ:</td>
            <td width="181" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['cpf']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="45" height="14" align="left" valign="top" class="style51">NOME:</td>
            <td width="292" align="left" valign="middle" class="style46"><?php echo $row_naconsulta['nome_cli']; ?></td>
            <td width="75" align="left" valign="top" class="style46"><strong>C&Oacute;D &Uacute;NICO:</strong></td>
            <td width="97" align="left" valign="middle" class="style46"><?php echo $row_naconsulta['uc']; ?></td>
            <td width="58" align="left" valign="top" class="style51">MEDIDOR:</td>
            <td width="129" align="left" valign="middle" class="style46"><?php echo $row_naconsulta['medidor']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="61" align="left" valign="top" class="style51">ENDERE&Ccedil;O:</td>
            <td width="643" align="left" valign="middle" class="style46"><?php echo $row_naconsulta['endereco']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="42" align="left" valign="top" class="style51">BAIRRO:</td>
            <td width="172" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['bairro']; ?></td>
            <td width="51" align="left" valign="top" class="style51">DISTRITO:</td>
            <td width="137" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['distrito']; ?></td>
            <td width="60" align="left" valign="top" class="style51">MUN&Iacute;CIPIO:</td>
            <td width="234" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['municipio']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="55" align="left" valign="top" class="style51">CELULAR:</td>
            <td width="152" class="style46"><?php echo $row_naconsulta['celular']; ?></td>
            <td width="104" align="left" valign="top" class="style51">TELEFONE FIXO:</td>
            <td width="389" class="style46"><?php echo $row_naconsulta['telefone']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="27" align="left" valign="top" class="style51">O.S.</td>
            <td width="313" align="left" valign="baseline" class="style46"><span class="style; ?></span></td>
              <td align="left" valign="top">
            <label><?php echo $row_naconsulta['os_nub']; ?></label>            </td>
            <td width="61" align="left" valign="top" class="style52">SERVI&Ccedil;O:</td>
            <td width="299" align="left" valign="baseline" class="style53"><?php echo $row_naconsulta['prioridade']; ?></td>
          </tr>
      </table>
      <table width="710" height="32" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="68" align="left" valign="top" class="style51">OCORR&Ecirc;NCIA:</td>
            <td width="636" align="left" valign="baseline" class="style46"><?php echo $row_naconsulta['ocorrencia']; ?></td>
          </tr>
      </table><br>
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><span class="style51">Hist&oacute;rico da N.A. de pedidos de refor&ccedil;os e conclus&otilde;es.</span></td>
        </tr>
      </table>
      <table width="710" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="704" height="46" align="left" valign="top" class="style46"><?php do { ?>
              <?php echo $row_novarec['newsrec']; ?>  <?php echo $row_novarec['ip']; ?>
              - STATUS: <?php echo $row_novarec['in_situacao']; ?><br>
            <?php } while ($row_novarec = mysql_fetch_assoc($novarec)); ?></td>
          </tr>
      </table><br>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td align="center" valign="baseline"><form method="post" name="form2" action="<?php echo $editFormAction; ?>">
              <table width="359" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr valign="baseline">
              <td height="19" align="center" valign="top" nowrap="nowrap"><span class="style51">Refor&ccedil;a</span></td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td width="101" height="25" align="center" valign="top" nowrap="nowrap"><input name="botao" type="image" value="teste" src="../images/mais_icone.png" width="35" height="25"></td>
              <td width="418" valign="top"><input name="soma" type="hidden" value="<?php echo $row_naconsulta['soma']+1; ?>" />
                  <label>
                  <input name="situacao" type="hidden" id="situacao" value="EM ANDAMENTO" />
				  <input name="in_situacao" type="hidden" id="in_situacao" value="EM ANDAMENTO" />
                  <input name="ocorrencia" type="hidden" id="ocorrencia" value="<?php echo $row_naconsulta['ocorrencia']; ?> | Novo contato: <?php echo $dataHora; ?>" />
                                  <input name="noid" type="hidden" value="<?php echo $row_naconsulta['id']; ?>">
                                  <input name="ip" type="hidden" id="ip" value="| NOVA SOLICITAÇÃO FEITA POR <?php echo "$ip"; ?>">
                                  <input name="newsrec" type="hidden" value="<?php echo $dataHora; ?>">
                                  <input name="id_re" type="hidden" value="">
                  <input type="hidden" name="id" value="<?php echo $row_naconsulta['id']; ?>" />
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="id" value="<?php echo $row_naconsulta['id']; ?>" />
                                  <input type="hidden" name="MM_insert" value="form2" />
              </label></td>
            </tr>
        </table>
      </form></label></td>
          </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($naconsulta);

mysql_free_result($novarec);
?>
