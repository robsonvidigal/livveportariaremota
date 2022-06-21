<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Exemplo de ComboBox com AJAX- JQuery</title>

    <script src="jquery-1.3.2.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#estados').change(function(){
                $('#cidades').load('cidades.php?estado='+$('#estados').val() );

            });
        });

    </script>
</head>

<body>

<select name="estados" id="estados">
    <?php
        mysql_connect('localhost','root','callmaceio2012');
        mysql_selectdb('combobox');

       $result = mysql_query("select * from tb_estados ORDER BY id ASC");

       while($row = mysql_fetch_array($result) ){
            echo "<option value='".$row['id']."'>".$row['nome']."</option>";

       }

    ?>
</select>


<select name="cidades" id="cidades">
    <option value="0">Escolha um estado</option>
</select>




</body>

</html>
