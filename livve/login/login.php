<?php require_once('../Connections/provider.php'); ?>
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
.style5 {
	color: #8C0209;
	font-weight: bold;
}
.style10 {font-size: 12px}
.style11 {color: #8C0209}
.style19 {color: #000000}
body {
	margin-top: 0px;
}
.style49 {	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
	color: #003466;
}
.style6 {	font-size: 18px;
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #FFFFFF;
}
-->
</style>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="#"><span>BOLETIM</span>OPERACIONAL - call<span class="style19">center</span> - <span class="style19">login</span> </a></h1>
  </div>
  <div id="menu">
    <ul id="main">
      <li class="current_page_item"><a href="../index.php">in&iacute;cio</a></li>
<li><a href="ocorrencia_inserir.php">Controle</a></li>
<li><a href="../busca/busca_resultado.php">Pesquisar</a></li>
<li></li>
</ul>
    <ul id="feed">
      <li></li>
      <li></li>
</ul>
  </div>
</div>
<!-- end header -->
<div id="wrapper">
  <!-- start page -->
  <div id="page">
    <!-- start content -->
    <form id="form1" method="post" action="<?php echo $loginFormAction; ?>">
      <table width="490" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th height="28" colspan="3" align="center" valign="middle" background="../images/img02.jpg" scope="col"><span class="style6">Bem Vindo(a), Digite  Login e Senha</span></th>
        </tr>
        <tr>
          <th width="128" rowspan="3" align="left" valign="middle" scope="col"><img src="../images/36_256x256.png" width="191" height="196" /></th>
          <th width="88" height="24" align="center" valign="middle" scope="col"><span class="style11">Login:</span></th>
          <th width="245" align="left" valign="middle" scope="col"><label>
            <input name="login" id="login" size="32" type="text&gt;"/>
          </label></th>
        </tr>
        <tr>
          <th height="22" align="center" valign="top" scope="col"><span class="style11">Senha:</span></th>
          <th align="left" valign="top" scope="col"><input name="senha" type="password" id="senha" size="32" /></th>
        </tr>
        <tr>
          <th height="93" colspan="2" align="center" valign="middle" scope="col"><label></label>
              <input name="Submit2" type="submit" class="style11" value="ENTRAR" />
              <input name="Submit2" type="reset" class="style11" value="APAGAR" /></th>
        </tr>
        <tr>
          <th height="21" colspan="3" align="center" valign="top" scope="col"><span class="style49"> </span></th>
        </tr>
        <tr>
          <th height="88" colspan="3" align="center" valign="top" scope="col"> <?php if(isset($_GET["login_errado"])) { ?>
              <p class="style11">LOGIN OU SENHA N&Atilde;O LOCALIZADOS NO SISTEMA. <br />
                  <br />
                POR FAVOR ENTRE EM CONTATO COM A COORDENA&Ccedil;&Atilde;O DO CALL CENETER.</p>
            <?php } ?></th>
        </tr>
      </table>
    </form>
    <!-- end content -->
    <!-- start sidebars -->
    <!-- end sidebars -->
<div style="clear: both;">&nbsp;</div>
  </div>
  <!-- end page -->
</div>
<div id="footer">
  <p class="copyright">&copy;&nbsp;&nbsp;2013 Todos os direitos reservados &nbsp;&bull;&nbsp; Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<div align="center">Desenvolvido: <a href="mailto:robsonvidigal@gmail.com">robson vidigal</a></div>
</body>
</html>