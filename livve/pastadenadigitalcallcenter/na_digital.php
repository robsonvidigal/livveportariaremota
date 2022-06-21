<?php 
/*

Versão 0.1 - última atualização - 21/09/2016

Bugs:
21/09/2016 - Bug: Correção no envio para banco de dados do distrito.
             Bug: Correção para obrigação do preenchimentos de alguns itens.

*/
?>
<?php require_once('../Connections/provider.php'); ?>
<?php require_once('../Connections/servico.php'); ?>

<?php
$ip = $_SERVER['REMOTE_ADDR'];
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_na SET tempo=%s, os_nub=%s, teleatendente=%s, pa=%s, hora=%s, `data`=%s, cod_cliente=%s, rg=%s, cpf=%s, nome_cli=%s, uc=%s, medidor=%s, endereco=%s, bairro=%s, distrito=%s, municipio=%s, telefone=%s, celular=%s, ocorrencia=%s, prioridade=%s, soma=%s, situacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['tempo'], "text"),
                       GetSQLValueString($_POST['os_nub'], "text"),
                       GetSQLValueString($_POST['teleatendente'], "text"),
                       GetSQLValueString($_POST['pa'], "text"),
                       GetSQLValueString($_POST['hora'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['cod_cliente'], "text"),
                       GetSQLValueString($_POST['rg'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['nome_cli'], "text"),
                       GetSQLValueString($_POST['uc'], "text"),
                       GetSQLValueString($_POST['medidor'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['distrito'], "text"),
                       GetSQLValueString($_POST['municipio'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['ocorrencia'], "text"),
                       GetSQLValueString($_POST['prioridade'], "text"),
                       GetSQLValueString($_POST['soma'], "text"),
                       GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "na-enviada-com-sucesso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_atua_os = "-1";
if (isset($_GET['os_nub'])) {
  $colname_atua_os = (get_magic_quotes_gpc()) ? $_GET['os_nub'] : addslashes($_GET['os_nub']);
}
mysql_select_db($database_provider, $provider);
$query_atua_os = sprintf("SELECT * FROM tb_na WHERE os_nub = '%s' ORDER BY id DESC", $colname_atua_os);
$atua_os = mysql_query($query_atua_os, $provider) or die(mysql_error());
$row_atua_os = mysql_fetch_assoc($atua_os);
$totalRows_atua_os = mysql_num_rows($atua_os);

mysql_select_db($database_servico, $servico);
$query_agendamento = "SELECT * FROM tb_servico ORDER BY nome_ser ASC";
$agendamento = mysql_query($query_agendamento, $servico) or die(mysql_error());
$row_agendamento = mysql_fetch_assoc($agendamento);
$totalRows_agendamento = mysql_num_rows($agendamento);
?>

<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=md5($_POST['senha']);
  $MM_fldUserAuthorization = "nivel";
  $MM_redirectLoginSuccess = "pastadenadigitalcallcenter/na-consulta.php";
  $MM_redirectLoginFailed = "login/login.php?login_errado=true";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_provider, $provider);
  	
  $LoginRS__query=sprintf("SELECT login, senha, nivel FROM login WHERE login='%s' AND senha='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $provider) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'nivel');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "r,s,a";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "semacesso.html";
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

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuarios = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $provider) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>N.A. DIGITAL O.S. <?php echo $row_atua_os['os_nub']; ?></title>
<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #CCCCCC;
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
        text-decoration: underline;
}
a:active {
        color: #FF0000;
        text-decoration: none;
}
.style19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.style26 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        font-weight: bold;
}
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style29 {font-size: 8px}
.style42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.style44 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FF0000; }
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
.style54 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; color: #FF0000; }
.style56 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; color: #000000; }
-->
</style>

<?php

$meses = array (1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05", 6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11", 12 => "12");
 $hoje = getdate();
 $dia = $hoje["mday"];
 $mes = $hoje["mon"];
 $nomemes = $meses[$mes];
 $ano = $hoje["year"];
 $diadasemana = $hoje["wday"];
?>


<script language="JavaScript">
function mueveHorario(){
        momentoActual = new Date()
        hora = momentoActual.getHours()
        minuto = momentoActual.getMinutes()
        segundo = momentoActual.getSeconds()

        str_segundo = new String (segundo)
        if (str_segundo.length == 1)
                segundo = "0" + segundo

        str_minuto = new String (minuto)
        if (str_minuto.length == 1)
                minuto = "0" + minuto

        str_hora = new String (hora)
        if (str_hora.length == 1)
                hora = "0" + hora

        horaImprimible = hora + ":" + minuto + ":" + segundo

        document.form_hora.hora.value = horaImprimible

        setTimeout("mueveHorario()",1000)
}
</script>

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

<script>
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
</script>

</head>

<body onload="mueveHorario()">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form_hora" id="form_hora"" onSubmit="return validaCampoObrigatorio(this)"">
  
  <table width="720" height="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td align="center" valign="middle"><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="123" align="center" valign="middle"><img src="imagens/logo_casal.png" width="93" height="53" /></td>
            <td width="410" align="center" valign="middle"><div align="center" class="style48">NOTIFICA&Ccedil;&Atilde;O 
              DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
            <td width="159" align="center" valign="middle"><div align="center" class="style48">Call 
              Center </div></td>
          </tr>
        </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="71" align="left" valign="top"><span class="style50">N&Uacute;MERO NA:</span></td>
              <td width="633" align="left" valign="baseline" class="style52"><?php echo $row_atua_os['id']; ?></td>
            </tr>
          </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="75" align="left" valign="top"><span class="style54">TELEATENDENTE:</span></td>
              <td width="119" align="left" valign="baseline"><input name="teleatendente" type="hidden" class="style46" id="teleatendente" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_usuarios['login']; ?>" xml:lang="1" /> <span class="style28"><?php echo $row_usuarios['login']; ?></span></td>
              <td width="23" align="left" valign="top"><span class="style50">PA:</span></td>
              <td width="140" align="left" valign="baseline"><input name="pa2" type="text" disabled="disabled" class="style46" id="pa2" value="<?php echo "$ip"; ?>" size="18" /></td>
              <td width="31" align="left" valign="top"><span class="style50">HORA:</span></td>
              <td width="130" align="left" valign="baseline"><span class="style46"><span class="style19">
                <input name="hora" type="text" class="style46" id="hora" size="18" />
              </span> </span></td>
              <td width="28" align="left" valign="top"><span class="style50">DATA:</span></td>
              <td width="146" align="left" valign="baseline"><input name="data2" type="text" disabled="disabled" class="style46" id="data2" value="<?php echo "$dia/$nomemes/$ano";
?>" size="18" />
                  <span class="style42"></span></td>
            </tr>
          </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="71" align="left" valign="top">&nbsp;</td>
              <td width="120" align="left" valign="baseline">&nbsp;</td>
              <td width="85" align="left" valign="top"><span class="style50">RG/INSC. EST.:</span></td>
              <td width="138" align="left" valign="baseline"><input name="rg" type="text" class="style46" onkeypress='return SomenteNumero(event)' value="" size="18" maxlength="20"/></td>
              <td width="49" align="left" valign="top"><span class="style50">CPF/CNPJ:</span></td>
              <td width="233" align="left" valign="baseline"><input name="cpf" type="text" class="style46" value="" size="18" maxlength="14" onkeypress='return SomenteNumero(event)'/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="34" height="19" align="left" valign="top"><span class="style54">NOME:</span></td>
              <td width="324" align="left" valign="baseline"><input name="nome_cli" type="text" class="style46" id="nome_cli" lang="1" onfocus="mudarCorCampo(this,'white')" value="" size="55" maxlength="45" xml:lang="1" /></td>
              <td width="80" align="left" valign="top"><span class="style54"><strong>MATR&Iacute;CULA:</strong></span></td>
              <td width="74" align="left" valign="baseline"><input name="uc" type="text" class="style46" id="uc" lang="1" onfocus="mudarCorCampo(this,'white')" OnKeyPress="formatar('########', this)" value="" size="13" maxlength="11" xml:lang="1"/></td>
              <td width="56" align="left" valign="top"><span class="style50">HITR&Ocirc;METRO:</span></td>
              <td width="128" align="left" valign="baseline"><input name="medidor" type="text" class="style46" value="" size="15" maxlength="9"/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="61" align="left" valign="top"><span class="style50">ENDERE&Ccedil;O:</span></td>
              <td width="643" align="left" valign="middle"><input name="endereco" type="text" class="style46" value="" size="90" maxlength="125" /></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="54" align="left" valign="top"><span class="style54">UNIDADE:</span></td>
              <td width="161" align="left" valign="middle"><label>
                <select name="distrito" class="style46" id="distrito" lang="1" onfocus="mudarCorCampo(this,'white')" xml:lang="1">
                  <option value=" "> </option>
				  <option value="FAROL">FAROL</option>
                  <option value="BENEDITO BENTES">BENEDITO BENTES</option>
                  <option value="JARAGUA">JARAGUA</option>
				  <option value="AGRESTE">AGRESTE</option>
				  <option value="SERRANA">SERRANA</option>
				  <option value="SERTAO">SERTAO</option>
				  <option value="B. LEITEIRA">B. LEITEIRA</option>
				  <option value="LESTE">LESTE</option>
				  <option value="SANAMA">SANAMA</option>
                </select>
              </label></td>
              <td width="44" align="left" valign="top"><span class="style54"><span class="style56">BAIRRO:</span></span></td>
              <td width="169" align="left" valign="bottom">
              <input name="bairro" type="text" class="style46" value="" size="20" maxlength="15" />
              </span></label></td>
              <td width="56" align="left" valign="top"><span class="style54">MUN&Iacute;CIPIO:</span></td>
              <td width="212" align="left" valign="middle" class="style46"><label>
              <input name="municipio" type="text" class="style46" id="municipio" />
              </label></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="48" align="left" valign="top"><span class="style54">CELULAR:</span></td>
              <td width="71"><input name="celular" type="text" class="style46" id="celular" lang="1" onfocus="mudarCorCampo(this,'white')" value="" size="12" maxlength="11" xml:lang="1" onkeypress='return SomenteNumero(event)'/></td>
              <td width="80" align="left" valign="top"><span class="style50">TELEFONE FIXO:</span></td>
              <td width="501"><input name="telefone" type="text" class="style46" value="" size="12" maxlength="10" onkeypress='return SomenteNumero(event)'/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="28" align="left" valign="top"><span class="style50">R.A.</span></td>
              <td width="316" align="left" valign="baseline"><input name="os_nub" type="text" class="style46" id="os_nub" value="<?php echo $row_atua_os['os_nub']; ?>" size="13" maxlength="12" />
              <span class="style; ?></span></td>
              <td align="left" valign="top"></td>
              <td width="56" align="left" valign="top"><span class="style54">SERVI&Ccedil;O:</span></td>
              <td width="300" align="right" valign="baseline"><label>
<select name="prioridade" class="style46" id="prioridade" lang="1" onfocus="mudarCorCampo(this,'white')" xml:lang="1">
                <?php
do {  
?>
                <option value="<?php echo $row_agendamento['nome_ser']?>"><?php echo $row_agendamento['nome_ser']?></option>
                <?php
} while ($row_agendamento = mysql_fetch_assoc($agendamento));
  $rows = mysql_num_rows($agendamento);
  if($rows > 0) {
      mysql_data_seek($agendamento, 0);
	  $row_agendamento = mysql_fetch_assoc($agendamento);
  }
?>
              </select>
</select>
              </select>
              </select>
              </label>			  </td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="75" align="left" valign="top"><span class="style26 style29"><span class="style50">OCORR&Ecirc;NCIA:</span></span></td>
              <td width="629" align="left" valign="baseline"><span class="style19">
                <textarea name="ocorrencia" cols="76" rows="8"></textarea>
              </span></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td align="center" valign="baseline"><input name="submit" type="submit" class="style46" value="ENCAMINHAR" />
                  <label>
                  <input name="Reset" type="reset" class="style46" value="LIMPAR" />
                </label></td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <input name="id" type="hidden" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_atua_os['id']; ?>">
    <span class="style28"><span class="style44"><span class="style19">
    <input name="situacao" type="hidden" value="EM ANDAMENTO" />
    </span></span></span><span class="style28"><span class="style44"><span class="style19">
    <input name="tempo" type="hidden" value="9999999999" />
    </span></span></span><span class="style28"><span class="style44"><span class="style19">
    <input name="soma" type="hidden" value="1<?php echo $row_atua_os['soma']; ?>" />
    </span></span></span>
    <input name="pa" type="hidden" class="style46" value="<?php echo "$ip"; ?>" />
    <span class="style19">
    <input name="data" type="hidden" class="style46" id="data" value="<?php echo "$dia/$nomemes/$ano";  ?>" />
  </span>
    <label></label>
  </p>
</form>
</body>
</html>
<?php
mysql_free_result($agendamento);
?>