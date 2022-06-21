<?php require_once('../../Connections/provider.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO login (nome, id, matricula, login, senha, nivel,  supervisor) VALUES (%s, %s, %s, %s, md5(%s), %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['matricula'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nivel'], "text"),
                       GetSQLValueString($_POST['supervisor'], "text"));

  mysql_select_db($database_provider, $provider);
  $Result1 = mysql_query($insertSQL, $provider) or die(mysql_error());

  $insertGoTo = "../login/cadastro_com_sucesso.php";
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
<style type="text/css">
<!--
.style10 {font-size: 12px}
.style6 {font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
}
.style12 {
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
	font-size: 12px;
}
body {
	background-color: #0099FF;
	margin-left: 0px;
	margin-top: 50px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style13 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #999999;
}
-->
</style>

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
				function soletras(e)
	 						{
								var expressao;

								expressao = /[0-9]/;

							if(expressao.test(String.fromCharCode(e.keyCode)))
							{
								return false;
							}
								else
							{
								return true;
							}
							}
			
		</script>	
		
		
		<script>
				function sonumeros(e)
	 						{
								var expressao;

								expressao = /[a-z]/;

							if(expressao.test(String.fromCharCode(e.keyCode)))
							{
								return false;
							}
								else
							{
								return true;
							}
							}
			
		</script>			


</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" id="form2" " onSubmit="return validaCampoObrigatorio(this)"">
  <table width="399" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style6"><img src="../imagens/logo_casal_grande.png" width="124" height="70" /></span></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style6">:: Cadastro de acesso :: </span></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="19%"><span class="style12">Nome:</span></td>
                <td width="39%" align="left" valign="middle"><input name="nome" type="text" id="nome" size="10" onkeypress="return soletras(event)"/></td>
                <td width="42%" align="left" valign="middle"><span class="style13"> Ex.: Jos&eacute; Mariano </span></td>
              </tr>
              
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="60"><span class="style12">Matricula:</span></td>
              <td width="125"><input name="matricula" type="text" id="matricula" onkeypress="return sonumeros(event)" size="10" maxlength="5"/></td>
              <td width="133" align="left" valign="middle"><span class="style13"> Ex.: 61234</span></td>
            </tr>
            
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="19%"><span class="style12">Login: </span></td>
              <td width="39%" align="left" valign="middle"><input name="login" type="text" id="login" lang="1" onfocus="mudarCorCampo(this,'white')" size="10" xml:lang="1" onkeypress="return soletras(event)"/></td>
              <td width="42%" align="left" valign="middle"><span class="style13">Ex.: Jose Mariano </span></td>
            </tr>
            
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="60"><span class="style12">Senha:</span></td>
              <td width="125" align="left" valign="middle"><span class="style10">
                <input name="senha" type="password" id="senha" lang="1" onfocus="mudarCorCampo(this,'white')" size="10" xml:lang="1" />
              </span></td>
              <td width="133" align="left" valign="middle"><span class="style10"><span class="style13">Ex.: Livre123 (letras e n&uacute;emros) </span></span></td>
            </tr>
            
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF" class="style12">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="style12"> Lembre-se de anotar sua senha. </span></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><input name="nivel" type="hidden" id="nivel" value="a" /></td>
        </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><input name="submit" type="submit" id="submit" value="CADASTRAR" /></td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  <p>
    <input name="id" type="hidden" value="" />
    <input type="hidden" name="MM_insert" value="form2" />
  </p>
</form>
</body>
</html>
