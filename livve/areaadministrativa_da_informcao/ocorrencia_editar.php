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
	
  $logoutGoTo = "../login/login.php";
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
  $updateSQL = sprintf("UPDATE informacao SET horario=%s, operador=%s, rd=%s, assunto=%s, informacao=%s, controlador=%s, supervisor=%s, dia=%s WHERE id=%s",
                       GetSQLValueString($_POST['horario'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['rd'], "text"),
                       GetSQLValueString($_POST['assunto'], "text"),
                       GetSQLValueString($_POST['informacao'], "text"),
                       GetSQLValueString($_POST['controlador'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"),
                       GetSQLValueString($_POST['dia'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "ocorrencia_inserir.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editor = "-1";
if (isset($_GET['id'])) {
  $colname_editor = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_provider, $provider);
$query_editor = sprintf("SELECT * FROM informacao WHERE id = %s", $colname_editor);
$editor = mysql_query($query_editor, $provider) or die(mysql_error());
$row_editor = mysql_fetch_assoc($editor);
$totalRows_editor = mysql_num_rows($editor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Ocorr&ecirc;ncia editando ::</title>
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
.style40 {font-family: Verdana, Arial, Helvetica, sans-serif; color: #FFFFFF; font-size: 20px;}
.style21 {font-size: 12px; color: #FFFFFF; }
.style54 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #8C0209; }
-->
</style>

<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
        tinyMCE.init({
                // General options
                mode : "textareas",
                theme : "advanced",
                plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

                // Theme options
                theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,|,forecolor,backcolor,|,link,unlink,image,media,code,|,undo,redo",
                theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,iespell,charmap,|,preview,fullscreen",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing : true,

                // Example content CSS (should be your site CSS)
                content_css : "css/content.css",

                // Drop lists for link/image/media/template dialogs
                template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js",

                // Style formats
                style_formats : [
                        {title : 'Bold text', inline : 'b'},
                        {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                        {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                        {title : 'Example 1', inline : 'span', classes : 'example1'},
                        {title : 'Example 2', inline : 'span', classes : 'example2'},
                        {title : 'Table styles'},
                        {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
                ],

                // Replace values for the template plugin
                template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                }
        });
</script>
<!-- /TinyMCE -->
<script type="text/javascript">
if (document.location.protocol == 'file:') {
        alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">ocorr&ecirc;ncia</span>editando<span class="style19"></span> </a></h1>
  </div>
  <div id="menu">
     <ul id="main">
     <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li></li>
<li><a href="../pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=" target="_blank">N.A. Digital</a></li>
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
    <form action="<?php echo $editFormAction; ?>  " method="post" id="form1"" onSubmit="return validaCampoObrigatorio(this)"">
      <table width="675" height="279" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr valign="baseline">
          <td height="29" colspan="2" align="center" valign="middle" nowrap="nowrap" background="../images/img02.jpg" class="style40"><h3 class="style21">OCORR&Ecirc;NCIA - ALTERAR </h3></td>
        </tr>
        <tr valign="baseline">
          <td width="119" height="26" align="center" valign="middle" nowrap="nowrap" class="style11" id="operador">Operador(a) </td>
          <td width="522" align="left" valign="middle"><input type="text" name="operador"  value="<?php echo $row_editor['operador']; ?>" size="27" /></td>
        </tr>
        <tr valign="baseline">
          <td height="26" align="center" valign="middle" nowrap="nowrap"><span class="style54">Unidade</span></td>
          <td align="left" valign="middle"><select name="rd" >
            <?php
do {  
?>
            <option value="<?php echo $row_editor['rd']?>"><?php echo $row_editor['rd']?></option>
            <?php
} while ($row_editor = mysql_fetch_assoc($editor));
  $rows = mysql_num_rows($editor);
  if($rows > 0) {
      mysql_data_seek($editor, 0);
	  $row_editor = mysql_fetch_assoc($editor);
  }
?><option value="(FAROL)">FAROL</option>
            <option value="(BENEDITO BENTES)">BENEDITO BENTES</option>
            <option value="(JARAGUA)">JARAGUA</option>
            <option value="(AGRESTE)">AGRESTE</option>
            <option value="(SERRANA)">SERRANA</option>
            <option value="(SERTAO)">SERTAO</option>
            <option value="(B. LEITEIRA)">B. LEITEIRA</option>
            <option value="(LESTE)">LESTE</option>
            <option value="(SANAMA)">SANAMA</option>
              
              
          </select></td>
        </tr>
        <tr valign="baseline">
          <td align="center" valign="middle" nowrap="nowrap"><span class="style54">T&iacute;tulo</span></td>
          <td height="26" align="left" valign="middle"><input name="assunto" type="text" id="assunto" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_editor['assunto'];  echo $row_editor['assunto2']; ?>" size="102" xml:lang="1" /></td>
        </tr>
        <tr valign="baseline">
          <td height="103" align="center" valign="middle" nowrap="nowrap"><span class="style11" id="informacao">Informa&ccedil;&atilde;o:</span></td>
          <td align="left" valign="middle"><textarea name="informacao" cols="65" rows="6"><?php echo $row_editor['informacao']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td height="26" colspan="2" align="center" valign="middle" nowrap="nowrap"><input name="Submit2" type="submit" value="ALTERAR" /></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_editor['id']; ?>" />
      <input type="hidden" name="horario" value="<?php echo $row_editor['horario']; ?>" />
      <input type="hidden" name="controlador" value="<?php echo $row_editor['controlador']; ?>" />
      <input type="hidden" name="supervisor" value="<?php echo $row_editor['supervisor']; ?>" />
      <input type="hidden" name="dia" value="<?php echo $row_editor['dia']; ?>" />
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id" value="<?php echo $row_editor['id']; ?>" />
    </form>
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
mysql_free_result($editor);
?>
