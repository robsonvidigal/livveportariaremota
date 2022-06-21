<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.botao {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; background-color: #D9E3F6; color: #3C4D81; border: thin #EBEBEB ridge}
.campos {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-style: normal; color: #3C4D81; background-color: #D9E3F6; border: thin #EBEBEB none}
-->
</style>
</head>

<body>

<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	



<?

$data = substr($nascimento_a, 0,5);
   if($acao == "gravar")

   {

   if($acao == "gravar")

		$niver= "$nick_a $data\n";


		$fp=fopen("../aniv/aniversariantes.txt", "a");
		fwrite($fp, $niver);
		fclose($fp);
      
    } ?>

</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><form method="post" action="../aniv/index.php?acao=gravar" enctype="multipart/form-data">
      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#3C4D81"><b>.:
        Cadastro de Aniversariantes :.</b></font></div>
      <table width="76%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
        </tr>
        <tr>
          <td align="right" width="97"><div align="left"><font color="#3C4D81" face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Nome:</b> </font></div></td>
          <td align="left" width="172"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
            <input name="nick_a" value="" size="30" class="campos" style="border: 1px dashed #3C4D81; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" />
          </font> </td>
        </tr>
        <tr>
          <td align="right" width="97"><div align="left"><font color="#3C4D81" face="Verdana, Arial, Helvetica, sans-serif" size="1"> <b>Nascimento:</b> </font></div></td>
          <td align="left" width="172"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
            <input name="nascimento_a" value="dd/mm" size="7" maxlength="5" class="campos" style="border: 1px dashed #3C4D81; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1" />
          </font> </td>
        </tr>
        <tr align="left">
          <td colspan="2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br />
                    <input type="submit" name="salvar" value="Cadastrar" class="botao" />
                    <input type="reset" name="limpar" value="Limpar" class="botao" />
          </font></div></td>
        </tr>
      </table>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <p align="center">&nbsp;</p>
    </form></td>
  </tr>
  <tr>
    <td></p></td>
  </tr>
</table>
</body>
</html>
