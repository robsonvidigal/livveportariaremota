<?php require_once('../Connections/provider.php'); ?>
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
	
  $logoutGoTo = "login.php";
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

$MM_restrictGoTo = "login.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE dados_do_plantao SET diadata=%s, supervisor=%s, turnoinicio=%s, turnofim=%s, bkp=%s WHERE id=%s",
                       GetSQLValueString($_POST['diadata'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"),
                       GetSQLValueString($_POST['turnoinicio'], "date"),
                       GetSQLValueString($_POST['turnofim'], "date"),
                       GetSQLValueString($_POST['bkp'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "plantao_inserir.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editar = "-1";
if (isset($_GET['id'])) {
  $colname_editar = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_editar = sprintf("SELECT * FROM dados_do_plantao WHERE id = %s", $colname_editar);
$editar = mysql_query($query_editar, $provider) or die(mysql_error());
$row_editar = mysql_fetch_assoc($editar);
$totalRows_editar = mysql_num_rows($editar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Editando plant&atilde;o ::</title>
<meta name="Keywords" content="" />
<meta name="Boletim operacional" content="" />
<link href="../default.css" rel="stylesheet" type="text/css" media="screen" />
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:783px;
	top:129px;
	width:382px;
	height:17px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:807px;
	top:69px;
	width:358px;
	height:52px;
	z-index:2;
}
.style5 {
	color: #8C0209;
	font-weight: bold;
}
.style10 {font-size: 12px}
.style11 {color: #8C0209}
.style19 {color: #000000}
body {
	margin-top: 0px;
}
.style13 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-size: 18px;
	font-weight: bold;
}
.style20 {
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #FFFFFF;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">editando</span>plant&atilde;o </a></h1>
  </div>
  <div id="menu">
    <ul id="main">
     <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li><a href="../busca/busca_resultado.php">Pesquisar</a></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=EM+ANDAMENTO" target="_blank">N.A. Digital<img src="../imagens/inter2.gif" width="15" height="15" /></a></li>
<li><a href="plantao_inserir.php">Plant&atilde;o</a></li>
<li><a href="operadoresesistemas_inserir.php">Cod</a></li>
<li><a href="cadastro_usuario.php">Administra&ccedil;&atilde;o</a></li>
<li><a href="<?php echo $logoutAction ?>">Sair</a></li>
<li></li>
</ul>
    <ul id="feed">
      <li></li>
      <li></li>
</ul>
  </div>
</div>
<!-- end header -->
<div id="wrapper">
  <!-- start page -->
  <div id="page">
    <!-- start content -->
    <table width="547" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle"><form action="<?php echo $editFormAction; ?>" method="post" id="form1">
            <table width="487" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td height="32" colspan="2" align="center" valign="middle" nowrap="nowrap" background="../images/img02.jpg" class="style13"><h3 class="style20">PLANT&Atilde;O - ALTERAR </h3></td>
              </tr>
              <tr valign="baseline">
                <td width="128" height="26" align="right" valign="middle" nowrap="nowrap"><span class="style11">Supervisor(a):</span></td>
                <td width="347" align="left" valign="middle"><input type="text" name="supervisor" value="<?php echo $row_editar['supervisor']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td height="26" align="right" valign="middle" nowrap="nowrap"><span class="style11">In&iacute;cio:</span></td>
                <td align="left" valign="middle"><select name="turnoinicio" id="turnoinicio">
                    <?php
do {  
?>
                    <option value="<?php echo $row_editar['turnofim']?>"<?php if (!(strcmp($row_editar['turnofim'], $row_editar['turnofim']))) {echo "selected=\"selected\"";} ?>><?php echo $row_editar['turnofim']?></option>
                    <?php
} while ($row_editar = mysql_fetch_assoc($editar));
  $rows = mysql_num_rows($editar);
  if($rows > 0) {
      mysql_data_seek($editar, 0);
	  $row_editar = mysql_fetch_assoc($editar);
  }
?>
                    <option value="00:00" <?php if (!(strcmp("00:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>00:00</option>
                    <option value="01:00" <?php if (!(strcmp("01:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>01:00</option>
                    <option value="02:00" <?php if (!(strcmp("02:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>02:00</option>
                    <option value="03:00" <?php if (!(strcmp("03:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>03:00</option>
                    <option value="04:00" <?php if (!(strcmp("04:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>04:00</option>
                    <option value="05:00" <?php if (!(strcmp("05:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>05:00</option>
                    <option value="06:00" <?php if (!(strcmp("06:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>06:00</option>
                    <option value="07:00" <?php if (!(strcmp("07:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>07:00</option>
                    <option value="08:00" <?php if (!(strcmp("08:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>08:00</option>
                    <option value="09:00" <?php if (!(strcmp("09:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>09:00</option>
                    <option value="10:00" <?php if (!(strcmp("10:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>10:00</option>
                    <option value="11:00" <?php if (!(strcmp("11:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>11:00</option>
                    <option value="12:00" <?php if (!(strcmp("12:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>12:00</option>
                    <option value="13:00" <?php if (!(strcmp("13:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>13:00</option>
                    <option value="14:00" <?php if (!(strcmp("14:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>14:00</option>
                    <option value="15:00" <?php if (!(strcmp("15:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>15:00</option>
                    <option value="16:00" <?php if (!(strcmp("16:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>16:00</option>
                    <option value="17:00" <?php if (!(strcmp("17:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>17:00</option>
                    <option value="18:00" <?php if (!(strcmp("18:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>18:00</option>
                    <option value="19:00" <?php if (!(strcmp("19:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>19:00</option>
                    <option value="20:00" <?php if (!(strcmp("20:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>20:00</option>
                    <option value="21:00" <?php if (!(strcmp("21:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>21:00</option>
                    <option value="22:00" <?php if (!(strcmp("22:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>22:00</option>
                    <option value="23:00" <?php if (!(strcmp("23:00", $row_usuarios_plantao['turnofim']))) {echo "selected=\"selected\"";} ?>>23:00</option>
                  </select></td>
              </tr>
              <tr valign="baseline">
                <td height="26" align="right" valign="middle" nowrap="nowrap"><span class="style11">T&eacute;rmino:</span></td>
                <td align="left" valign="middle"><select name="turnofim" id="turnofim">
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar['turnoinicio']?>"<?php if (!(strcmp($row_editar['turnoinicio'], $row_editar['turnoinicio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_editar['turnoinicio']?></option>
                  <?php
} while ($row_editar = mysql_fetch_assoc($editar));
  $rows = mysql_num_rows($editar);
  if($rows > 0) {
      mysql_data_seek($editar, 0);
	  $row_editar = mysql_fetch_assoc($editar);
  }
?>
                  <option value="00:00" <?php if (!(strcmp("00:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>00:00</option>
                  <option value="01:00" <?php if (!(strcmp("01:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>01:00</option>
                  <option value="02:00" <?php if (!(strcmp("02:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>02:00</option>
                  <option value="03:00" <?php if (!(strcmp("03:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>03:00</option>
                  <option value="04:00" <?php if (!(strcmp("04:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>04:00</option>
                  <option value="05:00" <?php if (!(strcmp("05:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>05:00</option>
                  <option value="06:00" <?php if (!(strcmp("06:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>06:00</option>
                  <option value="07:00" <?php if (!(strcmp("07:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>07:00</option>
                  <option value="08:00" <?php if (!(strcmp("08:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>08:00</option>
                  <option value="09:00" <?php if (!(strcmp("09:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>09:00</option>
                  <option value="10:00" <?php if (!(strcmp("10:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>10:00</option>
                  <option value="11:00" <?php if (!(strcmp("11:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>11:00</option>
                  <option value="12:00" <?php if (!(strcmp("12:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>12:00</option>
                  <option value="13:00" <?php if (!(strcmp("13:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>13:00</option>
                  <option value="14:00" <?php if (!(strcmp("14:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>14:00</option>
                  <option value="15:00" <?php if (!(strcmp("15:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>15:00</option>
                  <option value="16:00" <?php if (!(strcmp("16:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>16:00</option>
                  <option value="17:00" <?php if (!(strcmp("17:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>17:00</option>
                  <option value="18:00" <?php if (!(strcmp("18:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>18:00</option>
                  <option value="19:00" <?php if (!(strcmp("19:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>19:00</option>
                  <option value="20:00" <?php if (!(strcmp("20:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>20:00</option>
                  <option value="21:00" <?php if (!(strcmp("21:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>21:00</option>
                  <option value="22:00" <?php if (!(strcmp("22:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>22:00</option>
                  <option value="23:00" <?php if (!(strcmp("23:00", $row_usuarios_plantao['turnoinicio']))) {echo "selected=\"selected\"";} ?>>23:00</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td height="26" align="right" valign="middle" nowrap="nowrap"><span class="style11">Controlador(a):</span></td>
                <td align="left" valign="middle"><input type="text" name="bkp" value="<?php echo $row_editar['bkp']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td height="28" colspan="2" align="center" valign="middle" nowrap="nowrap"><input name="Submit" type="submit" value="ALTERAR" /></td>
              </tr>
            </table>
          <input type="hidden" name="id" value="<?php echo $row_editar['id']; ?>" />
            <input type="hidden" name="diadata" value="<?php echo $row_editar['diadata']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_editar['id']; ?>" />
        </form></td>
      </tr>
    </table>
    <!-- end content -->
    <!-- start sidebars -->
    <!-- end sidebars -->
<div style="clear: both;">&nbsp;</div>
  </div>
  <!-- end page -->
</div>
<div id="footer">
  <p class="copyright">&copy;&nbsp;&nbsp;2013 Todos os direitos reservados &nbsp;&bull;&nbsp; Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<div align="center">Desenvolvido: <a href="mailto:robsonvidigal@gmail.com">robson vidigal</a></div>
</body>
</html>
<?php
mysql_free_result($editar);
?>