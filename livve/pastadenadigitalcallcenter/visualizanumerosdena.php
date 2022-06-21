<?php require_once('../Connections/provider.php'); ?><?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_conna = 20;
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
<meta http-equiv="refresh" content="60"/>
<title>:: Boletim Operacional ::</title>
<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 5px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #FFFFFF;
}
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
.style17 {        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #003466;
}
.style18 {color: #990000}
.style21 {font-size: 17px; color: #013567; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style43 {color: #8C0209}
.style46 {font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style28 {font-size: 12px}
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

<td width="870" align="left" valign="top"><table width="720" height="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="top"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="style46">
      <tr>
        <th width="245" scope="col"><span class="style17"> <span class="style18"> </span></span></th>
        <th width="455" align="right" valign="top" scope="col"> <span class="style46">
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
      <table width="700" height="55" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
        <tr>
          <td width="123">&nbsp;</td>
          <td width="410" align="center" valign="middle"><div align="center" class="style48">NOTIFICA&Ccedil;&Atilde;O 
            DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
          <td width="159" align="center" valign="middle"><div align="center" class="style48">Call 
            Center </div></td>
        </tr>
      </table>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="style46">
        <tr>
          <td height="23">NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO / CONSULTA (<?php echo $totalRows_conna ?>) </td>
        </tr>
      </table>
      <table width="700" height="28" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><table width="390" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td class="style46"><form id="form2" name="form2" method="get" action="visualizanumerosdena.php" >
                  <table width="363" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="120"><div align="center"><span class="style46">PESQUISAR R.A.</span> </div></td>
                      <td width="154" align="center"><input name="pesquisar" type="text" id="pesquisar" class="style46" /></td>
                      <td width="89" align="left"><label>
                        <input name="Submit" type="submit" class="style46" value="PESQUISAR" />
                      </label></td>
                    </tr>
                  </table>
              </form></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="baseline"><table border="0" width="50%" align="center">
              <tr>
                <td width="23%" align="center"><?php if ($pageNum_conna > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, 0, $queryString_conna); ?>"><img src="First.gif" border=0></a>
                      <?php } // Show if not first page ?>
                </td>
                <td width="31%" align="center"><?php if ($pageNum_conna > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, max(0, $pageNum_conna - 1), $queryString_conna); ?>"><img src="Previous.gif" border=0></a>
                      <?php } // Show if not first page ?>
                </td>
                <td width="23%" align="center"><?php if ($pageNum_conna < $totalPages_conna) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, min($totalPages_conna, $pageNum_conna + 1), $queryString_conna); ?>"><img src="Next.gif" border=0></a>
                      <?php } // Show if not last page ?>
                </td>
                <td width="23%" align="center"><?php if ($pageNum_conna < $totalPages_conna) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_conna=%d%s", $currentPage, $totalPages_conna, $queryString_conna); ?>"><img src="Last.gif" border=0></a>
                      <?php } // Show if not last page ?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><form id="form1" name="form1" method="post" action="">
             <table width="700" height="38" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="style46">
              <tr>
                <td height="14" valign="bottom" bgcolor="#CCCCCC"><strong>O.S.</strong></td>
                <td valign="bottom" bgcolor="#CCCCCC"><strong>Cidade</strong></td>
                <td valign="bottom" bgcolor="#CCCCCC"><strong>Servi&ccedil;o</strong></td>
                <td valign="bottom" bgcolor="#CCCCCC"><strong>Situa&ccedil;&atilde;o</strong></td>
              </tr>
                          <?php do { ?>
              <tr>
                <td valign="bottom"><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><?php echo $row_conna['os_nub']; ?></a></td>
                <td valign="bottom"><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><span class="style43"><?php echo $row_conna['municipio']; ?></span></a></td>
                <td valign="bottom"><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"><?php echo $row_conna['prioridade']; ?> </a><a href="#" onclick="MM_openBrWindow('naparaconsulta.php?id=<?php echo $row_conna['id']; ?>','','scrollbars=yes,width=860,height=480,top=130,left=320')"> <?php echo $row_conna['soma']; ?></a></td>
                <td valign="bottom"><?php echo $row_conna['situacao']; ?></td>
              </tr>
                          <?php } while ($row_conna = mysql_fetch_assoc($conna)); ?>
            </table>
              <table width="700" height="24" border="0" cellpadding="0" cellspacing="0" class="style46">
               <tr>
                 <td align="center" valign="bottom">&nbsp;
Registro(s) de <?php echo ($startRow_conna + 1) ?> &agrave; <?php echo min($startRow_conna + $maxRows_conna, $totalRows_conna) ?></td>
               </tr>
             </table>
          </form>
                        </td>
        </tr>
      </table>
      </td>
  </tr>
</table>
  <p>&nbsp;</p>
</td>
</body>
</html>
<?php
mysql_free_result($conna);
?>
