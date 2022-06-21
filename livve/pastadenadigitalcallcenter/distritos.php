<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> ddd </title>

 <script src="jquery-1.3.2.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#esc_distrito').change(function(){
                $('#municipio').load('municipio.php?estado='+$('#esc_distrito').val() );
				
            });
        });
		 $(document).ready(function(){
            $('#municipio').change(function(){
           
				$('#distrito').load('distritos_al.php?estado='+$('#esc_distrito').val() );
            });
        });

    </script>
	
</head>

<body>
<p>
  <select name="esc_distrito" class="style46" id="esc_distrito">
    <?php
        mysql_connect('localhost','root','callmaceio2012');
        mysql_selectdb('combobox');

       $result = mysql_query("select * from tb_estados ORDER BY id ASC");

       while($row = mysql_fetch_array($result) ){
            echo "<option value='".$row['id']."'>".$row['nome']."</option>";

       }

    ?>
  </select>
  <span class="style46">
  <select name="municipio" size="1" class="style46" id="municipio" onchange="repete()">
    
  </select>
</p>
</body>
</html>