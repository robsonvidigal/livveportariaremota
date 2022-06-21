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
mysql_select_db($database_provider, $provider);
$query_usuariosdosistema = "SELECT * FROM login ORDER BY id ASC";
$usuariosdosistema = mysql_query($query_usuariosdosistema, $provider) or die(mysql_error());
$row_usuariosdosistema = mysql_fetch_assoc($usuariosdosistema);
$totalRows_usuariosdosistema = mysql_num_rows($usuariosdosistema);

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
  $insertSQL = sprintf("INSERT INTO login (nome, id, matricula, login, senha, nivel, inicio, fim, supervisor) VALUES (%s, %s, %s, %s, md5(%s), %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['matricula'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nivel'], "text"),
                       GetSQLValueString($_POST['inicio'], "text"),
                       GetSQLValueString($_POST['fim'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "cadastro_usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Cadastro de Usu&aacute;rio ::</title>
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
.style1 {	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003466;
}
.style50 {	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #890208;
}
.style53 {color: #FFFFFF; }
-->
</style>
</head>
<body>
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">Cadastro</span>de<span class="style19">usu&aacute;rios</span> </a></h1>
  </div>
  <div id="menu">
     <ul id="main">
     <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=EM+ANDAMENTO" target="_blank">N.A. Digital</a></li>
<li></li>
<li></li>
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
    <table width="800" height="327" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th align="center" valign="middle" scope="col"><form action="<?php echo $editFormAction; ?>" method="post" id="form2" " onSubmit="return validaCampoObrigatorio(this)"">
            <table width="800" height="257" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#8C0209">
              <tr>
                <td height="50" colspan="2" align="center" valign="middle" background="../images/img02.jpg"><h3 align="center" class="style53">Cadastro de novo usu&aacute;rio</h3></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle" class="style11">Nome: </td>
                <td align="left" valign="middle"><label>
                  <input name="nome" type="text" id="nome" size="32" />
                </label></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle" class="style11">Matricula: </td>
                <td align="left" valign="middle"><label>
                  <input name="matricula" type="text" id="matricula" size="32" />
                </label></td>
              </tr>
              <tr>
                <td width="342" height="24" align="right" valign="middle"><span class="style11">Login: </span></td>
                <td width="458" align="left" valign="middle"><label>
                  <input name="login" type="text" id="login" lang="1" onfocus="mudarCorCampo(this,'white')" size="32" xml:lang="1" />
                </label></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle" class="style11">Senha: </td>
                <td align="left" valign="middle"><label> <span class="style10">
                  <input name="senha" type="hidden" id="senha" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php
$letras  = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','x','w','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','X','W','Y','Z');
$numeros = array(0,1,2,3,4,5,6,7,8,9);
$total_let = count($letras)-1;
$total_num = count($numeros)-1;
$senha = $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)] . $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)] . $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)];
$nova_senha = $senha;
 
echo $senha;

?>" xml:lang="1" />
                  <?php 
				echo $senha;
				?>
                </span></label></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle"><span class="style11">N&iacute;vel de acesso: </span></td>
                <td align="left" valign="middle"><input name="nivel" type="text" id="nivel" size="5" />
                    <span class="style50">* S = SUPERVISOR  * R = COORDENADOR * BRANCO = S/ ACESSO </span></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle" class="style11">Turno: </td>
                <td align="left" valign="middle"><label>
                  <select name="inicio" id="inicio">
                    <option value="01:00">01:00</option>
                    <option value="03:00">03:00</option>
                    <option value="06:00">06:00</option>
                    <option value="07:00">07:00</option>
                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                    <option value="21:00">21:00</option>
                  </select>
                  <span class="style11">&Agrave;s </span>
                  <select name="fim" id="select2">
                    <option value="07:00">07:00</option>
                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                    <option value="21:00">21:00</option>
                    <option value="01:00">01:00</option>
                    <option value="02:00">02:00</option>
                    <option value="03:00">03:00</option>
                  </select>
                  <span class="style1"> </span></label></td>
              </tr>
              <tr>
                <td height="24" align="right" valign="middle"><span class="style11">Supervisor(a): </span></td>
                <td align="left" valign="middle"><label>
                  <input name="supervisor" type="text" id="supervisor" size="32" />
                </label></td>
              </tr>
              <tr>
                <td height="26" colspan="2" align="center" valign="middle"><div align="left">
                    <label> </label>
                    <div align="center">
                      <input name="submit" type="submit" id="submit" value="CADASTRAR" />
                    </div>
                  <label> </label>
                    <div align="center"></div>
                </div>
                    <div align="center"></div>
                  <div align="center"></div></td>
              </tr>
            </table>
          <input name="id" type="hidden" value="" />
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
            <p>&nbsp;</p>
            <table width="800" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="48" background="../images/img02.jpg"><div align="center"><span class="style11 style53">Lista de Usu&aacute;rios Cadastrados </span></div></td>
              </tr>
            </table>
            <?php do { ?>
            <table width="800" height="60" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" background="../images/img06.jpg">
              <tr>
                <td height="30" align="center" valign="middle"><span class="style11">Login</span></td>
                <td><span class="style11"><?php echo $row_usuariosdosistema['login']; ?></span></td>
                <td width="95" align="center"><a href="../trocadesenha/trocarsenha.php?id=<?php echo $row_usuariosdosistema['id']; ?>"><img src="../images/edit.ico" width="34" height="27" border="0" /></a></td>
                <td width="95" align="center"><a href="cadastro_usuario_apagar.php?id=<?php echo $row_usuariosdosistema['id']; ?>"><img src="../images/delete.ico" width="34" height="27" border="0" /></a></td>
              </tr>
              <tr>
                <td width="142" align="center" valign="middle" class="style11">Turno</td>
                <td width="468" class="style11"><?php echo $row_usuariosdosistema['inicio']; ?> &Agrave;s <?php echo $row_usuariosdosistema['fim']; ?></td>
                <td colspan="2" align="center" class="style1"></td>
              </tr>
            </table>
          <br />
            <?php } while ($row_usuariosdosistema = mysql_fetch_assoc($usuariosdosistema)); ?>
            <br /></th>
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
mysql_free_result($usuariosdosistema);
?>
