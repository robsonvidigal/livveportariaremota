<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<script>

$(document).ready(function(){
	
	$("#entrar").click(function(){
		
		if ($("#nome").val()==''){
			$("#mensagem").html("Campo obrigatório");
			$("#nome").focus(); // foco no campo
			}else{
				$("#meuform").submit();
		}
	
	});
	
});
</script>


</head>
<body>

<form name="meuform" id="meuform" method="POST" >
Nome: <input type="text" name="nome" id="nome"> 
<input type="button" name="entrar" id="entrar" value="entrar">
<div id="mensagem"></div>
</form>

</body>
</html>








