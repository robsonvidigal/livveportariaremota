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
  `profissao` varchar(40) NOT NULL,
  `h_registro` varchar(9) NOT NULL,
  `d_registro` varchar(11) NOT NULL,
  `ip_registro` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `sexo`, `profissao`, `h_registro`, `d_registro`, `ip_registro`) VALUES
(1, 'Robson Vidigal', 'teste@email.com', 'Masculino', 'Estudante PHP', '00:00:00', '0000-00-00', '0'),
(2, 'Giovana Nair Vieira', 'giovana.nair.vieira@lht.com.br', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(3, 'Carolina Caroline Silvana Assis', 'carolina-assis73@engenharia.ufjf.br', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(5, 'Nathan Oliver Novaes', 'nathan_novaes@gustavoscoelho.com.br', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(6, 'Carlos Lucas Isaac Moreira', 'carlos_moreira@bn.com.br', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(7, 'Carlos JoÃ£o Santos', 'carlos_joao_santos@midiasim.com.br', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(8, 'Melissa Lorena GalvÃ£o', 'melissa_galvao@msltecnologia.com.br', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(9, 'Leandro Francisco Martin Dias', 'leandro_francisco_dias@eptv.com.br', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(10, 'Carolina Carolina VitÃ³ria Corte Real', 'carolina.carolina.cortereal@hotmnail.com', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(11, 'Valentina TÃ¢nia Laura Lopes', 'valentina.tania.lopes@esctech.com.br', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(12, 'Guilherme Caio Ribeiro', 'guilhermecaioribeiro@mega-vale.com', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(13, 'Alana LÃ­via AntÃ´nia Castro', 'alana_livia_castro@willianfernandes.com.br', 'Feminino', '', '00:00:00', '0000-00-00', '0'),
(15, 'FÃ¡bio Theo Lopes', 'fabio.theo.lopes@ipk.org.br', 'Masculino', 'Analista', '00:00:00', '0000-00-00', '0'),
(16, 'Catarina Aurora Gomes', 'catarinaauroragomes@iname.com', 'Feminino', 'Estudante ASP', '00:00:00', '0000-00-00', '0'),
(17, 'Manoel Victor Peixoto', 'manoel-peixoto75@homail.com', 'Masculino', 'Motorista B', '00:00:00', '0000-00-00', '0'),
(24, 'Hugo Hugo Tiago Assis', 'hugo-assis87@asproplastic.com.br', 'Masculino', 'Encanador', '00:00:00', '0000-00-00', '0'),
(25, 'PatrÃ­cia Liz Luna das Neves', 'patricia_dasneves@prositeweb.com.br', 'Feminino', 'Encanadora', '00:00:00', '0000-00-00', '0'),
(26, 'ClÃ¡udia Luiza de Paula', 'claudia.luiza.depaula@viavaleseguros.com.br', 'Feminino', 'Motorista AB', '00:00:00', '0000-00-00', '0'),
(27, 'MÃ¡rcio Caleb Noah Nogueira', 'marcio-nogueira76@htmail.com', 'Masculino', 'Aux. Administrativo', '00:00:00', '0000-00-00', '0'),
(28, 'Rodrigo Henrique Barbosa', 'rodrigo-barbosa84@transtelli.com.br', 'Masculino', '', '00:00:00', '0000-00-00', '0'),
(29, 'Augusto Igor Mateus da Rocha', 'augusto-darocha86@hotmail.co.jp', 'Masculino', 'Motorista AB', '00:00:00', '0000-00-00', '0'),
(30, 'Mateus Manuel Kaique Lima', 'mateus.manuel.lima@dafitex.com.br', 'Masculino', 'Arquiteto', '00:00:00', '0000-00-00', '0'),
(31, 'Vera Mariane Isabela da Mota', 'veramarianedamota@deca.com.br', 'Feminino', 'Vendedora', '00:00:00', '0000-00-00', '0'),
(32, 'Kevin Arthur Yago Fernandes', 'kevinarthurfernandes@br.com.br', 'Masculino', 'Vendedor', '00:00:00', '0000-00-00', '0'),
(34, 'Sandra Daiane Esther dos Santos', 'sandra_daiane_dossantos@jammer.com.br', 'Feminino', 'Aux. Administrativa', '00:00:00', '0000-00-00', '0'),
(35, 'Luiz Gustavo GalvÃ£o', 'luiz-galvao90@aulicinobastos.com.br', 'Masculino', 'Gerente', '00:00:00', '0000-00-00', '0'),
(36, 'Anderson Lorenzo GalvÃ£o', 'anderson.lorenzo.galvao@flexvale.com.br', 'Masculino', 'Vendedor', '00:00:00', '0000-00-00', '0'),
(37, 'AntÃ´nia Laura Fernandes', 'antonia.laura.fernandes@ladder.com.br', 'Feminino', 'Supervisora', '00:00:00', '0000-00-00', '0'),
(38, 'LetÃ­cia Aline Martins', 'leticiaalinemartins@rotadasbandeiras.com.br', 'Feminino', 'Vendedora', '00:00:00', '0000-00-00', '0'),
(39, 'Luiz Gustavo Moraes', 'luiz-moraes93@hotmail.de', 'Masculino', 'Motorista D', '19:29:00', '0000-00-00', '0'),
(40, 'Camila Olivia Marina Ribeiro', 'camila_ribeiro@prifree.fr', 'Feminino', 'Contadora', '19:29:52', '0000-00-00', '0'),
(41, 'Nilma Macario dos Santos', 'teste@teste.com', 'Feminina', 'Aux. Administrativo', '20:36:47', '0000-00-00', '0'),
(42, 'Bryan Heitor Leonardo Drumond', 'bryan-drumond83@dyna.com.br', 'Masculino', 'Gerente de Vendas', '00:00:00', '0000-00-00', '0'),
(43, 'FÃ¡bio Lorenzo Vicente Vieira', 'fabio.lorenzo.vieira@yahoo.fr', 'Masculino', 'Vendedor', '00:00:00', '0000-00-00', '0'),
(44, 'Emily Raquel Martins', 'emily_raquel_martins@soluxenergiasolar.com.br', 'Feminino', 'CobranÃ§a', '00:00:00', '0000-00-00', '0'),
(45, 'Helena Sophie Jennifer Farias', 'helenasophiefarias@coraza.com.br', 'Feminino', 'SecretÃ¡ria', '', '', '0'),
(46, 'Camila Olivia da Mata', 'camilaoliviadamata@terrabrasil.com.br', 'Feminino', 'Estagiaria', '', '', '0'),
(47, 'Jennifer Rosa Regina Bernardes', 'jennifer_bernardes@thibe.com.br', 'Feminino', 'Estagiaria', '10:21:10', '', '0'),
(48, 'Anthony Danilo Bernardo Sales', 'anthonydanilosales@lojabichopapao.com.br', 'Masculino', 'Estagiario', '10:22:51', '17/07/2022', '0'),
(49, 'Yago Benedito Emanuel Lopes', 'yagobeneditolopes@gmx.de', 'Masculino', 'Estagiario', '10:30:25', '17/07/2022', '0'),
(50, 'Brenda Isabella Bernardes', 'brendaisabellabernardes@abareias.com.br', 'Feminino', 'Motorista C', '10:39:52', '17/07/2022', '0'),
(51, 'OtÃ¡vio Elias Nascimento', 'otavioeliasnascimento@msn.com', 'Masculino', 'Estagiario', '11:56:31', '17/07/2022', '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
