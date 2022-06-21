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
  $insertSQL = sprintf("INSERT INTO novarec (id_re, noid, ip, in_situacao, operador, newsrec) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_re'], "int"),
                       GetSQLValueString($_POST['noid'], "int"),
                       GetSQLValueString($_POST['ip'], "text"),
					   GetSQLValueString($_POST['in_situacao'], "text"),
					   GetSQLValueString($_POST['operador'], "text"),
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
?>
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
	
  $logoutGoTo = "../../pastadenadigitalcallcenter/login/login.php";
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

$MM_restrictGoTo = "../../pastadenadigitalcallcenter/login/login.php";
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
.style53 {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF0000;
	font-weight: bold;
}
.style54 {font-size: 12px}
.style55 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style56 {font-size: 12}
.style57 {font-size: 14px}
.style58 {font-size: 13px}
-->
</style>
</head>

<body>
<table width="720" height="361" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="middle"><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
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
            <td width="71" align="left" valign="top" class="style50">N&Uacute;MERO NA:</td>
            <td width="633" align="left" valign="bottom" class="style46 style54"><?php echo $row_naconsulta['id']; ?></td>
          </tr>
        </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="75" align="left" valign="top" class="style46"><strong class="style50">TELEATENDENTE:</strong></td>
            <td width="179" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['teleatendente']; ?></td>
            <td width="15" align="left" valign="top" class="style50">PA:</td>
            <td width="117" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['pa']; ?></td>
            <td width="29" align="left" valign="top" class="style50">HORA:</td>
            <td width="121" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['hora']; ?></td>
            <td width="27" align="left" valign="top" class="style50">DATA:</td>
            <td width="129" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['data']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="95" align="left" valign="top" class="style50">&nbsp;</td>
            <td width="146" align="left" valign="bottom" class="style55">&nbsp;</td>
            <td width="92" align="left" valign="top" class="style50">RG/INSC. EST.:</td>
            <td width="112" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['rg']; ?></td>
            <td width="70" align="left" valign="top" class="style50">CPF/CNPJ:</td>
            <td width="181" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['cpf']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="32" height="14" align="left" valign="top" class="style50">NOME:</td>
            <td width="291" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['nome_cli']; ?></td>
            <td width="59" align="left" valign="top" class="style50"><strong>MATR&Iacute;CULA:</strong></td>
            <td width="111" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['uc']; ?></td>
            <td width="47" align="left" valign="top" class="style50">HITR&Ocirc;METRO:</td>
            <td width="156" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['medidor']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="52" align="left" valign="top" class="style50">ENDERE&Ccedil;O:</td>
            <td width="652" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['endereco']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="42" align="left" valign="top" class="style50">BAIRRO:</td>
            <td width="172" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['bairro']; ?></td>
            <td width="51" align="left" valign="top" class="style50">UNIDADE:</td>
            <td width="150" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['distrito']; ?></td>
            <td width="59" align="left" valign="top" class="style50">MUN&Iacute;CIPIO:</td>
            <td width="222" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['municipio']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="55" align="left" valign="top" class="style50">CELULAR:</td>
            <td width="166" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['celular']; ?></td>
            <td width="83" align="left" valign="top" class="style50">TELEFONE FIXO:</td>
            <td width="396" align="left" valign="bottom" class="style55"><?php echo $row_naconsulta['telefone']; ?></td>
          </tr>
      </table>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="24" align="left" valign="top" class="style50">R.A.:</td>
            <td width="316" align="left" valign="bottom" class="style46"><span class="style; ?></span></td>
              <td align="left" valign="top">
              <label class="style55"><?php echo $row_naconsulta['os_nub']; ?></label>            </td>
            <td width="45" align="left" valign="top" class="style50">SERVI&Ccedil;O:</td>
            <td width="315" align="left" valign="bottom" class="style53"><?php echo $row_naconsulta['prioridade']; ?></td>
          </tr>
      </table>
      <table width="710" height="32" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td width="68" align="left" valign="top" class="style50">OCORR&Ecirc;NCIA:</td>
            <td width="636" align="left" valign="baseline" class="style55"><?php echo $row_naconsulta['ocorrencia']; ?></td>
          </tr>
      </table>
      <br>
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><span class="style51">Hist&oacute;rico da N.A. de pedidos de refor&ccedil;os e conclus&otilde;es.</span></td>
        </tr>
      </table>
      <table width="710" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="704" height="46" align="left" valign="top" class="style46"><br><?php do { ?>
                  <span class="style57"><span class="style58"><strong><?php echo $row_novarec['newsrec']; ?></strong> - <?php echo $row_novarec['operador']; ?> <?php echo $row_novarec['ip']; ?> - <strong>STATUS:</strong> <?php echo $row_novarec['in_situacao']; ?>, <strong>JUSTIFICATIVA:</strong> <?php echo $row_novarec['justificativa']; ?></span><br>
                  <br>
                  <?php } while ($row_novarec = mysql_fetch_assoc($novarec)); ?>
              </span><span class="style57">              </span><span class="style56">              </span><span class="style54">              </span></td>
          </tr>
      </table>
      <br>
      <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
          <tr>
            <td align="center" valign="baseline"><form method="post" name="form2" action="<?php echo $editFormAction; ?>">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
            <tr valign="baseline">
              <td width="418" height="25" align="left" valign="middle" class="style46">Ol&aacute;! <?php echo $row_usuarios['login']; ?>, deseja Refor&ccedil;ar a R.A? 
                
                <label>
                <input name="botao" type="submit" class="style46" id="botao" value="Sim" />
                <input name="soma" type="hidden" value="<?php echo $row_naconsulta['soma']+1; ?>" />
                <input name="situacao" type="hidden" id="situacao" value="EM ANDAMENTO" />
                <input name="in_situacao" type="hidden" id="in_situacao" value="EM ANDAMENTO" />
				<input name="operador" type="hidden" id="operador" value="REFO&Ccedil;O FEITO POR: <?php echo $row_usuarios['login']; ?>" />
                <input name="ocorrencia" type="hidden" id="ocorrencia" value="<?php echo $row_naconsulta['ocorrencia']; ?> | Novo contato: <?php echo $dataHora; ?>" />
                <input name="noid" type="hidden" value="<?php echo $row_naconsulta['id']; ?>" />
                <input name="ip" type="hidden" id="ip" value="| IP: <?php echo "$ip"; ?>" />
                <input name="newsrec" type="hidden" value="<?php echo $dataHora; ?>" />
                <input name="id_re" type="hidden" value="" />
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
