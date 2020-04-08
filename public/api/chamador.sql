-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: chamador.itep.govrn
-- Tempo de geração: 02-Abr-2020 às 17:05
-- Versão do servidor: 10.3.22-MariaDB-0ubuntu0.19.10.1
-- versão do PHP: 7.3.11-0ubuntu0.19.10.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `chamador`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fichas_tb`
--

CREATE TABLE `fichas_tb` (
  `ficha_id` bigint(20) NOT NULL COMMENT 'id da Ficha',
  `ficha_numero` int(10) UNSIGNED NOT NULL COMMENT 'Número de chamada da Ficha',
  `ficha_nome` text NOT NULL COMMENT 'Nome da Ficha',
  `ficha_telefone` text DEFAULT NULL COMMENT 'Telefone da Ficha',
  `ficha_status` text NOT NULL DEFAULT 'NÃO ATENDIDO' COMMENT 'Status da Ficha',
  `ficha_setor_id` bigint(20) DEFAULT NULL COMMENT 'id do Setor para qual a Ficha vai ser atendida',
  `ficha_usuario_id` bigint(20) DEFAULT NULL COMMENT 'id do Funcionário que está atendendo a Ficha',
  `ficha_prioridade` tinyint(1) NOT NULL COMMENT 'Se a Ficha tem prioridade no atendidmento',
  `ficha_criacao_data` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data de criação da Ficha',
  `ficha_atualizacao_data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Data da atualização das informações da Ficha'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela com as Fichas do Sistema';

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs_tb`
--

CREATE TABLE `logs_tb` (
  `log_id` bigint(20) NOT NULL COMMENT 'id do Log',
  `log_usuario_nome` text NOT NULL COMMENT 'Nome do Usuário que criou o Log',
  `log_usuario_setor_nome` text NOT NULL COMMENT 'Nome do Setor do Usuário que criou o Log',
  `log_data_criacao` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data de criação do Log',
  `log_acao` text NOT NULL COMMENT 'Ação do Log',
  `log_de_nome` text DEFAULT NULL COMMENT 'Nome do Usuário ou do Setor que sofreu a Ação',
  `log_de_setor_nome` text DEFAULT NULL COMMENT 'Caso a Ação seja para um Usuário, este é o nome do Setor dele',
  `log_de_numero` text DEFAULT NULL COMMENT 'Número da Ficha que sofreu a Ação',
  `log_de_telefone` text DEFAULT NULL COMMENT 'Telefone da Ficha que sofreu a Ação',
  `log_para_nome` text DEFAULT NULL COMMENT 'Nome do Setor para onde foi encaminhado a Ficha',
  `log_ip` text NOT NULL COMMENT 'ip do Usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores_tb`
--

CREATE TABLE `setores_tb` (
  `setor_id` bigint(20) NOT NULL COMMENT 'id do Setor',
  `setor_nome` text NOT NULL COMMENT 'Nome do Setor',
  `setor_ficha` tinyint(1) NOT NULL COMMENT 'Se o Setor é um gerenciador de fichas',
  `setor_admin` tinyint(1) NOT NULL COMMENT 'Se o Setor é administrador do Sistema',
  `setor_deletado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Se o Setor foi Deletado do sistema',
  `setor_criado_data` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data que o Setor foi criado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de Setores do Sistema';

--
-- Extraindo dados da tabela `setores_tb`
--

INSERT INTO `setores_tb` (`setor_id`, `setor_nome`, `setor_ficha`, `setor_admin`, `setor_deletado`, `setor_criado_data`) VALUES
(1, 'DIGETI', 0, 1, 0, '2020-04-02 20:05:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_tb`
--

CREATE TABLE `usuarios_tb` (
  `usuario_id` bigint(20) NOT NULL COMMENT 'id do Funcionário',
  `usuario_nome` text NOT NULL COMMENT 'Nome do Funcionário',
  `usuario_setor_id` bigint(20) NOT NULL COMMENT 'id do Setor atual do Funcionário',
  `usuario_login` text NOT NULL COMMENT 'Login do Funcionário',
  `usuario_senha` text NOT NULL COMMENT 'Senha do Funcionário',
  `usuario_deletado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Se o Funcionário foi deletado do sistema',
  `usuario_criado_data` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data que o Funcionário foi adicionado ao sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de Funcionários do Sistema';

--
-- Extraindo dados da tabela `usuarios_tb`
--

INSERT INTO `usuarios_tb` (`usuario_id`, `usuario_nome`, `usuario_setor_id`, `usuario_login`, `usuario_senha`, `usuario_deletado`, `usuario_criado_data`) VALUES
(1, 'DIGETI ADMIN', 1, 'itep.digeti', 'e7d80ffeefa212b7c5c55700e4f7193e', 0, '2020-04-02 20:04:29');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fichas_tb`
--
ALTER TABLE `fichas_tb`
  ADD PRIMARY KEY (`ficha_id`) USING BTREE COMMENT 'Auto incremento de id para a Ficha';

--
-- Índices para tabela `logs_tb`
--
ALTER TABLE `logs_tb`
  ADD PRIMARY KEY (`log_id`);

--
-- Índices para tabela `setores_tb`
--
ALTER TABLE `setores_tb`
  ADD PRIMARY KEY (`setor_id`) USING BTREE COMMENT 'Auto incremento de id para setor';

--
-- Índices para tabela `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  ADD PRIMARY KEY (`usuario_id`) USING BTREE COMMENT 'Auto incremento de id para usuário',
  ADD UNIQUE KEY `usuario_login` (`usuario_login`(50)) USING BTREE COMMENT 'O login do Funcionário deve ser único no sistema';

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fichas_tb`
--
ALTER TABLE `fichas_tb`
  MODIFY `ficha_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id da Ficha';

--
-- AUTO_INCREMENT de tabela `logs_tb`
--
ALTER TABLE `logs_tb`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id do Log';

--
-- AUTO_INCREMENT de tabela `setores_tb`
--
ALTER TABLE `setores_tb`
  MODIFY `setor_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id do Setor', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  MODIFY `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id do Funcionário', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
