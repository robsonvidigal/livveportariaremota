<?php require_once('../../Connections/provider.php'); ?>
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
  $updateSQL = sprintf("UPDATE tb_na SET os_nub=%s, teleatendente=%s, pa=%s, hora=%s, `data`=%s, cod_cliente=%s, rg=%s, cpf=%s, nome_cli=%s, uc=%s, medidor=%s, endereco=%s, bairro=%s, municipio=%s, telefone=%s, celular=%s, ocorrencia=%s, prioridade=%s, soma=%s, situacao=%s WHERE id=%s",
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

mysql_select_db($database_provider, $provider);
$query_atua_os = "SELECT * FROM tb_na ORDER BY id DESC";
$atua_os = mysql_query($query_atua_os, $provider) or die(mysql_error());
$row_atua_os = mysql_fetch_assoc($atua_os);
$totalRows_atua_os = mysql_num_rows($atua_os);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="refresh" content="0;URL=na_digital.php?os_nub=<?php echo $row_atua_os['os_nub']; ?>">
<title>N.A. DIGITAL O.S. <?php echo $row_atua_os['os_nub']; ?></title>


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
                        alert("Existe(m) " + erro + " campo(s) obrigat�rio(s) vazio(s)! ")
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
.style11 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 13px;
}
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
.style19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style29 {font-size: 8px}
.style30 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style31 {
        color: #FF0000;
        font-weight: bold;
}
.style33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 6px; }
.style38 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #FF0000;
        font-weight: bold;
}
.style42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.style43 {color: #FF0000}
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-weight: bold; }
.style46 {font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.style50 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.style52 {color: #000000;
        font-size: 10px;
}
-->
</style>
</head>

<body onload="mueveHorario()">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form_hora" id="form_hora"" onSubmit="return validaCampoObrigatorio(this)"">
  <p><input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="id" value="<?php echo $row_atua_os['id']; ?>">
    <span class="style19">
    <input name="situacao" type="hidden" value="EM ANDAMENTO<?php echo $row_atua_os['situacao']; ?>" />
  </span><span class="style19">
  <input name="soma" type="hidden" value="1<?php echo $row_atua_os['soma']; ?>" />
  </span></p>
</form>
</body>
</html>
<?php
mysql_free_result($atua_os);
?>