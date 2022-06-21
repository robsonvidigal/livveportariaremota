<?php require_once('../Connections/provider.php'); ?><?php
$currentPage = $_SERVER["PHP_SELF"];

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
$query_conna = sprintf("SELECT * FROM tb_na WHERE tb_na.os_nub LIKE'%%%%%s%%%%' OR  tb_na.data LIKE'%%%%%s%%%%' OR  tb_na.uc LIKE'%%%%%s%%%%' OR  tb_na.cod_cliente LIKE'%%%%%s%%%%' OR  tb_na.rg LIKE'%%%%%s%%%%' OR  tb_na.cpf LIKE'%%%%%s%%%%' OR  tb_na.medidor LIKE'%%%%%s%%%%' OR tb_na.municipio LIKE'%%%%%s%%%%' OR tb_na.prioridade LIKE'%%%%%s%%%%' OR tb_na.situacao LIKE'%%%%%s%%%%' ORDER BY id DESC", $pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna,$pesquisar_conna);
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
<meta http-equiv="refresh" content="180"/>
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
.style1 {        font-size: 12px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style17 {        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style18 {color: #990000}
.style19 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 14px;
}
.style21 {font-size: 17px; color: #013567; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style28 {font-size: 12px}
.style35 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style36 {
        color: #FFFFFF;
        font-size: 10px;
}
.style40 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style42 {color: #FFFF00}
.style43 {color: #8C0209}
.style44 {font-size: 12px; color: #8C0209; }
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>

<td width="870" align="center" valign="top"><?php do { ?>
  <table width="563" height="18" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
      <td width="51" height="20" align="left" valign="top"><span class="style35">N&ordm; 
        DA O.S.:</span></td>
      <td width="96" valign="middle" bgcolor="#8C0209"><span class="style40"><a href="#" onclick="MM_openBrWindow('../pastadenadigitalcallcenter/naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"><?php echo $row_conna['os_nub']; ?></a></span></td>
      <td width="62" align="left" valign="top"><span class="style35">TIPO SERVI&Ccedil;O: </span></td>
      <td width="344" valign="middle" bgcolor="#8C0209"><span class="style40"><a href="#" onclick="MM_openBrWindow('../pastadenadigitalcallcenter/naparaconsulta-controle-situacao.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"><?php echo $row_conna['prioridade']; ?> ( <?php echo $row_conna['soma']; ?> )
        
        - <span class="style42"><?php echo $row_conna['municipio']; ?></span></a></span></td>
      </tr>
  </table>
  <?php } while ($row_conna = mysql_fetch_assoc($conna)); ?></td>
</body>
</html>
<?php
mysql_free_result($conna);
?>
