<?php require_once('../Connections/provider.php'); ?>
<?php
mysql_select_db($database_provider, $provider);
$query_usuariosdosistema = "SELECT * FROM login ORDER BY id ASC";
$usuariosdosistema = mysql_query($query_usuariosdosistema, $provider) or die(mysql_error());
$row_usuariosdosistema = mysql_fetch_assoc($usuariosdosistema);
$totalRows_usuariosdosistema = mysql_num_rows($usuariosdosistema);

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO login (nome, id, matricula, login, senha, nivel, inicio, fim, supervisor) VALUES (%s, %s, %s, %s, md5(%s), %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['matricula'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nivel'], "text"),
                       GetSQLValueString($_POST['inicio'], "text"),
                       GetSQLValueString($_POST['fim'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "../pastadenadigitalcallcenter/login/login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Cadastro de Usu&aacute;rio ::</title>
<meta name="Keywords" content="" />
<meta name="Boletim operacional" content="" />
<link href="../default.css" rel="stylesheet" type="text/css" media="screen" />
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:783px;
	top:129px;
	width:382px;
	height:17px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:807px;
	top:69px;
	width:358px;
	height:52px;
	z-index:2;
}
.style10 {font-size: 12px}
.style11 {color: #8C0209}
.style19 {color: #000000}
body {
	margin-top: 0px;
}
.style1 {	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003466;
}
.style50 {	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #890208;
}
.style53 {color: #FFFFFF; }
-->
</style>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" id="form2" " onSubmit="return validaCampoObrigatorio(this)"">
  <table width="800" height="257" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#8C0209">
    <tr>
      <td height="50" colspan="2" align="center" valign="middle" background="../images/img02.jpg"><h3 align="center" class="style53">Cadastro de novo usu&aacute;rio</h3></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" class="style11">Nome: </td>
      <td align="left" valign="middle"><label>
        <input name="nome" type="text" id="nome" size="32" />
      </label></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" class="style11">Matricula: </td>
      <td align="left" valign="middle"><label>
        <input name="matricula" type="text" id="matricula" size="32" />
      </label></td>
    </tr>
    <tr>
      <td width="342" height="24" align="right" valign="middle"><span class="style11">Login: </span></td>
      <td width="458" align="left" valign="middle"><label>
        <input name="login" type="text" id="login" lang="1" onfocus="mudarCorCampo(this,'white')" size="32" xml:lang="1" />
      </label></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" class="style11">Senha: </td>
      <td align="left" valign="middle"><label> <span class="style10">
        <input name="senha" type="hidden" id="senha" lang="1" onfocus="mudarCorCampo(this,'white')" value="<?php
$letras  = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','x','w','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','X','W','Y','Z');
$numeros = array(0,1,2,3,4,5,6,7,8,9);
$total_let = count($letras)-1;
$total_num = count($numeros)-1;
$senha = $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)] . $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)] . $letras[rand(0,$total_let)] . $numeros[rand(0,$total_num)];
$nova_senha = $senha;
 
echo $senha;

?>" xml:lang="1" />
        <?php 
				echo $senha;
				?>
      </span></label></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle"><span class="style11">N&iacute;vel de acesso: </span></td>
      <td align="left" valign="middle"><input name="nivel" type="text" id="nivel" size="5" />
          <span class="style50">* S = SUPERVISOR  * R = COORDENADOR * BRANCO = S/ ACESSO </span></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle" class="style11">Turno: </td>
      <td align="left" valign="middle"><label>
        <select name="inicio" id="inicio">
          <option value="01:00">01:00</option>
          <option value="03:00">03:00</option>
          <option value="06:00">06:00</option>
          <option value="07:00">07:00</option>
          <option value="08:00">08:00</option>
          <option value="09:00">09:00</option>
          <option value="13:00">13:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="19:00">19:00</option>
          <option value="20:00">20:00</option>
          <option value="21:00">21:00</option>
        </select>
        <span class="style11">&Agrave;s </span>
        <select name="fim" id="select2">
          <option value="07:00">07:00</option>
          <option value="08:00">08:00</option>
          <option value="09:00">09:00</option>
          <option value="12:00">12:00</option>
          <option value="13:00">13:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="19:00">19:00</option>
          <option value="20:00">20:00</option>
          <option value="21:00">21:00</option>
          <option value="01:00">01:00</option>
          <option value="02:00">02:00</option>
          <option value="03:00">03:00</option>
        </select>
        <span class="style1"> </span></label></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="middle"><span class="style11">Supervisor(a): </span></td>
      <td align="left" valign="middle"><label>
        <input name="supervisor" type="text" id="supervisor" size="32" />
      </label></td>
    </tr>
    <tr>
      <td height="26" colspan="2" align="center" valign="middle"><div align="left">
        <label> </label>
        <div align="center">
          <input name="submit" type="submit" id="submit" value="CADASTRAR" />
        </div>
        <label> </label>
        <div align="center"></div>
      </div>
          <div align="center"></div>
        <div align="center"></div></td>
    </tr>
  </table>
  <input name="id" type="hidden" value="" />
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<!-- end header -->
</body>

</html>
<?php
mysql_free_result($usuariosdosistema);
?>
