-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `db_boletim`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sexo` varchar(9) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `sexo`) VALUES
(1, 'Robson Vidigal', 'teste@email.com', 'Masculino'),
(2, 'Giovana Nair Vieira', 'giovana.nair.vieira@lht.com.br', 'Feminino'),
(3, 'Carolina Caroline Silvana Assis', 'carolina-assis73@engenharia.ufjf.br', 'Feminino'),
(5, 'Nathan Oliver Novaes', 'nathan_novaes@gustavoscoelho.com.br', 'Masculino'),
(6, 'Carlos Lucas Isaac Moreira', 'carlos_moreira@bn.com.br', 'Masculino'),
(7, 'Carlos JoÃ£o Santos', 'carlos_joao_santos@midiasim.com.br', 'Masculino'),
(8, 'Melissa Lorena GalvÃ£o', 'melissa_galvao@msltecnologia.com.br', 'Feminino'),
(9, 'Leandro Francisco Martin Dias', 'leandro_francisco_dias@eptv.com.br', 'Masculino'),
(10, 'Carolina Carolina VitÃ³ria Corte Real', 'carolina.carolina.cortereal@hotmnail.com', 'Feminino'),
(11, 'Valentina TÃ¢nia Laura Lopes', 'valentina.tania.lopes@esctech.com.br', 'Feminino'),
(12, 'Guilherme Caio Ribeiro', 'guilhermecaioribeiro@mega-vale.com', 'Masculino'),
(13, 'Alana LÃ­via AntÃ´nia Castro', 'alana_livia_castro@willianfernandes.com.br', 'Feminino'),
(15, 'FÃ¡bio Theo Lopes', 'fabio.theo.lopes@ipk.org.br', 'Masculino'),
(16, 'Catarina Aurora Gomes', 'catarinaauroragomes@iname.com', 'Feminino'),
(17, 'Manoel Victor Peixoto', 'manoel-peixoto75@homail.com', 'Masculino'),
(24, 'Hugo Hugo Tiago Assis', 'hugo-assis87@asproplastic.com.br', 'Masculino');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
