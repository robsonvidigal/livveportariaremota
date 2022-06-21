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
<meta http-equiv="Refresh" content="180"/>
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
}
a:visited {
	text-decoration: none;
	color: #FFFFFF;
}
a:hover {
	text-decoration: none;
	color: #FFFFFF;
}
a:active {
	text-decoration: none;
	color: #FFFFFF;
}
a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FFFFFF;
}
.style31 {color: #FFFFFF}
.style33 {font-family: Arial, Helvetica, sans-serif; color: #666666; font-size: 10px; font-weight: bold; }
.style34 {font-family: Arial, Helvetica, sans-serif; color: #FFFFFF; font-size: 12px; font-weight: bold; }
.style47 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666666;
}
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
    <td width="49%" align="left" valign="middle" bgcolor="#0099FF"><img src="../img_news/logo_top.png" width="706" height="86" /></td>
    <td width="49%" align="right" valign="middle" bgcolor="#0099FF"><table width="100%" height="78" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%" height="24" align="right" valign="middle">&nbsp;</td>
        </tr>
      <tr>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" valign="middle"><a href="index.php" style="color: #FFFFFF">Iníci<span class="style31">o</span></a><span class="style31"> |  </span><a href="#" onClick="MM_openBrWindow('/pastadenadigitalcallcenter/na-consulta.php','N.A. Digital','scrollbars=yes,width=730,height=480,top=130,left=320')">N.A. Digital</a> <span class="style31">|</span> <a href="#" onClick="MM_openBrWindow('/pastadenadigitalcallcenter/visualizanumerosdena.php?pesquisar=em+andamento&amp;Submit=PESQUISAR','N.A. Digital','scrollbars=yes,width=730,height=480,top=130,left=320')">Consultar N.A. Digital</a> <span class="style31">|</span> <a href="#" onClick="MM_openBrWindow('../ede/index.php','InfDiv','scrollbars=yes,width=797,height=600')">Informativos Diversos </a><span class="style31">|</span> <a href="../areaadministrativa_da_informcao/ocorrencia_inserir.php" target="_blank">Controle</a></td>
        </tr>
    </table></td>
    <td width="1%" align="right" valign="middle" bgcolor="#0099FF">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="49%" align="left" valign="middle" class="style2">P&aacute;gina ser&aacute; atualizada em  <span id="clock1"></span>
        <script>setTimeout('getSecs()',1000);</script></td>
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
    <td width="98%" align="center" valign="middle" bgcolor="#CCCCCC" class="style31">:: Informa&ccedil;&otilde;es  :: </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td width="15%" align="center" valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><span class="style34">:: Informativos Diversos :: </span></td>
          </tr>
          <tr>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="70%" align="left" valign="middle">&nbsp;</td>
        <td width="14%" align="center" valign="top">&nbsp;</td>
      </tr>
    </table></td>
    <td></td>
  </tr>
  
  <tr>
    <td width="1%">&nbsp;</td>
    <td align="center" valign="middle" class="style2">Elaborado por Robson Vidigal</td>
    <td width="1%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
