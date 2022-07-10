<?php require_once('../connect/conexao.php'); ?>
<?php

//Verifica se existe a variável txtnome
if (isset($_GET["txtnome"])) {
    $nome = $_GET["txtnome"];
    
    //Verifica se a variável está vazia
    if (empty($nome)){
        $sql = "SELECT * FROM contato";
    } else {
        $nome .= "%";
        $sql = "SELECT * FROM contato WHERE nome like '$nome'";
    }
    sleep(1);
    $result = mysql_query($sql);
    $cont = mysql_affected_rows($db_boletim);
    //Verifica se a consulta retornou linhas
    if ($cont > 0) {
        //Atribui o código HTML para montar uma tabela
        $tabela = "<table border='1'>
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>CELULAR</th>
                            <th>EMAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>";
        $return = "$tabela";
        //Captura s dados da consulta e inseri na tabela HTML
        while ($linha = mysql_fetch_arry($result)) {
            $return.= "<td>" . utf8_decode($lina["NOME"]) . "</td>";
            $return.= "<td>" . utf8_decode($lina["FONE"]) . "</td>";
            $return.= "<td>" . utf8_decode($lina["CELULAR"]) . "</td>";
            $return.= "<td>" . utf8_decode($lina["EMAIL"]) . "</td>";
            $return.= "</tr>";
        }
        echo $return.="</tbody></table>";
    }else {
        //Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
        echo "Não foram encontrados registros!";
    }
}
?>