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
        
  $logoutGoTo = "../areaadministrativa_da_informcao/ocorrencia_inserir.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
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
<?php
//determina um tempo para a variável $tempo
   $tempo = time();

   //deleta a linha que não foi atualizada no tempo de 1800 segundos
   mysql_query("DELETE FROM tb_na WHERE tempo <'$tempo'".-"1800");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="refresh" content="3"/>
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
        color: #8C0209;
        text-decoration: none;
}
a:visited {
        color: #8C0209;
        text-decoration: none;
}
a:hover {
        color: #8C0209;
        text-decoration: underline;
}
a:active {
        color: #8C0209;
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
.style46 {font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
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
<table width="701" height="146" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" align="center" valign="top"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="baseline"><table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_conna > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, 0, $queryString_conna); ?>"><img src="First.gif" border="0" /></a>
                  <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_conna > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, max(0, $pageNum_conna - 1), $queryString_conna); ?>"><img src="Previous.gif" border="0" /></a>
                  <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_conna < $totalPages_conna) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, min($totalPages_conna, $pageNum_conna + 1), $queryString_conna); ?>"><img src="Next.gif" border="0" /></a>
                  <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_conna < $totalPages_conna) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, $totalPages_conna, $queryString_conna); ?>"><img src="Last.gif" border="0" /></a>
                  <?php } // Show if not last page ?>
              </td>
            </tr>
        </table></td>
      </tr>
    </table>
      <table width="700" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="style46">
        <tr>
          <td bgcolor="#CCCCCC"><strong>O.S.</strong></td>
          <td bgcolor="#CCCCCC"><strong>Cidade</strong></td>
          <td bgcolor="#CCCCCC"><strong>Servi&ccedil;o</strong></td>
          <td bgcolor="#CCCCCC"><strong>Situa&ccedil;&atilde;o</strong></td>
        </tr>
        <?php do { ?>
        <tr>
          <td><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"><?php echo $row_conna['os_nub']; ?></a></td>
          <td><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"><span class="style43"><?php echo $row_conna['municipio']; ?></span></a></td>
          <td><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"><?php echo $row_conna['prioridade']; ?> </a><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=770,height=600')"> <?php echo $row_conna['soma']; ?></a></td>
          <td><?php echo $row_conna['situacao']; ?></td>
        </tr>
        <?php } while ($row_conna = mysql_fetch_assoc($conna)); ?>
      </table>
      <table width="700" height="24" border="0" cellpadding="0" cellspacing="0" class="style46">
        <tr>
          <td align="center" valign="bottom">&nbsp;
            Registros de <?php echo ($startRow_conna + 1) ?> &agrave; <?php echo min($startRow_conna + $maxRows_conna, $totalRows_conna) ?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>

</html>
<?php
mysql_free_result($conna);
?>
