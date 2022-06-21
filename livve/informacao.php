<?php require_once('Connections/provider.php'); ?>
<?php require_once('Connections/provider.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_informacao = 20;
$pageNum_informacao = 0;
if (isset($_GET['pageNum_informacao'])) {
  $pageNum_informacao = $_GET['pageNum_informacao'];
}
$startRow_informacao = $pageNum_informacao * $maxRows_informacao;

mysql_select_db($database_provider, $provider);
$query_informacao = "SELECT * FROM informacao ORDER BY id DESC";
$query_limit_informacao = sprintf("%s LIMIT %d, %d", $query_informacao, $startRow_informacao, $maxRows_informacao);
$informacao = mysql_query($query_limit_informacao, $provider) or die(mysql_error());
$row_informacao = mysql_fetch_assoc($informacao);

if (isset($_GET['totalRows_informacao'])) {
  $totalRows_informacao = $_GET['totalRows_informacao'];
} else {
  $all_informacao = mysql_query($query_informacao);
  $totalRows_informacao = mysql_num_rows($all_informacao);
}
$totalPages_informacao = ceil($totalRows_informacao/$maxRows_informacao)-1;

$queryString_informacao = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_informacao") == false &&
        stristr($param, "totalRows_informacao") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_informacao = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_informacao = sprintf("&totalRows_informacao=%d%s", $totalRows_informacao, $queryString_informacao);

$queryString_ocorrencias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ocorrencias") == false &&
        stristr($param, "totalRows_ocorrencias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ocorrencias = "&" . htmlentities(implode("&", $newParams));
  }
}
?>

<?php

//Relogio
$meses = array (1 => "JANEIRO", 2 => "FEVEREIRO", 3 => "MAR&Ccedil;O", 4 => "ABRIL", 5 => "MAIO", 6 => "JUNHO", 7 => "JULHO", 8 => "AGOSTO", 9 => "SETEMBRO", 10 => "OUTUBRO", 11 => "NOVEMBRO", 12 => "DEZEMBRO");
$diasdasemana = array (1 => "SEGUNDA-FEIRA",2 => "TER&Ccedil;A-FEIRA",3 => "QUARTA-FEIRA",4 => "QUINTA-FEIRA",5 => "SEXTA-FEIRA",6 => "S&Aacute;BADO",0 => "DOMINGO");
 $hoje = getdate();
 $dias = $hoje["mday"];
 $mes = $hoje["mon"];
 $nomemes = $meses[$mes];
 $ano = $hoje["year"];
 $diadasemana = $hoje["wday"];
 $nomediadasemana = $diasdasemana[$diadasemana];
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boletim &gt;&gt;&gt;</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	text-decoration: none;
	color: #0099FF;
}
a:visited {
	text-decoration: none;
	color: #0099FF;
}
a:hover {
	text-decoration: none;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #0099FF;
}
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
}
.style3 {color: #666666}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #666666; }
.style7 {font-weight: bold; color: #0099FF;}
.style8 {color: #000000}
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style12 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; }
.style14 {color: #666666; font-weight: bold; }
-->
</style>

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
    if (document.all||document.getElementById ||document.layers) {
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
<!-- Fim script relogio --> 

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="19" align="center" valign="middle"><?php if ($pageNum_informacao > 0) { // Show if not first page ?>
      
          <a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, 0, $queryString_informacao); ?>">&lt;&lt; Primeira</a><strong>
          <?php } // Show if not first page ?> 
     
    <?php if ($pageNum_informacao > 0) { // Show if not first page ?>
      </MM:DECORATION></MM_HIDDENREGION>
      </strong>
      <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=2><a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, max(0, $pageNum_informacao - 1), $queryString_informacao); ?>">&lt; Anterior</a></MM:DECORATION></MM_HIDDENREGION>
      <strong>
    <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=2>
      <?php } // Show if not first page ?> 
	
	
  

    
	
	
	<?php if ($pageNum_informacao < $totalPages_informacao) { // Show if not last page ?>
	  </MM:DECORATION></MM_HIDDENREGION>
      </strong>
      <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=3><a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, min($totalPages_informacao, $pageNum_informacao + 1), $queryString_informacao); ?>"> Pr&oacute;xima &gt;</a></MM:DECORATION></MM_HIDDENREGION>
      <strong>
	<MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=3>
	  
	  <?php } // Show if not last page ?> 
    <?php if ($pageNum_informacao < $totalPages_informacao) { // Show if not last page ?>
    </MM:DECORATION></MM_HIDDENREGION>
      </strong>
      <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=4><a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, $totalPages_informacao, $queryString_informacao); ?>">&Uacute;ltima &gt;&gt;</a></MM:DECORATION></MM_HIDDENREGION>
      <strong>
    <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=4>
      <?php } // Show if not last page ?>
      </strong></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="108" align="center" valign="middle" bgcolor="#E6E6E6">
	<br />
	<?php do { ?>
      <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td align="left" valign="middle" class="style3"><strong>Assunto/Informativo</strong>: <strong><span class="style7"> <?php echo strip_tags($row_informacao['assunto'], "<href><i>"); ?></span></strong><br />
                <span class="style3"><strong>Remetente</strong>: <?php echo $row_informacao['operador']; ?></span><br />
                <strong>Setor</strong>: (<?php echo $row_informacao['rd']; ?>)</td>
            </tr>
            <tr>
              <td width="41%" align="left" valign="middle" class="style9"><span class="style3"><?php echo $row_informacao['horario']; ?> </span><strong>| </strong><span class="style3"><?php echo $row_informacao['dia']; ?></span></td>
            </tr>
          </table>
            <table width="98%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="style4 style8"><?php echo strip_tags ( nl2br($row_informacao['informacao']), "<strong><em><span><img><li><p><ol><ul><a>"); ?></td>
              </tr>
            </table>
            <table width="98%" border="0" cellspacing="4" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="style12"> <span class="style14">Publicado por:</span> <em><?php echo $row_informacao['controlador']; ?></em></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="520" border="0" cellpadding="0" cellspacing="0">
      </table>
      <br />
    <?php } while ($row_informacao = mysql_fetch_assoc($informacao)); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="19" align="center" valign="middle"><?php if ($pageNum_informacao > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, 0, $queryString_informacao); ?>">&lt;&lt; Primeira</a><strong>
          <?php } // Show if not first page ?>
        <?php if ($pageNum_informacao > 0) { // Show if not first page ?>
        </MM:DECORATION></MM_HIDDENREGION>
      </strong>
      <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=7><a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, max(0, $pageNum_informacao - 1), $queryString_informacao); ?>">&lt; Anterior</a></MM:DECORATION></MM_HIDDENREGION>
      <strong>
        <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=7>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_informacao < $totalPages_informacao) { // Show if not last page ?>
        </MM:DECORATION></MM_HIDDENREGION>
      </strong>
      <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=8><a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, min($totalPages_informacao, $pageNum_informacao + 1), $queryString_informacao); ?>"> Pr&oacute;xima &gt;</a></MM:DECORATION></MM_HIDDENREGION>
      <strong>
        <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=8>
        <?php } // Show if not last page ?>
      </strong>
      <?php if ($pageNum_informacao < $totalPages_informacao) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_informacao=%d%s", $currentPage, $totalPages_informacao, $queryString_informacao); ?>">&Uacute;ltima &gt;&gt;</a>
        <?php } // Show if not last page ?>      </td>
  </tr>
</table>
</body>
</html>
