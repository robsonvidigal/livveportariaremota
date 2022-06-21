<?php require_once('../Connections/provider.php'); ?>
<?php require_once('../../Connections/bd_servicos.php'); ?>
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
        
  $logoutGoTo = "../areaadministrativa_da_informcao/ocorrencia_inserir.php";
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

$MM_restrictGoTo = "../areaadministrativa_da_informcao/ocorrencia_inserir.php";
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

$maxRows_conna = 25;
$pageNum_conna = 0;
if (isset($_GET['pageNum_conna'])) {
  $pageNum_conna = $_GET['pageNum_conna'];
}
$startRow_conna = $pageNum_conna * $maxRows_conna;

$pesquisar_conna = "-1";
if (isset($_GET['pesquisar'])) {
  $pesquisar_conna = (get_magic_quotes_gpc()) ? $_GET['pesquisar'] : addslashes($_GET['pesquisar']);
}
mysql_select_db($database_provider, $provider);
$query_conna = sprintf("SELECT * FROM tb_na WHERE 
tb_na.id LIKE'%%%s%%' AND distrito = 'farol' AND situacao = 'em andamento' ORDER BY id DESC", $pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna);
$query_limit_conna = sprintf("%s LIMIT %d, %d", $query_conna, $startRow_conna, $maxRows_conna);
$conna = mysql_query($query_limit_conna, $provider) or die(mysql_error());
$row_conna = mysql_fetch_assoc($conna);

if (isset($_GET['totalRows_conna'])) {
  $totalRows_conna = $_GET['totalRows_conna'];
} else {
  $all_conna = mysql_query($query_conna);
  $totalRows_conna = mysql_num_rows($all_conna);
}
$totalPages_conna = ceil($totalRows_conna/$maxRows_conna)-1;

$queryString_conna = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_conna") == false && 
        stristr($param, "totalRows_conna") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_conna = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_conna = sprintf("&totalRows_conna=%d%s", $totalRows_conna, $queryString_conna);

mysql_select_db($database_bd_servicos, $bd_servicos);
$query_agendamento = "SELECT * FROM tb_servico ORDER BY nome_ser ASC";
$agendamento = mysql_query($query_agendamento, $bd_servicos) or die(mysql_error());
$row_agendamento = mysql_fetch_assoc($agendamento);
$totalRows_agendamento = mysql_num_rows($agendamento);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Boletim Operacional ::</title>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #013567;
}
.style2 {font-size: 11px; color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif;}
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
.style1 {        font-size: 12px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style17 {        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style18 {color: #990000}
.style21 {font-size: 17px; color: #013567; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style22 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
}
.style27 {font-size: 12px;
        font-weight: bold;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #FFFFFF;
}
.style28 {font-size: 12px}
.style31 {
        font-size: 12px;
        font-weight: bold;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style35 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style37 {font-size: 12px; color: #013567; }
.style40 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style41 {color: #FFFF00}
.style42 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style43 {color: #013567}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" valign="middle" bgcolor="#003466"><img src="../imagens/fundo.jpg" width="1000" height="107" /></td>
  </tr>
</table>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="870" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="1000" height="137" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="870" height="137" align="left" valign="top"><table width="821" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="454" scope="col"><span class="style17"> <span class="style18"> </span></span></th>
        <th width="403" align="right" valign="top" scope="col"> <span class="style1">
          <!-- script relogio -->
            <script>
var clockid=new Array()
var clockidoutside=new Array()
var i_clock=-1
var thistime= new Date()
var hours=thistime.getHours()
var minutes=thistime.getMinutes()
var seconds=thistime.getSeconds()
if (eval(hours) <10) {hours="0"+hours}
if (eval(minutes) < 10) {minutes="0"+minutes}
if (seconds < 10) {seconds="0"+seconds}
var thistime = hours+":"+minutes+":"+seconds

function writeclock() {
    i_clock++
    if (document.all || document.getElementById || document.layers) {
 clockid[i_clock]="clock"+i_clock
 document.write("<span id='"+clockid[i_clock]+"' style='position:relative'>"+thistime+"</span>")
    }
}

function clockon() {
    thistime= new Date()
    hours=thistime.getHours()
    minutes=thistime.getMinutes()
    seconds=thistime.getSeconds()
    if (eval(hours) <10) {hours="0"+hours}
    if (eval(minutes) < 10) {minutes="0"+minutes}
    if (seconds < 10) {seconds="0"+seconds}
    thistime = hours+":"+minutes+":"+seconds
    
    if (document.all) {
 for (i=0;i<=clockid.length-1;i++) {
     var thisclock=eval(clockid[i])
     thisclock.innerHTML=thistime
 }
    }

    if (document.getElementById) {
 for (i=0;i<=clockid.length-1;i++) {
     document.getElementById(clockid[i]).innerHTML=thistime
 }
    }
    var timer=setTimeout("clockon()",1000)
}
window.onload=clockon
          </script>
          <!-- script relogio -->
            <script>writeclock()

            </script>
          /
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
 echo "$nomediadasemana, $dia de $nomemes de $ano";
?>
        </span></th>
      </tr>
    </table>
      
      <table width="780" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td class="style21"> NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO - UNIDADE - FAROL </td>
        </tr>
      </table>
      <BR />
      <table width="894" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="91" align="center" bgcolor="#013567"><span class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle.php?pesquisar=">INICIO</a><a href="visualizanumerosdena-para-excluir.php?pesquisar=ARAPIRACA"></a></span></td>
          <td width="91" height="20" align="center" bgcolor="#013567"><span class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-farol.php?pesquisar=">FAROL</a><a href="visualizanumerosdena-para-excluir.php?pesquisar=ARAPIRACA"></a></span></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-benedito_bentes.php?pesquisar=">B.BENTES</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-jaragua.php?pesquisar=">JARAGU&Aacute;</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-agreste.php?pesquisar=">AGRESTE</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-serrana.php?pesquisar=">SERRANA</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-sertao.php?pesquisar=">SERT&Atilde;O</a> </td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-b.leiteira.php?pesquisar=">B.LEITEIRA</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-leste.php?pesquisar=">LESTE</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-sanama.php?pesquisar=">SANAMA</a></td>
        </tr>
      </table>
      <table width="539" height="23" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#013567">
        <tr>
          <td width="179" height="21" align="center"><span class="style31"><a href="visualizanumerosdena-para-controle-pendentes.php?pesquisar=">R.A.s ABERTAS </a> </span></td>
          <td width="176" align="center"><span class="style31"><a href="visualizanumerosdena-para-controle-pesquisa.php?pesquisar=CONCLU&Iacute;DA">R.A.s CONCLU&Iacute;DAS</a></span></td>
        </tr>
      </table>
      <br />
      <table width="114" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="114" align="center" valign="middle"><form><input name="button" type="button" class="style37" onClick='parent.location="javascript:location.reload()"' value="ATUALIZAR" />
          </form></td>
        </tr>
      </table><br />
      <br />
      <table width="222" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="56" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, 0, $queryString_conna); ?>">
            <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
              <img src="../imagens/primeira.gif" width="20" height="20" />
              <?php } // Show if recordset not empty ?></a></td>
          <td width="56" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, max(0, $pageNum_conna - 1), $queryString_conna); ?>"> 
            <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
              <img src="../imagens/anterior.gif" width="20" height="20" />
            <?php } // Show if recordset not empty ?> </a></td>
          <td width="55" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, min($totalPages_conna, $pageNum_conna + 1), $queryString_conna); ?>">
            <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
              <img src="../imagens/proxima.gif" width="20" height="20" />
            <?php } // Show if recordset not empty ?> </a></td>
          <td width="55" align="center"><?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
              <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, $totalPages_conna, $queryString_conna); ?>"><img src="../imagens/avanca.gif" width="20" height="20" /></a>
              <?php } // Show if recordset not empty ?></td>
        </tr>
      </table><br />
      <form id="form1" name="form1" method="post" action="">
        <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            
            <table width="794" height="26" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
              <tr>
                
                <td width="40" height="24" align="left" valign="top"><span class="style33">N&ordm; 
                 R.A.</span> </td>
                  
                <td width="97" valign="middle" bgcolor="#013567"><p class="style22"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><strong><?php echo $row_conna['os_nub']; ?></strong></a></p>                </td>
                  
            <td width="30" align="left" valign="top"><span class="style33">R.A:</span></td>
                  
            <td width="359" valign="middle" bgcolor="#013567" class="style22"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><strong><?php echo $row_conna['prioridade']; ?> - <span class="style41"><?php echo $row_conna['distrito']; ?></span> -   <?php echo $row_conna['data']; ?></strong></a></td>
                
            <td width="49" align="left" valign="top" bgcolor="#FFFFFF" class="style33">SITUA&Ccedil;&Atilde;O:</td>
                
            <td width="205" align="left" valign="middle" bgcolor="#013567"><span class="style40"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><?php echo $row_conna['situacao']; ?></a><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')">
                (<?php echo $row_conna['soma']; ?>)</a></span></td>
              </tr>
            </table>
            
            <?php } while ($row_conna = mysql_fetch_assoc($conna)); ?>
          <?php } // Show if recordset not empty ?>
      </form>    </td>
  </tr>
</table>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="870" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="1000" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#013567" class="style2">:: Desenvolvido Robson Vidigal :: </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($conna);
?>
