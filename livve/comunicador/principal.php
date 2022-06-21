<?php
/* Chat em ajax X-Chat
   Autor do Chat: Hedi Carlos Minin
   http://www.xlinkweb.com.br

  chat x-chat em ajax versão xq 1.0
  Demonstração e download em: http://guia.xq.com.br/chat2/
  
 */

session_start();
if(!$_SESSION['usu_nick']){
	header('Location:index.php'); 	
   }else{
	$nick = $_SESSION['usu_nick'];
  }
     global $acao;
	 
if ($acao =="mudarestilo") {
     require('class.mysql.php');
     require('config.inc.php');

$nick = $_SESSION['usu_nick'];
		
//para evitar problemas com javascript
$estilo = str_replace('"',' ',$estilo);
$estilo = str_replace(';','',$estilo);
$estilo = str_replace('(','',$estilo);
$estilo = str_replace(')','',$estilo);
$estilo = str_replace("'"," ",$estilo);
$estilo = str_replace('|','',$estilo);

//atualiza o estilo
$sql = new Mysql;
$sql->Consulta("UPDATE $tabela_usu SET estilo='$estilo' WHERE nick='$nick' LIMIT 1"); 
                  } else {
	$estilo = "estilo.css";			  
                   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Comunicador Interno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<? echo $estilo; ?>" rel="stylesheet" type="text/css">
<script src="js/ajax.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
var conteudo = '';
var flood = 0;
var imgenvia = new Image();
imgenvia.src = 'icones/enviar.jpg';
var imgflood = new Image();
imgflood.src = 'icones/at.jpg';

function rolar() { 
	if(document.getElementById("rolagem").value == 1){
		fler.scrollBy(0,70);
		setTimeout("rolar()",0); 
	}
}


//atualiza o estado atual do usuario
obj_estado = new montaXMLHTTP();
function setaestado(){

	var estado = document.getElementById("estado").value;
	
		obj_estado.open("POST","estado.php",true);
		obj_estado.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		obj_estado.send("estado="+estado);
		if(estado=='1'){
			document.getElementById("imgst").src='icones/on.gif';
		}
		if(estado=='2'){
			document.getElementById("imgst").src='icones/voltoja.gif';
		}
		if(estado=='3'){
			document.getElementById("imgst").src='icones/ausente.gif';
		}
		
		mensagem.value=""; 
		mensagem.focus();

}

//atualiza o estilo atual do usuario
obj_estilo = new montaXMLHTTP();
function setaestilo(){

	var estilo = document.getElementById("estilo").value;
	
		obj_estilo.open("POST","estilo.php",true);
		obj_estilo.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		obj_estilo.send("estilo="+estilo);
			document.getElementById("estilo").value;
		mensagem.value=""; 
		mensagem.focus();

}

function inicia(){
	document.getElementById("load").style.visibility = 'hidden';
	document.getElementById('mensagem').focus();
	document.getElementById("exibefrase").innerHTML  = 'Você está falando com Todos.';
}
//contar caracteres da mensagem
function ContaCaracteres(){

 	var mensagem = document.getElementById("mensagem").value;
	var qtd = mensagem.length;

	if((qtd > 0) && (qtd < 2)){
		document.getElementById("botenviar").innerHTML = '<a href="#" onClick="VerificaMsg()"><img src="icones/enviar.jpg" width="50" height="50" border="0"></a>';
	}
	if(qtd == 0){
		document.getElementById("botenviar").innerHTML = '<img src="icones/enviar_d.jpg" width="50" height="50">';	
	}
	if (qtd > 300){
	    document.getElementById("mensagem").value = mensagem.substr(0,300)
	}
}

function VerificaMsg(){
	var mensagem = document.getElementById("mensagem").value;
	var espacos = mensagem.split(' ');

	if(espacos.length - 1 == mensagem.length){
		setTimeout('Limpar()',10);
	}else{
		Enviar();
	}
	
}
function Limpar(){
	document.getElementById("mensagem").value = '';
	document.getElementById("mensagem").focus();
}

obj_envia = new montaXMLHTTP();
function Enviar(){

	if(flood == 0){
		var mensagem = document.getElementById("mensagem").value;
		var reservado = document.getElementById("reservado").value;
		var falacom = document.getElementById("falacom").value;
		var nick = document.getElementById("nick").value;
		var cor = document.getElementById("cor").value;
		var classe = 'separador';
		var textoreser = '';
		//limpa o campo
		setTimeout('Limpar()',10);
		//smiles
		var mensagem_rep = mensagem;
		for(i = 1; i < 27; i++){
			while(mensagem_rep.indexOf(':'+ i +':') != -1){
				mensagem_rep = mensagem_rep.replace(':'+ i +':','<img src="smiles/'+ i +'.gif">');
			}
		}
		//envia mensagem
		if((reservado != 0) && (falacom != 'Todos')){
			classe = 'reservado';
			textoreser = 'reservadamente';
		}else{
			reservado = 0;
		}
		//mostra o texto antes de enviar
		conteudo += '<div class="'+ classe +'"><b><font color="' +cor+ '">' +nick+ '</font></b> <i><font color="#666666">' +textoreser+' fala com</font></i> <b>' +falacom+ '</b>:<br>' +mensagem_rep+ '<br></div>';
		fler.document.getElementById("mostrar").innerHTML = conteudo;
		//envia a mensagem
		obj_envia.open("POST","enviar.php",true);
		obj_envia.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		obj_envia.send("mensagem=" +mensagem+ "&falacom=" +falacom+ "&reser=" +reservado+ "&cor=" +cor);
		flood = 1;
		setTimeout('liberaflood()',1300);
	}else{
		var tabela = '';
		tabela += '<table border="0" cellspacing="0" cellpadding="0" class="texto11"><tr>';
        tabela += '<td width="28"><img src="icones/at.jpg"></td>';
        tabela += ' <td width="350">O sistema anti-flood está ativado.</td>';
        tabela += '</tr></table>';
		document.getElementById("exibefrase").innerHTML  = tabela;
		setTimeout('retornafrase()',5000);
	}
}

function liberaflood(){
	flood = 0;
}

function retornafrase(){
	var frase = document.getElementById("salvafrase").value;
	var falacom = document.getElementById("falacom").value;
	if(falacom == 'Todos'){
		document.getElementById("exibefrase").innerHTML = frase;
	}else{
		if(frase != ''){
			document.getElementById("exibefrase").innerHTML = falacom+ ': ' +frase;
		}else{
			document.getElementById("exibefrase").innerHTML = falacom;
		}
	}
}

function reenvia(){
	Ler();
}

obj_mostra = new montaXMLHTTP();
function Ler(){	
	obj_mostra.open("GET","ler.php",true);
	obj_mostra.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	obj_mostra.onreadystatechange = function(){
		if(obj_mostra.readyState == 4){
				conteudo += obj_mostra.responseText;
				fler.document.getElementById("mostrar").innerHTML = conteudo;
				clearTimeout(re);
				setTimeout("Ler()",1000);
		}
	}
	obj_mostra.send(null);
	var re = setTimeout("reenvia()",10000);
}

function enviasmile(img){
	var texto = document.getElementById('mensagem').value;
	img = ' :' + img + ': ';
	document.getElementById('mensagem').value = texto + img;
	document.getElementById('mensagem').focus();
	document.getElementById("botenviar").innerHTML = '<a href="#" onClick="VerificaMsg()"><img src="icones/enviar.jpg" width="50" height="50" border="0"></a>';
}

function aba(id){
	//document.getElementById('int1').style.backgroundColor = '#FFFFFF';
	//document.getElementById('int2').style.backgroundColor = '#FFFFFF';
	//document.getElementById('int3').style.backgroundColor = '#FFFFFF';
	//document.getElementById('int' +id).style.backgroundColor = '#CCCCCC';
	document.getElementById('int1').style.backgroundImage = "url('icones/branco.jpg')";
	document.getElementById('int2').style.backgroundImage = "url('icones/branco.jpg')";
	document.getElementById('int3').style.backgroundImage = "url('icones/branco.jpg')";
	document.getElementById('int' +id).style.backgroundImage = "url('icones/fundo.jpg')";
	if(id == 1){
		intsmiles();
	}
	if(id == 2){
		intimagem();
	}
	if(id == 3){
		intcor();
	}
	document.getElementById("mensagem").focus();
}

function intsmiles(){
	var exibe = '';
	exibe += '<table width="221" border="0" cellspacing="1" cellpadding="0"><tr>';
	exibe += '<td width="20"><a href="#" onClick="enviasmile(1)"><img src="smiles/1.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="23"><a href="#" onClick="enviasmile(2)"><img src="smiles/2.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="40"><a href="#" onClick="enviasmile(3)"><img src="smiles/3.gif" width="35" height="20" border="0"></a></td>';
	exibe += '<td width="28"><a href="#" onClick="enviasmile(4)"><img src="smiles/4.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="20"><a href="#" onClick="enviasmile(5)"><img src="smiles/5.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="26"><a href="#" onClick="enviasmile(6)"><img src="smiles/6.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="28"><a href="#" onClick="enviasmile(7)"><img src="smiles/7.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="18"><a href="#" onClick="enviasmile(8)"><img src="smiles/8.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td width="18"><a href="#" onClick="enviasmile(9)"><img src="smiles/9.gif" width="20" height="20" border="0"></a></td>';
	exibe += '</tr><tr> ';
	exibe += '<td><a href="#" onClick="enviasmile(10)"><img src="smiles/10.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(11)"><img src="smiles/11.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(12)"><img src="smiles/12.gif" width="26" height="18"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(13)"><img src="smiles/13.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(14)"><img src="smiles/14.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(15)"><img src="smiles/15.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(16)"><img src="smiles/16.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(17)"><img src="smiles/17.gif" width="20" height="20"  border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(18)"><img src="smiles/18.gif" width="23" height="20"  border="0"></a></td>';
	exibe += '</tr><tr> ';
	exibe += '<td height="28"><a href="#" onClick="enviasmile(19)"><img src="smiles/19.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(20)"><img src="smiles/20.gif" width="20" height="20" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(21)"><img src="smiles/21.gif" width="20" height="27" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(22)"><img src="smiles/22.gif" width="28" height="28" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(23)"><img src="smiles/23.gif" width="20" height="26" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(24)"><img src="smiles/24.gif" width="26" height="23" border="0"></a></td>';
	exibe += '<td colspan="2"><a href="#" onClick="enviasmile(25)"><img src="smiles/25.gif" width="40" height="18" border="0"></a></td>';
	exibe += '<td><a href="#" onClick="enviasmile(26)"><img src="smiles/26.gif" width="20" height="20" border="0"></a></td>';
	exibe += '</tr></table>';
	document.getElementById("interacao").innerHTML = exibe;
}

function intimagem(){
	var reservado = document.getElementById("reservado").value;
	var falacom = document.getElementById("falacom").value;
	var cor = document.getElementById("cor").value;
	
	var exibe = '';
	exibe += '<form name="form1" enctype="multipart/form-data" method="post" action="envia_imagem.php" target="fupload" onSubmit="desabilita()">';
	exibe += '<table width="160" border="0" cellspacing="0" cellpadding="0"><tr><td height="32">';
	exibe += '<input type="file" name="imagem" class="form">';
	exibe += '</td></tr><tr>';
	exibe += '<td align="center"><input type="submit" name="Submit" value="Enviar" class="form">';
	exibe += '<input name="icor" type="hidden"  value="' +cor+ '">';
	exibe += '<input name="ifalacom" type="hidden"  value="' +falacom+ '">';
	exibe += '<input name="ireser" type="hidden"  value="' +reservado+ '">';
	exibe += '</td>';
	exibe += '</tr></table></form>';
	document.getElementById("interacao").innerHTML = exibe;
}

function desabilita(){
	document.form1.Submit.disabled = true;
	document.form1.Submit.value = 'Enviando...';
}

function avisaimg(erro){
	var falacom = document.getElementById("falacom").value;
	if(erro == 1){
		erro = 'Imagem enviada para';
	}
	if(erro == 2){
		erro = 'Falha ao enviar imagem para';
	}
	conteudo += '<div class="separador"><i><font color="#666666">' +erro+ '</font></i> <b>' +falacom+ '</b></div>';
	fler.document.getElementById("mostrar").innerHTML = conteudo;
}

function intcor(){
	var exibe = '';
	exibe += '<table width="210" border="0" cellspacing="1" cellpadding="0"><tr> ';
	exibe += '<td width="18" bgcolor="#000000" onClick="alteracor(1)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#00CC00" onClick="alteracor(2)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#330000" onClick="alteracor(3)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#666600" onClick="alteracor(4)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#660000" onClick="alteracor(5)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#CC0000" onClick="alteracor(6)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#CC6600" onClick="alteracor(7)" >&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#FF0000" onClick="alteracor(8)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#FF3300" onClick="alteracor(9)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#0000FF" onClick="alteracor(10)">&nbsp;</td>';
	exibe += '<td width="18" bgcolor="#003300" onClick="alteracor(11)">&nbsp;</td>';
	exibe += '</tr><tr>';
	exibe += '<td bgcolor="#333333" onClick="alteracor(12)">&nbsp;</td>';
	exibe += '<td bgcolor="#00CC33" onClick="alteracor(13)">&nbsp;</td>';
	exibe += '<td bgcolor="#330033" onClick="alteracor(14)">&nbsp;</td>';
	exibe += '<td bgcolor="#666633" onClick="alteracor(15)">&nbsp;</td>';
	exibe += '<td bgcolor="#660033" onClick="alteracor(16)">&nbsp;</td>';
	exibe += '<td bgcolor="#CC0033" onClick="alteracor(17)">&nbsp;</td>';
	exibe += '<td bgcolor="#CC6633" onClick="alteracor(18)">&nbsp;</td>';
	exibe += '<td bgcolor="#FF0033" onClick="alteracor(19)">&nbsp;</td>';
	exibe += '<td bgcolor="#FF6600" onClick="alteracor(20)">&nbsp;</td>';
	exibe += '<td bgcolor="#0033FF" onClick="alteracor(21)">&nbsp;</td>';
	exibe += '<td bgcolor="#006600" onClick="alteracor(22)">&nbsp;</td>';
	exibe += '</tr><tr> ';
	exibe += '<td bgcolor="#666666" onClick="alteracor(23)">&nbsp;</td>';
	exibe += '<td bgcolor="#00CC66" onClick="alteracor(24)">&nbsp;</td>';
	exibe += '<td bgcolor="#330066" onClick="alteracor(25)">&nbsp;</td>';
	exibe += '<td bgcolor="#666666" onClick="alteracor(26)">&nbsp;</td>';
	exibe += '<td bgcolor="#660066" onClick="alteracor(27)">&nbsp;</td>';
	exibe += '<td bgcolor="#CC0066" onClick="alteracor(28)">&nbsp;</td>';
	exibe += '<td bgcolor="#CC6666" onClick="alteracor(29)">&nbsp;</td>';
	exibe += '<td bgcolor="#FF0066" onClick="alteracor(30)">&nbsp;</td>';
	exibe += '<td bgcolor="#FF9900" onClick="alteracor(31)">&nbsp;</td>';
	exibe += '<td bgcolor="#0066FF" onClick="alteracor(32)">&nbsp;</td>';
	exibe += '<td bgcolor="#009900" onClick="alteracor(33)">&nbsp;</td>';
	exibe += '</tr></table>';
	document.getElementById("interacao").innerHTML = exibe;
}

function alteracor(cor){
	var setacor = '';
	switch(cor){
		case 1: setacor = '#000000'; break;
		case 2: setacor = '#00CC00'; break;
		case 3: setacor = '#330000'; break;
		case 4: setacor = '#666600'; break;
		case 5: setacor = '#660000'; break;
		case 6: setacor = '#CC0000'; break;
		case 7: setacor = '#CC6600'; break;
		case 8: setacor = '#FF0000'; break;
		case 9: setacor = '#FF3300'; break;
		case 10: setacor = '#0000FF'; break;
		case 11: setacor = '#003300'; break;
		case 12: setacor = '#333333'; break;
		case 13: setacor = '#00CC33'; break;
		case 14: setacor = '#330033'; break;
		case 15: setacor = '#666633'; break;
		case 16: setacor = '#660033'; break;
		case 17: setacor = '#CC0033'; break;
		case 18: setacor = '#CC6633'; break;
		case 19: setacor = '#FF0033'; break;
		case 20: setacor = '#FF6600'; break;
		case 21: setacor = '#0033FF'; break;
		case 22: setacor = '#006600'; break;
		case 23: setacor = '#666666'; break;
		case 24: setacor = '#00CC66'; break;
		case 25: setacor = '#330066'; break;
		case 26: setacor = '#666666'; break;
		case 27: setacor = '#660066'; break;
		case 28: setacor = '#CC0066'; break;
		case 29: setacor = '#CC6666'; break;
		case 30: setacor = '#FF0066'; break;
		case 31: setacor = '#FF9900'; break;
		case 32: setacor = '#0066FF'; break;
		case 33: setacor = '#009900'; break;
	}
	var nick = document.getElementById("nick").value;
	document.getElementById("cor").value = setacor;
	document.getElementById("exibenick").innerHTML = '<strong><font color="' +setacor+ '">' +nick+ '</font></strong>';
	document.getElementById("mensagem").focus();
}

function frase(){
	var frase = document.getElementById("frase").value;
	if(frase != 'Volto logo, ausente ou frase pessoal'){
		obj_frase = new montaXMLHTTP();
		obj_frase.open("POST","frase.php",true);
		obj_frase.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		obj_frase.send("frase=" +frase);
	}
}

function sair(){
	document.getElementById("textoload").innerHTML = '<strong>Saindo...</strong><br><br><img src="icones/load.gif" width="100" height="22"><br><br>';
	document.getElementById("load").style.visibility = 'Visible';
	window.top.location.href = 'sair.php';
}
</script>
<style type="text/css">
<!--
.style1 {
	color: #CC0000;
	font-weight: bold;
}
-->
</style>
</head>

<body onLoad="rolar(),inicia(),setTimeout('Ler()',2000);" bgcolor="#FFFFFF">

<div id="load" style="position:absolute; width:100%; height:100%; z-index:auto; left: 0px; top: 0px; visibility: visible;"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="570" bgcolor="#FFFFFF" class="texto11">
    <tr>
      <td align="center" id="textoload"><strong>Carregando, aguarde...</strong><br><br>
        <img src="icones/load.gif" width="100" height="22"><br><br>
       </td>
    </tr>
  </table>
</div>


<div align="center">
<style type="text/css">
<!--
.style1 {color: #999999}
.style2 {color: #333333}
.style3 {color: #333333}
-->
</style>
<div align="center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td height="31" colspan="3" class="borda" align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="2" class="topo">
          <tr>
            <td width="693" height="15" id="exibefrase">&nbsp;<br>			</td>
            <td width="57"><a href="#" title="Sair do Chat" class="style1" onClick="sair()">Sair</a></td>
          </tr>
          <tr>
            <td height="15" colspan="2">
	<!-- SELECT 1 INICIO -->
	  &nbsp;&nbsp;
	  <select name="apoio" onChange="window.open(this.value)" style="background-color:#E0E7E9; border: 1px solid #28849B; font-family:verdana; font-size:9pt">
              <option selected>Favoritos</option>
              <option value="http://cco.call.br">Contra-Cheque</option>
              <option value="#"></option>
              <option value="#"></option>
            </select>
	<!-- SELECT 1 FIM -->				  
	<!-- SELECT 2 INICIO -->			  
			  &nbsp;&nbsp;<select name="estudo" onChange="window.open(this.value)" style="background-color:#E0E7E9; border: 1px solid #28849B; font-family:verdana; font-size:9pt">
              <option selected>Sites parceiros</option>
              <option value="#"></option>
              <option value="#"></option>
              <option value="#"></option>
              <option value="#"></option>
            </select> 
		<!-- SELECT 2 FIM -->		 
						<span class="style5"> Comunicado Interno </span><span class="style6"> | Eletrobras Distribuiçao Alagoas.</span>			</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="10" colspan="3"></td>
    </tr>
    <tr> 
      <td width="98%" height="353" align="center" bgcolor="#FFFFFF" class="chat" onMouseOver="document.getElementById('rolagem').value = 0" onMouseOut="document.getElementById('rolagem').value = 1,rolar()"><iframe src="ler.html" name="fler" width="98%" marginwidth="0" height="352" marginheight="0" scrolling="auto" frameborder="0"></iframe></td>
      <td width="6">&nbsp;</td>
      <td width="167" class="borda" valign="top">
	  <table width="160" border="0" cellspacing="0" cellpadding="0" class="online">
          <tr> 
            <td height="20">&nbsp;Falar com:</td>
          </tr>
          <tr> 
            <td height="283" class="texto11"><iframe src="online.html" name="fonline" width="159" marginwidth="0" height="310" marginheight="0" scrolling="auto" frameborder="0"></iframe></td>
          </tr>
          <tr>
            <td class="texto11" align="center"><hr noshade color="#CCCCCC" size="1" width="90%"></td>
          </tr>
          <tr> 
            <td class="texto11" align="center">&nbsp;Clique no usuario </td>
          </tr>
      </table></td>
    </tr>
    <tr> 
      <td colspan="3" height="10"><iframe src="" name="fupload" width="1" marginwidth="0" height="1" marginheight="0" scrolling="no" frameborder="0">
        
        </iframe><input type="hidden" id="salvafrase" value="Você está falando com Todos."></td>
    </tr>
    <tr> 
      <td height="122" colspan="3" class="inferior" align="center"> 
        <table width="733" border="0" cellpadding="0" cellspacing="1">
          <tr> 
            <td height="46" colspan="2">  
              <table border="0" cellspacing="0" cellpadding="0" class="texto11">
                <tr> 
                  <td width="107" height="26" align="center" id="exibenick"><strong><font color="#006699"><?=$nick;?>
                    </font></strong> </td>
                  <td width="186"> <select name="select" class="form" id="reservado" title="Selecione como deseja interagir com este usuário">
                      <option value="0">Fala com</option>
                      <option value="1">Fala reservadamente com </option>
                  </select></td>
                  <td width="95" id="exibefalacom">Todos </td>
                  <td width="103">&nbsp;<a href="#" title="Sair do Chat" class="style1" onClick="sair()">Sair</a></td>
                </tr>
                <tr> 
                  <td height="20" colspan="3"> &nbsp;Estado:&nbsp;&nbsp; 
                    <select name="select2"  class="form" id="estado" onChange="javascript:setaestado();">
                  <option value="1">Conectado</option>
                  <option value="2">Volto logo</option>
                  <option value="3">Ausente</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;<img src="icones/on.gif" id="imgst">&nbsp;&nbsp;&nbsp;
                    <input type="hidden" id="nick" value="<?=$nick;?>">
                    <input name="hidden" type="hidden" id="cor" value="#006699">
                    <input type="hidden" id="rolagem" value="1">
                    <input type="hidden" id="falacom" value="Todos">
                    &nbsp;&nbsp;
					
Estilo:&nbsp;&nbsp; 
                    <select onChange="window.location = this.options[this.selectedIndex].value" >
                  <option value="" selected="selected">Escolha</option>
                  <option value="principal.php?estilo=estilo.css&acao=mudarestilo">Padrao</option>
                  <option value="principal.php?estilo=vermelho.css&acao=mudarestilo">Vermelho</option>
                        </select>
                    &nbsp;</td>
                </tr>
              </table></td>
            <td width="238" rowspan="2" align="center"> <table width="236" border="0" cellspacing="0" cellpadding="0" class="texto11">
                <tr> 
                  <td width="69" height="17" align="center" bgcolor="#CCCCCC" id="int1" background="icones/fundo.jpg"><a href="#" onClick="aba(1)" title="Exibe smiles">Smiles</a></td>
                  <td width="100" align="center" bgcolor="#FFFFFF" id="int2"><a href="#" onClick="aba(2)" title="Enviar uma imagem">Enviar 
                    imagem</a></td>
                  <td width="67" align="center" bgcolor="#FFFFFF" id="int3"><a href="#" onClick="aba(3)" title="Alterar cor do meu nick">Cor 
                    nick</a></td>
                </tr>
                <tr> 
                  <td height="75" colspan="3" class="borda" align="center" id="interacao"><table width="227" border="0" cellspacing="1" cellpadding="0">
                      <tr> 
                        <td width="20"><a href="#" onClick="enviasmile(1)"><img src="smiles/1.gif" width="20" height="20" border="0"></a></td>
                        <td width="20"><a href="#" onClick="enviasmile(2)"><img src="smiles/2.gif" width="20" height="20" border="0"></a></td>
                        <td width="35"><a href="#" onClick="enviasmile(3)"><img src="smiles/3.gif" width="35" height="20" border="0"></a></td>
                        <td width="28"><a href="#" onClick="enviasmile(4)"><img src="smiles/4.gif" width="20" height="20" border="0"></a></td>
                        <td width="20"><a href="#" onClick="enviasmile(5)"><img src="smiles/5.gif" width="20" height="20" border="0"></a></td>
                        <td width="26"><a href="#" onClick="enviasmile(6)"><img src="smiles/6.gif" width="20" height="20" border="0"></a></td>
                        <td width="23"><a href="#" onClick="enviasmile(7)"><img src="smiles/7.gif" width="20" height="20" border="0"></a></td>
                        <td width="20"><a href="#" onClick="enviasmile(8)"><img src="smiles/8.gif" width="20" height="20" border="0"></a></td>
                        <td width="25"><a href="#" onClick="enviasmile(9)"><img src="smiles/9.gif" width="20" height="20" border="0"></a></td>
                      </tr>
                      <tr> 
                        <td><a href="#" onClick="enviasmile(10)"><img src="smiles/10.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(11)"><img src="smiles/11.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(12)"><img src="smiles/12.gif" width="26" height="18"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(13)"><img src="smiles/13.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(14)"><img src="smiles/14.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(15)"><img src="smiles/15.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(16)"><img src="smiles/16.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(17)"><img src="smiles/17.gif" width="20" height="20"  border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(18)"><img src="smiles/18.gif" width="23" height="20"  border="0"></a></td>
                      </tr>
                      <tr> 
                        <td height="28"><a href="#" onClick="enviasmile(19)"><img src="smiles/19.gif" width="20" height="20" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(20)"><img src="smiles/20.gif" width="20" height="20" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(21)"><img src="smiles/21.gif" width="20" height="27" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(22)"><img src="smiles/22.gif" width="28" height="28" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(23)"><img src="smiles/23.gif" width="20" height="26" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(24)"><img src="smiles/24.gif" width="26" height="23" border="0"></a></td>
                        <td colspan="2"><a href="#" onClick="enviasmile(25)"><img src="smiles/25.gif" width="40" height="18" border="0"></a></td>
                        <td><a href="#" onClick="enviasmile(26)"><img src="smiles/26.gif" width="20" height="20" border="0"></a></td>
                      </tr>
                    </table></td>
                </tr>
            </table></td>
          </tr>
          <tr> 
            <td width="483" height="0"> 
            <textarea name="textarea" cols="85" class="formbranco" rows="3" id="mensagem"  onKeyPress="ContaCaracteres();if (event.keyCode==13){ VerificaMsg();}" onKeyDown="ContaCaracteres();" onKeyUp="ContaCaracteres();" onFocus="ContaCaracteres();" onChange="ContaCaracteres();" title="Digite sua mensagem"></textarea></td>
            <td width="64" align="center" id="botenviar"><img src="icones/enviar_d.jpg" width="50" height="50" align="absmiddle"></td>
          </tr>
          <tr>
            <td height="23" colspan="3" class="texto11">&nbsp;&nbsp;&nbsp;Estado do usu&aacute;rio: <img src="icones/on.gif" alt="Conectado" width="12" height="19" id="imgst"> Conectado <img src="icones/voltoja.gif" alt="Volta logo" name="imgst" width="12" height="19" id="imgst"> Volta logo <img src="icones/ausente.gif" alt="Ausente" name="imgst" width="12" height="19" id="imgst"> Ausente</td>
          </tr>
      </table></td>
    </tr>
</table>
</div>
</body>
</html>
