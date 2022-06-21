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
  $MM_redirectLoginSuccess = "pastadenadigitalcallcenter/na-consulta.php";
  $MM_redirectLoginFailed = ".login/login.php?login_errado=true";
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
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../login/login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "r,s,a";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "semacesso.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?php
$currentPage = $_SERVER["PHP_SELF"];

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_provider, $provider);
$query_usuarios = sprintf("SELECT * FROM login WHERE login = '%s'", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $provider) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boletim &gt;&gt;&gt; </title>
<meta http-equiv='Refresh' content='1;URL=/pastadenadigitalcallcenter/na-consulta.php' />
<style type="text/css">
<!--
.style52 {color: #0099FF; font-family: Arial, Helvetica, sans-serif; }
.style53 {font-family: Arial, Helvetica, sans-serif}
.style54 {font-size: 11px}
.style56 {color: #0099FF; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style6 {font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	color: #0099FF;
}
body {
	margin-left: 0px;
	margin-top: 50px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #0099FF;
}
a:link {
	color: #0099FF;
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
.style18 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #990000; font-style: italic; }
-->
</style>
</head>


<body>
<table width="399" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="399" align="center" valign="top"><form id="form1" method="post" action="<?php echo $loginFormAction; ?>">
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
              <td width="21%" align="center" valign="middle"><span class="style56"><?php echo $row_usuarios['login']; ?></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="15%"><span class="style56">Logout: </span></td>
              <td width="85%"> <a href="<?php echo $logoutAction ?>" class="style56">Sair</a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#FFFFFF"><img src="../../images/untitled.png" width="43" height="37" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>