-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 24-Jul-2019 às 19:29
-- Versão do servidor: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_itep`
--
CREATE DATABASE IF NOT EXISTS `sistema_itep` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sistema_itep`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fichas_tb`
--

CREATE TABLE `fichas_tb` (
  `ficha_id` bigint(20) NOT NULL,
  `ficha_nome` text NOT NULL,
  `ficha_telefone` text NOT NULL,
  `ficha_setor_id` bigint(20) NOT NULL,
  `ficha_status` text NOT NULL,
  `ficha_data` datetime NOT NULL,
  `ficha_preferencial` tinyint(1) NOT NULL,
  `ficha_encaminhado_setor_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs_tb`
--

CREATE TABLE `logs_tb` (
  `log_id` bigint(20) NOT NULL,
  `log_data` datetime NOT NULL,
  `log_div` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mails_tb`
--

CREATE TABLE `mails_tb` (
  `mail_id` bigint(20) NOT NULL,
  `mail_assunto` text NOT NULL,
  `mail_de_usuario_id` bigint(20) NOT NULL,
  `mail_para_setor_id` bigint(20) NOT NULL,
  `mail_conteudo` longtext NOT NULL,
  `mail_status_caixa_entrada` tinyint(1) NOT NULL,
  `mail_status_caixa_saida` tinyint(1) NOT NULL,
  `mail_data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `painel_tb`
--

CREATE TABLE `painel_tb` (
  `painel_id` bigint(20) NOT NULL,
  `painel_senha` text NOT NULL,
  `painel_nome` text NOT NULL,
  `painel_sala` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `painel_tb`
--

INSERT INTO `painel_tb` (`painel_id`, `painel_senha`, `painel_nome`, `painel_sala`) VALUES
(1, '0', 'NULL', 'NULL'),
(2, '0', 'NULL', 'NULL'),
(3, '0', 'NULL', 'NULL'),
(4, '0', 'NULL', 'NULL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores_tb`
--

CREATE TABLE `setores_tb` (
  `setor_id` bigint(20) NOT NULL,
  `setor_nome` text NOT NULL,
  `setor_sala` text NOT NULL,
  `setor_hall` tinyint(1) NOT NULL,
  `setor_admin` tinyint(1) NOT NULL,
  `setor_ficha_preferencial` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `setores_tb`
--

INSERT INTO `setores_tb` (`setor_id`, `setor_nome`, `setor_sala`, `setor_hall`, `setor_admin`, `setor_ficha_preferencial`) VALUES
(1, 'TECNOLOGIA DA INFORMAÃ‡ÃƒO', 'INFORMÃTICA - SEGUNDO ANDAR', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_tb`
--

CREATE TABLE `usuarios_tb` (
  `usuario_id` bigint(20) NOT NULL,
  `usuario_nome` text NOT NULL,
  `usuario_cargo` text NOT NULL,
  `usuario_setor_id` bigint(20) NOT NULL,
  `usuario_login` text NOT NULL,
  `usuario_senha` text NOT NULL,
  `usuario_update_data` datetime DEFAULT NULL,
  `usuario_cadastrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios_tb`
--

INSERT INTO `usuarios_tb` (`usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_setor_id`, `usuario_login`, `usuario_senha`, `usuario_update_data`, `usuario_cadastrado`) VALUES
(1, 'ALLAN DE MIRANDA SILVA', 'ESTAGIÃGIO EM TI', 1, 'allan.silva', 'e10adc3949ba59abbe56e057f20f883e', '2019-07-24 18:52:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fichas_tb`
--
ALTER TABLE `fichas_tb`
  ADD PRIMARY KEY (`ficha_id`);

--
-- Indexes for table `logs_tb`
--
ALTER TABLE `logs_tb`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `mails_tb`
--
ALTER TABLE `mails_tb`
  ADD PRIMARY KEY (`mail_id`);

--
-- Indexes for table `painel_tb`
--
ALTER TABLE `painel_tb`
  ADD PRIMARY KEY (`painel_id`);

--
-- Indexes for table `setores_tb`
--
ALTER TABLE `setores_tb`
  ADD PRIMARY KEY (`setor_id`);

--
-- Indexes for table `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fichas_tb`
--
ALTER TABLE `fichas_tb`
  MODIFY `ficha_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs_tb`
--
ALTER TABLE `logs_tb`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mails_tb`
--
ALTER TABLE `mails_tb`
  MODIFY `mail_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `painel_tb`
--
ALTER TABLE `painel_tb`
  MODIFY `painel_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `setores_tb`
--
ALTER TABLE `setores_tb`
  MODIFY `setor_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  MODIFY `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
