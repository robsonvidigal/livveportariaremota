<?php 
/*

Versão 0.1 - última atualização - 21/09/2016

Bugs:
21/09/2016 - Bug: Correção no envio para banco de dados do distrito.
             Bug: Correção para obrigação do preenchimentos de alguns itens.

*/
?>
<?php require_once('../../Connections/provider.php'); ?>
<?php require_once('../../Connections/servico.php'); ?>
<?php
$ip = $_SERVER['REMOTE_ADDR'];
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
  $updateSQL = sprintf("UPDATE tb_na SET tempo=%s, os_nub=%s, teleatendente=%s, pa=%s, hora=%s, `data`=%s, cod_cliente=%s, rg=%s, cpf=%s, nome_cli=%s, uc=%s, medidor=%s, endereco=%s, bairro=%s, distrito=%s, municipio=%s, telefone=%s, celular=%s, ocorrencia=%s, prioridade=%s, soma=%s, situacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['tempo'], "text"),
                       GetSQLValueString($_POST['os_nub'], "text"),
                       GetSQLValueString($_POST['teleatendente'], "text"),
                       GetSQLValueString($_POST['pa'], "text"),
                       GetSQLValueString($_POST['hora'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['cod_cliente'], "text"),
                       GetSQLValueString($_POST['rg'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['nome_cli'], "text"),
                       GetSQLValueString($_POST['uc'], "text"),
                       GetSQLValueString($_POST['medidor'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['distrito'], "text"),
                       GetSQLValueString($_POST['municipio'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['ocorrencia'], "text"),
                       GetSQLValueString($_POST['prioridade'], "text"),
                       GetSQLValueString($_POST['soma'], "text"),
                       GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($updateSQL, $provider) or die(mysql_error());

  $updateGoTo = "na-enviada-com-sucesso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_atua_os = "-1";
if (isset($_GET['os_nub'])) {
  $colname_atua_os = (get_magic_quotes_gpc()) ? $_GET['os_nub'] : addslashes($_GET['os_nub']);
}
mysql_select_db($database_provider, $provider);
$query_atua_os = sprintf("SELECT * FROM tb_na WHERE os_nub = '%s' ORDER BY id DESC", $colname_atua_os);
$atua_os = mysql_query($query_atua_os, $provider) or die(mysql_error());
$row_atua_os = mysql_fetch_assoc($atua_os);
$totalRows_atua_os = mysql_num_rows($atua_os);

mysql_select_db($database_servico, $servico);
$query_agendamento = "SELECT * FROM tb_servico ORDER BY nome_ser ASC";
$agendamento = mysql_query($query_agendamento, $servico) or die(mysql_error());
$row_agendamento = mysql_fetch_assoc($agendamento);
$totalRows_agendamento = mysql_num_rows($agendamento);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>N.A. DIGITAL O.S. <?php echo $row_atua_os['os_nub']; ?></title>
<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #CCCCCC;
}
a:link {
        color: #FF0000;
        text-decoration: none;
}
a:visited {
        color: #FF0000;
        text-decoration: none;
}
a:hover {
        color: #FF0000;
        text-decoration: underline;
}
a:active {
        color: #FF0000;
        text-decoration: none;
}
.style19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.style26 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        font-weight: bold;
}
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style29 {font-size: 8px}
.style30 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.style44 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FF0000; }
.style46 {
        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style52 {
        color: #000000;
        font-size: 10px;
}
.style54 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; color: #FF0000; }
-->
</style>

<?php

$meses = array (1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05", 6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11", 12 => "12");
 $hoje = getdate();
 $dia = $hoje["mday"];
 $mes = $hoje["mon"];
 $nomemes = $meses[$mes];
 $ano = $hoje["year"];
 $diadasemana = $hoje["wday"];
?>


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

        document.form_hora.hora.value = horaImprimible

        setTimeout("mueveHorario()",1000)
}
</script>

<script language="JavaScript">
<!--

function validaCampoObrigatorio(form1){
            var erro=0;
            var legenda;
            var obrigatorio;           
            for (i=0;i<form1.length;i++){
                        obrigatorio = form1[i].lang;
                        if (obrigatorio==1){
                                   if (form1[i].value == ""){
                                               var nome = form1[i].name;
                                               mudarCorCampo(form1[i], 'red');
                                               legenda=document.getElementById(nome);
                                               legenda.style.color="red";
                                               erro++;
                                   }
                        }
            }
            if(erro>=1){
                        alert("Existe(m) " + erro + " campo(s) obrigatório(s) vazio(s)! ")
                        return false;
            } else
                        return true;
}

function mudarCorCampo(elemento, cor){
            elemento.style.backgroundColor=cor;
}
//-->
</script>

<script>
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
</script>

<script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
</script>

 <script src="jquery-1.3.2.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#esc_distrito').change(function(){
                $('#municipio').load('municipio.php?estado='+$('#esc_distrito').val() );
				
            });
        });
		 $(document).ready(function(){
            $('#municipio').change(function(){
           
				$('#distrito').load('distritos_al.php?estado='+$('#esc_distrito').val() );
            });
        });

    </script>

<script language="JavaScript">
function repete() {
// o valor do input nome1 será igual ao do nome
document.form_hora.municipio2.value=document.form_hora.municipio.value;
}
</script>	
	
</head>

<body onload="mueveHorario()">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form_hora" id="form_hora"" onSubmit="return validaCampoObrigatorio(this)"">
  
  <table width="720" height="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td align="center" valign="middle"><table width="710" height="55" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
          <tr>
            <td width="123">&nbsp;</td>
            <td width="410" align="center" valign="middle"><div align="center" class="style48">NOTIFICA&Ccedil;&Atilde;O 
              DE ATENDIMENTO - SERVI&Ccedil;O 0800 </div></td>
            <td width="159" align="center" valign="middle"><div align="center" class="style48">Call 
              Center </div></td>
          </tr>
        </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="71" align="left" valign="top"><span class="style50">N&Uacute;MERO NA:</span></td>
              <td width="633" align="left" valign="baseline" class="style52"><?php echo $row_atua_os['id']; ?></td>
            </tr>
          </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="75" align="left" valign="top"><span class="style54">TELEATENDENTE:</span></td>
              <td width="119" align="left" valign="baseline"><input name="teleatendente"type="text" class="style46" id="teleatendente" lang="1" onfocus="mudarCorCampo(this,'white')" value="" size="18" maxlength="30" xml:lang="1" /></td>
              <td width="23" align="left" valign="top"><span class="style50">PA:</span></td>
              <td width="140" align="left" valign="baseline"><input name="pa2" type="text" disabled="disabled" class="style46" id="pa2" value="<?php echo "$ip"; ?>" size="18" /></td>
              <td width="31" align="left" valign="top"><span class="style50">HORA:</span></td>
              <td width="130" align="left" valign="baseline"><span class="style46"><span class="style19">
                <input name="hora" type="text" class="style46" id="hora" size="18" />
              </span> </span></td>
              <td width="28" align="left" valign="top"><span class="style50">DATA:</span></td>
              <td width="146" align="left" valign="baseline"><input name="data2" type="text" disabled="disabled" class="style46" id="data2" value="<?php echo "$dia/$nomemes/$ano";
?>" size="18" />
                  <span class="style42"></span></td>
            </tr>
          </table>
          <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="71" align="left" valign="top"><span class="style50">C&Oacute;D CLIENTE: </span></td>
              <td width="120" align="left" valign="baseline"><span class="style30">
                <input name="cod_cliente" type="text" class="style46"value="" size="18" maxlength="11" OnKeyPress="formatar('#.###.###-#', this)"/>
              </span></td>
              <td width="85" align="left" valign="top"><span class="style50">RG/INSC. EST.:</span></td>
              <td width="138" align="left" valign="baseline"><input name="rg" type="text" class="style46" onkeypress='return SomenteNumero(event)' value="" size="18" maxlength="20"/></td>
              <td width="49" align="left" valign="top"><span class="style50">CPF/CNPJ:</span></td>
              <td width="233" align="left" valign="baseline"><input name="cpf" type="text" class="style46" value="" size="18" maxlength="14" onkeypress='return SomenteNumero(event)'/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="34" height="19" align="left" valign="top"><span class="style54">NOME:</span></td>
              <td width="324" align="left" valign="baseline"><input name="nome_cli" type="text" class="style46" id="nome_cli" lang="1" onfocus="mudarCorCampo(this,'white')" value="" size="55" maxlength="45" xml:lang="1" /></td>
              <td width="80" align="left" valign="top"><span class="style54"><strong>C&Oacute;D &Uacute;NICO:</strong></span></td>
              <td width="83" align="left" valign="baseline"><input name="uc" type="text" class="style46" id="uc" lang="1" onfocus="mudarCorCampo(this,'white')" OnKeyPress="formatar('#.###.###-#', this)" value="" size="13" maxlength="11" xml:lang="1"/></td>
              <td width="47" align="left" valign="top"><span class="style50">MEDIDOR:</span></td>
              <td width="128" align="left" valign="baseline"><input name="medidor" type="text" class="style46" value="" size="15" maxlength="9"/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="61" align="left" valign="top"><span class="style50">ENDERE&Ccedil;O:</span></td>
              <td width="643" align="left" valign="middle"><input name="endereco" type="text" class="style46" value="" size="90" maxlength="125" /></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="42" align="left" valign="top"><span class="style50">BAIRRO:</span></td>
              <td width="122" align="left" valign="middle"><input name="bairro" type="text" class="style46" value="" size="20" maxlength="15" /></td>
              <td width="54" align="left" valign="top"><span class="style54">DISTRITO:</span></td>
              <td width="211" align="left" valign="middle"><option value=""></option>
</select>
              <label>
              <select name="esc_distrito" class="style46" id="esc_distrito">
                <?php
        mysql_connect('localhost','root','callmaceio2012');
        mysql_selectdb('combobox');

       $result = mysql_query("select * from tb_estados ORDER BY id ASC");

       while($row = mysql_fetch_array($result) ){
            echo "<option value='".$row['id']."'>".$row['nome']."</option>";

       }

    ?>
              </select>
              <span class="style46">
              <option value="0"></option>
              </select>
              </span></label></td>
              <td width="56" align="left" valign="top"><span class="style54">MUN&Iacute;CIPIO:</span></td>
              <td width="211" align="left" valign="middle" class="style46"><label>
                <select name="municipio" class="style46" id="municipio" onchange="repete()">
                  <option value="0">SELECIONE O DISTRITO</option>
                </select>
              </label></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="48" align="left" valign="top"><span class="style54">CELULAR:</span></td>
              <td width="71"><input name="celular" type="text" class="style46" id="celular" lang="1" onfocus="mudarCorCampo(this,'white')" value="" size="12" maxlength="11" xml:lang="1" onkeypress='return SomenteNumero(event)'/></td>
              <td width="80" align="left" valign="top"><span class="style50">TELEFONE FIXO:</span></td>
              <td width="501"><input name="telefone" type="text" class="style46" value="" size="12" maxlength="10" onkeypress='return SomenteNumero(event)'/></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="28" align="left" valign="top"><span class="style50">O.S.</span></td>
              <td width="316" align="left" valign="baseline"><input name="os_nub" type="text" class="style46" id="os_nub" value="<?php echo $row_atua_os['os_nub']; ?>" size="13" maxlength="12" />
              <span class="style; ?></span></td>
              <td align="left" valign="top"></td>
              <td width="56" align="left" valign="top"><span class="style54">SERVI&Ccedil;O:</span></td>
              <td width="300" align="right" valign="baseline"><label>
<select name="prioridade" class="style46" id="prioridade" lang="1" onfocus="mudarCorCampo(this,'white')" xml:lang="1">
                <?php
do {  
?>
                <option value="<?php echo $row_agendamento['nome_ser']?>"><?php echo $row_agendamento['nome_ser']?></option>
                <?php
} while ($row_agendamento = mysql_fetch_assoc($agendamento));
  $rows = mysql_num_rows($agendamento);
  if($rows > 0) {
      mysql_data_seek($agendamento, 0);
	  $row_agendamento = mysql_fetch_assoc($agendamento);
  }
?>
              </select>
</select>
              </select>
              </select>
              </label>			  </td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td width="75" align="left" valign="top"><span class="style26 style29"><span class="style50">OCORR&Ecirc;NCIA:</span></span></td>
              <td width="629" align="left" valign="baseline"><span class="style19">
                <textarea name="ocorrencia" cols="76" rows="8"></textarea>
              </span></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td align="center" valign="baseline"><input name="submit" type="submit" class="style46" value="ENCAMINHAR" />
                  <label>
                  <input name="Reset" type="reset" class="style46" value="LIMPAR" />
                </label></td>
            </tr>
        </table>
        <table width="561" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="422" align="right" valign="top" class="style50">&nbsp;</td>
            <td width="139" align="right" valign="middle"><select name="distrito" class="style46" id="distrito"/>            
            </select>
              </select></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <input name="id" type="hidden" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php echo $row_atua_os['id']; ?>">
    <span class="style28"><span class="style44"><span class="style19">
    <input name="situacao" type="hidden" value="EM ANDAMENTO" />
    </span></span></span><span class="style28"><span class="style44"><span class="style19">
    <input name="tempo" type="hidden" value="9999999999" />
    </span></span></span><span class="style28"><span class="style44"><span class="style19">
    <input name="soma" type="hidden" value="1<?php echo $row_atua_os['soma']; ?>" />
    </span></span></span>
    <input name="pa" type="hidden" class="style46" value="<?php echo "$ip"; ?>" />
    <span class="style19">
    <input name="data" type="hidden" class="style46" id="data" value="<?php echo "$dia/$nomemes/$ano";  ?>" />
  </span>
    <label>
    <input name="municipio2" type="text" id="municipio2" lang="1" onfocus="mudarCorCampo(this,'white')" xml:lang="1"/>
    </label>
  </p>
</form>
</body>
</html>