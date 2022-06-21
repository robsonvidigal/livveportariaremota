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
$MM_authorizedUsers = "r,s";
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

if ((isset($_POST['id'])) && ($_POST['id'] != "") && (isset($_GET['id']))) {
  $deleteSQL = sprintf("DELETE FROM informacao WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($deleteSQL, $provider) or die(mysql_error());

  $deleteGoTo = "ocorrencia_inserir.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_deletar = "-1";
if (isset($_GET['id'])) {
  $colname_deletar = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_deletar = sprintf("SELECT * FROM informacao WHERE id = %s", $colname_deletar);
$deletar = mysql_query($query_deletar, $provider) or die(mysql_error());
$row_deletar = mysql_fetch_assoc($deletar);
$totalRows_deletar = mysql_num_rows($deletar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Excluindo ::</title>
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
.style10 {font-size: 12px}
.style11 {color: #8C0209}
.style19 {color: #000000}
body {
        margin-top: 0px;
}
.style21 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FFFFFF; font-weight: bold; }
.style6 {        font-size: 12px;
        font-family: Georgia, "Times New Roman", Times, serif;
}
.style8 {        font-size: 10px;
        font-style: italic;
        color: #999999;
}
.style23 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style24 {color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style25 {font-size: 11px; color: #999999;}
-->
</style>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">excluindo</span>ocorr&ecirc;ncia </a></h1>
  </div>
  <div id="menu">
    <ul id="main">
     <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li><a href="../busca/busca_resultado.php">Pesquisar</a></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=EM+ANDAMENTO" target="_blank">N.A. Digital <img src="../imagens/inter2.gif" width="15" height="15" /></a></li>
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
    <table width="750" height="187" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="38" align="center" valign="middle" background="../images/img02.jpg"><h3><span class="style21 style10">DELETAR  OCORR&Ecirc;NCIA </span></h3></td>
      </tr>
      <tr>
        <td width="857" height="149" align="center" valign="middle"><form id="form1" method="post" action="">
            <table width="745" height="78" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><div align="justify" class="style6"><span class="style24"><strong><?php echo $row_deletar['horario']; ?></strong></span><span class="style23"> - <span class="style19"><?php echo $row_deletar['operador']; ?> ( <?php echo $row_deletar['rd']; ?> ) </span>- <span class="style11"> <?php echo strip_tags ($row_deletar['assunto'], "<href><i>"); ?> </span></span><span class="style24"><br />
                        <?php echo strip_tags ( nl2br ($row_deletar['informacao']), "<strong><em><span><img><li><p><ol><ul><a>"); ?></span> <span class="style23"><br />
                          <span class="style8"><span class="style25"><?php echo $row_deletar['dia']; ?>, Controlador: <?php echo $row_deletar['controlador']; ?>, Supervisor(a): <?php echo $row_deletar['supervisor']; ?></span></span></span></div></td>
              </tr>
              <tr>
                <td height="24" align="center" valign="middle"><input name="Submit2" type="submit" value="DELETAR" /></td>
              </tr>
            </table>
          <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" />
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
mysql_free_result($deletar);
?>
