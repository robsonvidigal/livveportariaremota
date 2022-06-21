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
        
  $logoutGoTo = "../login.php";
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
$MM_authorizedUsers = "r";
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

$MM_restrictGoTo = "../login.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_horario")) {
  $insertSQL = sprintf("INSERT INTO informacao (id, horario, operador, rd, assunto, informacao, controlador, supervisor, dia) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['horario'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['rd'], "text"),
                       GetSQLValueString($_POST['assunto'], "text"),
                       GetSQLValueString($_POST['informacao'], "text"),
                       GetSQLValueString($_POST['controlador'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"),
                       GetSQLValueString($_POST['dia'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "informativo_inserir.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_provider, $provider);
$query_plantao = "SELECT * FROM dados_do_plantao ORDER BY id DESC";
$plantao = mysql_query($query_plantao, $provider) or die(mysql_error());
$row_plantao = mysql_fetch_assoc($plantao);
$totalRows_plantao = mysql_num_rows($plantao);

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuarios = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $provider) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

$maxRows_in_ocorrencias = 15;
$pageNum_in_ocorrencias = 0;
if (isset($_GET['pageNum_in_ocorrencias'])) {
  $pageNum_in_ocorrencias = $_GET['pageNum_in_ocorrencias'];
}
$startRow_in_ocorrencias = $pageNum_in_ocorrencias * $maxRows_in_ocorrencias;

mysql_select_db($database_provider, $provider);
$query_in_ocorrencias = "SELECT * FROM informacao ORDER BY rd ASC";
$query_limit_in_ocorrencias = sprintf("%s LIMIT %d, %d", $query_in_ocorrencias, $startRow_in_ocorrencias, $maxRows_in_ocorrencias);
$in_ocorrencias = mysql_query($query_limit_in_ocorrencias, $provider) or die(mysql_error());
$row_in_ocorrencias = mysql_fetch_assoc($in_ocorrencias);

if (isset($_GET['totalRows_in_ocorrencias'])) {
  $totalRows_in_ocorrencias = $_GET['totalRows_in_ocorrencias'];
} else {
  $all_in_ocorrencias = mysql_query($query_in_ocorrencias);
  $totalRows_in_ocorrencias = mysql_num_rows($all_in_ocorrencias);
}
$totalPages_in_ocorrencias = ceil($totalRows_in_ocorrencias/$maxRows_in_ocorrencias)-1;

$queryString_in_ocorrencias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_in_ocorrencias") == false && 
        stristr($param, "totalRows_in_ocorrencias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_in_ocorrencias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_in_ocorrencias = sprintf("&totalRows_in_ocorrencias=%d%s", $totalRows_in_ocorrencias, $queryString_in_ocorrencias);
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_in_ocorrencias_informativo = 10;
$pageNum_in_ocorrencias_informativo = 0;
if (isset($_GET['pageNum_in_ocorrencias_informativo'])) {
  $pageNum_in_ocorrencias_informativo = $_GET['pageNum_in_ocorrencias_informativo_informativo'];
}
$startRow_in_ocorrencias_informativo = $pageNum_in_ocorrencias_informativo * $maxRows_in_ocorrencias_informativo;

$colname_in_ocorrencias_informativo = "-1";
if (isset($_GET['busca'])) {
  $colname_in_ocorrencias_informativo = (get_magic_quotes_gpc()) ? $_GET['busca'] : addslashes($_GET['busca']);
}
mysql_select_db($database_provider, $provider);
$query_in_ocorrencias_informativo = sprintf("SELECT id, horario, operador, rd, assunto, assunto2, informacao, controlador, supervisor, dia FROM informacao WHERE informacao LIKE '%%%s%%' OR assunto LIKE '%%%s%%' OR horario LIKE '%%%s%%' OR operador LIKE '%%%s%%' OR rd LIKE '%%%s%%' OR controlador LIKE '%%%s%%' OR supervisor LIKE '%%%s%%' OR dia LIKE '%%%s%%' ORDER BY id DESC", $colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo,$colname_in_ocorrencias_informativo);
$query_limit_in_ocorrencias_informativo = sprintf("%s LIMIT %d, %d", $query_in_ocorrencias_informativo, $startRow_in_ocorrencias_informativo, $maxRows_in_ocorrencias_informativo);
$in_ocorrencias_informativo = mysql_query($query_limit_in_ocorrencias_informativo, $provider) or die(mysql_error());
$row_in_ocorrencias_informativo = mysql_fetch_assoc($in_ocorrencias_informativo);

if (isset($_GET['totalRows_in_ocorrencias_informativo'])) {
  $totalRows_in_ocorrencias_informativo = $_GET['totalRows_in_ocorrencias_informativo'];
} else {
  $all_in_ocorrencias_informativo = mysql_query($query_in_ocorrencias_informativo);
  $totalRows_in_ocorrencias_informativo = mysql_num_rows($all_in_ocorrencias_informativo);
}
$totalPages_in_ocorrencias_informativo = ceil($totalRows_in_ocorrencias_informativo/$maxRows_in_ocorrencias_informativo)-1;

$queryString_in_ocorrencias_informativo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_in_ocorrencias_informativo") == false &&
        stristr($param, "totalRows_in_ocorrencias_informativo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_in_ocorrencias_informativo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_in_ocorrencias_informativo = sprintf("&totalRows_in_ocorrencias_informativo=%d%s", $totalRows_in_ocorrencias_informativo, $queryString_in_ocorrencias_informativo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Informativos ::</title>
<meta name="Keywords" content="" />
<meta name="Informativos" content="" />
<link href="../../default.css" rel="stylesheet" type="text/css" media="screen" />

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

        document.form_horario.horario.value = horaImprimible

        setTimeout("mueveHorario()",1000)
}
</script>

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
.style19 {color: #000000}
body {
        margin-top: 0px;
}
.style15 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #8C0209; font-style: italic; }
.style18 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #990000; font-style: italic; }
.style40 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #8C0209; }
.style2 {        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 20px;
        color: #FFFFFF;
}
.style54 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #8C0209; }
.style56 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #8C0209; font-weight: bold; }
.style10 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style57 {        color: #FF0000;
        font-weight: bold;
}
.style20 {        color: #999999;
        font-style: italic;
        font-size: 10px;
}
-->
</style>

<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
<body onload="mueveHorario()">
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">inserir</span>informativo </a></h1>
  </div>
  <div id="menu">
    <ul id="main">
     <li class="current_page_item"><a href="../index.php">In&iacute;cio</a></li>
        <li><a href="informativo_inserir.php?busca=INFORMATIVO+EDAL">Informativo EDAL</a></li>
        <li><a href="informativo_inserir.php?busca=DICAS+ATENDIMENTO">Dicas Atendimento</a></li>
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
    <!-- end content -->
    <!-- start sidebars -->
    <!-- end sidebars -->
<div style="clear: both;">&nbsp;
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <th width="143" height="19" align="center" valign="middle" scope="col"><span class="style15">Seja bem vindo(a): </span></th>
      <th width="197" align="left" valign="middle" scope="col"><span class="style18"><?php echo $row_usuarios['login']; ?></span></th>
      <th width="351" align="left" valign="middle" scope="col"></th>
      <th width="109" align="right" valign="middle" scope="col"><a href="../../trocadesenha/trocarsenha.php?id=<?php echo $row_usuarios['id']; ?>"><span class="style40">Alterar perfil </span></a></th>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><form action="<?php echo $editFormAction; ?>" method="post" name="form_horario" id="form_horario" >
        <table width="808" height="280" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr valign="baseline">
            <td height="35" colspan="4" align="center" valign="middle" nowrap="nowrap" background="../../images/img02.jpg"><span class="style2">Inserir Ocorr&ecirc;ncia</span></td>
          </tr>
          <tr valign="baseline">
            <td width="124" height="26" align="center" valign="middle" nowrap="nowrap"><span class="style54">Hor&aacute;rio</span></td>
            <td width="202" align="left" valign="middle"><input name="horario" type="text" class="style56" size="31" maxlength="12" readonly="true" style="border: 0px solid #FFFFFF"/>            </td>
            <td width="141" align="center" valign="middle"><span class="style54">Dia</span></td>
            <td width="294" align="center" valign="middle" class="style54"><strong>
              <input name="dia" type="hidden" value="
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
?>" /><?php

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
              </strong></td>
          </tr>
          <tr valign="baseline">
            <td height="26" align="center" valign="middle" nowrap="nowrap"><span class="style54">Operador(a)</span></td>
            <td align="left" valign="middle"><input name="operador" type="text" value="" size="35" maxlength="35"/></td>
            <td align="center" valign="middle"><span class="style54">Distritos</span></td>
            <td align="left" valign="middle"><select name="rd">
                <option value="INFORMATIVO EDAL" <?php if (!(strcmp("INFORMATIVO EDAL", ""))) {echo "SELECTED";} ?>>INFORMATIVO EDAL</option>
                <option value="DICAS ATENDIMENTO" <?php if (!(strcmp("DICAS ATENDIMENTO", ""))) {echo "SELECTED";} ?>>DICAS ATENDIMENTO</option>
                </select></td>
          </tr>
          <tr valign="baseline">
            <td align="center" valign="middle" nowrap="nowrap"><span class="style54" id="assunto">Ocorr&ecirc;ncia</span></td>
            <td height="26" colspan="3" align="left" valign="middle"><input name="assunto" type="text" value="" size="91"/></td>
          </tr>

          <tr valign="baseline">
            <td height="25" align="center" valign="middle" nowrap="nowrap"><span class="style54" id="informacao">Informa&ccedil;&atilde;o</span></td>
            <td colspan="3" align="left" valign="middle"><textarea name="informacao" cols="81" rows="6"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td height="23" align="center" valign="middle" nowrap="nowrap"><span class="style54">Controlador(a)</span></td>
            <td align="center" valign="middle"><input name="controlador" type="hidden" onfocus="if(this.value=='Digite aqui'){this.value=''}" onblur="if(this.value==''){this.value='Digite aqui'}" onkeydown="this.value = this.value.toUpperCase()" onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $row_usuarios['login']; ?>"/>
                <span class="style56"><?php echo $row_usuarios['login']; ?></span></td>
            <td align="center" valign="middle"><span class="style54">Supervisor(a)</span></td>
            <td align="center" valign="middle"><input name="supervisor" type="hidden" value="<?php echo $row_plantao['supervisor']; ?>"/>
                <span class="style56"><?php echo $row_plantao['supervisor']; ?></span></td>
          </tr>
          <tr valign="baseline">
            <td height="28" colspan="4" align="center" valign="middle" nowrap="nowrap"><input name="Submit" type="submit" value="Inserir ocorr&ecirc;ncia") /></td>
          </tr>
        </table>
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="MM_insert" value="form1" />
        <input type="hidden" name="MM_insert" value="form_horario" />
      </form></td>
    </tr>
  </table><br />
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="791" height="243" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="34" align="center" valign="middle" background="../../images/img02.jpg"><span class="style2">Ocorr&ecirc;ncias</span></td>
        </tr>
        <tr>
          <td height="32" align="center" valign="middle"><table width="500" height="47" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="154" border="0" cellpadding="0" cellspacing="0" bordercolor="">
                    <tr>
                      <td width="39" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, 0, $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/primeira.gif" width="20" height="20" border="0" /></a></td>
                      <td width="36" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, max(0, $pageNum_in_ocorrencias_informativo - 1), $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/anterior.gif" width="20" height="20" border="0" /></a></td>
                      <td width="40" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, min($totalPages_in_ocorrencias_informativo, $pageNum_in_ocorrencias_informativo + 1), $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/proxima.gif" width="20" height="20" border="0" /></a></td>
                      <td width="39" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, $totalPages_in_ocorrencias_informativo, $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/avanca.gif" width="20" height="20" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="62" align="center" valign="top"><table width="808" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="772" height="127" align="left" valign="middle"><?php do { ?>
                    <table width="112" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="56" height="33" align="center" valign="middle"><a href="informativo_editar.php?id=<?php echo $row_in_ocorrencias_informativo['id']; ?>"><img src="../../images/edit.ico" width="34" height="27" border="0" /></a></td>
                        <td width="56" align="center" valign="middle"><a href="informativo_excluir.php?id=<?php echo $row_in_ocorrencias_informativo['id']; ?>"><img src="../../images/delete.ico" width="34" height="27" border="0" /></a></td>
                      </tr>
                    </table>
                  <table width="804" height="79" border="0" align="center">
                      <tr>
                        <td height="75"><div align="justify"><span class="style10"><span class="style19"><strong><?php echo $row_in_ocorrencias_informativo['horario']; ?></strong></span> - <span class="style19"><?php echo $row_in_ocorrencias_informativo['operador']; ?></span> <span class="style19">(</span> <span class="style19"><?php echo $row_in_ocorrencias_informativo['rd']; ?></span> <span class="style19">)</span> <span class="style57">
                            <?php  echo strip_tags($row_in_ocorrencias_informativo['assunto'], "<href><i>"); ?>
                                  </span><span class="style19"><br /><?php echo strip_tags ( nl2br ($row_in_ocorrencias_informativo['informacao']), "<strong><em><span><img><li><p><ol><ul><a>"); ?></span><br />
                            <span class="style20"><?php echo $row_in_ocorrencias_informativo['dia']; ?>, Controlador(a): <?php echo $row_in_ocorrencias_informativo['controlador']; ?>, Supervisor(a): <?php echo $row_in_ocorrencias_informativo['supervisor']; ?></span></span></div>
                            <p>&nbsp;</p></td>
                      </tr>
                    </table>
                  <?php } while ($row_in_ocorrencias_informativo = mysql_fetch_assoc($in_ocorrencias_informativo)); ?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle"><table width="500" height="35" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="35" align="center" valign="middle"><table width="154" border="0" cellpadding="0" cellspacing="0" bordercolor="">
                    <tr>
                      <td width="39" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, 0, $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/primeira.gif" width="20" height="20" border="0" /></a></td>
                      <td width="36" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, max(0, $pageNum_in_ocorrencias_informativo - 1), $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/anterior.gif" width="20" height="20" border="0" /></a></td>
                      <td width="40" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, min($totalPages_in_ocorrencias_informativo, $pageNum_in_ocorrencias_informativo + 1), $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/proxima.gif" width="20" height="20" border="0" /></a></td>
                      <td width="39" align="center" valign="middle"><a href="<?php printf("%s?pageNum_in_ocorrencias_informativo=%d%s", $currentPage, $totalPages_in_ocorrencias_informativo, $queryString_in_ocorrencias_informativo); ?>"><img src="../../imagens/avanca.gif" width="20" height="20" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
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
mysql_free_result($in_ocorrencias_informativo);
?>

