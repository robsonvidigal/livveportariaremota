<?php require_once('../../Connections/provider.php'); ?>
<?php
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
  $MM_redirectLoginSuccess = "login_aberto.php";
  $MM_redirectLoginFailed = "../login/login.php?login_errado=true";
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
<title>:: Login ::</title>
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
body {
	margin-top: 50px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #0099FF;
}
.style6 {	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
}
.style52 {color: #0099FF; font-family: Arial, Helvetica, sans-serif; }
.style53 {font-family: Arial, Helvetica, sans-serif}
.style54 {font-size: 11px}
.style56 {color: #0099FF; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
a {
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
}
a:link {
	text-decoration: none;
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
.style57 {font-size: 10px}
-->
</style>
</head>
<body>
<table width="399" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="399" align="center" valign="top">
	
	<form id="form1" method="post" action="<?php echo $loginFormAction; ?>">
     
	 
	 <table width="90%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style6"><img src="../imagens/logo_casal_grande.png" width="124" height="70" /></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="style6">Bem Vindo(a)! </span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="21%"><span class="style56">Login:</span></td>
        <td width="79%"><label>
          <input name="login" type="text" id="login" size="15" />
        </label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="21%"><span class="style56">Senha: </span></td>
        <td width="79%"><span class="style52">
          <input name="senha" type="password" id="senha" size="15" />
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><span class="style53">
      <input name="Submit2" type="submit" value="ENTRAR" />
      <input name="Submit2" type="reset" value="APAGAR" />
    </span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="cadastro.php" class="style57">:: Cadastro de acesso:: </a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="style52">
      <?php if(isset($_GET["login_errado"])) { ?>
    </span>
      <p class="style52 style54">LOGIN OU SENHA N&Atilde;O LOCALIZADOS NO SISTEMA. <br />
          <br />
        POR FAVOR ENTRE EM CONTATO COM A COORDENA&Ccedil;&Atilde;O DO CALL CENETER.</p>
      <span class="style52">
      <?php } ?>
      </span></td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#FFFFFF"><img src="../../images/36_256x256.png" width="43" height="37" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

	 
</form>
	
	
	</td>
  </tr>
</table>




</body>
</html>