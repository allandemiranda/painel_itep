-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 17/07/2019 às 08:38
-- Versão do servidor: 5.7.26-0ubuntu0.18.04.1
-- Versão do PHP: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `itep_necro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `perito` varchar(100) NOT NULL,
  `numero_nic` varchar(100) NOT NULL,
  `data_entrada` date NOT NULL,
  `cadaver_informacao` varchar(100) NOT NULL,
  `data_fato` date NOT NULL,
  `procedencia_bairro` varchar(100) NOT NULL,
  `procedencia_cidade` varchar(100) NOT NULL,
  `procedencia_uf` varchar(100) NOT NULL,
  `cadaver_situacao` varchar(100) NOT NULL,
  `numero_guia` varchar(100) NOT NULL,
  `causa_morte` varchar(100) NOT NULL,
  `destino_exame` varchar(100) NOT NULL,
  `numero_sei` varchar(100) NOT NULL,
  `status_coleta` tinyint(1) NOT NULL,
  `nome_completo` varchar(100) DEFAULT NULL,
  `nome_pai` varchar(100) DEFAULT NULL,
  `nome_mae` varchar(100) DEFAULT NULL,
  `naturalidade_cidade` varchar(100) DEFAULT NULL,
  `naturalidade_uf` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `docuemnto_tipo` varchar(100) DEFAULT NULL,
  `docuemnto_numero` varchar(100) DEFAULT NULL,
  `docuemnto_orgao` varchar(100) DEFAULT NULL,
  `docuemnto_uf` varchar(100) DEFAULT NULL,
  `observacoes` varchar(500) DEFAULT NULL,
  `data_formulario` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `documentos`
--

INSERT INTO `documentos` (`id`, `perito`, `numero_nic`, `data_entrada`, `cadaver_informacao`, `data_fato`, `procedencia_bairro`, `procedencia_cidade`, `procedencia_uf`, `cadaver_situacao`, `numero_guia`, `causa_morte`, `destino_exame`, `numero_sei`, `status_coleta`, `nome_completo`, `nome_pai`, `nome_mae`, `naturalidade_cidade`, `naturalidade_uf`, `data_nascimento`, `docuemnto_tipo`, `docuemnto_numero`, `docuemnto_orgao`, `docuemnto_uf`, `observacoes`, `data_formulario`) VALUES
(1, 'ALLAN', '05348', '2019-07-10', 'HOMEM NÃƒO IDENTIFICADO', '2019-07-10', 'SERRINHA DE CIMA', 'SÃƒO GONSALO DO AMARANTE', 'RN', 'NÃƒO IDENTIFICADO', '145/2019 4Âª Eq. DHPP', 'ARMA DE FOGO', 'DP SÃƒO GONSALO DO AMARANTE', '0000000000', 1, 'MEU NOME COMPLETO AQUI SIM SIM', 'NOME DO MEU PAI AQUI SIM', 'NOME DA MINHA MÃƒE AQUI SIM', 'NATAL', 'RN', '2019-07-01', 'CTPS', '123456789', 'MT', 'RN', 'ENFORCAMENTO', '2019-07-17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobre_nome` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `matricula` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobre_nome`, `cargo`, `matricula`, `usuario`, `senha`) VALUES
(1, 'ALLAN', 'DE MIRANDA SILVA', 'ESTAGIÃRIO T.I.', '00.000-00', 'allan', 'senha1234'),
(2, 'ROSELY', 'SILVA COSTA', 'Auxiliar TÃ©cnico Forense', '98.562-7', 'rosely', 'ab610016t');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
