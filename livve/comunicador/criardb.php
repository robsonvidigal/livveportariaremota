<?php
require('class.mysql.php');
require('config.inc.php');

$sql = new Mysql;

$sql->Consulta("DROP TABLE IF EXISTS $tabela_msg");
$sql->Consulta("CREATE TABLE $tabela_msg(
	id INT AUTO_INCREMENT PRIMARY KEY,
	reservado INT(1) NOT NULL,
	usuario VARCHAR (40) NOT NULL,
	cor VARCHAR (7) NOT NULL,
	msg TEXT NOT NULL,
	falacom VARCHAR (40) NULL,
	tempo VARCHAR(15) NOT NULL)");	

$sql->Consulta("DROP TABLE IF EXISTS $tabela_usu");
$sql->Consulta("CREATE TABLE $tabela_usu(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nick VARCHAR (40) NOT NULL,
	frase VARCHAR (140) NULL,
	cor VARCHAR (7) NOT NULL,
	ip VARCHAR (20) NOT NULL,
	tempo VARCHAR(15) NOT NULL,
	estilo varchar(45) NOT NULL default 'estilo.css')");

?>