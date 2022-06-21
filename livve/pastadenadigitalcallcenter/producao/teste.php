<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script language="JavaScript">
function repete() {
// o valor do input nome1 será igual ao do nome
document.form.nome1.value=document.form.nome.value;

}
</script>


</head>
<body>
<form name="form">
Dados pessoais:
<br>

<label>
<select name="nome" id="nome" onchange="repete()">
  <option value=""></option>
  <option value="Marcos">Marcos</option>
  <option value="Robson">Robson</option>
</select>
</label>
<br>
email: <input type="text" name="email" value="">
<br>
endereço: <input type="text" name="endereco" value="">
<br>
repetir ( nome e email ) <input type="checkbox" >
<br>
Dados Profissionais:
<br>
nome: <input type="text" name="nome1" value="">
<br>
email: <input type="text" name="email1" value="">
<br>
endereço: <input type="text" name="endereco1" value="">
</form>
</body>
</html>








