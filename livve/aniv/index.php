<!-- Desenvolvido por Mariano Leite - email: mariano@omegamix.com.br - site: www.omegamix.com.br-->
<html><head>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../imagens/style.css" type=text/css rel=StyleSheet>
<title>Aniversariantes do Mês OMEGAMIX</title>
<body bgcolor=EBF1FA leftmargin="0" topmargin="0" marginwidth="0">
<A NAME="niverdomes"></A>
<br><center><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#3C4D81">
<p style="margin-top: 0; margin-bottom: 0">Essa área foi feita para fazer uma singela homenagem aos usuários do OMEGAMIX, exibindo os aniversariantes do mês.</p>
<p style="margin-top: 0; margin-bottom: 0">Se você ainda não cadastrou a sua data de aniversaria, não perca tempo e faça já o seu cadastro. Não e preciso colocar o seu ano de nascimento, só o dia e o Mês que você nasceu!</font></p>
</center><br>
<p align="center">
<table width="300" border="1"  align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bordercolorlight="#CCCCCC" bordercolordark="#000000">
  <tr>
    <td width="144"  align="center" valign="top">
      <?php

 $mes =date('m'); //Gera mes em formato numérico

//compara os meses numericos pra gerar os meses escritos - inicio
 if ($mes=='01') {$mes_escrito='Janeiro';}
 if ($mes=='02') {$mes_escrito='Fevereiro';}
 if ($mes=='03') {$mes_escrito='Março';}
 if ($mes=='04') {$mes_escrito='Abril';}
 if ($mes=='05') {$mes_escrito='Maio';}
 if ($mes=='06') {$mes_escrito='Junho';}
 if ($mes=='07') {$mes_escrito='Julho';}
 if ($mes=='08') {$mes_escrito='Agosto';}
 if ($mes=='09') {$mes_escrito='Setembro';}
 if ($mes=='10') {$mes_escrito='Outubro';}
 if ($mes=='11') {$mes_escrito='Novembro';}
 if ($mes=='12') {$mes_escrito='Dezembro';}
 //compara os meses numericos pra gerar os meses escritos - fim

echo"<table width=299 align=center  border=0 cellspacing=0 cellpadding=0><tr><td width=100% bgcolor=#D9E3F6 align=center><font color=3C4D81 size=1 face=Verdana>Aniversariantes do Mês de <b>$mes_escrito</b></font></td></tr><table>"; //mostra o mês corrente

echo"<table width=299 align=center  border=1 cellspacing=0 cellpadding=0><tr>"; //Abre tabela para impressão dos nomes e datas de aniversário na tela

$linhas = file('aniversariantes.txt'); //abre aniversarios.txt
$nenhum = true;
foreach($linhas as $linha) {
$nome = substr($linha, 0, strrpos($linha, ' ')); //pega o nome na lista
$data = trim(substr($linha, strrpos($linha, ' ') + 4)); //pega o mês da data gravada
$data_niver = trim(substr($linha, strrpos($linha, ' ') + 1)); //pega a data toda

if($data ==  $mes) { //Se o mes corrente for igual ao mes do aniversario aparecera a lista com os nomes e datas
echo"
    <td width=87%><p align=left><font color=black size=1 face=Verdana>$nome</p></td>
    <td width=13%><p align=right><font color=black size=1 face=Verdana>$data_niver</p></td></tr>";
$nenhum = false;
}
}
if($nenhum) { echo '</table><table width=299 align=center  border=1 cellspacing=0 cellpadding=0><tr><td><p align=center><font face=Verdana size=1><b>Nenhum aniversário</b></p></font></td></tr>'; } //Se não tiver aniversário no mes aparecera a mensagem dessa linha
echo'</table>';
?>
</td>
  </tr>
</table><br>
<div align="center"> <a href="cadastrar.php"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
<b>Cadastrar Aniversariante</b></font></a></div>
<br><br><br><br><br><br><br><br>
<p align="center"> <strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
<font color="#3399FF">Power By </font>
<a target="_blank" href="http://www.omegamix.com.br/mdesigner/" style="text-decoration: none">
<font color="#3399FF">M-Designer</font></a></font></strong></p>
</body>
</html>
<!-- Desenvolvido por Mariano Leite - email: mariano@omegamix.com.br - site: www.omegamix.com.br-->

