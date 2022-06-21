<?php require_once('../Connections/provider.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_busca_resultado = 10;
$pageNum_busca_resultado = 0;
if (isset($_GET['pageNum_busca_resultado'])) {
  $pageNum_busca_resultado = $_GET['pageNum_busca_resultado'];
}
$startRow_busca_resultado = $pageNum_busca_resultado * $maxRows_busca_resultado;

$colname_busca_resultado = "-1";
if (isset($_GET['busca'])) {
  $colname_busca_resultado = (get_magic_quotes_gpc()) ? $_GET['busca'] : addslashes($_GET['busca']);
}
mysql_select_db($database_provider, $provider);
$query_busca_resultado = sprintf("SELECT horario, operador, rd, assunto, assunto2, informacao, controlador, supervisor, dia FROM informacao WHERE informacao LIKE '%%%s%%' OR assunto LIKE '%%%s%%' OR horario LIKE '%%%s%%' OR operador LIKE '%%%s%%' OR rd LIKE '%%%s%%' OR controlador LIKE '%%%s%%' OR supervisor LIKE '%%%s%%' OR dia LIKE '%%%s%%' ORDER BY id DESC", $colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado,$colname_busca_resultado);
$query_limit_busca_resultado = sprintf("%s LIMIT %d, %d", $query_busca_resultado, $startRow_busca_resultado, $maxRows_busca_resultado);
$busca_resultado = mysql_query($query_limit_busca_resultado, $provider) or die(mysql_error());
$row_busca_resultado = mysql_fetch_assoc($busca_resultado);

if (isset($_GET['totalRows_busca_resultado'])) {
  $totalRows_busca_resultado = $_GET['totalRows_busca_resultado'];
} else {
  $all_busca_resultado = mysql_query($query_busca_resultado);
  $totalRows_busca_resultado = mysql_num_rows($all_busca_resultado);
}
$totalPages_busca_resultado = ceil($totalRows_busca_resultado/$maxRows_busca_resultado)-1;

mysql_select_db($database_provider, $provider);
$query_plantao = "SELECT * FROM dados_do_plantao ORDER BY id DESC";
$plantao = mysql_query($query_plantao, $provider) or die(mysql_error());
$row_plantao = mysql_fetch_assoc($plantao);
$totalRows_plantao = mysql_num_rows($plantao);

mysql_select_db($database_provider, $provider);
$query_operadores = "SELECT * FROM operador ORDER BY id DESC";
$operadores = mysql_query($query_operadores, $provider) or die(mysql_error());
$row_operadores = mysql_fetch_assoc($operadores);
$totalRows_operadores = mysql_num_rows($operadores);

$queryString_busca_resultado = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_busca_resultado") == false && 
        stristr($param, "totalRows_busca_resultado") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_busca_resultado = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_busca_resultado = sprintf("&totalRows_busca_resultado=%d%s", $totalRows_busca_resultado, $queryString_busca_resultado);
?>

<?php

//Relogio
$meses = array (1 => "janeiro", 2 => "fevereiro", 3 => "mar&ccedil;o", 4 => "abril", 5 => "maio", 6 => "junho", 7 => "julho", 8 => "agosto", 9 => "setembro", 10 => "outubro", 11 => "novembro", 12 => "dezembro");
$diasdasemana = array (1 => "segunda-feira",2 => "ter&ccedil;a-feira",3 => "quarta-feira",4 => "quinta-feira",5 => "sexta-feira",6 => "s&aacute;bado",0 => "domingo");
 $hoje = getdate();
 $dias = $hoje["mday"];
 $mes = $hoje["mon"];
 $nomemes = $meses[$mes];
 $ano = $hoje["year"];
 $diadasemana = $hoje["wday"];
 $nomediadasemana = $diasdasemana[$diadasemana];
 ?>

<?php
$hr = date(" H ");
if($hr >= 12 && $hr<18) {
$resp = "Boa tarde!";}
else if ($hr >= 0 && $hr <12 ){
$resp = "Bom dia!";}
else {
$resp = "Boa noite!";}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boletim &gt;&gt;&gt; </title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	color: #666666;
	font-size: 10px;
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
	font-size: 11px;
	color: #FFFFFF;
}
.style31 {
	color: #FFFFFF;
	font-size: 12px;
}
.style33 {font-family: Arial, Helvetica, sans-serif; color: #666666; font-size: 10px; font-weight: bold; }
.style47 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666666;
}
.style53 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #666666;
}
.style54 {
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666666;
	font-style: italic;
}
.style59 {color: #0099FF; font-weight: bold; }
.style60 {color: #000000}
.style61 {font-size: 13px; font-family: Arial, Helvetica, sans-serif;}
.style63 {font-family: Arial, Helvetica, sans-serif; color: #666666; font-size: 12px; font-weight: bold; }
.style65 {color: #666666; }
-->
</style></head>


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

        <!-- Script COIs --> 
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#esc_cidades').change(function(){
                $('#distritos').load('distritos_al.php?estado='+$('#esc_cidades').val() );
				
            });
        });
		 $(document).ready(function(){
            $('#distritos').change(function(){
           
				$('#municipio').load('municipio.php?estado='+$('#esc_cidades').val() );
            });
        });

    </script>
		<!-- Script COIs Fim --> 


<!--  N.A. Digital  //-->
<script language="JavaScript" type="text/javascript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_0518161926_0) return;
            window.mm_menu_0519223408_0 = new Menu("root",148,17,"Verdana, Arial, Helvetica, sans-serif",11,"#FFFFFF","#FFFFFF","#003366","#003366","left","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_0519223408_0.addMenuItem("VISUALIZAR&nbsp;N.A.","window.open('pastadenadigitalcallcenter/visualizanumerosdena.php', '_self');");
   mm_menu_0519223408_0.fontWeight="bold";
   mm_menu_0519223408_0.hideOnMouseOut=true;
   mm_menu_0519223408_0.bgColor='#FFFFFF';
   mm_menu_0519223408_0.menuBorder=1;
   mm_menu_0519223408_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0519223408_0.menuBorderBgColor='#FFFFFF';

                            window.mm_menu_0420073016_0 = new Menu("root",217,18,"Geneva, Arial, Helvetica, sans-serif",12,"#FFFFFF","#FFFFFF","#003463","#999999","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_0420073016_0.addMenuItem("INFORMAÇÕES&nbsp;DIVERSAS","location='ifdv/index.php'");
   mm_menu_0420073016_0.fontWeight="bold";
   mm_menu_0420073016_0.hideOnMouseOut=true;
   mm_menu_0420073016_0.bgColor='#555555';
   mm_menu_0420073016_0.menuBorder=1;
   mm_menu_0420073016_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0420073016_0.menuBorderBgColor='#FFFFFF';

mm_menu_1120101645_0.writeMenus();
} // mmLoadMenus()

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<!--  N.A. Digital Fim //-->

		<script language="JavaScript" src="mm_menu.js" type="text/javascript"></script>

	<SCRIPT language=JavaScript>
		<!-- begin
				var sHors = "00"; 
				var sMins = "03";
				var sSecs = "00";
								function getSecs(){
										sSecs--;
									if(sSecs<0)
    							{sSecs=59;sMins--;if(sMins<=9)sMins="0"+sMins;}
							if(sMins=="0-1")
   							 {sMins=5;sHors--;if(sHors<=9)sHors="0"+sHors;}
								if(sSecs<=9)sSecs="0"+sSecs;
									if(sHors=="0-1")
										{sHors="00";sMins="00";sSecs="00";
											clock1.innerHTML=sHors+"<font color=#000000>:</font>"+sMins+"<font color=#000000>:</font>"+sSecs;}
  					  else
   				 {
 										  clock1.innerHTML=sHors+"<font color=#000000>:</font>"+sMins+"<font color=#000000>:</font>"+sSecs;
   							setTimeout('getSecs()',1000);
					}
				}
			//-->
		</SCRIPT>

<body>
<script language="JavaScript1.2" type="text/javascript">mmLoadMenus();</script>
<!-- start header -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" align="left" valign="middle" bgcolor="#0099FF">&nbsp;</td>
    <td width="49%" align="left" valign="middle" bgcolor="#0099FF"><img src="../img_news/logo_top.png" width="506" height="86" /></td>
    <td width="49%" align="right" valign="middle" bgcolor="#0099FF"><table width="100%" height="78" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%" height="24" align="right" valign="middle">&nbsp;</td>
        </tr>
      <tr>
        <td align="right" valign="middle"><form id="form1" method="get" action="busca_resultado.php">
          <span class="style1">Pesquisar</span>
          <input name="busca" type="text" id="busca"  size="20"/>
          <input type="submit" name="Submit" value="OK" />
                        </form></td>
        </tr>
      <tr>
        <td align="right" valign="middle"><span class="style31"><a href="../index.php" style="color: #FFFFFF">Início</a> | <a href="#" onClick="MM_openBrWindow('/pastadenadigitalcallcenter/na-consulta.php','N.A. Digital','scrollbars=yes,width=730,height=480,top=130,left=320')" style="color: #FFFFFF">N.A. Digital</a> |</span> <span class="style31"><a href="#" onClick="MM_openBrWindow('/pastadenadigitalcallcenter/visualizanumerosdena.php?pesquisar=em+andamento&amp;Submit=PESQUISAR','N.A. Digital','scrollbars=yes,width=730,height=480,top=130,left=320')" style="color: #FFFFFF">Consultar N.A. Digital</a> |</span> <span class="style31"><a href="#" onClick="MM_openBrWindow('../ede/index.php','InfDiv','scrollbars=yes,width=797,height=600')" style="color: #FFFFFF">Informativos Diversos </a>|</span> <span class="style31"><a href="../areaadministrativa_da_informcao/ocorrencia_inserir.php" target="_blank" style="color: #FFFFFF">Controle</a></span></td>
        </tr>
    </table></td>
    <td width="1%" align="right" valign="middle" bgcolor="#0099FF">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="49%" align="left" valign="middle" class="style2"></td>
    <td width="49%" align="right" valign="middle"><span class="style2">
	
		<?php
			echo "$resp";
		?>
	
	<!-- script relogio -->
        <script>writeclock()

                </script>      
        <!-- Fim do script -->
	/ <?php
//Relogio
 echo "$nomediadasemana, $dias de $nomemes de $ano";
?>
    </span></td>
    <td width="1%" align="right" valign="middle" class="style2">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td width="98%" align="center" valign="middle" bgcolor="#E6E6E6" class="style65">:: Resultado(s) da Pesquisa:: </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E6E6E6">
      <tr>
        <td width="18%" align="center" valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="middle" bgcolor="#E6E6E6"><span class="style63">:: Informativos Diversos :: </span></td>
          </tr>
          <tr>
            <td align="center" valign="top"><iframe src="/ede/index2.php" name="fonline" width="100%" marginwidth="0" height="525" marginheight="0" scrolling="Auto" frameborder="0" id="fonline"></iframe></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="66%" align="center" valign="top"> 
		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="19" align="center" valign="middle"><span class="style59"><a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, 0, $queryString_busca_resultado); ?>" style="color: #0099FF">&lt;&lt; Primeira</a> <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, max(0, $pageNum_busca_resultado - 1), $queryString_busca_resultado); ?>" style="color: #0099FF"> | &lt; Anterior </a> | <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, min($totalPages_busca_resultado, $pageNum_busca_resultado + 1), $queryString_busca_resultado); ?>" style="color: #0099FF">Pr&oacute;xima &gt; | </a> <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, $totalPages_busca_resultado, $queryString_busca_resultado); ?>" style="color: #0099FF">&Uacute;ltima &gt;&gt; </a></span> </td>
  </tr>
</table>
        <?php do { ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="108" align="center" valign="middle" bgcolor="#E6E6E6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="#E6E6E6">&nbsp;</td>
                    </tr>
                            </table>
                    <table width="98%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="center" valign="middle"><div class="entry">
                            <table width="100%" border="0" cellpadding="0" cellspacing="4" bgcolor="#FFFFFF">
                              <tr>
                                <td align="left" valign="middle"><span class="style53"><strong><?php echo $row_busca_resultado['horario']; ?></strong> - <?php echo $row_busca_resultado['operador']; ?> (<strong><?php echo $row_busca_resultado['rd']; ?></strong>) - <span class="style59"><?php echo strip_tags($row_busca_resultado['assunto'], "<b><i><br>"); ?></span></span></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
                              <tr>
                                <td align="left" valign="middle" class="style6 style60"><span class="style42  style61"><?php echo strip_tags ( nl2br($row_busca_resultado['informacao']), "<strong><em><span><img><li><p><ol><ul><a>"); ?></span></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="4" bgcolor="#FFFFFF">
                              <tr>
                                <td align="left" valign="middle" class="style4 style5 style54"><span class="style36"><?php echo $row_busca_resultado['dia']; ?></span>,  INSERIDO POR: <span class="style36"><?php echo $row_busca_resultado['controlador']; ?></span></td>
                              </tr>
                            </table>
                        </div></td>
                      </tr>
                    </table>
                    <table width="520" border="0" cellpadding="0" cellspacing="0">
                  </table></td>
                </tr>
              </table>
          <?php } while ($row_busca_resultado = mysql_fetch_assoc($busca_resultado)); ?><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="19" align="center" valign="middle"><span class="style59"><a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, 0, $queryString_busca_resultado); ?>" style="color: #0099FF">&lt;&lt; Primeira</a> | <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, max(0, $pageNum_busca_resultado - 1), $queryString_busca_resultado); ?>" style="color: #0099FF">&lt; Anterior </a> <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, min($totalPages_busca_resultado, $pageNum_busca_resultado + 1), $queryString_busca_resultado); ?>" style="color: #0099FF"> | Pr&oacute;xima &gt; |  </a> <a href="<?php printf("%s?pageNum_busca_resultado=%d%s", $currentPage, $totalPages_busca_resultado, $queryString_busca_resultado); ?>" style="color: #0099FF">&Uacute;ltima &gt;&gt; </a></span> </td>
  </tr>
</table></td>
        <td width="16%" align="center" valign="top"><table width="95%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td align="center" valign="middle" class="style33">&nbsp;</td>
          </tr>
          
          
          <tr>
            <td align="center" valign="middle" bgcolor="#E6E6E6"><span class="style63">:: Calend&aacute;rio ::</span></td>
          </tr>
          <tr>
            <td align="center" valign="middle"><?php
/**
 * Script que cria o calend&aacute;rio do m&ecirc;s.
 * contato: rodrigo.amora@globo.com
 *
 * @author Rodrigo Amora
 * @created 07/02/2009
 * @version 1.0, 07/02/2009
 */
 
$ano = date("Y");
$cont = 0;
$dia = date("d");
$dias = array();
$mes = date("m");
$totalDias = date("t");
$primeiroDia = date("D", mktime(0, 0, 0, $mes, 1, $ano));
 
for($d = 0; $d < $totalDias; $d++)$dias[$d] = array_push($dias, $d+1);
 
switch($primeiroDia){
	case "Sun":
		$pos = 0;
	break;
 
	case "Mon":
		$pos = 1;
	break;
 
	case "Tue":
		$pos = 2;
	break;
 
	case "Wed":
		$pos = 3;
	break;
 
	case "Thu":
		$pos = 4;
	break;
 
	case "Fri":
		$pos = 5;
	break;
 
	case "Sat":
		$pos = 6;
	break;
}//Fim do switch
 
switch($mes){
	case 1:
		$mes2 = "Janeiro";
	break;
 
	case 2:
		$mes2 = "Fevereiro";
	break;
 
	case 3:
		$mes2 = "Mar&ccedil;o";
	break;
 
	case 4:
		$mes2 = "Abril";
	break;
 
	case 5:
		$mes2 = "Maio";
	break;
 
	case 6:
		$mes2 = "Junho";
	break;
 
	case 7:
		$mes2 = "Julho";
	break;
 
	case 8:
		$mes2 = "Agosto";
	break;
 
	case 9:
		$mes2 = "Setembro";
	break;
 
	case 10:
		$mes2 = "Outubro";
	break;
 
	case 11:
		$mes2 = "Novembro";
	break;
 
	case 12:
		$mes2 = "Dezembro";
	break;
}//Fim do switch
 
echo "<table align='center' border=0 cellspacing=1 cellpadding=1>";
echo "<tr><td bgColor='#3186FA' colspan=7><center><b><font color='White' face='Arial, Helvetica, sans-serif' size='2'>$mes2/$ano</font></b></center></td></tr>";
echo "<tr><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Dom</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Seg</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Ter</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Qua</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Qui</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>Sex</font></td><td><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>S&aacute;b</font></td></tr>";
 
for($linha = 0; $linha < 6; $linha++){
	echo "</tr>";
	for($coluna = 0; $coluna < 7; $coluna++){
		$pos2 = $cont - $pos;
 
		if(empty($dias[$pos2]))echo "<td><span class='style34'><center> - </span></center></td>";
		else{
			if($dias[$pos2] == $dia)print_r ("<td bgColor='#3186FA'><b><center><font color='White'><span class='style34'>".$dias[$pos2]."</span></font></center></b></td>");
			else print_r ("<td><center><font color='#666666' face='Arial, Helvetica, sans-serif' size='2'>".$dias[$pos2]."</font></center></td>");
		}//Fim do else
 
		$cont++;
	}//Fim do for
	echo "</tr>";
}//Fim do for
 
echo "</table>";
?></td>
          </tr>
          
          <tr>
            <td align="center" valign="middle"><a href="../ede/Aneel/" target="_blank"></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="1%">&nbsp;</td>
    <td align="center" valign="middle" class="style2">Elaborado por Robson Vidigal</td>
    <td width="1%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($busca_resultado);
?>
