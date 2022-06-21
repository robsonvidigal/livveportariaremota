<?php require_once('../Connections/provider.php'); ?>
<?php

$currentPage =  $_SERVER['PHP_SELF'];

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
$MM_authorizedUsers = "r";
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

$MM_restrictGoTo = "../areaadministrativa_da_informcao/semacesso.html";
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
$maxRows_conna = 30;
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
$query_conna = sprintf("SELECT * FROM tb_na WHERE tb_na.os_nub LIKE'%%%s%%' OR  tb_na.data LIKE'%%%s%%' OR  tb_na.uc LIKE'%%%s%%' OR  tb_na.cod_cliente LIKE'%%%s%%' OR  tb_na.rg LIKE'%%%s%%' OR  tb_na.cpf LIKE'%%%s%%' OR  tb_na.medidor LIKE'%%%s%%' OR tb_na.municipio LIKE'%%%s%%' OR tb_na.prioridade LIKE'%%%s%%' OR tb_na.situacao LIKE'%%%%%s%%%%' OR tb_na.distrito LIKE'%%%%%s%%%%' ORDER BY situacao DESC", $pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna);
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
.style1 {	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003466;
}
.style17 {	font-size: 10px;
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
.style29 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
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
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" valign="middle" bgcolor="#003466"><img src="../imagens/fundo.jpg" width="1000" height="107" /></td>
  </tr>
</table>
<table width="1000" height="137" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="130" height="137" align="center" valign="top" bgcolor="#013567"><table width="127" height="313" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="21">&nbsp;</td>
      </tr>
      <tr>
        <td height="273" align="center" valign="middle"><span class="style27"><a href="../index.php">IN&Iacute;CIO</a><br />
              <br />
              <a href="../areaadministrativa_da_informcao/ocorrencia_inserir.php">CONTROLE</a><br />
              <br />
              <span class="style28"><a href="visualizanumerosdena-para-excluir.php">SUPERVIS&Atilde;O</a></span></span><span class="style28"><br />
              <br />
              </span><span class="style31"><a href="<?php echo $logoutAction ?>">SAIR</a></span><font size="2" face="Verdana, Arial, Helvetica, sans-serif" class="style28"><br />
              <br />
            </font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870" align="left" valign="top"><table width="821" border="0" align="center" cellpadding="0" cellspacing="0">
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
          <td class="style21"> NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO / CONSULTA <?php echo $row_conna['situacao']; ?></td>
        </tr>
      </table>
      <BR /><table width="717" height="23" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#013567">
        <tr>
          <td width="179" height="21" align="center"><span class="style31"><a href="visualizanumerosdena-para-excluir.php?pesquisar=EM+ANDAMENTO">EM ANDAMENTO</a> </span></td>
          <td width="176" align="center" class="style31"><a href="/pastadenadigitalcallcenter/visualizanumerosdena-para-controle-pesquisa.php?pesquisar=FAROL&amp;Submit2=PESQUISAR">FAROL </a></td>
          <td width="176" align="center"><a href="visualizanumerosdena-para-excluir.php?pesquisar=SUPERVIS%C3O" class="style31">&Aacute;GUA 02 </a></td>
          <td width="176" align="center"><span class="style31"><a href="visualizanumerosdena-para-excluir.php?pesquisar=CONCLU%CDDA">&Aacute;GUA 03 </a></span></td>
        </tr>
      </table>
      <table width="830" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="91" height="20" align="center" bgcolor="#013567"><span class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=ARAPIRACA">ARAPIRACA</a></span></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=PENEDO">PENEDO</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=PALMEIRA">PALMEIRA</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=SANTANA">SANTANA</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=DELMIRO">DELMIRO</a></td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=S%C3O+MIGUEL">S&Atilde;O MIGUEL</a> </td>
          <td width="89" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=RIO+LARGO">RIO LARGO </a></td>
          <td width="60" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=UNI%C3O">UNI&Atilde;O</a></td>
          <td width="65" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=MATRIZ">MATRIZ</a></td>
          <td width="80" align="center" bgcolor="#013567" class="style42"><a href="visualizanumerosdena-para-excluir.php?pesquisar=MACEI%D3">MACEI&Oacute;</a></td>
        </tr>
      </table>
      <BR />
      <form id="form2" name="form2" method="get" action="visualizanumerosdena-para-excluir.php" >
        <table width="340" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="118"><div align="center"><span class="style37"><span class="style35">PESQUISAR R.A. </span>.</span> </div></td>
            <td width="133" align="center"><input name="pesquisar" type="text" id="pesquisar" class="style28" /></td>
                  <td width="89" align="left"><label>
                    <input name="Submit" type="submit" class="style28" value="PESQUISAR" />
            </label></td>
          </tr>
        </table>
      </form>
      <table width="221" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="56" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, max(0, $pageNum_conna - 1), $queryString_conna); ?>"></a></td>
          <td width="55" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, max(0, $pageNum_conna - 1), $queryString_conna); ?>">
            <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
            <img src="../imagens/anterior.gif" width="20" height="20" border="0" />
            <?php } // Show if recordset not empty ?>
          </a></td>
          <td width="55" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, min($totalPages_conna, $pageNum_conna + 1), $queryString_conna); ?>">
            <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
            <img src="../imagens/proxima.gif" width="20" height="20" />
            <?php } // Show if recordset not empty ?>
          </a></td>
          <td width="55" align="center"><a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, min($totalPages_conna, $pageNum_conna + 1), $queryString_conna); ?>"></a></td>
        </tr>
      </table>
      <form id="form1" name="form1" method="post" action="">
        <?php if ($totalRows_conna > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            
            <table width="847" height="28" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
              
              <tr>
                
                <td width="40" height="26" align="left" valign="top"><span class="style33">N&ordm; 
                 R.A.:</span> </td>
                  
                <td width="96" valign="middle" bgcolor="#013567"><p class="style22"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=740,height=400')"><strong><?php echo $row_conna['os_nub']; ?></strong></a></p>                </td>
                  
            <td width="64" align="left" valign="top"><span class="style33">TIPO SERVI&Ccedil;O:</span></td>
                  
            <td width="322" valign="middle" bgcolor="#013567" class="style22"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=740,height=400')"><strong><?php echo $row_conna['prioridade']; ?> - <span class="style41"><?php echo $row_conna['municipio']; ?></span> -   <?php echo $row_conna['data']; ?></strong></a></td>
                
            <td width="49" align="left" valign="top" bgcolor="#FFFFFF" class="style33">SITUA&Ccedil;&Atilde;O:</td>
                
            <td width="158" align="center" valign="middle" bgcolor="#013567"><span class="style40"><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=740,height=345')"><?php echo $row_conna['situacao']; ?></a><a href="#" onClick="MM_openBrWindow('naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=710,height=410')"> 
                (<?php echo $row_conna['soma']; ?>)</a></span></td>
                <td width="102" align="center" valign="middle" bgcolor="#990000"><span class="style40"><a href="naparaconsulta-excluindo-notadigital.php?id=<?php echo $row_conna['id']; ?>">
                  <label></label>
                EXCLUIR</a></span></td>
              </tr>
            </table>
            
            <?php } while ($row_conna = mysql_fetch_assoc($conna)); ?>
          <?php } // Show if recordset not empty ?>
	  </form>
    </td>
  </tr>
</table>
<table width="1000" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#013567" class="style2">:: Desenvolvido Robson Vidigal :: </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($conna);
?>