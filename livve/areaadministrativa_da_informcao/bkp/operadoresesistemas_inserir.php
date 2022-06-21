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
  $insertSQL = sprintf("INSERT INTO operador (id, arapiraca, penedo, palmeira, santana, delmiro, saomiguel, riolargo, uniao, matriz, maceio, ajuriar, ajuripe, ajuripa, ajurisa, ajuride, ajurims, ajuriri, ajuriun, ajurima, ajurimc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['arapiraca'], "text"),
                       GetSQLValueString($_POST['penedo'], "text"),
                       GetSQLValueString($_POST['palmeira'], "text"),
                       GetSQLValueString($_POST['santana'], "text"),
                       GetSQLValueString($_POST['delmiro'], "text"),
                       GetSQLValueString($_POST['saomiguel'], "text"),
                       GetSQLValueString($_POST['riolargo'], "text"),
                       GetSQLValueString($_POST['uniao'], "text"),
                       GetSQLValueString($_POST['matriz'], "text"),
                       GetSQLValueString($_POST['maceio'], "text"),
                       GetSQLValueString($_POST['ajuriar'], "text"),
                       GetSQLValueString($_POST['ajuripe'], "text"),
                       GetSQLValueString($_POST['ajuripa'], "text"),
                       GetSQLValueString($_POST['ajurisa'], "text"),
                       GetSQLValueString($_POST['ajuride'], "text"),
                       GetSQLValueString($_POST['ajurims'], "text"),
                       GetSQLValueString($_POST['ajuriri'], "text"),
                       GetSQLValueString($_POST['ajuriun'], "text"),
                       GetSQLValueString($_POST['ajurima'], "text"),
                       GetSQLValueString($_POST['ajurimc'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "operadoresesistemas_inserir.php";
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
<title>:: Inserindo cod ::</title>
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
.style1 {        font-size: 12px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12; color: #003466; }
.style8 {        font-size: 12px;
        font-family: Georgia, "Times New Roman", Times, serif;
        color: #FFFFFF;
        font-weight: bold;
}
-->
</style>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_0518173749_0) return;
  window.mm_menu_0518173749_0 = new Menu("root",91,18,"Verdana, Arial, Helvetica, sans-serif",12,"#FFFFFF","#FFFFFF","#8C0209","#999999","left","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_0518173749_0.addMenuItem("Editar&nbsp;Cod","location='operadoresesistemas_editar.php'");
   mm_menu_0518173749_0.hideOnMouseOut=true;
   mm_menu_0518173749_0.bgColor='#FFFFFF';
   mm_menu_0518173749_0.menuBorder=1;
   mm_menu_0518173749_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0518173749_0.menuBorderBgColor='#FFFFFF';

mm_menu_0518173749_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">cod</span> </a></h1>
  </div>
  <div id="menu">
    <ul id="main">
      <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li><a href="../busca/busca_resultado.php">Pesquisar</a></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=EM+ANDAMENTO" target="_blank">N.A. Digital </a></li>
<li><a href="plantao_inserir.php">Plant&atilde;o</a></li>
<li><a href="operadoresesistemas_inserir.php" name="link2" id="link1" onmouseover="MM_showMenu(window.mm_menu_0518173749_0,0,50,null,'link2')" onmouseout="MM_startTimeout();">Cod</a></li>
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
    <table width="501" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle"><form action="<?php echo $editFormAction; ?>" method="post" id="form1">
          <table width="452" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr valign="baseline">
              <td height="39" colspan="3" align="center" valign="middle" nowrap="nowrap" background="../images/img02.jpg"><h3><span class="style8">INFORMA&Ccedil;&Otilde;ES SOBRE AS RD E SISTEMA </span></h3></td>
            </tr>
            <tr valign="baseline">
              <td width="137" height="21" align="right" valign="middle" nowrap="nowrap" class="style11">Distritos</td>
              <td width="192" align="left" valign="middle" class="style11">&nbsp;</td>
              <td width="101" align="left" valign="middle" class="style11">Sistema</td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11">Arapiraca: </td>
              <td align="left" valign="middle"><input type="text" name="arapiraca" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuriar">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Penedo: </div></td>
              <td align="left" valign="middle"><input type="text" name="penedo" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuripe">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Palmeira: </div></td>
              <td align="left" valign="middle"><input type="text" name="palmeira" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuripa">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Santana: </div></td>
              <td align="left" valign="middle"><input type="text" name="santana" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajurisa">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Delmiro: </div></td>
              <td align="left" valign="middle"><input type="text" name="delmiro" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuride">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">S&atilde;o Miguel: </div></td>
              <td align="left" valign="middle"><input type="text" name="saomiguel" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajurims">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Rio Largo </div></td>
              <td align="left" valign="middle"><input type="text" name="riolargo" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuriri">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Uni&atilde;o: </div></td>
              <td align="left" valign="middle"><input type="text" name="uniao" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajuriun">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Matriz: </div></td>
              <td align="left" valign="middle"><input type="text" name="matriz" value="" size="32" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()"/></td>
              <td align="left" valign="middle"><select name="ajurima">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap="nowrap" bordercolor="#003466" class="style11"><div align="right">Macei&oacute;:</div></td>
              <td align="left" valign="middle"><input type="text" name="maceio" " value="" size="32" />
              <td align="left" valign="middle"><select name="ajurimc">
                <option value=" " <?php if (!(strcmp(" ", ""))) {echo "SELECTED";} ?>> </option>
                <option value="OK" <?php if (!(strcmp("OK", ""))) {echo "SELECTED";} ?>>OK</option>
                <option value="SEM" <?php if (!(strcmp("SEM", ""))) {echo "SELECTED";} ?>>SEM</option>
              </select></td>
            </tr>

            <tr valign="baseline">
              <td colspan="3" align="center" valign="middle" nowrap="nowrap"><input name="Submit" type="submit" value="INSERIR" /></td>
            </tr>
          </table>
          <input type="hidden" name="id" value="" />
          <input type="hidden" name="MM_insert" value="form1" />
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
