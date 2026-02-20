-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 20/02/2026 às 10:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_ecc_santoantonio`
--
CREATE DATABASE IF NOT EXISTS `banco_ecc_santoantonio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `banco_ecc_santoantonio`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcoes_ecc`
--

CREATE TABLE `funcoes_ecc` (
  `id` int(11) NOT NULL,
  `nome_funcao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcoes_ecc`
--

INSERT INTO `funcoes_ecc` (`id`, `nome_funcao`) VALUES
(8, 'Acolhida'),
(4, 'Cafezinho e Minimercado'),
(11, 'Círculos'),
(3, 'Compras'),
(1, 'Coordenador Geral'),
(7, 'Cozinha'),
(9, 'Liturgia e Vigília'),
(5, 'Ordem e Limpeza'),
(2, 'Sala'),
(6, 'Secretaria'),
(10, 'Visitação');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_ciclos`
--

CREATE TABLE `tabela_ciclos` (
  `cod_encontro` int(11) DEFAULT NULL,
  `cod_circulo` int(11) DEFAULT NULL,
  `cod_membro` int(11) DEFAULT NULL,
  `coordenador` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_cor_circulos`
--

CREATE TABLE `tabela_cor_circulos` (
  `Codigo` int(11) NOT NULL,
  `Circulo` varchar(50) DEFAULT NULL,
  `Cor` varchar(20) DEFAULT NULL,
  `Ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_encontristas`
--

CREATE TABLE `tabela_encontristas` (
  `Codigo` int(11) NOT NULL,
  `Etapa` int(11) DEFAULT 1,
  `Cod_Membros` int(11) DEFAULT NULL,
  `Cod_Encontro` int(11) DEFAULT NULL,
  `Cod_Circulo` int(11) DEFAULT NULL,
  `Imprimir` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_encontros`
--

CREATE TABLE `tabela_encontros` (
  `codigo` int(11) NOT NULL,
  `etapa` int(11) DEFAULT 1,
  `encontro` varchar(100) DEFAULT NULL,
  `periodo` varchar(100) DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `ano_evento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela_encontros`
--

INSERT INTO `tabela_encontros` (`codigo`, `etapa`, `encontro`, `periodo`, `tema`, `observacao`, `ano_evento`) VALUES
(1, 1, 'I - Encontro de Casais com Cristo', '24, 25 e 26 de Abril de 2026', 'Paróquia de São Francisco de Assis', 'Testes', 0),
(2, 1, NULL, 'Março/2025', 'XIX Encontro de Casais', NULL, 2025),
(3, 1, NULL, 'Outubro/2025', 'XX Encontro de Casais', NULL, 2025),
(4, 1, NULL, 'Maio/2026', 'XXI Encontro de Casais', NULL, 2026),
(5, 1, NULL, 'Novembro/2026', 'XXII Encontro de Casais', NULL, 2026),
(6, 1, NULL, 'Abril/2027', 'XXIII Encontro de Casais', NULL, 2027),
(7, 1, NULL, 'Setembro/2027', 'XXIV Encontro de Casais', NULL, 2027),
(8, 1, NULL, 'Março/2028', 'XXV Encontro de Casais', NULL, 2028),
(9, 1, NULL, 'Agosto/2028', 'XXVI Encontro de Casais', NULL, 2028);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_equipes_trabalho`
--

CREATE TABLE `tabela_equipes_trabalho` (
  `Cod_Encontro` int(11) NOT NULL,
  `Cod_Membros` int(11) NOT NULL,
  `Equipe` varchar(100) NOT NULL,
  `Funcao` varchar(100) DEFAULT NULL,
  `Imprimir` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela_equipes_trabalho`
--

INSERT INTO `tabela_equipes_trabalho` (`Cod_Encontro`, `Cod_Membros`, `Equipe`, `Funcao`, `Imprimir`) VALUES
(1, 1, 'Cozinha', 'Membro', 1),
(1, 55, 'Cafezinho e Minimercado', 'Coordenador', 1),
(1, 56, 'Coordenador Geral', 'Coordenador', 1),
(2, 1, 'Cozinha', 'Coordenador', 1),
(3, 1, 'Coordenador Geral', 'Coordenador', 1),
(3, 2, 'Secretaria', 'Coordenador', 1),
(3, 3, 'Acolhida', 'Membro', 1),
(3, 4, 'Cozinha', 'Membro', 1),
(4, 1, 'Liturgia e Vigília', 'Membro', 1),
(4, 2, 'Cozinha', 'Membro', 1),
(4, 3, 'Cozinha', 'Coordenador', 1),
(5, 1, 'Liturgia e Vigília', 'Coordenador', 1),
(5, 2, 'Acolhida', 'Coordenador', 1),
(6, 1, 'Compras', 'Membro', 1),
(6, 4, 'Secretaria', 'Membro', 1),
(7, 1, 'Compras', 'Coordenador', 1),
(7, 2, 'Sala', 'Coordenador', 1),
(8, 1, 'Coordenador Geral', 'Coordenador', 1),
(8, 3, 'Montagem/Som', 'Coordenador', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_membros`
--

CREATE TABLE `tabela_membros` (
  `codigo` int(11) NOT NULL,
  `ele` varchar(100) DEFAULT NULL,
  `apelido_dele` varchar(50) DEFAULT NULL,
  `foto_ele` varchar(255) DEFAULT NULL,
  `nascimento_dele` date DEFAULT NULL,
  `ela` varchar(100) DEFAULT NULL,
  `apelido_dela` varchar(50) DEFAULT NULL,
  `foto_ela` varchar(255) DEFAULT NULL,
  `nascimento_dela` date DEFAULT NULL,
  `casamento` date DEFAULT NULL,
  `ano_ECC` varchar(100) DEFAULT NULL,
  `pastoral` varchar(100) DEFAULT NULL,
  `paroquia` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modalidade` varchar(50) DEFAULT NULL,
  `end_rua` varchar(255) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT 'PB',
  `fone` varchar(20) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `correspondencia` tinyint(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela_membros`
--

INSERT INTO `tabela_membros` (`codigo`, `ele`, `apelido_dele`, `foto_ele`, `nascimento_dele`, `ela`, `apelido_dela`, `foto_ela`, `nascimento_dela`, `casamento`, `ano_ECC`, `pastoral`, `paroquia`, `modalidade`, `end_rua`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `fone`, `ativo`, `correspondencia`, `email`, `status`) VALUES
(1, 'Erlon Crispim Xavier', 'Nego Erlon', NULL, NULL, 'Maria Alexsandra de Souza Crispim', 'Sandra', NULL, NULL, NULL, '12 ECC ano 2003', 'Pastoral Família', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(2, 'Alan Morais Ribeiro', 'Alan', NULL, NULL, 'Maria Istefane Paulo Marques', 'Istefane', NULL, NULL, NULL, '2017', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(3, 'Alexsandro Lacerda de Caldas', 'Sande', NULL, NULL, 'Lidia Nara Gusmão de Moura Lacerda Caldas', 'Nara', NULL, NULL, NULL, '16ª 2007', 'Pastoral Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(4, 'Amarildo Cabral Leite', 'Lobão', NULL, NULL, 'Arisangela Araújo Nóbrega Leite', NULL, NULL, NULL, NULL, 'XXIV 2015 Azul', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(5, 'Antonio Carvalho Leite', 'Toinho', NULL, NULL, 'Luzia Henrique de Almeida Carvalho', 'Luzia', NULL, NULL, NULL, '2 a 4 de Setembro 2011', 'Pastoral da Criança e Batismo', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(6, 'Arcelino de Brito Costa', 'Arcelino', NULL, NULL, 'Alanna Delanny Morais Ribeiro', 'Alanna', NULL, NULL, NULL, 'XXII 2013', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(7, 'Argemiro Oliveira dos Santos Filho', 'Argemiro', NULL, NULL, 'Jorvania Pereira Alves Oliveira', 'Vaninha', NULL, NULL, NULL, 'XIII 2009', 'Familiar e Batismo', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(8, 'Damião Mamede Leite', 'Damião', NULL, NULL, 'Luciana Cavalcante Porto Leite', 'Luciana', NULL, NULL, NULL, '2012', 'Som dízimo, catequese', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(9, 'Danilo Pereira Dias', 'Danilo', NULL, NULL, 'Rafaela Marinho de Figueiredo', 'Rafaela', NULL, NULL, NULL, '2009', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(10, 'Emerson Leandro Rodrigues', 'Mecinho', NULL, NULL, 'Erta Soraya Ribeiro César Rodrigues', NULL, NULL, NULL, NULL, '25-2017', 'Pastoral Familiar e Liturgia', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(11, 'Eudes Ferreira de Melo', 'Eudes', NULL, NULL, 'Elaine Katia Fernandes dos Santos', 'Katia', NULL, NULL, NULL, 'XIX', 'Pastoral Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(12, 'Eudo Passos de Almeida Filho', 'Eudo', NULL, NULL, 'Camila de Caldas Nascimento Almeida', 'Camila', NULL, NULL, NULL, '1ª Etapa 2015 / 2ª Etapa 2018', 'Dízimo', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(13, 'Evaldo Medeiros da Costa', 'Evaldo', NULL, NULL, 'Miranir Brilhante da Silva', 'Miranir', NULL, NULL, NULL, '2011', 'Pastoral do dízimo, liturgia', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(14, 'Eliezer dos Santos Moreira', 'Flávia', NULL, NULL, 'Flávia Soares Carneiro', 'Flavia', NULL, NULL, NULL, 'Primeira', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(15, 'Francineudo Medeiros da Costa', 'Leudo', NULL, NULL, 'Maria José Rodrigues Alves Medeiros', 'Maria', NULL, NULL, NULL, 'XXV 2016', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(16, 'GILBERTO CARLOS DE LIMA CABRAL', 'CABRAL', NULL, NULL, 'EDIJANE MOREIRA DOS SANTOS CABRAL', 'EDIJANE', NULL, NULL, NULL, 'XXV ano 2016', 'BATISMO e DIZIMO', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(17, 'Giordanny Venancio Ribeiro de Paula', NULL, NULL, NULL, 'Gabriela de Oliveira Figueiredo Leitão Venancio', 'Bela', NULL, NULL, NULL, '2018', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(18, 'Henrique José de Araujo Trindade', 'Henrique', NULL, NULL, 'Kallyanny Kelly de Souza Trindade', 'kallyanny', NULL, NULL, NULL, '2006', 'Pastoral Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(19, 'Henrique José de Carvalho Gomes', NULL, NULL, NULL, 'Fabiana Martins Laurindo', NULL, NULL, NULL, NULL, 'Número 31 Ano 2024', 'Apostolado da Oração', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(20, 'Jefferson Alexandre Batista de Oliveira', 'Negão', NULL, NULL, 'Abelania da Silva Medeiros de Oliveira', 'Bebe', NULL, NULL, NULL, 'Primeira', 'Família', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(21, 'Joabson Gomes de Araújo', 'Joabson', NULL, NULL, 'Tássia Rangel Soares Costa Freire de Araújo', 'Tássia', NULL, NULL, NULL, '1', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(22, 'Jorge Luiz Damasceno Morato', 'Jorge', NULL, NULL, 'Nayra Carla Maia Cunha Damasceno', 'Nayra', NULL, NULL, NULL, '2019', 'Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(23, 'José Airson Alves', 'NINO', NULL, NULL, 'Arinalba Vieira de Sousa Alves', 'NALBA', NULL, NULL, NULL, 'XIX-2010', 'Pastoral da Esperança e Liturgia', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(24, 'José Garibalde Fernandes Botelho', 'Garibalde', NULL, NULL, 'Maria Tânia Paz de Sousa Botelho', 'Tania', NULL, NULL, NULL, '7º ENCONTRO', 'Pastoral da Família', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(25, 'José Gilvan de Araujo', 'Gilvan', NULL, NULL, 'Marleide Macedo de Araújo', 'Lêda', NULL, NULL, NULL, '9 encontro, 2000', 'Pastoral familiar, batismo, liturgia', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(26, 'Jose ineil ferreira da silva', 'Neil', NULL, NULL, 'Erileide Araújo Lima', 'Linda', NULL, NULL, NULL, '2017', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(27, 'José Ribamar Coura Neto', 'José', NULL, NULL, 'Tuanny Lopes Alves Silvestre Coura', 'Tuanny', NULL, NULL, NULL, '2023', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(28, 'Juscelino Trigueiro Bezerra', 'Celino', NULL, NULL, 'Alexsandra Lacerda de Caldas Trigueiro', NULL, NULL, NULL, NULL, 'XXI', 'Catequese e Terço dos Homens', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(29, 'Kadmu Alves Camboim', 'Kadmu', NULL, NULL, 'Maria das Graças Ferreira de Menezes', 'Gracinha', NULL, NULL, NULL, '26/2017', 'Pastoral Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(30, 'Lindemberg Bezerra de Sousa', 'Bergão', NULL, NULL, 'Josimeiry Santana Alves', 'Josy', NULL, NULL, NULL, '1 2018', 'Família', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(31, 'Manoel Pereira de Araujo Junior', 'Junior', NULL, NULL, 'Sheyla Rangel Israel de Araujo', 'Sheyla', NULL, NULL, NULL, '18', 'Familiar', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(32, 'Paulo Gomes Pereira', 'Paulinho', NULL, NULL, 'Raissa Diniz Freire', NULL, NULL, NULL, NULL, 'No ano de 2019', NULL, NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(33, 'Rodrigo Barbalho', 'Rodrigo', NULL, '1988-04-16', 'Maria Alcione Mota Pereira Escariao', 'Alcione', NULL, '1984-05-25', '2012-11-22', '2015', 'Batismo', 'Paróquia São Francisco de Assis', 'Desmembramento', 'Rua Antônio Praxedes dos santos', '24', NULL, 'Maternidade', NULL, 'PB', '83 98674-5489 | 83 9', 1, NULL, 'barbalho315@gmail.com', NULL),
(34, 'Romério', 'Romério', NULL, NULL, 'Valdriana', 'Aninha', NULL, NULL, NULL, '5 Encontro', 'Batismo', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(35, 'Thiago Carneiro de Lira', 'Thiago', NULL, NULL, 'Fernanda Soares Cordeiro Carneiro', 'Fernanda', NULL, NULL, NULL, '20 2011', 'Ecc, família e dízimo', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(36, 'Vandoberto Simões Ribeiro Júnior', 'Júnior', NULL, NULL, 'Gislaine Suelen Lucena Silva', 'Gislaine', NULL, NULL, NULL, '2013', 'Canto', NULL, 'Desmembramento', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(37, 'João Carlos Lucena de Medeiros', 'João Carlos', NULL, NULL, 'Euzinete Alves de Sousa Medeiros', 'Euzinete', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(38, 'Inaldo da Silva Santos', 'Banainha', NULL, NULL, 'Francilaure Nobrega Sousa', 'Fran', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(39, 'Onaldo Rodrigues Soares', 'Onaldo', NULL, NULL, 'Edna Lucia Batista Leite', 'Edna', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(40, 'Valdelano de Sousa Nobre', 'Lano', NULL, NULL, 'Maria da Conceição de Oliveira Sousa', 'Ceiça', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(41, 'Thiago da Silva Gomes', 'Thiago', NULL, NULL, 'Tamires de Sousa Nunes Gomes', 'Tamires', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(42, 'Irajá Alves Monteiro', 'Iraja', NULL, NULL, 'Gabriella Mendes da Silva Campos Monteiro', 'Gabriella', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(43, 'Fabio Junior Francisco da Silva', 'Fabio Junior', NULL, NULL, 'Ianne Raquel da Silva Araujo', 'Raquel', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(44, 'Marcos Antonio Guerra Junior', 'Marquinhos', NULL, NULL, 'Daniela Maria Trindade da Silva Gerra', 'Danny', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(45, 'Jose Carlos Benvenutti Junior', NULL, NULL, NULL, 'Cristiana Barbosa Bevenutti', 'Cristiana', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, 'João Pessoa', 'PB', NULL, 1, NULL, NULL, NULL),
(46, 'André Lopes Lima', 'André', NULL, NULL, 'Maria Rosalva Furtado Neto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(47, 'Marcos Antonio Estrela', 'Marcos', NULL, NULL, 'Mislainy de Caldas Batista', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(48, 'Fabiano de Caldas Batista', 'Fabiano', NULL, NULL, 'Mona Lisa Lopes Santos Caldas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(49, 'Ermano Roncalli d de Oliveira', 'Emano', NULL, NULL, 'Maria Sorlane Lucena de Oliveira', 'Sorlane', NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(50, 'Adigley Janio Mendes', NULL, NULL, NULL, 'Ryanne Diniz Mamede', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(51, 'Julio Cesar Fernandes de Freitas', 'Julio', NULL, NULL, 'Iohannah Almeida de Freitas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(52, 'Pedro Roberto de Matos Pereira', 'Pedro', NULL, NULL, 'Milene Sarmento M de Matos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(53, 'Helleno de Sousa Ó Netto', NULL, NULL, NULL, 'Jaqueline Oliveira do Ó', NULL, NULL, NULL, NULL, '2015', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(54, 'Jair Junior', NULL, NULL, NULL, 'Julia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, 'Mosoro', 'PB', NULL, 1, NULL, NULL, NULL),
(55, 'Emerson Medeiros Menesses', 'Merson', NULL, NULL, 'Monica Cosme Ribeiro Souza', NULL, NULL, NULL, NULL, '2022', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(56, 'Ariosvaldo Lucena de Sousa Junior', 'BH', NULL, NULL, 'Izabelle Cristinne F de O Doia', NULL, NULL, NULL, NULL, '2008', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(57, 'Roberto Nicacio Leite Segundo', 'Segundo', NULL, NULL, 'Amanda Leite Felix', NULL, NULL, NULL, NULL, '2017', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(58, 'Dário Leitão Nunes', 'Dário', NULL, NULL, 'Maria do Socorro Sousa dos S. L. Nunes', NULL, NULL, NULL, NULL, '1998', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(59, 'Francisco de Assis Martins de Barros', 'Chico', NULL, NULL, 'Celiete Dantas Batista', NULL, NULL, NULL, NULL, '2008', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(60, 'José Adriano da Silva Tenorio', 'Adriano', NULL, NULL, 'Andreza da Gama Silva Tenorio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, 'Matureia', 'PB', '83981863127', 1, NULL, NULL, NULL),
(61, 'Pedro Cordeiro de Lira Neto', 'Pedro', NULL, NULL, 'Vitória Maria Vieira Rocha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(62, 'Wendell Marinho Henrique', 'Pequeno', NULL, NULL, 'Dannuza Lucena Viana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(63, 'João Lopes de Sousa Neto', 'João', NULL, NULL, 'Fabiana Casusa de Oliveira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(64, 'Semião Oliveira de Medeiros', NULL, NULL, NULL, 'Maria de Fátima Porfírio de Medeiros', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(65, 'Maria do Socorro da Costa Meira', NULL, NULL, NULL, 'José de Assis Mendes Meira Junior', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(66, 'Rogério Lacerda Estrela Alves', NULL, NULL, NULL, 'Glaúcia Maria D. da Silva Estrela', NULL, NULL, NULL, NULL, '2011', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(67, 'Walber barreto martins da Nóbrega', 'Walber', NULL, NULL, 'Layse Júlia Abílio Diniz Melquiades de Medeiros Martins', NULL, NULL, NULL, NULL, '2016', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(68, 'Euclides Pereira de Souza', NULL, NULL, NULL, 'Maria do Socorro dos Santos Pereira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(69, 'Pablo Trindade', NULL, NULL, NULL, 'Nayse Cleia Maia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, 'João Pessoa', 'PB', NULL, 1, NULL, NULL, NULL),
(70, 'Pedro Batista dos Santos', NULL, NULL, NULL, 'Maria Daguia Simões', NULL, NULL, NULL, NULL, '2017', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(71, 'Vinicius Batista Braga', NULL, NULL, NULL, 'Maria da Conceição Ferreira da Silva', NULL, NULL, NULL, NULL, '2024', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(72, 'Maria da Conceição Ferreira da Silva', NULL, NULL, NULL, 'Thayza Kelly Medeiros Firmino Almeida', NULL, NULL, NULL, NULL, '2018', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(73, 'ALLEX FABIAN MORAIS RIBEIRO', NULL, NULL, NULL, 'ALENE RUBIA DA COSTA SILVA RIBEIRO', NULL, NULL, NULL, NULL, '2011', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(74, 'Estevão Bruno de Sousa Araújo', NULL, NULL, NULL, 'Anna Walleria Machado Fernandes', NULL, NULL, NULL, NULL, '2011', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(75, 'Marcelo Justino de Medeiros', 'Marcelo', NULL, NULL, 'Ethyenne Almeida de A. Medeiros', NULL, NULL, NULL, NULL, '2012', NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(76, 'Jos Claudio', NULL, NULL, NULL, 'Raphaela Oliveira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(77, 'Stanislau', NULL, NULL, NULL, 'Elaine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(78, 'Carlos', NULL, NULL, NULL, 'Monica', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tranferencia', NULL, NULL, NULL, NULL, NULL, 'PB', NULL, 1, NULL, NULL, NULL),
(79, 'João Silva', NULL, NULL, NULL, 'Maria Silva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Centro', NULL, 'PB', '(83) 99999-1111', 1, NULL, NULL, NULL),
(80, 'Carlos Oliveira', NULL, NULL, NULL, 'Ana Oliveira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Belo Horizonte', NULL, 'PB', '(83) 99999-2222', 1, NULL, NULL, NULL),
(81, 'Ricardo Santos', NULL, NULL, NULL, 'Beatriz Santos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jardim Queiroz', NULL, 'PB', '(83) 99999-3333', 1, NULL, NULL, NULL),
(82, 'Paulo Souza', NULL, NULL, NULL, 'Fernanda Souza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Noé Trajano', NULL, 'PB', '(83) 99999-4444', 1, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcoes_ecc`
--
ALTER TABLE `funcoes_ecc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_funcao` (`nome_funcao`);

--
-- Índices de tabela `tabela_ciclos`
--
ALTER TABLE `tabela_ciclos`
  ADD KEY `fk_membro_ciclo` (`cod_membro`);

--
-- Índices de tabela `tabela_cor_circulos`
--
ALTER TABLE `tabela_cor_circulos`
  ADD PRIMARY KEY (`Codigo`);

--
-- Índices de tabela `tabela_encontristas`
--
ALTER TABLE `tabela_encontristas`
  ADD PRIMARY KEY (`Codigo`),
  ADD KEY `Cod_Membros` (`Cod_Membros`),
  ADD KEY `Cod_Encontro` (`Cod_Encontro`);

--
-- Índices de tabela `tabela_encontros`
--
ALTER TABLE `tabela_encontros`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `tabela_equipes_trabalho`
--
ALTER TABLE `tabela_equipes_trabalho`
  ADD PRIMARY KEY (`Cod_Encontro`,`Cod_Membros`,`Equipe`),
  ADD KEY `Cod_Membros` (`Cod_Membros`);

--
-- Índices de tabela `tabela_membros`
--
ALTER TABLE `tabela_membros`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcoes_ecc`
--
ALTER TABLE `funcoes_ecc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tabela_cor_circulos`
--
ALTER TABLE `tabela_cor_circulos`
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabela_encontristas`
--
ALTER TABLE `tabela_encontristas`
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabela_encontros`
--
ALTER TABLE `tabela_encontros`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tabela_membros`
--
ALTER TABLE `tabela_membros`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tabela_ciclos`
--
ALTER TABLE `tabela_ciclos`
  ADD CONSTRAINT `fk_membro_ciclo` FOREIGN KEY (`cod_membro`) REFERENCES `tabela_membros` (`Codigo`);

--
-- Restrições para tabelas `tabela_encontristas`
--
ALTER TABLE `tabela_encontristas`
  ADD CONSTRAINT `tabela_encontristas_ibfk_1` FOREIGN KEY (`Cod_Membros`) REFERENCES `tabela_membros` (`Codigo`),
  ADD CONSTRAINT `tabela_encontristas_ibfk_2` FOREIGN KEY (`Cod_Encontro`) REFERENCES `tabela_encontros` (`Codigo`);

--
-- Restrições para tabelas `tabela_equipes_trabalho`
--
ALTER TABLE `tabela_equipes_trabalho`
  ADD CONSTRAINT `tabela_equipes_trabalho_ibfk_1` FOREIGN KEY (`Cod_Encontro`) REFERENCES `tabela_encontros` (`Codigo`),
  ADD CONSTRAINT `tabela_equipes_trabalho_ibfk_2` FOREIGN KEY (`Cod_Membros`) REFERENCES `tabela_membros` (`Codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;