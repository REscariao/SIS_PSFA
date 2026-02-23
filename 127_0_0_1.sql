-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 23/02/2026 às 01:34
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

--
-- Despejando dados para a tabela `tabela_ciclos`
--



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

--
-- Despejando dados para a tabela `tabela_cor_circulos`
--

INSERT INTO `tabela_cor_circulos` (`Codigo`, `Circulo`, `Cor`, `Ativo`) VALUES
(1, 'Amarelo', '#FFFF00', 1),
(2, 'Azul', '#0000FF', 1),
(3, 'Vermelho', '#FF0000', 1),
(4, 'Verde', '#008000', 1),
(5, 'Rosa', '#FFC0CB', 1),
(6, 'Laranja', '#FFA500', 1);

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


-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','pastor','supervisor') DEFAULT 'supervisor',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `status`, `created_at`) VALUES
(3, 'Administrador', 'seu-email@igreja.com', '$2y$10$xg3eFCYYmELNIx8gMUp/5.BX6Ib.ozb8P/MQjl8tCWYALxIVChk4m', 'admin', 1, '2026-02-22 02:33:13');

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
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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