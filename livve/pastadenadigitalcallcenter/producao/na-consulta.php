<?php require_once('../../Connections/provider.php'); ?>
<?php
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="visualizanumerosdena.php";
  $loginUsername = $_POST['os_nub'];
  $LoginRS__query = "SELECT os_nub FROM tb_na WHERE os_nub='" . $loginUsername . "'";
  mysql_select_db($database_provider, $provider);
  $LoginRS=mysql_query($LoginRS__query, $provider) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."pesquisar=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}



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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_hora")) {
  $insertSQL = sprintf("INSERT INTO tb_na (os_nub, pa, hora, `data`, ip, tempo) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['os_nub'], "text"),
                       GetSQLValueString($_POST['pa'], "text"),
                       GetSQLValueString($_POST['hora'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['tempo'], "int"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "na.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}

mysql_select_db($database_provider, $provider);
$query_na = "SELECT * FROM tb_na ORDER BY id DESC";
$na = mysql_query($query_na, $provider) or die(mysql_error());
$row_na = mysql_fetch_assoc($na);
$totalRows_na = mysql_num_rows($na);

mysql_select_db($database_provider, $provider);
$query_tb_cadastro_os = "SELECT * FROM tb_os";
$tb_cadastro_os = mysql_query($query_tb_cadastro_os, $provider) or die(mysql_error());
$row_tb_cadastro_os = mysql_fetch_assoc($tb_cadastro_os);
$totalRows_tb_cadastro_os = mysql_num_rows($tb_cadastro_os);
?>
<?php

//determina um tempo para a variável $tempo
   $tempo = time();

   // pega o IP do usuário
   $ip = $_SERVER['REMOTE_ADDR'];

   //deleta a linha que não foi atualizada no tempo de 1800 segundos
   mysql_query("DELETE FROM tb_na WHERE tempo <'$tempo'".-"3600");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>N.A DIGITAL - NOTIFICA&Ccedil;&Atilde;O DE ATENDIMENTO</title>

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


<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 5px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #CCCCCC;
}
a:link {
        color: #000066;
        text-decoration: none;
}
a:visited {
        color: #000066;
        text-decoration: none;
}
a:hover {
        color: #000066;
        text-decoration: underline;
}
a:active {
        color: #000066;
        text-decoration: none;
}
.style14 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #FF0000;
        font-weight: bold;
}
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-weight: bold; }
.style19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.style26 {        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        font-weight: bold;
}
.style29 {font-size: 8px}
.style42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.style46 {        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style52 {        color: #000000;
        font-size: 10px;
}
.style53 {font-size: 10px; color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
</style>

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
              <td align="left" valign="top">&nbsp;</td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td align="left" valign="top">&nbsp;</td>
              <td width="23" align="left" valign="top"><span class="style50">PA:</span></td>
              <td width="140" align="left" valign="baseline"><input name="pa" type="text" disabled="disabled" class="style46" value="<?php echo "$ip"; ?>" size="25" /></td>
              <td width="31" align="left" valign="top"><span class="style50">HORA:</span></td>
              <td width="134" align="left" valign="baseline"><span class="style42">
                <input name="hora" type="text" disabled="disabled" class="style46" size="25" />
              </span></td>
              <td width="31" align="left" valign="top"><span class="style50">DATA:</span></td>
              <td width="139" align="left" valign="baseline"><span class="style42">
              <input name="data" type="text" disabled="disabled" class="style46" value="<?php echo "$dia/$nomemes/$ano"; ?>" size="25" />
              </span></td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
            <tr>
              <td width="20" align="left" valign="top"><span class="style50">O.S.</span></td>
              <td width="125" align="left" valign="baseline"><span class="style; ?></span></td>
              <td align="left" valign="top">
                  <input name="os_nub" type="text" class="style46" id="os_nub" lang="1" onfocus="mudarCorCampo(this,'white')" size="25" maxlength="12" xml:lang="1" OnKeyPress="formatar('###.###.##', this)"/></td>
              <td width="103" align="right" valign="top"><span class="style18"><label></label>
                </span><span class="style50">N&ordm; gen&eacute;rico</span> </td>
              <td width="110" align="center" valign="baseline"><span class="style18">
                <label><span class="style14">
                <?php
$numeros = array(0,1,2,3,4,5,6,7,8,9);

$total_num = count($numeros)-1;
$senha = $numeros[rand(0,$total_num)] . $numeros[rand(0,$total_num)] . $numeros[rand(0,$total_num)] . $numeros[rand(0,$total_num)];
$nova_senha = $senha;
?>
                </span></label>
                <span class="style14"><?php echo "$ano$nomemes$dia";?><?php echo $senha;?>
              </span></span><span class="style18"></span></td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
        </table>
        <table width="710" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
              <td align="center" valign="baseline"><label>
                <input name="submit" type="submit" class="style46" value="ENVIAR" />
                <input name="Reset" type="reset" class="style46" value="LIMPAR" />
              </label></td>
            </tr>
        </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_hora">
  <input name="ip" type="hidden" id="ip" value="<?php echo "$ip"; ?>" />
  <input name="tempo" type="hidden" id="tempo" value="<?php echo "$tempo"; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>