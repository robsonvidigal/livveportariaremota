<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script type="text/javascript">

function valida_envia(){ 
   	//valido o nome 
   	if (document.fvalida.nome.value.length==0){ 
      	alert("Tem que escrever seu nome") 
      	document.fvalida.nome.focus() 
      	return 0; 
   	} 

   	//valido a idade. Tem que ser inteiro maior que 18 
   	edad = document.fvalida.idade.value 
   	edad = validarInteiro(idade) 
   	document.fvalida.idade.value=idade 
   	if (idade==""){ 
      	alert("Tem que introduzir um número inteiro em sua idade.") 
      	document.fvalida.idade.focus() 
      	return 0; 
   	}else{ 
      	if (idade<18){ 
         	alert("Deve ser maior de 18 anos.") 
         	document.fvalida.idade.focus() 
         	return 0; 
      	} 
   	} 

   	//valido o interesse 
   	if (document.fvalida.interesse.selectedIndex==0){ 
      	alert("Deve selecionar um motivo de seu contato.") 
      	document.fvalida.interesse.focus() 
      	return 0; 
   	} 

   	//o formulário se envia 
   	alert("Muito obrigado por enviar o formulário"); 
   	document.fvalida.submit(); 
} 
</script>


</head>
<body>

<form name="fvalida"> 
<table> 
<tr> 
   	<td>Nome: </td> 
   	<td><input type="text" name="nome" size="30" maxlength="100"></td> 
</tr> 
<tr> 
   	<td>Idade: </td> 
   	<td><input type="text" name="idade" size="3" maxlength="2"></td> 
</tr> 
<tr> 
   	<td>Interesse:</td> 
   	<td> 
   	<select name=interesse> 
   	<option value="Escolher">Escolher 
   	<option value="Comercial">Contato comercial 
   	<option value="Clientes">Atenção ao cliente 
   	<option value="Provedores">Contacto de provedores 
   	</select> 
   	</td> 
</tr> 
<tr> 
   	<td colspan="2" align="center"><input type="button" value="Enviar" onclick="valida_envia()"></td> 
</tr> 
</table> 
</form> 

</body>
</html>








