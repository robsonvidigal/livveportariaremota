    <?php

        $idestado = $_GET['estado'];

        mysql_connect('localhost','root','callmaceio2012');
        mysql_selectdb('combobox2');

       $result = mysql_query("SELECT * FROM tb_distritos WHERE estado = ".$idestado);

       while($row = mysql_fetch_array($result) ){
           echo "<option style='font-family: verdana, arial, comic sans ms; font-size: 10pt; color: #666666'; value='".$row['nome']." '>".$row['nome']."</option>";

       }

    ?>