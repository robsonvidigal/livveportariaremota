<?php require_once('../../../Connections/provider.php'); ?>
<?php
mysql_select_db($database_provider, $provider);
$query_tb_usariocadastrado = "SELECT * FROM login ORDER BY id DESC";
$tb_usariocadastrado = mysql_query($query_tb_usariocadastrado, $provider) or die(mysql_error());
$row_tb_usariocadastrado = mysql_fetch_assoc($tb_usariocadastrado);
$totalRows_tb_usariocadastrado = mysql_num_rows($tb_usariocadastrado);

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=md5($_POST['senha']);
  $MM_fldUserAuthorization = "nivel";
  $MM_redirectLoginSuccess = "pastadenadigitalcallcenter/na-consulta.php";
  $MM_redirectLoginFailed = "login/login.php?login_errado=true";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_provider, $provider);
  	
  $LoginRS__query=sprintf("SELECT login, senha, nivel FROM login WHERE login='%s' AND senha='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $provider) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'nivel');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="refresh" content="10;URL=../../pastadenadigitalcallcenter/login/login.php">
<title>:: Cadastro de Usu&aacute;rio ::</title>
<style type="text/css">
<!--
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
.style14 {
	font-size: 15px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="399" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style6"><img src="../imagens/logo_casal_grande.png" width="124" height="70" /></span></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF"><div align="center"><span class="style14">:: Cadastro de acesso realizado com sucesso :: </span></div></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="24%"><span class="style12">Nome:</span></td>
            <td width="76%" class="style12"><?php echo $row_tb_usariocadastrado['nome']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="76"><span class="style12">Matricula:</span></td>
            <td width="242" class="style12"><?php echo $row_tb_usariocadastrado['matricula']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%"><span class="style12">Login: </span></td>
            <td width="76%" class="style12"><?php echo $row_tb_usariocadastrado['login']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="77"><span class="style12">Senha:</span></td>
            <td width="241" class="style12">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF" class="style12">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><span class="style12">#Lembre de anotar sua senha e login. :) </span></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><input name="nivel" type="hidden" id="nivel" value="a" /></td>
      </tr>
      <tr>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($tb_usariocadastrado);
?>