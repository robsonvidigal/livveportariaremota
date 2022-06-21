<?php require_once('../../Connections/provider.php'); ?>
<?php require_once('../../Connections/provider.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO novarec (id_re, noid, newsrec, in_situacao, ip) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_re'], "int"),
                       GetSQLValueString($_POST['noid'], "int"),
                       GetSQLValueString($_POST['newsrec'], "text"),
					   GetSQLValueString($_POST['in_situacao'], "text"),
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

  $updateGoTo = "naparaconsulta-controle-situacao-mudada-com-sucesso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_naconsulta = 1;
$pageNum_naconsulta = 0;
if (isset($_GET['pageNum_naconsulta'])) {
  $pageNum_naconsulta = $_GET['pageNum_naconsulta'];
}
$startRow_naconsulta = $pageNum_naconsulta * $maxRows_naconsulta;

$colname_naconsulta = "-1";
if (isset($_GET['id'])) {
  $colname_naconsulta = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_naconsulta = sprintf("SELECT * FROM tb_na WHERE id = %s", $colname_naconsulta);
$query_limit_naconsulta = sprintf("%s LIMIT %d, %d", $query_naconsulta, $startRow_naconsulta, $maxRows_naconsulta);
$naconsulta = mysql_query($query_limit_naconsulta, $provider) or die(mysql_error());
$row_naconsulta = mysql_fetch_assoc($naconsulta);

if (isset($_GET['totalRows_naconsulta'])) {
  $totalRows_naconsulta = $_GET['totalRows_naconsulta'];
} else {
  $all_naconsulta = mysql_query($query_naconsulta);
  $totalRows_naconsulta = mysql_num_rows($all_naconsulta);
}
$totalPages_naconsulta = ceil($totalRows_naconsulta/$maxRows_naconsulta)-1;

$colname_novarec = "-1";
if (isset($_GET['id'])) {
  $colname_novarec = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_novarec = sprintf("SELECT * FROM novarec WHERE noid = %s ORDER BY id_re DESC", $colname_novarec);
$novarec = mysql_query($query_novarec, $provider) or die(mysql_error());
$row_novarec = mysql_fetch_assoc($novarec);
$totalRows_novarec = mysql_num_rows($novarec);

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuario = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $provider) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$queryString_naconsulta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_naconsulta") == false && 
        stristr($param, "totalRows_naconsulta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_naconsulta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_naconsulta = sprintf("&totalRows_naconsulta=%d%s", $totalRows_naconsulta, $queryString_naconsulta);
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

        <script language="JavaScript">
<!--

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
//-->
</script>




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
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style29 {font-size: 8px}
.style38 {font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #FF0000;
        font-weight: bold;
}
.style42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        font-weight: bold;
}
.style46 {font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style52 {color: #000000;
        font-size: 10px;
}
.style53 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>

<script language="JavaScript">
function repete() {
// o valor do input nome1 será igual ao do nome
document.form1.in_situacao.value=document.form1.situacao.value;
}
</script>


</head>

<body>
<table width="720" height="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="middle" bordercolor="#000000"><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
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
            <td width="79" align="left" valign="top"><span class="style50">N&Uacute;MERO NA:</span></td>
            <td width="322" align="left" valign="middle" class="style52"><span class="style28"><span class="style46"><?php echo $row_naconsulta['id']; ?></span></span></td>
            <td width="301" align="left" valign="baseline" class="style52">&nbsp;</td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="75" align="left" valign="top"><span class="style50">TELEATENDENTE:</span></td>
            <td width="119" align="left" valign="baseline"><input name="teleatendente2" type="text" class="style46" id="teleatendente2" value="<?php echo $row_naconsulta['teleatendente']; ?>" size="20" xml:lang="1" /></td>
            <td width="23" align="left" valign="top"><span class="style50">PA:</span></td>
            <td width="140" align="left" valign="baseline"><input name="pa2" type="text" class="style46" value="<?php echo $row_naconsulta['pa']; ?>" size="15" /></td>
            <td width="31" align="left" valign="top"><span class="style50">HORA:</span></td>
            <td width="130" align="left" valign="baseline"><span class="style42">
              <input name="hora2" type="text" class="style46" value="<?php echo $row_naconsulta['hora']; ?>" size="15" />
            </span></td>
            <td width="28" align="left" valign="top"><span class="style50">DATA:</span></td>
            <td width="146" align="left" valign="baseline"><span class="style42">
              <input name="data2" type="text" class="style46" value="<?php echo $row_naconsulta['data']; ?>" size="18" />
            </span></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="70" align="left" valign="top"><span class="style50">C&Oacute;D CLIENTE: </span></td>
            <td width="133" align="left" valign="baseline"><input name="cod_cliente2" type="text" class="style46" value="<?php echo $row_naconsulta['cod_cliente']; ?>" size="20" /></td>
            <td width="76" align="left" valign="top"><span class="style50">RG/INSC. EST.:</span></td>
            <td width="137" align="left" valign="baseline"><input name="rg2" type="text" class="style46" value="<?php echo $row_naconsulta['rg']; ?>" size="20" /></td>
            <td width="49" align="left" valign="top"><span class="style50">CPF/CNPJ:</span></td>
            <td width="231" align="left" valign="baseline"><input name="cpf2" type="text" class="style46" value="<?php echo $row_naconsulta['cpf']; ?>" size="30" /></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="46" height="19" align="left" valign="top"><span class="style50">NOME:</span></td>
            <td width="328" align="left" valign="baseline"><input name="nome_cli2" type="text" class="style46" id="nome_cli2" value="<?php echo $row_naconsulta['nome_cli']; ?>" size="43"/></td>
            <td width="70" align="left" valign="top"><span class="style50"><strong>C&Oacute;D &Uacute;NICO:</strong></span></td>
            <td width="77" align="left" valign="baseline"><input name="uc2" type="text" class="style46" id="uc2" value="<?php echo $row_naconsulta['uc']; ?>" size="14"/></td>
            <td width="47" align="left" valign="top"><span class="style50">MEDIDOR:</span></td>
            <td width="128" align="left" valign="baseline"><input name="medidor2" type="text" class="style46" value="<?php echo $row_naconsulta['medidor']; ?>" size="18" /></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="61" align="left" valign="top"><span class="style50">ENDERE&Ccedil;O:</span></td>
            <td width="643" align="left" valign="middle"><input name="endereco2" type="text" class="style46" value="<?php echo $row_naconsulta['endereco']; ?>" size="90" /></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="42" align="left" valign="top"><span class="style50">BAIRRO:</span></td>
            <td width="172" align="left" valign="baseline"><input name="bairro2" type="text" class="style46" value="<?php echo $row_naconsulta['bairro']; ?>" size="22" /></td>
            <td width="51" align="left" valign="top"><span class="style50">DISTRITO:</span></td>
            <td width="137" align="left" valign="baseline"><input name="textfield3" type="text"  class="style46" value="<?php echo $row_naconsulta['distrito']; ?>" size="17" /></td>
            <td width="60" align="left" valign="top"><span class="style50">MUN&Iacute;CIPIO:</span></td>
            <td width="234" align="left" valign="baseline"><input name="municipio2" type="text" class="style46" id="municipio2" value="<?php echo $row_naconsulta['municipio']; ?>" size="32"/></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="48" align="left" valign="top"><span class="style50">CELULAR:</span></td>
            <td width="76"><input name="celular2" type="text" class="style46" id="celular2" value="<?php echo $row_naconsulta['celular']; ?>" size="12" /></td>
            <td width="75" align="left" valign="top"><span class="style50">TELEFONE FIXO:</span></td>
            <td width="501"><input name="telefone2" type="text" class="style46" value="<?php echo $row_naconsulta['telefone']; ?>" size="12" /></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="28" align="left" valign="top"><span class="style50">O.S.</span></td>
            <td width="411" align="left" valign="baseline"><span class="style; ?></span></td>
              <td align="left" valign="top"><span class="style38"></span>
                <label>
                <input name="textfield22" type="text" class="style46" value="<?php echo $row_naconsulta['os_nub']; ?>" size="25" />
              </label></td>
            <td width="46" align="left" valign="top"><span class="style50">SERVI&Ccedil;O:</span></td>
            <td width="215" align="right" valign="baseline"><input name="prioridade2" type="text" class="style46" id="prioridade2"  value="<?php echo $row_naconsulta['prioridade']; ?>" size="43"/></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="68" align="left" valign="top"><span class="style26 style29"><span class="style50">OCORR&Ecirc;NCIA:</span></span></td>
            <td width="636" align="left" valign="baseline"><span class="style46">
              <textarea name="textarea" cols="80" rows="8" class="style46"><?php echo $row_naconsulta['ocorrencia']; ?> </textarea>
            </span></td>
          </tr>
      </table><br>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" ">
              <table width="711" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr valign="baseline">
                    <td colspan="4" align="left" valign="bottom" nowrap="nowrap"><input name="ip" type="hidden" id="ip" value="| Passada solicita&ccedil;&atilde;o por <?php echo $row_usuario['login']; ?>" />
                    <input name="noid" type="hidden" value="<?php echo $row_naconsulta['id']; ?>" />
                    <input name="newsrec" type="hidden" value="<?php echo $dataHora; ?>" />
					<input name="in_situacao" type="hidden" value="" />
                    <input name="id_re" type="hidden" value="" />
                    <input type="hidden" name="id3" value="<?php echo $row_naconsulta['id']; ?>" />
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="id" value="<?php echo $row_naconsulta['id']; ?>" />
                    <input type="hidden" name="MM_insert" value="form1" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td width="252" align="left" valign="bottom" nowrap="nowrap" class="style46">Ol&aacute;, <strong><?php echo $row_usuario['login']; ?></strong> o que deseja fazer? </td>
                    <td width="236" align="center" valign="middle"><select name="situacao" class="style46" id="situacao" lang="1" onfocus="mudarCorCampo(this,'white')" xml:lang="1" onchange="repete()">
                        <option value=""> </option>
                        <option value="CONCLU&Iacute;DA">CONCLU&Iacute;DA</option>
                        <option value="ABER. P/ SGT-AT">ABER. P/ SGT-AT</option>
                        <option value="O.S. PROGRAMADA P/ COI">O.S. PROGRAMADA P/ COI</option>
                        <option value="O.S. PROGRAMADA P/ COMERCIAL">O.S. PROGRAMADA P/ COMERCIAL</option>
                        <option value="PARCELAMENTO LANÇADO">PARCELAMENTO LANÇADO</option>
                        <option value="ENVIADO E-MAIL P/ DESTINATÁRIO">ENVIADO E-MAIL P/ DESTINATÁRIO</option>
                        <option value="UC INVÁLIDA!">UC INVÁLIDA!</option>
                        <option value="NEGADO P/ FALTA DE DADOS">NEGADO P/ FALTA DE DADOS</option>
                        <option value="SEM CONTATOS">SEM CONTATOS</option>
                        <option value="EM ANDAMENTO">EM ANDAMENTO</option>
                      </select></td>
                    <td width="141" align="center" valign="bottom"><input name="submit" type="submit" class="style46" value="ALTERAR SITUA&Ccedil;&Atilde;O" /></td>
                    <td width="82" align="center" valign="bottom"><input name="imprimir" type="button" class="style46" onclick="window.print();" value="IMPRIMIR" /></td>
                  </tr>
              </table>
                </form></td>
        </tr>
      </table><br />
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="right">
          <td align="left" class="style53">Hist&oacute;rico da N.A. de pedidos de refor&ccedil;os e conclus&otilde;es. </td>
        </tr>
      </table>
      <table width="710" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="704" align="left" valign="top" class="style46"><?php do { ?>
                <?php echo $row_novarec['newsrec']; ?>  <?php echo $row_novarec['ip']; ?>
                 - <?php echo $row_novarec['in_situacao']; ?><br />
                <?php } while ($row_novarec = mysql_fetch_assoc($novarec)); ?></td>
          </tr>
      </table>
      <table width="594" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="590" align="center" valign="baseline"></td>
          </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($naconsulta);

mysql_free_result($novarec);

mysql_free_result($usuario);
?>
