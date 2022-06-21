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
  $updateSQL = sprintf("UPDATE operador SET arapiraca=%s, penedo=%s, palmeira=%s, santana=%s, delmiro=%s, saomiguel=%s, riolargo=%s, uniao=%s, matriz=%s, maceio=%s, ajuriar=%s, ajuripe=%s, ajuripa=%s, ajurisa=%s, ajuride=%s, ajurims=%s, ajuriri=%s, ajuriun=%s, ajurima=%s, ajurimc=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['ajurimc'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "operadoresesistemas_editar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_provider, $provider);
$query_editar_operadores = "SELECT * FROM operador ORDER BY id DESC";
$editar_operadores = mysql_query($query_editar_operadores, $provider) or die(mysql_error());
$row_editar_operadores = mysql_fetch_assoc($editar_operadores);
$totalRows_editar_operadores = mysql_num_rows($editar_operadores);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Editando cod ::</title>
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
.style42 {font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FFFFFF;}
.style21 {
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
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">editando</span>cod </a></h1>
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
    <table width="527" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="376" height="373" align="center" valign="middle"><form action="<?php echo $editFormAction; ?>" method="post" id="form1">
            <table width="515" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td height="29" colspan="3" align="center" valign="middle" nowrap="nowrap" background="../images/img02.jpg" class="style42"><h3 class="style21">OPERADORES E SISTEMA AJURI - ALTERAR</h3></td>
              </tr>
              <tr valign="baseline">
                <td width="106" align="right" valign="middle" nowrap="nowrap"><span class="style11">Arapiraca: </span></td>
                <td width="194" align="left" valign="middle"><input type="text" name="arapiraca" value="<?php echo $row_editar_operadores['arapiraca']; ?>" size="32" /></td>
                <td width="215" align="left" valign="middle"><select name="ajuriar" >
                    <?php
do {  
?>
                    <option value="<?php echo $row_editar_operadores['ajuriar']; ?>"><?php echo $row_editar_operadores['ajuriar']; ?></option>
                    <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                    <option value=" "> </option>
                                        <option value="OK">OK</option>
                    <option value="SEM">SEM</option>
                    </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Penedo: </span></td>
                <td align="left" valign="middle"><input type="text" name="penedo" value="<?php echo $row_editar_operadores['penedo']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajuripe" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajuripe']; ?>"><?php echo $row_editar_operadores['ajuripe']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Palmeira: </span></td>
                <td align="left" valign="middle"><input type="text" name="palmeira" value="<?php echo $row_editar_operadores['palmeira']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajuripa" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajuripa']; ?>"><?php echo $row_editar_operadores['ajuripa']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Santana: </span></td>
                <td align="left" valign="middle"><input type="text" name="santana" value="<?php echo $row_editar_operadores['santana']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajurisa" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajurisa']; ?>"><?php echo $row_editar_operadores['ajurisa']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Delmiro: </span></td>
                <td align="left" valign="middle"><input type="text" name="delmiro" value="<?php echo $row_editar_operadores['delmiro']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajuride" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajuride']; ?>"><?php echo $row_editar_operadores['ajuride']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">S&atilde;o Miguel: </span></td>
                <td align="left" valign="middle"><input type="text" name="saomiguel" value="<?php echo $row_editar_operadores['saomiguel']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajurims" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajurims']; ?>"><?php echo $row_editar_operadores['ajurims']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Rio Largo: </span></td>
                <td align="left" valign="middle"><input type="text" name="riolargo" value="<?php echo $row_editar_operadores['riolargo']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajuriri" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajuriri']; ?>"><?php echo $row_editar_operadores['ajuriri']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Uni&atilde;o: </span></td>
                <td align="left" valign="middle"><input type="text" name="uniao" value="<?php echo $row_editar_operadores['uniao']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajuriun" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajuriun']; ?>"><?php echo $row_editar_operadores['ajuriun']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Matriz: </span></td>
                <td align="left" valign="middle"><input type="text" name="matriz" value="<?php echo $row_editar_operadores['matriz']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajurima" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajurima']; ?>"><?php echo $row_editar_operadores['ajurima']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap"><span class="style11">Macei&oacute;: </span></td>
                <td align="left" valign="middle"><input type="text" name="maceio" value="<?php echo $row_editar_operadores['maceio']; ?>" size="32" /></td>
                <td align="left" valign="middle"><select name="ajurimc" >
                  <?php
do {  
?>
                  <option value="<?php echo $row_editar_operadores['ajurimc']; ?>"><?php echo $row_editar_operadores['ajurimc']; ?></option>
                  <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
          $row_editor = mysql_fetch_assoc($editor);
  }
?>
                  <option value=" "> </option>
                                  <option value="OK">OK</option>
                  <option value="SEM">SEM</option>
                </select></td>
              </tr>
              <tr valign="baseline">
                <td colspan="3" align="center" valign="middle" nowrap="nowrap"><input name="submit" type="submit" value="ALTERAR" /></td>
              </tr>
            </table>
          <input type="hidden" name="id" value="<?php echo $row_editar_operadores['id']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_editar_operadores['id']; ?>" />
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
mysql_free_result($editar_operadores);
?>
