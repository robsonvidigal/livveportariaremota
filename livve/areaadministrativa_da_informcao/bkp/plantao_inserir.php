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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dados_do_plantao (id, diadata, supervisor, turnoinicio, turnofim, bkp) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['diadata'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"),
                       GetSQLValueString($_POST['turnoinicio'], "text"),
                       GetSQLValueString($_POST['turnofim'], "text"),
                       GetSQLValueString($_POST['bkp'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "plantao_inserir.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_plantao = 30;
$pageNum_plantao = 0;
if (isset($_GET['pageNum_plantao'])) {
  $pageNum_plantao = $_GET['pageNum_plantao'];
}
$startRow_plantao = $pageNum_plantao * $maxRows_plantao;

mysql_select_db($database_provider, $provider);
$query_plantao = "SELECT * FROM dados_do_plantao ORDER BY id DESC";
$query_limit_plantao = sprintf("%s LIMIT %d, %d", $query_plantao, $startRow_plantao, $maxRows_plantao);
$plantao = mysql_query($query_limit_plantao, $provider) or die(mysql_error());
$row_plantao = mysql_fetch_assoc($plantao);

if (isset($_GET['totalRows_plantao'])) {
  $totalRows_plantao = $_GET['totalRows_plantao'];
} else {
  $all_plantao = mysql_query($query_plantao);
  $totalRows_plantao = mysql_num_rows($all_plantao);
}
$totalPages_plantao = ceil($totalRows_plantao/$maxRows_plantao)-1;

$colname_usuarios_plantao = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios_plantao = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuarios_plantao = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuarios_plantao);
$usuarios_plantao = mysql_query($query_usuarios_plantao, $provider) or die(mysql_error());
$row_usuarios_plantao = mysql_fetch_assoc($usuarios_plantao);
$totalRows_usuarios_plantao = mysql_num_rows($usuarios_plantao);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Plant&atilde;o ::</title>
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
.style1 {	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003466;
}
.style20 {font-size: 18px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FFFFFF; font-weight: bold; }
.style16 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style22 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style23 {font-size: 12px; color: #FFFFFF; }
-->
</style>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">plant&atilde;o</span> </a></h1>
  </div>
  <div id="menu">
     <ul id="main">
     <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li><a href="../busca/busca_resultado.php">Pesquisar</a></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=EM+ANDAMENTO" target="_blank">N.A. Digital</a></li>
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
    <div class="post">
      <h3 class="title">
      <table width="800" height="199" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="22" align="center" background="../images/img02.jpg" class="style20"><h3 class="style23">PLANT&Atilde;O</h3></td>
        </tr>
        <tr>
          <td width="596" align="center" valign="top"><form action="<?php echo $editFormAction; ?>" method="post" id="form1">
              <table width="544" border="0" align="center" cellspacing="0">
                <tr valign="baseline">
                  <td height="24" align="center" valign="middle" nowrap="nowrap"><span class="style11">Dia</span></td>
                  <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="style11"><input name="diadata" type="hidden" value="<?php

$meses = array (1 => "JANEIRO", 2 => "FEVEREIRO", 3 => "MAR&Ccedil;O", 4 => "ABRIL", 5 => "MAIO", 6 => "JUNHO", 7 => "JULHO", 8 => "AGOSTO", 9 => "SETEMBRO", 10 => "OUTUBRO", 11 => "NOVEMBRO", 12 => "DEZEMBRO");
$diasdasemana = array (1 => "SEGUNDA-FEIRA",2 => "TER&Ccedil;A-FEIRA",3 => "QUARTA-FEIRA",4 => "QUINTA-FEIRA",5 => "SEXTA-FEIRA",6 => "S&Aacute;BADO",0 => "DOMINGO");
 $hoje = getdate();
 $dia = $hoje["mday"];
 $mes = $hoje["mon"];
 $nomemes = $meses[$mes];
 $ano = $hoje["year"];
 $diadasemana = $hoje["wday"];
 $nomediadasemana = $diasdasemana[$diadasemana];
 echo "$nomediadasemana, $dia DE $nomemes DE $ano";
?>" />
                      <?php

$meses = array (1 => "JANEIRO", 2 => "FEVEREIRO", 3 => "MAR&Ccedil;O", 4 => "ABRIL", 5 => "MAIO", 6 => "JUNHO", 7 => "JULHO", 8 => "AGOSTO", 9 => "SETEMBRO", 10 => "OUTUBRO", 11 => "NOVEMBRO", 12 => "DEZEMBRO");
$diasdasemana = array (1 => "SEGUNDA-FEIRA",2 => "TER&Ccedil;A-FEIRA",3 => "QUARTA-FEIRA",4 => "QUINTA-FEIRA",5 => "SEXTA-FEIRA",6 => "S&Aacute;BADO",0 => "DOMINGO");
$hoje = getdate();
$dia = $hoje["mday"];
$mes = $hoje["mon"];
$nomemes = $meses[$mes];
$ano = $hoje["year"];
$diadasemana = $hoje["wday"];
$nomediadasemana = $diasdasemana[$diadasemana];
echo "$nomediadasemana, $dia DE $nomemes DE $ano";
?>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="24" align="center" valign="middle" nowrap="nowrap"><span class="style11">Supervis&atilde;o(a)</span></td>
                  <td colspan="3" align="left" valign="middle" nowrap="nowrap"><input type="text" name="supervisor" value="<?php echo $row_usuarios_plantao['supervisor']; ?>" size="42"/></td>
                </tr>
                <tr valign="baseline">
                  <td height="24" align="center" valign="middle" nowrap="nowrap"><span class="style11">In&iacute;cio</span></td>
                  <td width="89" align="left" valign="middle" nowrap="nowrap"><label>
                    <select name="turnoinicio" id="turnoinicio">
                      <?php
do {  
?>
                      <option value="<?php echo $row_usuarios_plantao['inicio']?>"<?php if (!(strcmp($row_usuarios_plantao['inicio'], $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_usuarios_plantao['inicio']?></option>
                      <?php
} while ($row_usuarios_plantao = mysql_fetch_assoc($usuarios_plantao));
  $rows = mysql_num_rows($usuarios_plantao);
  if($rows > 0) {
      mysql_data_seek($usuarios_plantao, 0);
	  $row_usuarios_plantao = mysql_fetch_assoc($usuarios_plantao);
  }
?>
                      <option value="00:00" <?php if (!(strcmp("00:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>00:00</option>
                      <option value="01:00" <?php if (!(strcmp("01:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>01:00</option>
                      <option value="02:00" <?php if (!(strcmp("02:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>02:00</option>
                      <option value="03:00" <?php if (!(strcmp("03:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>03:00</option>
                      <option value="04:00" <?php if (!(strcmp("04:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>04:00</option>
                      <option value="05:00" <?php if (!(strcmp("05:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>05:00</option>
                      <option value="06:00" <?php if (!(strcmp("06:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>06:00</option>
                      <option value="07:00" <?php if (!(strcmp("07:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>07:00</option>
                      <option value="08:00" <?php if (!(strcmp("08:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>08:00</option>
                      <option value="09:00" <?php if (!(strcmp("09:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>09:00</option>
                      <option value="10:00" <?php if (!(strcmp("10:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>10:00</option>
                      <option value="11:00" <?php if (!(strcmp("11:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>11:00</option>
                      <option value="12:00" <?php if (!(strcmp("12:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>12:00</option>
                      <option value="13:00" <?php if (!(strcmp("13:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>13:00</option>
                      <option value="14:00" <?php if (!(strcmp("14:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>14:00</option>
                      <option value="15:00" <?php if (!(strcmp("15:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>15:00</option>
                      <option value="16:00" <?php if (!(strcmp("16:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>16:00</option>
                      <option value="17:00" <?php if (!(strcmp("17:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>17:00</option>
                      <option value="18:00" <?php if (!(strcmp("18:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>18:00</option>
                      <option value="19:00" <?php if (!(strcmp("19:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>19:00</option>
                      <option value="20:00" <?php if (!(strcmp("20:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>20:00</option>
                      <option value="21:00" <?php if (!(strcmp("21:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>21:00</option>
                      <option value="22:00" <?php if (!(strcmp("22:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>22:00</option>
                      <option value="23:00" <?php if (!(strcmp("23:00", $row_usuarios_plantao['inicio']))) {echo "selected=\"selected\"";} ?>>23:00</option>
                    </select>
                  </label></td>
                  <td width="80" align="left" valign="middle"><div align="center" class="style11">&Agrave;s</div></td>
                  <td width="238" align="left" valign="middle"><label>
                    <select name="turnofim" id="turnofim">
                      <?php
do {  
?>
                      <option value="<?php echo $row_usuarios_plantao['fim']?>"<?php if (!(strcmp($row_usuarios_plantao['fim'], $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>><?php echo $row_usuarios_plantao['fim']?></option>
                      <?php
} while ($row_usuarios_plantao = mysql_fetch_assoc($usuarios_plantao));
  $rows = mysql_num_rows($usuarios_plantao);
  if($rows > 0) {
      mysql_data_seek($usuarios_plantao, 0);
	  $row_usuarios_plantao = mysql_fetch_assoc($usuarios_plantao);
  }
?>
                      <option value="01:00" <?php if (!(strcmp("01:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>01:00</option>
                      <option value="02:00" <?php if (!(strcmp("02:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>02:00</option>
                      <option value="03:00" <?php if (!(strcmp("03:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>03:00</option>
                      <option value="04:00" <?php if (!(strcmp("04:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>04:00</option>
                      <option value="05:00" <?php if (!(strcmp("05:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>05:00</option>
                      <option value="06:00" <?php if (!(strcmp("06:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>06:00</option>
                      <option value="07:00" <?php if (!(strcmp("07:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>07:00</option>
                      <option value="08:00" <?php if (!(strcmp("08:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>08:00</option>
                      <option value="09:00" <?php if (!(strcmp("09:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>09:00</option>
                      <option value="10:00" <?php if (!(strcmp("10:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>10:00</option>
                      <option value="11:00" <?php if (!(strcmp("11:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>11:00</option>
                      <option value="12:00" <?php if (!(strcmp("12:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>12:00</option>
                      <option value="13:00" <?php if (!(strcmp("13:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>13:00</option>
                      <option value="14:00" <?php if (!(strcmp("14:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>14:00</option>
                      <option value="15:00" <?php if (!(strcmp("15:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>15:00</option>
                      <option value="16:00" <?php if (!(strcmp("16:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>16:00</option>
                      <option value="17:00" <?php if (!(strcmp("17:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>17:00</option>
                      <option value="18:00" <?php if (!(strcmp("18:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>18:00</option>
                      <option value="19:00" <?php if (!(strcmp("19:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>19:00</option>
                      <option value="20:00" <?php if (!(strcmp("20:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>20:00</option>
                      <option value="21:00" <?php if (!(strcmp("21:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>21:00</option>
                      <option value="22:00" <?php if (!(strcmp("22:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>22:00</option>
                      <option value="23:00" <?php if (!(strcmp("23:00", $row_usuarios_plantao['fim']))) {echo "selected=\"selected\"";} ?>>23:00</option>
                    </select>
                  </label></td>
                </tr>
                <tr valign="baseline">
                  <td height="24" align="center" valign="middle" nowrap="nowrap"><span class="style11">Controle</span></td>
                  <td colspan="3" align="left" valign="middle" nowrap="nowrap"><input type="text" name="bkp" value="<?php echo $row_usuarios_plantao['login']; ?>" size="42" /></td>
                </tr>
                <tr valign="baseline">
                  <td height="26" colspan="4" align="center" valign="middle" nowrap="nowrap"><input name="Submit" type="submit" value="INSERIR" /></td>
                </tr>
              </table>
            <input type="hidden" name="id" value="" />
              <input type="hidden" name="MM_insert" value="form1" />
          </form></td>
        </tr>
      </table>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="middle" background="../images/img02.jpg"><h3><span class="style23">INFORMA&Ccedil;&Otilde;ES DOS PLANT&Otilde;ES </span></h3></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <div align="center">
        <?php do { ?>
          <table width="625" height="32" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="782" align="center"><table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
                  <tr>
                    <td width="34" align="center" valign="middle"><span class="style11">Dia: </span></td>
                    <td width="209" align="center" valign="middle"><span class="style11"><?php echo $row_plantao['diadata']; ?></span></td>
                    <td width="84" align="center"><span class="style11">Controlador: </span></td>
                    <td width="105" align="center" valign="middle"><span class="style11"><?php echo $row_plantao['bkp']; ?></span></td>
                    <td width="133" align="center" valign="middle" class="style11"><span class="style16"><?php echo $row_plantao['turnoinicio']; ?></span></td>
                    <td width="120" align="center" valign="middle" class="style11"><?php echo $row_plantao['turnofim']; ?></td>
                    <td width="41" align="center" valign="middle"><span class="style22"><a href="plantao_editar.php?id=<?php echo $row_plantao['id']; ?>"><img src="../images/edit.ico" width="34" height="27" border="0" /></a></span></td>
                    <td width="56" align="center" valign="middle"><a href="plantao_deletar.php?id=<?php echo $row_plantao['id']; ?>"><img src="../images/delete.ico" width="34" height="27" border="0" /></a></td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <?php } while ($row_plantao = mysql_fetch_assoc($plantao)); ?>
        <br />
        <br />
      </div>
    </div>
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