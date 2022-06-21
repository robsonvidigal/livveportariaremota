    <?php

        $idestado = $_GET['estado'];

        mysql_connect('localhost','root','callmaceio2012');
        mysql_selectdb('combobox');

       $result = mysql_query("SELECT * FROM tb_cidades WHERE estado = ".$idestado);

       while($row = mysql_fetch_array($result) ){
           echo "<option value='".$row['nome']." '>".$row['nome']."</option>";

       }

    ?>