<?php

/* Chat em ajax X-Chat
   Autor do Chat: Hedi Carlos Minin
   http://www.xlinkweb.com.br

  chat x-chat em ajax versão xq 1.0
  Demonstração e download em: http://guia.xq.com.br/chat2/
  
 */

//classe para conexão com o banco de dados
//Hedi Carlos Minin
class Mysql{
        //em php 5 utiliza-se private ao invés de var
        var $servidor = 'localhost';
        var $banco = 'chat';
        var $usuario = 'root';
        var $senha = 'callmaceio2012';

        var $conexao;
        var $consulta;
        var $resultado;
        var $total_registros = 0;
        //metodo construtor
        function Mysql(){
    }
        //conectar no banco de dados
        function Conecta(){
                $this->conexao = @mysql_connect($this->servidor,$this->usuario,$this->senha); //varaivel link desntro desta classa recebera a conexão
                if(!$this->conexao){
                        echo 'Falha na conexão com o banco de dados<br>';
                        exit();
                }elseif(!mysql_select_db($this->banco,$this->conexao)){
                        echo 'Falha ao selecionar o banco de dados<br>';
                        exit();
                }
        }
        //realizar consulta sql
        function Consulta($query){
                $this->Conecta();
                $this->consulta = $query;
                if($this->resultado = @mysql_query($this->consulta)){
                        $this->Desconecta();
                        return $this->resultado;
                }else{
                        $this->Desconecta();
                        echo 'Erro ao realizar consulta';
                        exit();
                }
        
        }
        //total de registros
        function Totalreg($query){
                $this->total_registros = $this->Consulta($query);
                $this->total_registros = mysql_fetch_array($this->total_registros);
                return $this->total_registros[0];
        }
        //fechar a conexão
        function Desconecta(){
                return mysql_close($this->conexao);
        }
}
?>
