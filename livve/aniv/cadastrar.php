<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<LINK href="../imagens/style.css" type=text/css rel=StyleSheet>
<title>Cadastro de Aniversariantes</title>
<style type="text/css">
<!--
.campos {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; color: #3C4D81; background-color: #D9E3F6; border: thin #EBEBEB none}
.texto {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; color: #3C4D81; border: thin #EBEBEB none}
.botao {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; background-color: #D9E3F6; color: #3C4D81; border: thin #EBEBEB ridge}
.radio {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0000CC; border-style: none}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor=EBF1FA>
<center><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#3C4D81"><b>
Preencha corretamente os capos abaixo para fazer o seu cadastro!</b></font></center><br>
<!--PHP -->
<?

$data = substr($nascimento_a, 0,5);
   if($acao == "salvar")

   {

   if($acao == "salvar")

		$niver = "$nick_a $data\n";

		$fp=fopen("aniversariantes.txt", "a");
		fwrite($fp, $niver);
		fclose($fp);
      }

     ?>
	 
	 
<form method="post" action="cadastrar.php?acao=salvar" enctype="multipart/form-data">
  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#3C4D81"><b>.:
    Cadastro de Aniversariantes :.</b></font></div>
  <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td align="right" width="97"> <div align="left"><font color="#3C4D81" face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Nome:</b>
          </font></div></td>
      <td align="left" width="172"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
        <input name="nick_a" value="" size="30" class="campos" style="border: 1px dashed #3C4D81; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">
        </font> </tr>
    <tr>
      <td align="right" width="97"> <div align="left"><font color="#3C4D81" face="Verdana, Arial, Helvetica, sans-serif" size="1">
          <b>Nascimento:</b> </font></div></td>
      <td align="left" width="172"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
        <input name="nascimento_a" value="dd/mm" size="7" maxlength="5" class="campos" style="border: 1px dashed #3C4D81; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">
        </font> </tr>
    <tr align="left">
      <td colspan="2"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
          <input type="Submit" name="salvar" value="Cadastrar" class="botao">
          <input type="Reset" name="limpar" value="Limpar" class="botao">
          </font></div></td>
    </tr>
  </table>
  <div align="center"><br>
    <a href="index.php">Voltar ao menu </a><br>
    <br>
    <br>
    <br>
    <br>
  </div>
  <p align="center"> <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
<font color="#3399FF">Power By </font>
<a target="_blank" href="http://www.omegamix.com.br/mdesigner/" style="text-decoration: none">
<font color="#3399FF">M-Designer</font></a></font></strong></p>
</form>
</body>
</html>
<!-- Desenvolvido por Mariano Leite - email: mariano@omegamix.com.br - site: www.omegamix.com.br-->
