-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 28-Jul-2019 às 23:10
-- Versão do servidor: 5.7.27-0ubuntu0.18.04.1
-- versão do PHP: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_itep`
--
CREATE DATABASE IF NOT EXISTS `sistema_itep` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sistema_itep`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos`
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
-- Estrutura da tabela `necropapiloscopia_tb`
--

CREATE TABLE `necropapiloscopia_tb` (
  `necropapiloscopia_id` bigint(20) NOT NULL,
  `necropapiloscopia_protocolo` text,
  `necropapiloscopia_perito_id` bigint(20) DEFAULT NULL,
  `necropapiloscopia_perito_nome` text,
  `necropapiloscopia_perito_matricula` text,
  `necropapiloscopia_perito_cargo` text,
  `necropapiloscopia_doc_criacao_data` datetime DEFAULT NULL,
  `necropapiloscopia_doc_criacao_perito_nome` text,
  `necropapiloscopia_doc_modificacao_data` datetime DEFAULT NULL,
  `necropapiloscopia_doc_modificacao_perito_nome` text,
  `necropapiloscopia_nic_numero` text,
  `necropapiloscopia_entrada_data` date DEFAULT NULL,
  `necropapiloscopia_fato_data` date DEFAULT NULL,
  `necropapiloscopia_sei_protocolo` text,
  `necropapiloscopia_procedente_bairro` text,
  `necropapiloscopia_procedente_cidade` text,
  `necropapiloscopia_procedente_uf` text,
  `necropapiloscopia_informacoes` text,
  `necropapiloscopia_situacao` text,
  `necropapiloscopia_guia_numero` text,
  `necropapiloscopia_causa_morte` text,
  `necropapiloscopia_exame_destino` text,
  `necropapiloscopia_coleta_check` tinyint(1) DEFAULT NULL,
  `necropapiloscopia_coleta_motivo` text,
  `necropapiloscopia_digitais_folha_um` longblob NOT NULL,
  `necropapiloscopia_digitais_folha_dois` longblob NOT NULL,
  `necropapiloscopia_nascimento_data` date DEFAULT NULL,
  `necropapiloscopia_naturalidade_cidade` text,
  `necropapiloscopia_naturalidade_uf` text,
  `necropapiloscopia_nome` text,
  `necropapiloscopia_pai_nome` text,
  `necropapiloscopia_mae_nome` text,
  `necropapiloscopia_documento_tipo` text,
  `necropapiloscopia_documento_numero` text,
  `necropapiloscopia_documento_orgao` text,
  `necropapiloscopia_documento_uf` text,
  `necropapiloscopia_observacoes` text
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
  `setor_ficha_preferencial` tinyint(1) DEFAULT NULL,
  `setor_acessibilidade_cor` text,
  `setor_acessibilidade_check` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `setores_tb`
--

INSERT INTO `setores_tb` (`setor_id`, `setor_nome`, `setor_sala`, `setor_hall`, `setor_admin`, `setor_ficha_preferencial`, `setor_acessibilidade_cor`, `setor_acessibilidade_check`) VALUES
(1, 'TECNOLOGIA DA INFORMAÃ‡ÃƒO', 'INFORMÃTICA - SEGUNDO ANDAR', 0, 1, 1, '#1E252F', 0),
(2, 'ATENDIMENTO DE TRAUMATOLOGIA', 'SALA TRAUMATOLOGIA', 0, 0, 0, '#EB3E28', 1),
(3, 'ATENDIMENTO NECROTÃ‰RIO', 'SALA TRAUMATOLOGIA', 0, 0, 0, '#0E8F9F', 1),
(4, 'DIREÃ‡ÃƒO IML', 'SALA DE DIREÃ‡ÃƒO DO IML', 0, 1, 0, '#1E252F', 1),
(5, 'LAUDOS', 'SALA DE LAUDOS', 0, 0, 0, '#5B479F', 1),
(6, 'PSICOLOGIA', 'SALA DA PSICOLOGIA', 0, 0, 0, '#FF5D25', 1),
(7, 'ASSISTENTE SOCIAL', 'SALA DA ASSISTENTE SOCIAL', 0, 0, 0, '#32C867', 1),
(8, 'ODONTOLOGIA', 'SALA DA ODONTOLOGIA', 0, 0, 0, NULL, 0),
(9, 'NECROPAPILOSCOPIA', 'SALA DA NECROPAPILOSCOPIA', 0, 0, 0, NULL, 0),
(10, 'ANTROPOLOGIA', 'SALA DA ANTROPOLOGIA', 0, 0, 0, NULL, 0),
(11, 'MÃ‰DICO LEGISTA', 'SALA DOS MÃ‰DICOS LEGISTAS', 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
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
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobre_nome`, `cargo`, `matricula`, `usuario`, `senha`) VALUES
(1, 'ALLAN', 'DE MIRANDA SILVA', 'ESTAGIÃRIO T.I.', '00.000-00', 'allan', 'senha1234'),
(2, 'ROSELY', 'DA SILVA COSTA', 'Auxiliar TÃ©cnico Forense', '98.562-7', 'rosely', 'ab610016t'),
(3, 'SANDRA', 'MARIA BEZERRA LOPES MATEUS', 'Auxiliar TÃ©cnico Forense', '98.568-6', '78586143472', '78586143472'),
(4, 'ALDA', 'MARIA DE LIMA', 'Auxiliar TÃ©cnico Forense', '98.409-4', 'alda', '1721'),
(5, 'AVANA', 'FERNANDES ARAUJO', 'Auxiliar TÃ©cnico Forenses', '98.429-9', '45048320468', '4141'),
(6, 'SAMIR', 'ALBANEZ VERAS DE SOUZA', 'Agente TÃ©cnico Forense', '223.371-1', 'samir', '147258369');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_tb`
--

CREATE TABLE `usuarios_tb` (
  `usuario_id` bigint(20) NOT NULL,
  `usuario_nome` text NOT NULL,
  `usuario_cargo` text NOT NULL,
  `usuario_matricula` text,
  `usuario_setor_id` bigint(20) NOT NULL,
  `usuario_setor_edit` tinyint(1) DEFAULT NULL,
  `usuario_login` text NOT NULL,
  `usuario_senha` text NOT NULL,
  `usuario_update_data` datetime DEFAULT NULL,
  `usuario_cadastrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios_tb`
--

INSERT INTO `usuarios_tb` (`usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_matricula`, `usuario_setor_id`, `usuario_setor_edit`, `usuario_login`, `usuario_senha`, `usuario_update_data`, `usuario_cadastrado`) VALUES
(1, 'ALLAN DE MIRANDA SILVA', 'ESTAGIÃGIO EM TI', '000.00-0', 1, 0, 'allan.silva', 'e10adc3949ba59abbe56e057f20f883e', '2019-07-28 19:44:18', 1),
(2, 'ALDENIR MEDEIROS DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'aldenir.silva', '500b0b095f0c838d326c865dbfbfe9e9', '2019-07-25 08:36:21', 0),
(3, 'ALESSANDRA BEZERRA DA COSTA NEPOMUCENO', 'SEM CARGO', NULL, 1, NULL, 'alessandra.nepomuceno', '5c6988757e3628fe7a365fd30baa0225', '2019-07-25 08:36:21', 0),
(4, 'ALESSANDRA HELENA RIBEIRO DANTAS DE OLIVEIRA FARIAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'alessandra.farias', 'c3b0601fc5a8ca489d4a3bd17f7194c1', '2019-07-25 08:36:21', 0),
(5, 'ALEXANDRE HENRIQUE FIALHO RIBEIRO DANTAS', 'ANALISTA TECNICO FORENSE', NULL, 1, NULL, 'alexandre.dantas', 'f4fe349abc81b80e34ece30c6f4f575b', '2019-07-25 08:36:21', 0),
(6, 'ALEXANDRE NASCIMENTO DOS SANTOS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'alexandre.santos', '66233d30413665335b56b519e153877c', '2019-07-25 08:36:21', 0),
(7, 'ALFREDO FERREIRA DE MIRANDA', 'IMPRESSOR TIPOGRAFICO - CERN', NULL, 1, NULL, 'alfredo.miranda', 'd08a7c2c2f98eebb1b2c351caa5031f7', '2019-07-25 08:36:21', 0),
(8, 'ALFREDO SANTOS DO NASCIMENTO', 'VIGILANTE - CERN', NULL, 1, NULL, 'alfredo.nascimento', 'dcee49575b1c192bec417bd73daf13f5', '2019-07-25 08:36:21', 0),
(9, 'ALMIR LIMA DE ARAUJO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'almir.araujo', 'aa94e8bbf8412f745e0576ecde9c60fd', '2019-07-25 08:36:21', 0),
(10, 'ALVERI JOAO RAYMUNDO JUNIOR', 'ASSISTENTE INFORMATICA II - DATANORTE', NULL, 1, NULL, 'alveri.junior', '46d8468c2ea49759ff4175d4d767b445', '2019-07-25 08:36:21', 0),
(11, 'ALYNE SWERDA PEREIRA E SILVA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'alyne.silva', '3c9881d65922946484ce4cbe7e5e338a', '2019-07-25 08:36:21', 0),
(12, 'AMAURY LEITE MALTA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'amaury.malta', '0dbab71e1b26aac6d3df33108a9651bd', '2019-07-25 08:36:21', 0),
(13, 'ANA AIRES DE MESQUITA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.mesquita', '55771f6bb9d603720550c76bb2695735', '2019-07-25 08:36:21', 0),
(14, 'ANA CLAUDIA DE LIMA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.silva', 'd7e484aae14b2e83c8e7bfd509db7af8', '2019-07-25 08:36:21', 0),
(15, 'ANA CLAUDIA NOGUEIRA DA COSTA', 'CARGO PENSAO GRACIOSA', NULL, 1, NULL, 'ana.costa', '55edfdafa7715d06d3702363f7b2716f', '2019-07-25 08:36:21', 0),
(16, 'ANA CRISTINA ASSIS DE LIMA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.lima', 'cb79411f260c9881c96af1a6c61c1373', '2019-07-25 08:36:21', 0),
(17, 'ANA DULCE DA NOBREGA BEZERRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.bezerra', '605953cb37d0cee3d893491436d3379e', '2019-07-25 08:36:21', 0),
(18, 'ANA GLORIA DE MELO E SILVA', 'CARGO REQUISITADO', NULL, 1, NULL, 'ana.silva', '2eda76031356e4cc8f83b0e376852cf2', '2019-07-25 08:36:21', 0),
(19, 'ANA LUCIA FARIAS PIRES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ana.pires', '06adf802fac0b452081fc96ff522e935', '2019-07-25 08:36:21', 0),
(20, 'ANA MARIA BARBALHO DA SILVA COSTA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ana.costa', 'f722e7216c8b80a23cf10801abde0998', '2019-07-25 08:36:21', 0),
(21, 'ANA MARIA CAVALCANTE NETA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.neta', 'ef76ab678b547c30b0cbad9af09af606', '2019-07-25 08:36:21', 0),
(22, 'ANA PATRICIA GALVAO DANTAS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'ana.dantas', '68497df08a3a63ff0a7fe8ec6165e59d', '2019-07-25 08:36:21', 0),
(23, 'ANA PATRICIA TAVARES MOREIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ana.moreira', '657f6eca34d136cd4c7ff604eb127fc4', '2019-07-25 08:36:21', 0),
(24, 'ANAXIANNE WINDYSOR NAZARENO VIEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'anaxianne.vieira', '8223dd6fb40a79920706f1897ca29e91', '2019-07-25 08:36:21', 0),
(25, 'ANDERSON CARLOS DE FARIAS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'anderson.farias', 'd35ff41df24389864e483d8fde392fdd', '2019-07-25 08:36:21', 0),
(26, 'ANDERSON QUEIROZ DE OLIVEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'anderson.oliveira', 'e39505c183b8b63aea668dfc1261d00e', '2019-07-25 08:36:21', 0),
(27, 'ANDRE DA ROCHA SILVA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'andre.silva', 'e91733d52c18e006a320aeb22ed0f386', '2019-07-25 08:36:21', 0),
(28, 'ANDREA ABDON', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'andrea.abdon', '3b814093ef46e2970ad246268a76717e', '2019-07-25 08:36:21', 0),
(29, 'ANDREA CARLA BEZERRA LOPES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'andrea.lopes', '84935e57f2fc30f8ec425ad77815b0db', '2019-07-25 08:36:21', 0),
(30, 'ANDREA GALDINO BEZERRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'andrea.bezerra', '89db1b1ea1e99a7c3721d05705c361a7', '2019-07-25 08:36:21', 0),
(31, 'ANDRESSA MAYARA NASCIMENTO DE OLIVEIRA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'andressa.oliveira', '068f7edcdc80284cacb298ebb7ac502c', '2019-07-25 08:36:21', 0),
(32, 'ANDREY SILVA DE SOUZA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'andrey.souza', 'd2f7b3d00a97dbe19c5ef35eadf47758', '2019-07-25 08:36:21', 0),
(33, 'ANNE CAROLINE LEONIDAS PEREIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'anne.pereira', '1f9d05c9b85935385dee387a94c34d6f', '2019-07-25 08:36:21', 0),
(34, 'ANTONIA MENDES SARMENTO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'antonia.sarmento', 'bd20d9ffae03d46a9ffd78c2b9fb46b6', '2019-07-25 08:36:21', 0),
(35, 'ANTONIO AIRTON DIAS AGOSTINHO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'antonio.agostinho', '320f0d8c49f747e014454c9ab8b17802', '2019-07-25 08:36:21', 0),
(36, 'ANTONIO CARLOS CAVALCANTE CORREIA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'antonio.correia', '4525865da8268ae4a31d4336fbf6f8ec', '2019-07-25 08:36:21', 0),
(37, 'ANTONIO CARLOS DA SILVA', 'MOTORISTA III - CIDA', NULL, 1, NULL, 'antonio.silva', '07a5d4afdf0f0debcaace7b8951828a7', '2019-07-25 08:36:21', 0),
(38, 'ANTONIO DE SOUZA FILHO', 'CARGO REQUISITADO', NULL, 1, NULL, 'antonio.filho', '87069be21e518d60a458bc8924f696b1', '2019-07-25 08:36:21', 0),
(39, 'ANTONIO DO NASCIMENTO', 'VIGIA - COHAB', NULL, 1, NULL, 'antonio.nascimento', '924f331b81ccbe904a5615afff0db0f3', '2019-07-25 08:36:21', 0),
(40, 'ANTONIO NEI NOGUEIRA MARTINS JUNIOR', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'antonio.junior', '8ed441ffde21f70f2b13201411d4f6af', '2019-07-25 08:36:21', 0),
(41, 'ANTONIO RAMOS DOS SANTOS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'antonio.santos', 'b1cefffe4542a20ca8f703ee209398e4', '2019-07-25 08:36:21', 0),
(42, 'ANTONIO ROBERTO DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'antonio.silva', 'b6dfaf6f1270e31d484f70270bf0ff3d', '2019-07-25 08:36:21', 0),
(43, 'APARECIDA CRISTINA DE MEDEIROS', 'PROF PERM NIVEL - III', NULL, 1, NULL, 'aparecida.medeiros', '6073b541bec8fe5b866dc5f06f38c519', '2019-07-25 08:36:21', 0),
(44, 'ARIALDA HELENA DO CARMO MARTINS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'arialda.martins', '42af3c053c6c04df458377ff3ede3595', '2019-07-25 08:36:21', 0),
(45, 'ARTUR DA ROCHA CARNEIRO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'artur.carneiro', 'fe1e76716b8d4c27fb8b86cf0223b1c3', '2019-07-25 08:36:21', 0),
(46, 'ARYEL NAYARA DOS SANTOS', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'aryel.santos', '7c0381821a5508510c3dbd4570acee61', '2019-07-25 08:36:21', 0),
(47, 'ATAIDE DE MACEDO VIEIRA LIMA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'ataide.lima', '8f08fd348c775e2b4aab6242decd916d', '2019-07-25 08:36:21', 0),
(48, 'AVANA FERNANDES ARAUJO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'avana.araujo', 'bcce5af15ab0ed4ddd56785bd8cc870c', '2019-07-25 08:36:21', 0),
(49, 'BENE LEMUEL DANTAS GONDIM', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'bene.gondim', '5a54ca6f8469381bf2d2ec8852c59056', '2019-07-25 08:36:21', 0),
(50, 'BRIGIDA ZULAD RODRIGUES MACIEL DE SOUZA', 'SEM CARGO', NULL, 1, NULL, 'brigida.souza', 'baf21de191e2bef7d00d56768224418f', '2019-07-25 08:36:21', 0),
(51, 'BRUNNO HELISON BARBOSA MARQUES', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'brunno.marques', '5fc84e8afedc84ea97cfd061c3d5a79f', '2019-07-25 08:36:21', 0),
(52, 'BRUNO PESSOA NEVES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'bruno.neves', 'aef3bbd693a9f108178093db7204d98d', '2019-07-25 08:36:21', 0),
(53, 'CAMILA WALESKA DE MACEDO CALDAS', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'camila.caldas', 'b4aac7aeebef181ac8fecde563ea4c60', '2019-07-25 08:36:21', 0),
(54, 'CARLOS ALBERTO GALVAO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'carlos.galvao', 'd029f626a1b6a8e09afdfa0ba38dca6e', '2019-07-25 08:36:21', 0),
(55, 'CARLOS ANDRE NUNES JATOBA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'carlos.jatoba', 'e55f920d48b7535fc04a73e024b59679', '2019-07-25 08:36:21', 0),
(56, 'CARLOS COSTA DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'carlos.silva', 'aa2f3cd95161ebef4b9b7f6897333301', '2019-07-25 08:36:21', 0),
(57, 'CARLOS EDUARDO FERNANDES DE OLIVEIRA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'carlos.oliveira', '56df081feb515b5b10afd1b7b0c6e857', '2019-07-25 08:36:21', 0),
(58, 'CARLOS HENRIQUE DE LIMA E SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'carlos.silva', '4653a4080398bef36ba92783bec82679', '2019-07-25 08:36:21', 0),
(59, 'CARLOS MAGNO GONCALVES DE JESUS', 'DESENHISTA - CERN', NULL, 1, NULL, 'carlos.jesus', 'b7518424a06b54e107e328885cba722f', '2019-07-25 08:36:21', 0),
(60, 'CAROLINA DANTAS GADELHA SARAIVA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'carolina.saraiva', 'd411aa5f94ef900efbacf85107dca868', '2019-07-25 08:36:21', 0),
(61, 'CAROLINA DE FREITAS SINDEAUX QUEIROZ', 'SEM CARGO', NULL, 1, NULL, 'carolina.queiroz', '8628750a00b631e1c5edb16d5002a4c3', '2019-07-25 08:36:21', 0),
(62, 'CELIA MARIA LOPES DA SILVA GOMES', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'celia.gomes', 'bccca4f81ab0da59cc9c2ec851a9e056', '2019-07-25 08:36:21', 0),
(63, 'CICERO TIBERIO LANDIM DE ALMEIDA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'cicero.almeida', 'eef300742fe8b3b745856d5e2982126f', '2019-07-25 08:36:21', 0),
(64, 'CILENE LINS DE ALBUQUERQUE', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'cilene.albuquerque', '3a47d4231b4edfa55a96d16695317830', '2019-07-25 08:36:21', 0),
(65, 'CLAUDETE BEZERRA MARTINS', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'claudete.martins', 'fd7faa0502d83b04c19fa5f0551464bc', '2019-07-25 08:36:21', 0),
(66, 'CLAUDIONOR GOMES DE MOURA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'claudionor.moura', '1990c24626708a858b72df4053139e86', '2019-07-25 08:36:21', 0),
(67, 'CLAUTIA SHEILA NUNES DE CARVALHO LOPES', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'clautia.lopes', 'ed393cfe9eb01e87278a601c369d2acf', '2019-07-25 08:36:21', 0),
(68, 'CLEBER CARLOS DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'cleber.silva', 'e5bb0f11db32914b219d38e46182e1cf', '2019-07-25 08:36:21', 0),
(69, 'CLEIDE VIIDAL DE SOUSA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'cleide.sousa', 'c7e1c55fee744e9bfb3a659fbfaf6dbb', '2019-07-25 08:36:21', 0),
(70, 'CLEOPATRA DA CONCEICAO BEZERRA', 'AUX SERVIÃ‡O INFORMATICA II - DATANORTE', NULL, 1, NULL, 'cleopatra.bezerra', '61eaf2850ac4e25665f2fa3c09459295', '2019-07-25 08:36:21', 0),
(71, 'CLESIOSANGINA NUNES ABRANTES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'clesiosangina.abrantes', 'df49c1d99ea8c7d06b2b4b1129bd9a86', '2019-07-25 08:36:21', 0),
(72, 'CLODOMIRO FERREIRA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'clodomiro.silva', '761b14a3df3a499ef9b7ed4f964e0177', '2019-07-25 08:36:21', 0),
(73, 'CRISTHIANO HENRIQUE EUFRASIO DA COSTA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'cristhiano.costa', 'ab0143ed027c597afb64fe2769077e50', '2019-07-25 08:36:21', 0),
(74, 'CRISTOVAO BEZERRA DE LIMA', 'AUXILIAR TEC DE ADMINISTRAÃ‡ÃƒO - COHAB', NULL, 1, NULL, 'cristovao.lima', '43eec5cf4d76ab4bdb31103bb66119e4', '2019-07-25 08:36:21', 0),
(75, 'DALLYANE DOS SANTOS LISBOA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'dallyane.lisboa', 'ef6dea297c472be01a8ce34dade1dbfe', '2019-07-25 08:36:21', 0),
(76, 'DAMIAO PEREIRA DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'damiao.silva', '6dec31326ec6c9359f5e3c9756f7ee3c', '2019-07-25 08:36:21', 0),
(77, 'DANILO AIRES DOS SANTOS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'danilo.santos', 'd2b289023f28628f5a24d8516db05db1', '2019-07-25 08:36:21', 0),
(78, 'DANYELE MARINHO PONTES DA ROCHA', 'TECNICO EM ENFERMAGEM', NULL, 1, NULL, 'danyele.rocha', '0f204708291c7590455a30965de30584', '2019-07-25 08:36:21', 0),
(79, 'DAVI DE OLIVEIRA BERNARDINO', 'ASSISTENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'davi.bernardino', 'a895d1dda1ec46e442c3d04430fbeae3', '2019-07-25 08:36:21', 0),
(80, 'DAVI LEITE PAIVA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'davi.paiva', 'afc98e922d1e680fb8e3bfd65dc50f52', '2019-07-25 08:36:21', 0),
(81, 'DAWSON CAMPOS DE ILMA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'dawson.ilma', '35ef1b4a746ef606baa6425a517b6a14', '2019-07-25 08:36:21', 0),
(82, 'DEBORA ALVES PEREIRA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'debora.pereira', '583bd8c116aee027c2c1f904ff4ff928', '2019-07-25 08:36:21', 0),
(83, 'DEBORA VALENTIM MONTE ALTO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'debora.alto', '1ba2d8f143d794a721e92c62354da1ef', '2019-07-25 08:36:21', 0),
(84, 'DEBORAH CACHINA DE CARVALHO MAIA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'deborah.maia', '8e2dd639114f28938f464694ef22d62d', '2019-07-25 08:36:21', 0),
(85, 'DENILSON FERREIRA DA SILVA', 'CABO - PM/CBM', NULL, 1, NULL, 'denilson.silva', '224dcf1bb0fd388ecfe698fa2a896101', '2019-07-25 08:36:21', 0),
(86, 'DENIS RENATO RAMALHO OROZCO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'denis.orozco', '7344fdd6d0690d5dd761edbabe66009c', '2019-07-25 08:36:21', 0),
(87, 'DENNIS RODOLFO BARBOSA DA SILVA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'dennis.silva', '6c013a467872ed38bc02b38740f9f2b5', '2019-07-25 08:36:21', 0),
(88, 'DEOMAR FERNANDES DE ARRUDA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'deomar.arruda', '50db28efb045be2207e493dd42ebe6e9', '2019-07-25 08:36:21', 0),
(89, 'DEUSENI DE MENDONCA PIMENTEL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'deuseni.pimentel', '4b5735aa487aef7c4672c418a3f409ae', '2019-07-25 08:36:21', 0),
(90, 'DEYWISON MARCIEL QUEIROGA DE ALMEIDA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'deywison.almeida', 'ac4b9b1ba9c333c4c8bdd11c6da8b97d', '2019-07-25 08:36:21', 0),
(91, 'DIANA CARENINA QUEIROZ MOURA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'diana.moura', 'cd9708706c470b67adb05fe9d3647b52', '2019-07-25 08:36:21', 0),
(92, 'DIANA CARLA SECUNDO DA LUZ', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'diana.luz', 'ce1c8a27497938749022541702d3ae18', '2019-07-25 08:36:21', 0),
(93, 'DIEGO SABINO AMORIM DE ARAUJO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'diego.araujo', '4bd4d0236ca7ddb53f77d9d7d5d6ebd7', '2019-07-25 08:36:21', 0),
(94, 'DIOGO CIRNE NUNES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'diogo.nunes', '58cab86f6b249f4fa446f82e362b5618', '2019-07-25 08:36:21', 0),
(95, 'DOMICIANA MARILAC DE OLIVEIRA LOPES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'domiciana.lopes', '7979a153c44e5b536a5abaccf787d3b2', '2019-07-25 08:36:21', 0),
(96, 'EDILSON CARLOS ROCHA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'edilson.rocha', 'd2e2c7479fe5ef96a9553ecaa3f23fbf', '2019-07-25 08:36:21', 0),
(97, 'EDINALVA TEIXEIRA DA SILVA', 'AUXILIAR DE INFORMATICA I - DATANORTE', NULL, 1, NULL, 'edinalva.silva', '7df77270750aba434ab60d4c4c8b48fb', '2019-07-25 08:36:21', 0),
(98, 'EDINEIDE OLIVEIRA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'edineide.silva', '5d2057627d8d87191bfbc45ffdb5c850', '2019-07-25 08:36:21', 0),
(99, 'EDINILRA HERACLIO DE ARAUJO MAIA', 'AUXILIAR DE SERVICOS GERAIS', NULL, 1, NULL, 'edinilra.maia', '20b839e600cb04837c07b0909d5e8ee0', '2019-07-25 08:36:21', 0),
(100, 'EDMAR PEREIRA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'edmar.silva', '9673da55966ccb2ec4814689a8522f48', '2019-07-25 08:36:21', 0),
(101, 'EDNA COSTA DE MEDEIROS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'edna.medeiros', '07f723d8f11995410d51cba395a13c09', '2019-07-25 08:36:21', 0),
(102, 'EDNALDO BEZERRA DE CARVALHO', 'PROF SUPLEM P7C', NULL, 1, NULL, 'ednaldo.carvalho', '4ab07f9d4cd62f7d7564349390a197dc', '2019-07-25 08:36:21', 0),
(103, 'EDNALDO CEZARIO DE MEDEIROS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ednaldo.medeiros', 'd080cb6b56500dfbceaef1337602fa68', '2019-07-25 08:36:21', 0),
(104, 'EDSON DANTAS DE MEDEIROS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'edson.medeiros', '4372c9f87ea090d285ade32ef6c1024b', '2019-07-25 08:36:21', 0),
(105, 'EDUARDO ALEXANDRE SALVIANO SARAIVA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'eduardo.saraiva', 'c0b86afbe4cb6be2124181450fe8b8a6', '2019-07-25 08:36:21', 0),
(106, 'EDUARDO ARAUJO RAMOS', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'eduardo.ramos', 'a4859a8b72a5d12bcc43c23b8ca4f8f8', '2019-07-25 08:36:21', 0),
(107, 'EDVALDO MACHADO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'edvaldo.machado', 'c290275ca3e67f1acccba56e07c444e2', '2019-07-25 08:36:21', 0),
(108, 'EDWARD BEZERRA DE MOURA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'edward.moura', 'f3a804f097bfb5ec4883aa3c86446508', '2019-07-25 08:36:21', 0),
(109, 'ELAINE CUNHA E SILVA LEAO DOS ANJOS', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'elaine.anjos', 'f61a035777b695bc4c473d3a9ebdda11', '2019-07-25 08:36:21', 0),
(110, 'ELEONORA FELIX NUNES DE MOURA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'eleonora.moura', 'a81baf9ff95c884a81cf8115c4be9131', '2019-07-25 08:36:21', 0),
(111, 'ELIANE BEZERRA DE MOURA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'eliane.moura', '1437c11960bee1c52eb56cd3944f745f', '2019-07-25 08:36:21', 0),
(112, 'ELIAS GUILHERME LINO', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'elias.lino', 'a124c8a76f9826601f379523c18a3123', '2019-07-25 08:36:21', 0),
(113, 'ELIONE FERNANDES DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'elione.oliveira', '358dbc02b427c53876a0854f8b387550', '2019-07-25 08:36:21', 0),
(114, 'ELISANGELA FARIA ELIAS', 'CARGO REQUISITADO', NULL, 1, NULL, 'elisangela.elias', '7a9949bc9a3e59465c0854dfcab6bcfa', '2019-07-25 08:36:21', 0),
(115, 'ELIVANALDO BALBINO DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'elivanaldo.silva', 'f06624fc5e3435c8b26fbd8bbf108cb2', '2019-07-25 08:36:21', 0),
(116, 'ELIZABETH FILLARD TONELLO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'elizabeth.tonello', '3581a4317514b2c5bb529152b73f03c8', '2019-07-25 08:36:21', 0),
(117, 'ELSON GONCALVES DOS SANTOS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'elson.santos', '0ad6296dd169dc41bbc94a2500ccd073', '2019-07-25 08:36:21', 0),
(118, 'ELVYS MOYSES LINS BURITI', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'elvys.buriti', 'fe2c263e54c69aa94aba30dc6aac59c1', '2019-07-25 08:36:21', 0),
(119, 'EMANUELA DE OLIVEIRA ALVES', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'emanuela.alves', 'c594bd03985d5dd1a2e9e684bddffd5d', '2019-07-25 08:36:21', 0),
(120, 'EMANUELLA PINHEIRO SINDEAUX', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'emanuella.sindeaux', '839ca517e0d7b15a1ab6ef3a0e373f6c', '2019-07-25 08:36:21', 0),
(121, 'EMANUELLY OLIVIA QUEIROZ DE MANICOBA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'emanuelly.manicoba', '46ae5fefe669936da702bb735224d621', '2019-07-25 08:36:21', 0),
(122, 'EMERSON MICHELL DA SILVA SIQUEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'emerson.siqueira', 'cd9dd91bc0c2bddfcf44cd70a853e769', '2019-07-25 08:36:21', 0),
(123, 'EMERSON ROGERIO DANTAS DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'emerson.oliveira', '3324f468b6eb6303ec95a852154b32b8', '2019-07-25 08:36:21', 0),
(124, 'EMIDIA FERREIRA ROSADO ALMEIDA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'emidia.almeida', 'ecccf028a46ac1b862a95a1c1b986747', '2019-07-25 08:36:21', 0),
(125, 'ENILDA MARIA LIMA DE MORAES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'enilda.moraes', '3f0114e5ed6a91282f776c4eee020bc8', '2019-07-25 08:36:21', 0),
(126, 'ENILZA GOMES OLIVEIRA DE FREITAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'enilza.freitas', '7eb0657fd85835f862f268951fc2379c', '2019-07-25 08:36:21', 0),
(127, 'ERINALDO CEZARIO DE MEDEIROS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'erinaldo.medeiros', 'a09bdf1380797dc08218f4dd6290caca', '2019-07-25 08:36:21', 0),
(128, 'ERIVAN CASSIANO DA COSTA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'erivan.costa', 'c0efaf92614c43eadc4e263dfaef622e', '2019-07-25 08:36:21', 0),
(129, 'ERIVAN CORTEZ DE MEDEIROS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'erivan.medeiros', '9e743fa5b05d440ee61e8242070de95d', '2019-07-25 08:36:21', 0),
(130, 'ERNANI GOMES DE OLIVEIRA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ernani.silva', 'fd8a42915f5c2887af4074751653093b', '2019-07-25 08:36:21', 0),
(131, 'ERONALDO LOPES DE MEDEIROS', 'ASSISTENTE COMERCIAL II - CIDA', NULL, 1, NULL, 'eronaldo.medeiros', '76fd18f4230a2a9154dd6d5182f485a3', '2019-07-25 08:36:21', 0),
(132, 'ERONIDES RODRIGUES MACIEL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'eronides.maciel', '0f45dbf02917aeb7e69b49100985b436', '2019-07-25 08:36:21', 0),
(133, 'EUCLIDES BEZERRA NETO', 'AUX DE ESCRITORIO II - CDI', NULL, 1, NULL, 'euclides.neto', 'a605cefe7ab5407ce5d10f0b570df5c3', '2019-07-25 08:36:21', 0),
(134, 'EUDNA CARLA DE ARAUJO OLIVIO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'eudna.olivio', 'd86f92058cd9c4d87ccdcaeeea2bbd37', '2019-07-25 08:36:21', 0),
(135, 'EUGENIO BORGES DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'eugenio.silva', 'bb33da725d14bcf19c5ae69fb0ff9017', '2019-07-25 08:36:21', 0),
(136, 'EURIDICE CARVALHO PITHON', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'euridice.pithon', '20ddb69e58b2bcca9994882a162aa904', '2019-07-25 08:36:21', 0),
(137, 'EVALDO RAMON DIAS GUIMARAES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'evaldo.guimaraes', '6af5c0aa083e4d2f8d8f0c53705296a3', '2019-07-25 08:36:21', 0),
(138, 'EVANILDO CARLOS DE MORAIS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'evanildo.morais', '12d5a464e0c6a28edd2732333f68d613', '2019-07-25 08:36:21', 0),
(139, 'EVARISTO LACAVA DE ALMEIDA JUNIOR', 'CARGO REQUISITADO', NULL, 1, NULL, 'evaristo.junior', 'aa3b5b877901762501908c53112cfd47', '2019-07-25 08:36:21', 0),
(140, 'EVERALDO SATURNO DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'everaldo.silva', 'f038a96d544423730575c92e7a2c8765', '2019-07-25 08:36:21', 0),
(141, 'FABIANO FREIRE DE MELO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'fabiano.melo', '3d5162d5f4de2d9dc5ba4a9e645b63c4', '2019-07-25 08:36:21', 0),
(142, 'FABIO EDUARDO DE MENEZES MARTINS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'fabio.martins', 'be9800973485db3effc79d405661009c', '2019-07-25 08:36:21', 0),
(143, 'FABRICIO FERNANDES DE SA OLIVEIRA', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'fabricio.oliveira', '4b496a347ce9ba0b7bf7d0a2146fa779', '2019-07-25 08:36:21', 0),
(144, 'FELIPE SOARES DE CARVALHO PIRES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'felipe.pires', 'b753e1baab9622217d961034680cd19f', '2019-07-25 08:36:21', 0),
(145, 'FERNANDA CARVALHO CAGNI', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'fernanda.cagni', '32d06a0a9a82d679c10875e24d91e9bb', '2019-07-25 08:36:21', 0),
(146, 'FERNANDO DE SOUZA MARINHO', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'fernando.marinho', 'f2e79ef023c6591683d674b9fbbef44b', '2019-07-25 08:36:21', 0),
(147, 'FERNANDO FERREIRA DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'fernando.silva', 'ffa2f92d592985d2562f3303d86f3029', '2019-07-25 08:36:21', 0),
(148, 'FERNANDO MORAIS DE MEDEIROS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'fernando.medeiros', '0fbd1ded9cacdcf2ec3abd42892c4287', '2019-07-25 08:36:21', 0),
(149, 'FLAVIA DULCILLA MACEDO BARRETO CAVALCANTI', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'flavia.cavalcanti', '339bc6321bf77824675688741ef55760', '2019-07-25 08:36:21', 0),
(150, 'FLAVIA LOURRANE SALVADOR DE MELO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'flavia.melo', '302dc0d8f5f72d3fbd5105f45ef02028', '2019-07-25 08:36:21', 0),
(151, 'FLAVIO ALEXANDRE SANTOS DE AZEVEDO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'flavio.azevedo', '5ed911666f03c3242b0d4ba6d32e5855', '2019-07-25 08:36:21', 0),
(152, 'FRANCIELIA DA SILVA NERY', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francielia.nery', 'df1a3d6cc6bf6a2a6452ca7124b77eb5', '2019-07-25 08:36:21', 0),
(153, 'FRANCINETE MANICOBA DE OLIVEIRA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'francinete.oliveira', '1340499df061306ca25c39759a8df358', '2019-07-25 08:36:21', 0),
(154, 'FRANCINILDO FERNANDES DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francinildo.silva', '5b46e6b191e4ae645149b36b632a1f17', '2019-07-25 08:36:21', 0),
(155, 'FRANCISCA AFONSO DE MEDEIROS FERNANDES', 'CARGO REQUISITADO', NULL, 1, NULL, 'francisca.fernandes', '386d0b55d068b2fd28f2cd93625647e7', '2019-07-25 08:36:21', 0),
(156, 'FRANCISCA DE ASSIS ROCHA LOPES', 'AUX ADMINISTRATIVO I - CDM', NULL, 1, NULL, 'francisca.lopes', '0184aefa38b61c8128a6f9e64c1f29d4', '2019-07-25 08:36:21', 0),
(157, 'FRANCISCA ERINAIDE FREITAS NEGREIROS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisca.negreiros', 'b3d19d2a4d22e21f091070c67f16343a', '2019-07-25 08:36:21', 0),
(158, 'FRANCISCO ALBERTO DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisco.silva', 'c20d2484ab5d2ffa7d62e7d8b70a58ab', '2019-07-25 08:36:21', 0),
(159, 'FRANCISCO BEZERRA DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.oliveira', '77a4685e02fa463effb9394f85a47120', '2019-07-25 08:36:21', 0),
(160, 'FRANCISCO CANINDE AFONSO BEZERRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.bezerra', '5b9e362dfba247412bbc152b8b495610', '2019-07-25 08:36:21', 0),
(161, 'FRANCISCO CANINDE BARBALHO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.barbalho', 'c3038affb94b9f57fb7fc57e58358a03', '2019-07-25 08:36:21', 0),
(162, 'FRANCISCO CANINDE DE ALBUQUERQUE DOS SANTOS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisco.santos', '4e7ae85fe5ca09acca1b2a721c5570ec', '2019-07-25 08:36:21', 0),
(163, 'FRANCISCO CANINDE DE FRANCA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.franca', '09076fbc780a5a2b5cc20824a8a74f94', '2019-07-25 08:36:21', 0),
(164, 'FRANCISCO CANINDE FERNANDES DE QUEIROZ', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.queiroz', '9b6c5e2a56f072b890631a7b320c1410', '2019-07-25 08:36:21', 0),
(165, 'FRANCISCO CARDOSO DE MELO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.melo', '76a4f75dae3c3cebd25e0e1a63a2b8ec', '2019-07-25 08:36:21', 0),
(166, 'FRANCISCO DE PAULO MAURICIO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'francisco.mauricio', '2282e022e56af12a987a70afffb79bd6', '2019-07-25 08:36:21', 0),
(167, 'FRANCISCO DE SOUZA JUNIOR', 'PROF SUPLEM P9C', NULL, 1, NULL, 'francisco.junior', '5a4fd635cfcaf5a06db81b05481d790c', '2019-07-25 08:36:21', 0),
(168, 'FRANCISCO EDVALSON PEREIRA FILHO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisco.filho', '1c739b74f6740f72b9cc56231e8e1fa5', '2019-07-25 08:36:21', 0),
(169, 'FRANCISCO EUDES DA SILVA FONTES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisco.fontes', 'bbce6fb1a079a4cd30cf8c33e6bea1fb', '2019-07-25 08:36:21', 0),
(170, 'FRANCISCO FILADELFO DE FIGUEIREDO JUNIOR', 'Cargo Requisitado/Comissionado', NULL, 1, NULL, 'francisco.junior', '99662cecedbb76bc43168119110277c2', '2019-07-25 08:36:21', 0),
(171, 'FRANCISCO MARCELINO DA SILVA NETO', 'PROF PERM NIVEL - III', NULL, 1, NULL, 'francisco.neto', '03f2f3f210d458ecef2276d1427ebfad', '2019-07-25 08:36:21', 0),
(172, 'FRANCISCO MARIA DE OLIVEIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'francisco.oliveira', '6b8d89cf66268196b29fb3eec8e95d33', '2019-07-25 08:36:21', 0),
(173, 'FRANKLIN ESLLEY PAIVA SILVA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'franklin.silva', '199d4a1dfdeb8efbb9df2a193d2d97fe', '2019-07-25 08:36:21', 0),
(174, 'FRANKSWELL MACKSON SOARES DE MOURA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'frankswell.moura', 'be5f76c5ff476e6a3eccb644d12e73cb', '2019-07-25 08:36:21', 0),
(175, 'GABRIELA MEDEIROS DE MACEDO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'gabriela.macedo', '507a3ece369a3412ed38ba89b0cea841', '2019-07-25 08:36:21', 0),
(176, 'GECIEDNA COSTA DE MEDEIROS', 'ANALISTA TECNICO FORENSE', NULL, 1, NULL, 'geciedna.medeiros', '17b97845132e0a4817d80da38879fda4', '2019-07-25 08:36:21', 0),
(177, 'GEILNE ALVES QUEIROZ', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'geilne.queiroz', '138b3cbf5b2d7e0735cbffe977037e3f', '2019-07-25 08:36:21', 0),
(178, 'GEINE CELLI SUASSUNA DANTAS MOURA', 'CARGO REQUISITADO', NULL, 1, NULL, 'geine.moura', 'c5958c72c14f79009ad9612b38552e6b', '2019-07-25 08:36:21', 0),
(179, 'GENALDO CANUTO DE SOUZA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'genaldo.souza', '48accf894a15e627848cbc9d979ea0af', '2019-07-25 08:36:21', 0),
(180, 'GEORGINO CESAR DE SOUZA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'georgino.souza', '05d2e8949b9308d4164b14dcf61f9044', '2019-07-25 08:36:21', 0),
(181, 'GILBERTO DE MORAIS TARGINO FILHO', 'PROF PERM NIVEL - I', NULL, 1, NULL, 'gilberto.filho', '4b5f467b7594f4e79e28ecbfa3fb58e0', '2019-07-25 08:36:21', 0),
(182, 'GILKARLA SOARES', 'SEM CARGO', NULL, 1, NULL, 'gilkarla.soares', 'efd6a918bb905f8df8b3e09f7f0e6663', '2019-07-25 08:36:21', 0),
(183, 'GILLES VELENEUVE TRINDADE SILVANO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'gilles.silvano', 'cc82f3abec2c88b48d896fa97dfeee2b', '2019-07-25 08:36:21', 0),
(184, 'GILMAR TEIXEIRA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'gilmar.silva', '8eb7fef5785b9b53bd85cc7a8c88c972', '2019-07-25 08:36:21', 0),
(185, 'GIOVANI DOS ANJOS CERSOSIMO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'giovani.cersosimo', '5d32546c68d499d79b7b215acd2adf69', '2019-07-25 08:36:21', 0),
(186, 'GIVANALDO GOMES DA SILVA SEGUNDO', 'CARGO REQUISITADO', NULL, 1, NULL, 'givanaldo.segundo', '92f2179d012fa16f7196ec4b793b1cea', '2019-07-25 08:36:21', 0),
(187, 'GLAUBER HENRIQUE FREITAS BESSA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'glauber.bessa', '5a31148b6c0748b7a52071640b9d71ae', '2019-07-25 08:36:21', 0),
(188, 'GRECIA SYLVANYA DA COSTA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'grecia.costa', '29e9679765ed9ed2a84e047c1c02c5bb', '2019-07-25 08:36:21', 0),
(189, 'GREGORIO JOSE SARMENTO NETO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'gregorio.neto', 'b1be81a9eef2d9f2af3a956650e4e9da', '2019-07-25 08:36:21', 0),
(190, 'GUSTAVO ANTONIO MARCONDES DE PAULA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'gustavo.paula', '1aa56ece8d7e02b6403a4715e5174588', '2019-07-25 08:36:21', 0),
(191, 'GUSTAVO AUGUSTO MENDES COSTA LIMA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'gustavo.lima', 'a9c887eeeae4674bd03bac2e3ba8ec9f', '2019-07-25 08:36:21', 0),
(192, 'GUSTAVO CESAR DIAS MENDES', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'gustavo.mendes', '980ec4b0b8ff4dbd7a058989edcd21af', '2019-07-25 08:36:21', 0),
(193, 'HELENILCE ARAUJO GRILO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'helenilce.grilo', 'acca7056e87ed6adb2dc7e4cd25e52cd', '2019-07-25 08:36:21', 0),
(194, 'HENRIQUE EDUARDO DOS SANTOS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'henrique.santos', 'a92c470640e6c0edf7655fb7773bf248', '2019-07-25 08:36:21', 0),
(195, 'HIDALGO XAVIER DE SOUSA REBOUCAS', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'hidalgo.reboucas', '381c18f4f817460bff9e4df24a9c7b40', '2019-07-25 08:36:21', 0),
(196, 'HUGO PEREIRA DA SILVA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'hugo.silva', 'f77268b021a8ae2de2aa7d7ee5318239', '2019-07-25 08:36:21', 0),
(197, 'IANA ANGELICA DIAS MEDEIROS', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'iana.medeiros', 'c2b937360f9eb85b85a6ea37404633bb', '2019-07-25 08:36:21', 0),
(198, 'ILCIVONE ALVES DE OLIVEIRA UCHOA', 'TECNICO EM ENFERMAGEM', NULL, 1, NULL, 'ilcivone.uchoa', 'a8562ef67a9f05f953fa3cff4f1ad09c', '2019-07-25 08:36:21', 0),
(199, 'ILKA RAMOS DE BRITO SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ilka.silva', '90355e3064be1ab37df494323405caf5', '2019-07-25 08:36:21', 0),
(200, 'INAIRA MAURICIO DE MENEZES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'inaira.menezes', '849b90822d630dfce9c28af17f798ff0', '2019-07-25 08:36:21', 0),
(201, 'INES VIRGINIA CABALLERO DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ines.silva', '86372b6398087d93671ee9d33da8ecd3', '2019-07-25 08:36:21', 0),
(202, 'IOLANDA HOLANDA DE OLIVEIRA', 'CARGO REQUISITADO', NULL, 1, NULL, 'iolanda.oliveira', '556e3d02acef3b3dfb918d2f2c4584ff', '2019-07-25 08:36:21', 0),
(203, 'IRAGUACY LIMA DE ALMEIDA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'iraguacy.almeida', 'd27e2d8c27bf901fb7ee80fcdeb9bac7', '2019-07-25 08:36:21', 0),
(204, 'IRIS PEREIRA DE SA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'iris.sa', 'b6178a1d3171acc51986dd7ca11532cb', '2019-07-25 08:36:21', 0),
(205, 'IRONOMARQUE BATISTA DE MORAIS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'ironomarque.morais', 'cf455f4892c3b7db01f07d07043e8d6e', '2019-07-25 08:36:21', 0),
(206, 'ISAC AXEL DE MEDEIROS NOGUEIRA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'isac.nogueira', '7eb96889e50ff513c1ba667182d8c628', '2019-07-25 08:36:21', 0),
(207, 'ISAQUE RODRIGUES FREIRE GUEDES', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'isaque.guedes', '4d83bf2e1ec8dc3158ad4256e1e0e28c', '2019-07-25 08:36:21', 0),
(208, 'ISMAEL MENDES JUNIOR', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'ismael.junior', '836abee39f3011cc8339efbdfd89e30e', '2019-07-25 08:36:21', 0),
(209, 'ITALO MARTINS FORMIGA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'italo.formiga', '491877b814424e6ac365a705d5fe7952', '2019-07-25 08:36:21', 0),
(210, 'ITANIA MARIA DUARTE', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'itania.duarte', '646b0b6bfe59e0e71fa10da075716261', '2019-07-25 08:36:21', 0),
(211, 'IVAN COELHO DE SOUZA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'ivan.souza', '5ad16af1c202e913b685657deda8ece9', '2019-07-25 08:36:21', 0),
(212, 'IVAN FERNANDES DE OLIVEIRA FILHO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ivan.filho', '081125a6af74914d9d0e75aae32ef09f', '2019-07-25 08:36:21', 0),
(213, 'IVANALDO GOMES DA SILVA', 'ASSISTENTE INFORMATICA II - DATANORTE', NULL, 1, NULL, 'ivanaldo.silva', '5869352c2e61eb1e27ce0e1da55167c6', '2019-07-25 08:36:21', 0),
(214, 'IZAIAS REMAILES SILVA DE PAULA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'izaias.paula', '987496a1dab7d7a31f51dfc46b3cb655', '2019-07-25 08:36:21', 0),
(215, 'JACINTA PEREIRA DE MEDEIROS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jacinta.medeiros', '733c0421736dc3f795c9c5342706649e', '2019-07-25 08:36:21', 0),
(216, 'JACO MARTINS DE SOUSA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jaco.sousa', 'a7e46f1b75febc5f331b462bdbe8a914', '2019-07-25 08:36:21', 0),
(217, 'JACQUELINE BATISTA DA TRINDADE', 'AUX ADMINISTRATIVO II - EMPROTURN', NULL, 1, NULL, 'jacqueline.trindade', 'e294b47ea70b47ff0197489a728735d4', '2019-07-25 08:36:21', 0),
(218, 'JACQUELINE NASCIMENTO DE OLIVEIRA GARCIA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jacqueline.garcia', '7e930ed72c4c9f837e9d24047b685a4b', '2019-07-25 08:36:21', 0),
(219, 'JADER VIANA DE SOUZA JUNIOR', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jader.junior', '4c7bb1812709594295799f039cdfbff9', '2019-07-25 08:36:21', 0),
(220, 'JAIME DA COSTA CIRNE FILHO', 'AUXILIAR DE INFRAESTRUTURA (GNO)', NULL, 1, NULL, 'jaime.filho', '7f0506c0e67e7bce6b979a2b167c5020', '2019-07-25 08:36:21', 0),
(221, 'JAMAILDO PADRE DE ARAUJO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'jamaildo.araujo', 'a3986d7ca4b04d3503ac196cfce702c1', '2019-07-25 08:36:21', 0),
(222, 'JAMIL DIEB', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jamil.dieb', '7e9192f2b2150cc189b7f8c252f31128', '2019-07-25 08:36:21', 0),
(223, 'JANE RIBEIRO GURGEL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jane.gurgel', '0909b8793d9dfd372c7836d6e257ebf9', '2019-07-25 08:36:21', 0),
(224, 'JANILSON TEIXEIRA DE ALBUQUERQUE', 'AGENTE DE COBRANÃ‡A - COHAB', NULL, 1, NULL, 'janilson.albuquerque', '329ba79d7c2dbfbe82a4d30b7c8b036c', '2019-07-25 08:36:21', 0),
(225, 'JANUARIO GONCALVES DE OLIVEIRA', 'ANALISTA DE SISTEMAS PLENO - DATANORTE', NULL, 1, NULL, 'januario.oliveira', '2410cc29f28c37b62380d4ef41dc4a66', '2019-07-25 08:36:21', 0),
(226, 'JEAN MARCIO DOS SANTOS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'jean.santos', 'c952e5ff1ecab40b600c72f9926bd019', '2019-07-25 08:36:21', 0),
(227, 'JEFFERSON ARAUJO DE MAGALHAES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jefferson.magalhaes', 'e589349b49e10f2f335eb772f88e202e', '2019-07-25 08:36:21', 0),
(228, 'JENNESON ANDRADE DE ARAUJO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'jenneson.araujo', '8a02a5ea0d7d31a867af79f2a3cf63ce', '2019-07-25 08:36:21', 0),
(229, 'JESSIKA RENALLY RIBEIRO RODRIGUES ZANELLA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jessika.zanella', '473569a4861f4e45962c8ba75bf1866f', '2019-07-25 08:36:21', 0),
(230, 'JEZREEL PAULA DE AQUINO', 'SUBCOORDENADOR DO IML', NULL, 4, NULL, 'jezreel.aquino', '15c78e688a380b8c4391f3c39b1b2969', '2019-07-26 13:25:53', 1),
(231, 'JOAILSON JOSE DA COSTA', 'AUXILIAR DE INFRAESTRUTURA (GNO)', NULL, 1, NULL, 'joailson.costa', '08198ea427d9c32dffaa778680e2c7a7', '2019-07-25 08:36:21', 0),
(232, 'JOAO ALEXANDRE DE FIGUEIREDO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'joao.figueiredo', '7a76e757574f504bf0fff2e6bb1b1135', '2019-07-25 08:36:21', 0),
(233, 'JOAO BATISTA DE SOUZA', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'joao.souza', '4ba2b193980e3180d94e47a80a8f647f', '2019-07-25 08:36:21', 0),
(234, 'JOAO BATISTA LIMA LINHARES DE SOUSA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'joao.sousa', 'd8a6f3cc76bccfff85899bb4495b03b9', '2019-07-25 08:36:21', 0),
(235, 'JOAO GABRIEL BEZERRA COSTA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'joao.costa', '30df954b732c5543847cccc1bd906b79', '2019-07-25 08:36:21', 0),
(236, 'JOAO HELIO FERREIRA NETO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'joao.neto', '400caf50ac488f9ef72b556b2518b0db', '2019-07-25 08:36:21', 0),
(237, 'JOAO MARIA DE MACEDO', 'ASSISTENTE ADMINISTRATIVO (GNM)', NULL, 1, NULL, 'joao.macedo', 'd581f25b1afb3b6ac669c4f50c356f98', '2019-07-25 08:36:21', 0),
(238, 'JOAO MARIA DE SOUZA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'joao.souza', '0340d4bb9d496957d0f5930d96b40ca5', '2019-07-25 08:36:21', 0),
(239, 'JOAO MARIA FELIX DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'joao.silva', 'e5de55823a0ef398057b1163b7bbf474', '2019-07-25 08:36:21', 0),
(240, 'JOAO MARIA GALVAO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'joao.galvao', 'fd63858bc29e213c595a68474501c24f', '2019-07-25 08:36:21', 0),
(241, 'JOAO PEDROZA DANTAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'joao.dantas', '2bf7c128225bfe51a595ba59c4777d5c', '2019-07-25 08:36:21', 0),
(242, 'JOAO REVOREDO MARQUES FILHO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'joao.filho', 'e39897aa2e777f063d042e7f2667c7e9', '2019-07-25 08:36:21', 0),
(243, 'JOAO SOARES NETO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'joao.neto', '7a5714bf394674d6e889a5fa8e0d7053', '2019-07-25 08:36:21', 0),
(244, 'JOAO TORRES PINTO', 'MEDICO - ITEP', NULL, 1, NULL, 'joao.pinto', 'c4539793a044c89e48ded56ff82e038b', '2019-07-25 08:36:21', 0),
(245, 'JOAQUIM GUIMARAES DE MENEZES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'joaquim.menezes', 'f7351cd069f7a862e0aeb887ecd03aea', '2019-07-25 08:36:21', 0),
(246, 'JOEL BORBA FILHO', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'joel.filho', 'b1b1df19ae5b17975b7deb737029c052', '2019-07-25 08:36:21', 0),
(247, 'JOMAR FERNANDES GOMES DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jomar.silva', '7f090d4f33ff95a67cc0cadf419e7468', '2019-07-25 08:36:21', 0),
(248, 'JOSE ALCIDES GURGEL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.gurgel', '75955abd8fda7942dd6f220122bd898c', '2019-07-25 08:36:21', 0),
(249, 'JOSE AUGUSTO GALVAO PEREIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.pereira', '986a02b309686ff2501b94f5e144236e', '2019-07-25 08:36:21', 0),
(250, 'JOSE CARLOS DA SILVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.silveira', '23b1a1f0333b4c41bf6e5bedca521019', '2019-07-25 08:36:21', 0),
(251, 'JOSE CARLOS FERREIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.ferreira', 'eaa0f70d26f830debefa354a59ce32cc', '2019-07-25 08:36:21', 0),
(252, 'JOSE CLEONILDO DE MORAIS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.morais', 'd20a73522df97f0b684421cba0c9a9ee', '2019-07-25 08:36:21', 0),
(253, 'JOSE DE ARIMATEIA AVELINO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.avelino', '6b11779faee93c4d00f9ebd6557ef5f6', '2019-07-25 08:36:21', 0),
(254, 'JOSE DE ARIMATEIA DE OLIVEIRA', 'PROGRAMADOR PLENO - DATANORTE', NULL, 1, NULL, 'jose.oliveira', 'e15ec273c96f41405c14bf4f9a5c6e47', '2019-07-25 08:36:21', 0),
(255, 'JOSE DE ARIMATEIA DOS SANTOS SANTIAGO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.santiago', '99ba7b7bd155835f82657b3f84e7921f', '2019-07-25 08:36:21', 0),
(256, 'JOSE DE LIMA PEREIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.pereira', 'b5c143af7bb5ee709003576dd18bf80b', '2019-07-25 08:36:21', 0),
(257, 'JOSE DE SOUZA PINTO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jose.pinto', '4746bd1f2449de6dd5d5af799d789e45', '2019-07-25 08:36:21', 0),
(258, 'JOSE EDUARDO BARBOSA', 'AUXILIAR DE INFRAESTRUTURA (GNO)', NULL, 1, NULL, 'jose.barbosa', '1c32a5d14174a02620cb9996d1bf6810', '2019-07-25 08:36:21', 0),
(259, 'JOSE EUDES BEZERRIL', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.bezerril', 'c0d800fd5ded1612d05e074e860e4a14', '2019-07-25 08:36:21', 0),
(260, 'JOSE FERREIRA DA SILVA JUNIOR', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'jose.junior', '1852f65815219d54cdb90b2814e9adbf', '2019-07-25 08:36:21', 0),
(261, 'JOSE FILHO BEZERRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.bezerra', 'a2c76adb91bb39ad029a3fe7b6f31e5e', '2019-07-25 08:36:21', 0),
(262, 'JOSE GEORGE VARELA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.varela', 'a4fb32aae96bef0645e8970e72c5134a', '2019-07-25 08:36:21', 0),
(263, 'JOSE GERMANO DA SILVA NETO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jose.neto', '0df67b313a4660b2c748e43c107d0114', '2019-07-25 08:36:21', 0),
(264, 'JOSE GOMES DA SILVA FILHO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.filho', 'a52ab168898fd09266ac8bb37a0c811d', '2019-07-25 08:36:21', 0),
(265, 'JOSE MARIA LISBOA SOBRINHO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.sobrinho', 'd0089d74198eced82323a3ed6a71b6a2', '2019-07-25 08:36:21', 0),
(266, 'JOSE NAZARENO ALVES DE SOUZA', 'MOTORISTA - COHAB', NULL, 1, NULL, 'jose.souza', '928d3a328384df93f1d9f29b5bd9cc08', '2019-07-25 08:36:21', 0),
(267, 'JOSE NILSON DOS SANTOS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.santos', 'a0101a61eb575f0922832878d49256d5', '2019-07-25 08:36:21', 0),
(268, 'JOSE NUNES DA SILVA FILHO', 'SEM CARGO', NULL, 1, NULL, 'jose.filho', 'b61d905031d6a78faf04dfc3c4076555', '2019-07-25 08:36:21', 0),
(269, 'JOSE PEREIRA DA SILVA JUNIOR', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'jose.junior', '69918d391a3e199f329607d879682aae', '2019-07-25 08:36:21', 0),
(270, 'JOSE RISONALDO DE ABRANTES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'jose.abrantes', '3350fd91fea8f80f0df8c64361132139', '2019-07-25 08:36:21', 0),
(271, 'JOSE ROBERTO DA ROCHA PEREIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.pereira', '18f130236f587086aebd679701785090', '2019-07-25 08:36:21', 0),
(272, 'JOSE VANDIR DOS SANTOS XAVIER', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'jose.xavier', '5dbdd07151ea9fd824eece7996d68455', '2019-07-25 08:36:21', 0),
(273, 'JOSEANE XAVIER DE LIMA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'joseane.lima', '797e071753ec3171db2ebc45d1352699', '2019-07-25 08:36:21', 0),
(274, 'JOSELY DE SOUZA GONCALVES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'josely.goncalves', '39681d26f33c59532caddcf5d649dc76', '2019-07-25 08:36:21', 0),
(275, 'JOSETE DE OLIVEIRA LOPES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'josete.lopes', '3f5434c9f10313d3642de424c629e7ea', '2019-07-25 08:36:21', 0),
(276, 'JOSSERGIO SOARES ANTAS DE GOUVEIA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jossergio.gouveia', 'c6219d547601f0804211cd48787bc567', '2019-07-25 08:36:21', 0),
(277, 'JUAREZ BEZERRA DE AZEVEDO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'juarez.azevedo', 'a0a997c01f3b8ad17e3f2f92154601f3', '2019-07-25 08:36:21', 0),
(278, 'JUCIMARA VANESSA BALDUINO DE OLIVEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'jucimara.oliveira', '3a9e48524c0a2a80177906a89bc455b0', '2019-07-25 08:36:21', 0),
(279, 'JULIANNE MEDINO DE ARAUJO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'julianne.araujo', 'c345f550e1467ae008c20ca79f184972', '2019-07-25 08:36:21', 0),
(280, 'JULIO CESAR GOMES NUNES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'julio.nunes', '09ae433add66f64e32a8f2c0ba68b0a7', '2019-07-25 08:36:21', 0),
(281, 'JULIO CESAR LIMA DA ROCHA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'julio.rocha', '7149eefe9de22f4d569ce06a94950934', '2019-07-25 08:36:21', 0),
(282, 'KARINE CORADINI', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'karine.coradini', 'dae1a9307737b28f969e3f1931177d0f', '2019-07-25 08:36:21', 0),
(283, 'KARLA PINHEIRO DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'karla.oliveira', '3dde916f42a6090173c73480b4c784ad', '2019-07-25 08:36:21', 0),
(284, 'KARLA VERUSKA DE SOUZA ARARUNA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'karla.araruna', '3e8c551a310b4057a53c96db56b391a6', '2019-07-25 08:36:21', 0),
(285, 'KELSEN NOBRE DE ANDRADE', 'CABO - PM/CBM', NULL, 1, NULL, 'kelsen.andrade', '31f2bcaae30b8eeb0638eb22581f50d5', '2019-07-25 08:36:21', 0),
(286, 'KERMA KELLER COSTA DE SOUZA DANTAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'kerma.dantas', '130e7cc9c1667a30d3c3422abb473e65', '2019-07-25 08:36:21', 0),
(287, 'KLEBER JOSE DE O MOURA', 'CARGO REQUISITADO', NULL, 1, NULL, 'kleber.moura', 'cc860e3c607b3e216fb7e7568c007717', '2019-07-25 08:36:21', 0),
(288, 'LAENY NILO SILVA DOS SANTOS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'laeny.santos', '3667622aff5b9a22b29b4705bf2a3059', '2019-07-25 08:36:21', 0),
(289, 'LARISSA OLIVEIRA AGUIAR', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'larissa.aguiar', '7aa1a92a96acfe15769637acb076e4b4', '2019-07-25 08:36:21', 0),
(290, 'LARISSA RODRIGUES ATAIDE JUNIOR', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'larissa.junior', 'eec3e018c0dc6d1e22688eec1a2d9a25', '2019-07-25 08:36:21', 0),
(291, 'LAUDEMAR ROBERTO DOS SANTOS PESSOA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'laudemar.pessoa', 'e6222a0b796f3426de12218e82be5d22', '2019-07-25 08:36:21', 0),
(292, 'LAURA BREYDZA CAVALCANTE DE ARAUJO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'laura.araujo', 'b17e2d33f773e0afed392d4aae0f996a', '2019-07-25 08:36:21', 0),
(293, 'LEIDE MARY NORONHA CASTRO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'leide.castro', '3043da05dca1a2e46c3970d098d11db9', '2019-07-25 08:36:21', 0),
(294, 'LEILA EMIDIA CARVALHO FONTES CARDOSO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'leila.cardoso', '8e307dade79709c9ae832fe7c9c64399', '2019-07-25 08:36:21', 0),
(295, 'LEILSON AZEVEDO MARTINS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'leilson.martins', '82f1871778f614b1a4e71d29dfd84065', '2019-07-25 08:36:21', 0),
(296, 'LEONARDO AUGUSTO REGO DE SOUZA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'leonardo.souza', '4d94839bd38301cd314afc8eb11ae57c', '2019-07-25 08:36:21', 0),
(297, 'LETICIA OLIVEIRA BRITO PLACIDO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'leticia.placido', '2cdc2a248995fc6aed3008b84d7e1ae0', '2019-07-25 08:36:21', 0),
(298, 'LEVI LOPES TORRES', 'SEM CARGO', NULL, 1, NULL, 'levi.torres', 'a7d02380d8fdb5bee6cb9f2ab3bf570e', '2019-07-25 08:36:21', 0),
(299, 'LEVI MOREIRA DE MORAIS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'levi.morais', '8b5856ac8d2744f80caf757480a35bae', '2019-07-25 08:36:21', 0),
(300, 'LEVI NUNES MEDEIROS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'levi.medeiros', 'de136fa09d3706fc8ee22b20675dbf3b', '2019-07-25 08:36:21', 0),
(301, 'LILIAN MARCIA SANTIAGO DO NASCIMENTO FONSECA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'lilian.fonseca', '917d117de983862cded98aec301809de', '2019-07-25 08:36:21', 0),
(302, 'LUAN MOTA VIEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'luan.vieira', 'f22d82629e60acaa54d15838fe9c3af8', '2019-07-25 08:36:21', 0),
(303, 'LUCAS CONRADO SAVIETO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'lucas.savieto', '4cedce0e603f1c0758de2573492741da', '2019-07-25 08:36:21', 0),
(304, 'LUCAS DE SOUZA XAVIER', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'lucas.xavier', '867366d14f959821dca85e765dd0d516', '2019-07-25 08:36:21', 0),
(305, 'LUCAS MARTINS DE MOURA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'lucas.moura', 'ffc66bbfebede304651b67c54c6eb14a', '2019-07-25 08:36:21', 0),
(306, 'LUCAS RAFAEL PINTO NOBRE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'lucas.nobre', 'b582ad9741d6acb0a41226919232b8ce', '2019-07-25 08:36:21', 0),
(307, 'LUCIA HELENA BOSCO DE MIRANDA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'lucia.miranda', 'fc9be6109e98662ce594d4eecb13a96d', '2019-07-25 08:36:21', 0),
(308, 'LUCIA MARIA SANTOS DA CRUZ', 'TECNICO DE NIVEL SUPERIOR - COHAB', NULL, 1, NULL, 'lucia.cruz', 'e4b25af43a3b34d94bb419f619311039', '2019-07-25 08:36:21', 0),
(309, 'LUCIA MEDEIROS DANTAS', 'ANALISTA TECNICO FORENSE', NULL, 1, NULL, 'lucia.dantas', 'e19c9e4e202e022bb5c2b198b4796339', '2019-07-25 08:36:21', 0),
(310, 'LUCIANA LIMA DE FREITAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'luciana.freitas', 'fcd1572938fa4cc104d503d3c6e5c0ae', '2019-07-25 08:36:21', 0),
(311, 'LUCIANA PEREIRA DE MOURA LIMA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'luciana.lima', '1fdeb21fcd89b23893229c65fe7cd317', '2019-07-25 08:36:21', 0);
INSERT INTO `usuarios_tb` (`usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_matricula`, `usuario_setor_id`, `usuario_setor_edit`, `usuario_login`, `usuario_senha`, `usuario_update_data`, `usuario_cadastrado`) VALUES
(312, 'LUCIMAR BEZERRA ALVES', 'TECNICO DE NIVEL SUPERIOR - COHAB', NULL, 1, NULL, 'lucimar.alves', 'a695dbc7109bdb682bf73bbcd5089eda', '2019-07-25 08:36:21', 0),
(313, 'LUCINETE PEREIRA DE ARAUJO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'lucinete.araujo', 'dbf1121c5a0020a28c22fb201e5d005e', '2019-07-25 08:36:21', 0),
(314, 'LUCIO FLAVIO FERNANDES DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'lucio.oliveira', '44dfb324f063b1427a83619a2d392aa3', '2019-07-25 08:36:21', 0),
(315, 'LUIS ANTONIO DE OLIVEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'luis.oliveira', '800344ab99e6eb5d1af87d3f61b2fc5b', '2019-07-25 08:36:21', 0),
(316, 'LUIS MANUEL ESTEVES DA ROCHA VIEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'luis.vieira', '989b1cddd6b4e6bf80c4bdb7bed802da', '2019-07-25 08:36:21', 0),
(317, 'LUIS PAULO ALVES SILVA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'luis.silva', '6d9da49bdfdaecc5073fa5e5a9e7dd40', '2019-07-25 08:36:21', 0),
(318, 'LUIZ ANTONIO DUARTE LIMA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'luiz.lima', 'ba2403282da5daa37e3c47d8b299086c', '2019-07-25 08:36:21', 0),
(319, 'LUIZ CARLOS BARBOSA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'luiz.barbosa', 'dcf8e7a40c06a06d9a32d14583d9783e', '2019-07-25 08:36:21', 0),
(320, 'LUIZ EDUARDO LEOCADIO CAVALCANTI', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'luiz.cavalcanti', '0f1fcddf68def0f25e77a628c10359f9', '2019-07-25 08:36:21', 0),
(321, 'LYDICE CAROLINNE MELO DE CARVALHO GUERRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'lydice.guerra', '891fa433f885f4edce3027c7bcf2fa72', '2019-07-25 08:36:21', 0),
(322, 'MAGALI PACHECO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'magali.pacheco', '69f57b7ab029f498a996d3f8a5bf0c08', '2019-07-25 08:36:21', 0),
(323, 'MAGDA GODEIRO DUTRA TEIXEIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'magda.teixeira', 'f736a780934e2fa7454819e28fd4298f', '2019-07-25 08:36:21', 0),
(324, 'MAGNA ANIZERETHE LEITE DANTAS', 'PROF PERM NIVEL - I', NULL, 1, NULL, 'magna.dantas', 'a5ea847453fedc8d7bfad3a87866e062', '2019-07-25 08:36:21', 0),
(325, 'MAGNOLIA ARRUDA MARIANO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'magnolia.mariano', 'a4b2631a7e6729d5bc551f15f825a6aa', '2019-07-25 08:36:21', 0),
(326, 'MAGNOLIA LIZANDRA DA SILVA LIMA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'magnolia.lima', '640efb1066adab2d8ac3bd93ab31d318', '2019-07-25 08:36:21', 0),
(327, 'MAIARA FELIPE SOUZA DAMASCENA', 'SEM CARGO', NULL, 1, NULL, 'maiara.damascena', 'f11bd948fb1406fc7239f16c3bbea144', '2019-07-25 08:36:21', 0),
(328, 'MAISA DE OLIVEIRA MEIRA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'maisa.meira', 'f0810249f646996999443ca88b9e188a', '2019-07-25 08:36:21', 0),
(329, 'MAKEZIA SAYURE DE MORAIS GURGEL', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'makezia.gurgel', '47c4ca108a4b7fbf0dd115f20abf2acf', '2019-07-25 08:36:21', 0),
(330, 'MANOEL BATISTA DE PONTES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'manoel.pontes', '37c7a6f3128766ae7e02f3d1080d2672', '2019-07-25 08:36:21', 0),
(331, 'MANOEL VIRGOLINO DA SILVA FILHO', 'ASSIST TEC ADMINISTRATIVO II - CIDA', NULL, 1, NULL, 'manoel.filho', '963ad14c0dd203d6a058a21f84712129', '2019-07-25 08:36:21', 0),
(332, 'MARCELO ALVES DO NASCIMENTO', 'AUX DE ESCRITORIO I - CDI', NULL, 1, NULL, 'marcelo.nascimento', '291b978ea306614614e28820ac0b9010', '2019-07-25 08:36:21', 0),
(333, 'MARCELO GLAUBER DA SILVA PEREIRA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'marcelo.pereira', '9df684d8e50a4537e3e97a47fc2becec', '2019-07-25 08:36:21', 0),
(334, 'MARCIA MARIA GALVAO DE MOURA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'marcia.moura', '8fe49e961231fce6ffba9ba1db31a900', '2019-07-25 08:36:21', 0),
(335, 'MARCONDE JOSE DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'marconde.silva', '41e91d1e47bcfbac885aafc48659cea4', '2019-07-25 08:36:21', 0),
(336, 'MARCONI FERREIRA DE MEDEIROS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'marconi.medeiros', '02cb61e9553a97dc13b058e2ea3f25c5', '2019-07-25 08:36:21', 0),
(337, 'MARCOS ANTONIO DAS CHAGAS', 'CARGO REQUISITADO', NULL, 1, NULL, 'marcos.chagas', '8ae926335e166795f32f3325a2ad511a', '2019-07-25 08:36:21', 0),
(338, 'MARCOS ANTONIO XAVIER DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'marcos.silva', 'ef63627355033c9c7b3becce1027d2d3', '2019-07-25 08:36:21', 0),
(339, 'MARCOS DAIAN FIGUEIREDO DA SILVA SARAIVA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'marcos.saraiva', '730bb286db58f4c8fae0ac3ce1060cae', '2019-07-25 08:36:21', 0),
(340, 'MARCOS JOSE BRANDAO GUIMARAES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'marcos.guimaraes', '0f0b17031dee33a8d5de3c157c6a399e', '2019-07-25 08:36:21', 0),
(341, 'MARIA ABIGAIL DIOGENES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.diogenes', '8b10e47eb73817daa3efc921ea46c718', '2019-07-25 08:36:21', 0),
(342, 'MARIA ADRIANA GOMES DA SILVA', 'SEM CARGO', NULL, 1, NULL, 'maria.silva', '86185ccbf9976ddab758d1c56f133e5e', '2019-07-25 08:36:21', 0),
(343, 'MARIA ALCIVANIA DE MORAIS LOURENCO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.lourenco', 'e423e872d08f16c9c60ebeba4b440d37', '2019-07-25 08:36:21', 0),
(344, 'MARIA ALICE GOMES DE FARIAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.farias', 'd05587fae27e57b74c9003bb398f0876', '2019-07-25 08:36:21', 0),
(345, 'MARIA ALZENEIDE DE OLIVEIRA', 'SEM CARGO', NULL, 1, NULL, 'maria.oliveira', '6eb437caf9d73d2e5944eab9a5225eab', '2019-07-25 08:36:21', 0),
(346, 'MARIA ANTONIA SILVA DE OLIVEIRA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.oliveira', 'cddba1db251d86766b243dc4a1c24979', '2019-07-25 08:36:21', 0),
(347, 'MARIA APARECIDA AFONSO DE MEDEIROS SANTOS', 'AXA B - AUX SERV TEC ADMINISTRATIVOS', NULL, 1, NULL, 'maria.santos', '33e01c9f4f2ab6de0fe3d4b8dcc41179', '2019-07-25 08:36:21', 0),
(348, 'MARIA AURINEIDE GOMES NUNES DE FREITAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.freitas', '58f0401702817e2d8ef6fa23e76f069d', '2019-07-25 08:36:21', 0),
(349, 'MARIA BEATRIZ DE MELO FONSECA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.fonseca', '98a6619df0b977ce8046761da848d0e0', '2019-07-25 08:36:21', 0),
(350, 'MARIA CRISTINA FERREIRA DE ALMEIDA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.almeida', '75abfc7dd12d882a01dfe018f9889d35', '2019-07-25 08:36:21', 0),
(351, 'MARIA DA CONCEICAO SANTOS DE CASTRO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.castro', '106083ba27cb6f894348f2d20dcd711e', '2019-07-25 08:36:21', 0),
(352, 'MARIA DANTAS DE MELO NETA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.neta', 'dd13cb22d1fb664fe7f04fed3b5b81ac', '2019-07-25 08:36:21', 0),
(353, 'MARIA DAS DORES DE OLIVEIRA NETA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.neta', '353715ca57a0f6d13848ba922092f05e', '2019-07-25 08:36:21', 0),
(354, 'MARIA DAS GRACAS COSTA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.silva', 'ff8d4401231665fd41a866ba8edec59a', '2019-07-25 08:36:21', 0),
(355, 'MARIA DAS GRACAS DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.silva', '557aab0afbf729f5c40fa3826bb62f44', '2019-07-25 08:36:21', 0),
(356, 'MARIA DAS GRACAS DE SOUSA OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.oliveira', '8587ab76f2e9e5584b7c355aa1c1008d', '2019-07-25 08:36:21', 0),
(357, 'MARIA DE FATIMA COSTA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.costa', '76887f9f32a6b345bdd7456c66b39c05', '2019-07-25 08:36:21', 0),
(358, 'MARIA DE FATIMA LUCENA BEZERRA', 'AUXILIAR TEC DE CONTABILIDADE - COHAB', NULL, 1, NULL, 'maria.bezerra', 'ea8141b5d19bf673e41854c164679c81', '2019-07-25 08:36:21', 0),
(359, 'MARIA DE LOURDES CAVALCANTE FERREIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.ferreira', 'e1f2112126d5b394aa5948543c1f5ce6', '2019-07-25 08:36:21', 0),
(360, 'MARIA DE LOURDES DE MACEDO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.macedo', 'f84f578bb8b359076ffb2263dd27a50e', '2019-07-25 08:36:21', 0),
(361, 'MARIA DE LOURDES PAIVA SOLANO MORAIS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.morais', 'b24ca9ba3057f6e9a78dcb2b081b930e', '2019-07-25 08:36:21', 0),
(362, 'MARIA DO SOCORRO DA SILVA COSTA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.costa', '26e2837a473bfcc50ad8452a291ef969', '2019-07-25 08:36:21', 0),
(363, 'MARIA DO SOCORRO GUILHERME DA SILVA', 'ANALISTA TECNICO FORENSE', NULL, 1, NULL, 'maria.silva', 'c9e25aebe8f6217f255f7cf54fb742a6', '2019-07-25 08:36:21', 0),
(364, 'MARIA DO SOCORRO MIRANDA DA NOBREGA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.nobrega', 'd155fff5046d9fbc63706bccacc50232', '2019-07-25 08:36:21', 0),
(365, 'MARIA FERREIRA DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.silva', '25c2a769cb335789fbb97cac9474aabd', '2019-07-25 08:36:21', 0),
(366, 'MARIA GORETTI LUCENA DE OLIVEIRA', 'CARGO REQUISITADO', NULL, 1, NULL, 'maria.oliveira', '6ef7a73dfe178d9dd80006761f83f526', '2019-07-25 08:36:21', 0),
(367, 'MARIA HELENA MOTA DA SILVA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'maria.silva', '7b07df990b28c8538fd8252c034a7e77', '2019-07-25 08:36:21', 0),
(368, 'MARIA IMACULADA VITAL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.vital', '692703ef9e5522fb0f4cd7b41a7ab568', '2019-07-25 08:36:21', 0),
(369, 'MARIA JANUARIA DOS SANTOS BATISTA', 'AUXILIAR DE SERVICOS GERAIS', NULL, 1, NULL, 'maria.batista', '0fb140c4184e00e78a82c5e2951d433a', '2019-07-25 08:36:21', 0),
(370, 'MARIA LUCIA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.silva', '859ee2dbb3a9233524e9c8d80f93067a', '2019-07-25 08:36:21', 0),
(371, 'MARIA LUIZA COSTA LOPES CARDOSO', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'maria.cardoso', '02c60fe7d2927579ab3d0501e63a200a', '2019-07-25 08:36:21', 0),
(372, 'MARIA LUZINETE ULISSES DIAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.dias', '907f51f46df5f09ed2472049c2212e23', '2019-07-25 08:36:21', 0),
(373, 'MARIA NAZARE DE FREITAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maria.freitas', 'f1dc5d119bea0292022abdd2e503b168', '2019-07-25 08:36:21', 0),
(374, 'MARIA SUELY ALVES DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maria.silva', '2f0983ef4bb3c521020a718f2921e28e', '2019-07-25 08:36:21', 0),
(375, 'MARIA VERONEIDE DE OLIVEIRA MAIA', 'CARGO REQUISITADO', NULL, 1, NULL, 'maria.maia', '739489c5123e12c279c6e1f4c5df6c21', '2019-07-25 08:36:21', 0),
(376, 'MARILENE TEIXEIRA DE CARVALHO PINHEIRO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'marilene.pinheiro', '04119da874d0006b32f8e08fce2b6619', '2019-07-25 08:36:21', 0),
(377, 'MARILIA FARIAS DE MELO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'marilia.melo', '372d939a2a7dc5a115f7ef83c0998424', '2019-07-25 08:36:21', 0),
(378, 'MARINA CAVALCANTE GURGEL CARLOS', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'marina.carlos', 'c862088355ac3ce9b422bfd3ebcb0764', '2019-07-25 08:36:21', 0),
(379, 'MARIZA OLIVEIRA BARBOSA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'mariza.barbosa', 'c959e9aef96f759265148e8e64d9f736', '2019-07-25 08:36:21', 0),
(380, 'MARIZA RARENE SARAIVA GUARA', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'mariza.guara', 'cc6bbbf2f744b411b7fa1039f19ee827', '2019-07-25 08:36:21', 0),
(381, 'MARLON FERREIRA DE AQUINO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'marlon.aquino', 'd62561bceaa3035427cdcd6544682a71', '2019-07-25 08:36:21', 0),
(382, 'MATHEUS CARLOS BARBOSA LEAL DE SOUSA FE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'matheus.fe', '0868e88723262f1095b2b7e3d50c4bbd', '2019-07-25 08:36:21', 0),
(383, 'MAURILIO JORDAN ASSUNCAO RAMOS', 'SEM CARGO', NULL, 1, NULL, 'maurilio.ramos', '0be2f91b9feba1f6820446e0e991deb5', '2019-07-25 08:36:21', 0),
(384, 'MAURILUCIA DE OLIVEIRA ROCHA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'maurilucia.rocha', '41a744ce4520ba8fd0160afe2cf8d619', '2019-07-25 08:36:21', 0),
(385, 'MAXIMO TEIXEIRA DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'maximo.oliveira', '3a19b715aafa8f8ff1be8e706b0328a8', '2019-07-25 08:36:21', 0),
(386, 'MERCIA GALVAO DE MOURA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'mercia.moura', 'f466935e866c6512c146be5514fe59c7', '2019-07-25 08:36:21', 0),
(387, 'MICAEL RODRIGO DE OLIVEIRA MACHADO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'micael.machado', 'c96e012c6852e9f4ccdbb9b2b7889b67', '2019-07-25 08:36:21', 0),
(388, 'MOAB ARAUJO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'moab.araujo', 'a281bfc45b59260308c06157818bef36', '2019-07-25 08:36:21', 0),
(389, 'MUCIO FLAVIO DE CARVALHO QUEIROZ FILHO', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'mucio.filho', '6e6a8922b074a577351e65ef00e0834a', '2019-07-25 08:36:21', 0),
(390, 'MYRNA DA SILVA ELEUTERIO', 'Cargo Requisitado/Comissionado', NULL, 1, NULL, 'myrna.eleuterio', '2ee347c8e6b129699c22d772c868bb64', '2019-07-25 08:36:21', 0),
(391, 'NADJA MARIA CAMARA DE SOUZA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'nadja.souza', 'fe0214bc02aba237152c61be0f993c06', '2019-07-25 08:36:21', 0),
(392, 'NADJA SUELY RODRIGUES PESSOA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'nadja.pessoa', '0dbf8b29753e9bcef34379b2ab857347', '2019-07-25 08:36:21', 0),
(393, 'NATAN EMANUELL DE SOBRAL E SILVA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'natan.silva', 'cae6cd92c4fb82ec890d0004dcc878af', '2019-07-25 08:36:21', 0),
(394, 'NATHALIA NUNES E ARAUJO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'nathalia.araujo', '7b69b4916b296924ed9fec091be426a5', '2019-07-25 08:36:21', 0),
(395, 'NAZARENO FERNANDES REGIS JUNIOR', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'nazareno.junior', '897e21cde8dd9bb9cdbefae8c872e496', '2019-07-25 08:36:21', 0),
(396, 'NELMA DE LOURDES AZEVEDO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'nelma.azevedo', 'b747c536b04c7f9273e147493ced21a9', '2019-07-25 08:36:21', 0),
(397, 'NEWTON MOTA GURGEL FILHO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'newton.filho', '23e6d985aeaa6504fedb49666a9a02b7', '2019-07-25 08:36:21', 0),
(398, 'NEYVEMIDIA CORSINO RODRIGUES ALVES', 'AUXILIAR DE INFRAESTRUTURA (GNO)', NULL, 1, NULL, 'neyvemidia.alves', 'e08b079d81a741352e78760c4976ea11', '2019-07-25 08:36:21', 0),
(399, 'NINIANY BARBOSA DANTAS DE FREITAS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'niniany.freitas', '7149d1fe7b163112dbf047944b486938', '2019-07-25 08:36:21', 0),
(400, 'OLEGARIO GALDINO DE ARAUJO NETO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'olegario.neto', 'ab45a25cb98ad0e5f0fcee988ced9b6a', '2019-07-25 08:36:21', 0),
(401, 'ONIVALDO FRANCISCO DE OLIVEIRA JUNIOR', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'onivaldo.junior', 'd0f14db13f9e061fb317fd3ae14256c9', '2019-07-25 08:36:21', 0),
(402, 'OTAVIO DOMINGOS MOREIRA SANTOS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'otavio.santos', '8cd11bc80bb1bfdbf071f0013bc55995', '2019-07-25 08:36:21', 0),
(403, 'PALMERIO SOUZA RABELO', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'palmerio.rabelo', '6f8f6e34df7fd9df4a614baf1b59491a', '2019-07-25 08:36:21', 0),
(404, 'PAULA MERCIA MEDEIROS DE SOUZA TORRES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'paula.torres', '9b7023163fb74b477c3d6e6e4e1ef177', '2019-07-25 08:36:21', 0),
(405, 'PAULO ANDERSON NOGUEIRA PEREIRA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'paulo.pereira', 'ae54e7b7d5012b24a35d06db5c100edb', '2019-07-25 08:36:21', 0),
(406, 'PAULO ANDRE CARVALHO DE SOUSA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'paulo.sousa', 'ad8542454c7eaf11d216120a064a4a02', '2019-07-25 08:36:21', 0),
(407, 'PAULO ARMANDO LETTIERI PINTO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'paulo.pinto', '3e6284029aabb5e238219071eeaf1528', '2019-07-25 08:36:21', 0),
(408, 'PAULO ROBERTO DO VALE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'paulo.vale', '38ca3b066d7b87e6d06d358a32ef011e', '2019-07-25 08:36:21', 0),
(409, 'PEDRO EDUARDO SELVA SUBTIL', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'pedro.subtil', 'a489c75d0c335ec5ff7af8030c50b9dd', '2019-07-25 08:36:21', 0),
(410, 'PEDRO HENRIQUE MEIRA DE ANDRADE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'pedro.andrade', '26b4c85b7d9bc8bd1700842e195af7ef', '2019-07-25 08:36:21', 0),
(411, 'PEDRO QUERINO DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'pedro.silva', '13dd7f752682a9edfe27d9089e806f9f', '2019-07-25 08:36:21', 0),
(412, 'PIERRE PATRICK PACHECO LIRA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'pierre.lira', 'f10fcb91c4134dfc1b0b886e7a8f5e56', '2019-07-25 08:36:21', 0),
(413, 'PORFIRIO DANTAS GOMES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'porfirio.gomes', '30f81ddc7f38d68ea85cd91e0d45a93d', '2019-07-25 08:36:21', 0),
(414, 'PRISCILLA KALLYANE GOMES COSTA MEDEIROS', 'SEM CARGO', NULL, 1, NULL, 'priscilla.medeiros', '001fa2b0ca0f037d7d13072911ddf670', '2019-07-25 08:36:21', 0),
(415, 'RAFAELA CICERA DE ALBUQUERQUE D.DA ROCHA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'rafaela.rocha', '6b5f9822a39261b88013af1e4fd459af', '2019-07-25 08:36:21', 0),
(416, 'RAIMUNDA FERNANDES DA COSTA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'raimunda.costa', '4d2476c5eca79b94f9f3416a3d50c5f9', '2019-07-25 08:36:21', 0),
(417, 'RAIMUNDO NASCIMENTO ROCHA JUNIOR', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'raimundo.junior', '70dbfd2a070bef8b524e51c25782c146', '2019-07-25 08:36:21', 0),
(418, 'RAIZA LORENA SANDES SOUZA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'raiza.souza', 'f2fad7edcae5587ef678fbff66795edc', '2019-07-25 08:36:21', 0),
(419, 'RANIELLE FERNANDES PIMENTA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'ranielle.pimenta', 'e93f27fcca4eeba5032d29ed3a044c0c', '2019-07-25 08:36:21', 0),
(420, 'RAPHAEL DANTAS LUZ PEIXOTO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'raphael.peixoto', '6fe837f7079f90826600325d328a9609', '2019-07-25 08:36:21', 0),
(421, 'REGINALDO SERGIO BALDUINO DE MELO', 'ELETRICISTA A NIV 25 - SUPLEM DATANORTE', NULL, 1, NULL, 'reginaldo.melo', 'b3577ad728f1cc3676d52145c5fef0e8', '2019-07-25 08:36:21', 0),
(422, 'REJANE LICIA TORRES FERNANDES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'rejane.fernandes', '225ddf636e800ed465e33d149856a613', '2019-07-25 08:36:21', 0),
(423, 'RENAN MATA PEREIRA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'renan.pereira', 'fcb2fe88c2be03d5eb54dc3a7c763fd1', '2019-07-25 08:36:21', 0),
(424, 'RENATO PEREIRA GRIGORIO DE LACERDA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'renato.lacerda', 'fb74bcf835fd18d312beefbad9dc3ecc', '2019-07-25 08:36:21', 0),
(425, 'RENILDO DE SOUZA MARCELINO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'renildo.marcelino', '95146b1b07fd67bdf5eef505a7777f95', '2019-07-25 08:36:21', 0),
(426, 'RENILSON DE OLIVEIRA MAPELE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'renilson.mapele', 'd37e4927b0f68a20bc79f234f1356845', '2019-07-25 08:36:21', 0),
(427, 'RENO ARAUJO GOIS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'reno.gois', '66eaa5de61e20ab5939350fe0334b338', '2019-07-25 08:36:21', 0),
(428, 'RICARDO BEZERRA DO AMARAL', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ricardo.amaral', 'd43c28cf36920ac0976dd5ec167af7b5', '2019-07-25 08:36:21', 0),
(429, 'RICARDO JOSE BARBALHO AZEVEDO', 'ANALISTA TECNICO FORENSE', NULL, 1, NULL, 'ricardo.azevedo', 'f49f8150fa7f44780f8eb6c045f9ce79', '2019-07-25 08:36:21', 0),
(430, 'RICARDO LUIZ PRADO', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ricardo.prado', '13b29bf216cf4595de595d383b2a7eae', '2019-07-25 08:36:21', 0),
(431, 'RICARDO MONTGOMERY GOMES DE LIMA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'ricardo.lima', 'a1284834ed08bbff29c05eb98781d928', '2019-07-25 08:36:21', 0),
(432, 'RITA LOPES DANTAS', 'CARGO REQUISITADO', NULL, 1, NULL, 'rita.dantas', 'c4de6f3d4730efd60d2546ce54fa501c', '2019-07-25 08:36:21', 0),
(433, 'RITA SOARES DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'rita.silva', '2d7ebaa683c95384e551a3c781551356', '2019-07-25 08:36:21', 0),
(434, 'ROBERTA LICIA MARQUES PENA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'roberta.pena', 'b96131855e1fda0a9535e822bd5a1ac6', '2019-07-25 08:36:21', 0),
(435, 'ROBERTO ALVES PEREIRA DOS SANTOS', 'TECNICO AGRICOLA II - CIDA', NULL, 1, NULL, 'roberto.santos', '665a8e4e84ace3da1e5820b656bcdaf5', '2019-07-25 08:36:21', 0),
(436, 'ROBERTO FERREIRA DA SILVA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'roberto.silva', '18321e2ff1fa447a334231b9c736e26a', '2019-07-25 08:36:21', 0),
(437, 'ROBERTO MANOEL DIAS DE LIMA', 'AUXILIAR TEC DE ENGENHARIA - COHAB', NULL, 1, NULL, 'roberto.lima', '7448735ae5b72c5c7a3b8108363ef276', '2019-07-25 08:36:21', 0),
(438, 'ROBSON FERNANDES DA TRINDADE', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'robson.trindade', '15e2770bda67aeea99d3680dd86c8960', '2019-07-25 08:36:21', 0),
(439, 'RODOLFO DA NOBREGA CORREA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'rodolfo.correa', '52f6126585f10f57accbbd6617fb20b6', '2019-07-25 08:36:21', 0),
(440, 'ROLDAO FERREIRA DA CRUZ JUNIOR', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'roldao.junior', 'dddca0b5a61c6f0cc5d9976d400c7a48', '2019-07-25 08:36:21', 0),
(441, 'ROMUALDO FERREIRA DA SILVA', 'PROF PERM NIVEL - III', NULL, 1, NULL, 'romualdo.silva', 'f4ada20be3a754bfaf4281472db428d6', '2019-07-25 08:36:21', 0),
(442, 'RONALDO FERNANDES DE MACEDO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'ronaldo.macedo', '60c4adab40dacba66e5d70857ef8299e', '2019-07-25 08:36:21', 0),
(443, 'ROSALBA MARIA COSTA', 'AUXILIAR DE INFORMATICA I - DATANORTE', NULL, 1, NULL, 'rosalba.costa', '8b66d9bfe77c46c8632c57cba0062ed9', '2019-07-25 08:36:21', 0),
(444, 'ROSANA FERREIRA GUEDES MARINHO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'rosana.marinho', '21ad8586c7744f7d88089c8d914c7c10', '2019-07-25 08:36:21', 0),
(445, 'ROSANA MAGNA DE SOUZA', 'AUXILIAR TECNICO FORENSE (RAIO X)', NULL, 1, NULL, 'rosana.souza', '83dacf46fe0ee4cf3442349ea24385a9', '2019-07-25 08:36:21', 0),
(446, 'ROSANGELA DAVILLA VICENTE DE OLIVEIRA WITTE', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'rosangela.witte', '48deedda90cc5dc6057196e4b3746240', '2019-07-25 08:36:21', 0),
(447, 'ROSE MARY PEGADO E SILVA FREITAS', 'MEDICO - ITEP', NULL, 1, NULL, 'rose.freitas', '5d670043e074a1e1d567eff7e398c14d', '2019-07-25 08:36:21', 0),
(448, 'ROSEANE FERREIRA DE SOUZA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'roseane.souza', '9502976a0b2c714f52f170c82259509a', '2019-07-25 08:36:21', 0),
(449, 'ROSELITA ARAUJO DE FIGUEIREDO TRINDADE', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'roselita.trindade', '182d2a1bc3678ab15eeaedbb8d0289e9', '2019-07-25 08:36:21', 0),
(450, 'ROSELY DA SILVA COSTA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'rosely.costa', '271acfc7a96d5df05403daca21ed4682', '2019-07-25 08:36:21', 0),
(451, 'ROSILENE MONTEIRO ALVES SOUSA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'rosilene.sousa', '175f5e82965ab859d6aec1b077706574', '2019-07-25 08:36:21', 0),
(452, 'ROSSANO JOSE BATISTA CABRAL', 'MOTORISTA', NULL, 1, NULL, 'rossano.cabral', 'ea107d489b4fe4f12817620fbfe3de26', '2019-07-25 08:36:21', 0),
(453, 'RUBENS GERALDO DE ARAUJO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'rubens.araujo', '212ae03529de877137cbcb57b2b4eb52', '2019-07-25 08:36:21', 0),
(454, 'RUTENIO DINIZ DE MEDEIROS', 'SEM CARGO', NULL, 1, NULL, 'rutenio.medeiros', '0a9a7a48d5ace0af3bb1b34fe8ce76c2', '2019-07-25 08:36:21', 0),
(455, 'RUZIEL SOARES ALVES', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ruziel.alves', 'fb015d0acd4ccccb7e00217dafde6d5e', '2019-07-25 08:36:21', 0),
(456, 'SAIMON MEDEIROS LEAO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'saimon.leao', '646df192eef0752e52140c36063db7e4', '2019-07-25 08:36:21', 0),
(457, 'SAMIR ALBANEZ VERAS DE SOUZA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'samir.souza', '3ead7b9216feb978912d27bd0f5ba2f9', '2019-07-25 08:36:21', 0),
(458, 'SANDRA MARIA BEZERRA LOPES MATEUS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'sandra.mateus', '6329380baf2dd964620abbe9eb36dce6', '2019-07-25 08:36:21', 0),
(459, 'SAULO PEREIRA DE OLIVEIRA LIMA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'saulo.lima', 'bf5a2cb45e8b97c621be4ffbf1fcf4e8', '2019-07-25 08:36:21', 0),
(460, 'SAULO SANTIAGO ALMEIDA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'saulo.almeida', '463b534208787c1faa6bda9a634ace06', '2019-07-25 08:36:21', 0),
(461, 'SEBASTIAO AVELINO DANTAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'sebastiao.dantas', '3bb59e038aa4ad37dda1170696a9a2ee', '2019-07-25 08:36:21', 0),
(462, 'SEBASTIAO FRANCA COSTA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'sebastiao.costa', '2e10f072c2a569ec9915e7bcba63ffb1', '2019-07-25 08:36:21', 0),
(463, 'SEBASTIAO OLIVEIRA DA SILVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'sebastiao.silva', 'c79bf54bf5d2b2aab23197560393cfca', '2019-07-25 08:36:21', 0),
(464, 'SERGIO DE FREITAS COSTA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'sergio.costa', '8aec2733d1056084082fd18498fa410b', '2019-07-25 08:36:21', 0),
(465, 'SHEILA KAIONARA FERREIRA DO REGO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'sheila.rego', '97322af24b449ec7ad58d118bd6178d3', '2019-07-25 08:36:21', 0),
(466, 'SIDARQUE BATISTA DE SALES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'sidarque.sales', 'c09bf7ce12ba1dfd481e3ef8a7521b0f', '2019-07-25 08:36:21', 0),
(467, 'SILMARA DANTAS SOUSA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'silmara.sousa', 'b3e91553e9e9440c7be37dda7cd3a946', '2019-07-25 08:36:21', 0),
(468, 'SILVANA TEIXEIRA FERREIRA DE CASTRO', 'OFICIAL ADMINISTRATIVO - FUNGEL', NULL, 1, NULL, 'silvana.castro', '0ac8e0e1b50a329fb96a02d2d87dbd4d', '2019-07-25 08:36:21', 0),
(469, 'SILVANO TEIXEIRA DE LIMA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'silvano.lima', '4e3e831653fa6efc80bdebeff6161185', '2019-07-25 08:36:21', 0),
(470, 'SILVIA VIANA FRANCELINO ARAUJO GALVAO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'silvia.galvao', '37082d37470b897f0a38299ca9ed7310', '2019-07-25 08:36:21', 0),
(471, 'SILZA FERREIRA DA SILVA PRESTES CAMARA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'silza.camara', 'a832b2da1614d5cba67dc9b5333d5c60', '2019-07-25 08:36:21', 0),
(472, 'SMITH RAFAEL CORDEIRO MEDEIROS', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'smith.medeiros', 'c30c563140a0379abd5516c17bc51b0f', '2019-07-25 08:36:21', 0),
(473, 'SOLANGE BORGES DE MENDONCA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'solange.mendonca', 'a6f72083c604a60790db1623e0347502', '2019-07-25 08:36:21', 0),
(474, 'SOLANGE MARIA RODRIGUES DE ALMEIDA REGIS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'solange.regis', '08b0995e34776b74c569af64295e1318', '2019-07-25 08:36:21', 0),
(475, 'SUELI FERREIRA DE CASTRO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'sueli.castro', '638bbd2a7ea792c36908453d6e76d1f5', '2019-07-25 08:36:21', 0),
(476, 'SUELY CRISTINA MENDES TAVARES', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'suely.tavares', '8b97d0aa460f6815a334a0353b383ad8', '2019-07-25 08:36:21', 0),
(477, 'SUMMAIA KANDICI CUNHA DOS SANTOS', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'summaia.santos', 'd891ae68ec9b858877fa4284afa9c508', '2019-07-25 08:36:21', 0),
(478, 'SUZYELAINE TAMARINDO MARQUES DA CRUZ', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'suzyelaine.cruz', 'f6120dbddba2fa87d766c5e7057062a4', '2019-07-25 08:36:21', 0),
(479, 'TANAGARA IRINA DE SIQUEIRA NEVES FALCAO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'tanagara.falcao', 'bedecf2bb086bbdae3deadab4413f3c1', '2019-07-25 08:36:21', 0),
(480, 'TANIA TAZIA DE LIMA SANTIAGO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'tania.santiago', 'efa8c90fb369716132d80a2ffb1227c5', '2019-07-25 08:36:21', 0),
(481, 'TANIZIA BANDEIRA CEZAR', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'tanizia.cezar', '57a93e075812fbbd9aecfcf40e45d72e', '2019-07-25 08:36:21', 0),
(482, 'TARCISIO AQUINO DE CARVALHO JUNIOR', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'tarcisio.junior', '455c502911a46e4d3aeec7360233d575', '2019-07-25 08:36:21', 0),
(483, 'TARCISIO ARAUJO DE MEDEIROS', 'PROF PERM NIVEL - I', NULL, 1, NULL, 'tarcisio.medeiros', '21e3621426438d293a1febe082498ef5', '2019-07-25 08:36:21', 0),
(484, 'TELANIA CORTEZ LEITE', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'telania.leite', '2c79a0515fd2ea54974f51b3e186d1de', '2019-07-25 08:36:21', 0),
(485, 'TEOFILO CLENILDO MAIA DE FREITAS', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'teofilo.freitas', 'd4ca39359fc57529ad75310583e48f62', '2019-07-25 08:36:21', 0),
(486, 'TERESA CRISTINA EPIFANIO DIOGENES REGO', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'teresa.rego', 'ec8d8bfc5eed64639d3284eab6e32fde', '2019-07-25 08:36:21', 0),
(487, 'THAYNARA LEITE DE ANDRADE', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'thaynara.andrade', 'b669247490d53995b97817ea31a3458d', '2019-07-25 08:36:21', 0),
(488, 'THIAGO ANGELS BATISTA OLIVEIRA', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'thiago.oliveira', 'd61a0e02496f0b3983e0615d68b8aa0a', '2019-07-25 08:36:21', 0),
(489, 'THIAGO DE SOUZA VALLEGAS PEREIRA', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'thiago.pereira', 'c22dacab921ac0c26d75561cf9354c4a', '2019-07-25 08:36:21', 0),
(490, 'THYAGO MARSICANO VIEIRA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'thyago.vieira', '205370549788825e43b9acac02ea53ef', '2019-07-25 08:36:21', 0),
(491, 'TIAGO TADEU SANTOS DE ARAUJO', 'TERCEIRO SARGENTO - PM/CBM', NULL, 1, NULL, 'tiago.araujo', 'c0b7e0a1708276a7d2675cb429b8cebb', '2019-07-25 08:36:21', 0),
(492, 'TULIO ALBERTO DE OLIVEIRA SOUZA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'tulio.souza', '3b6402b4836095cf9827e7b7c19872c3', '2019-07-25 08:36:21', 0),
(493, 'UBIRAJARA CALDAS LEONARDO NOGUEIRA', 'PERITO TECNICO FORENSE', NULL, 1, NULL, 'ubirajara.nogueira', '87ac5c2a4a459853111e62cc8c788346', '2019-07-25 08:36:21', 0),
(494, 'ULISSES BEZERRA FILHO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'ulisses.filho', '0ce635fd8ad426962b5d3dc294eb21de', '2019-07-25 08:36:21', 0),
(495, 'VALDENIR FERREIRA DE FARIAS', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'valdenir.farias', 'c1eb8358aebb9a47edee30a6481794e7', '2019-07-25 08:36:21', 0),
(496, 'VALQUIRIA CRUZ DE OLIVEIRA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'valquiria.oliveira', 'fee148cec8acbd66f4ee11ebd87a1c66', '2019-07-25 08:36:21', 0),
(497, 'VERA LUCIA PIMENTEL LANDIM DE ALMEIDA', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'vera.almeida', '87d129f58ceef04fc98e41143dca58cb', '2019-07-25 08:36:21', 0),
(498, 'VERA LUCIA SOARES DE FREITAS PAIVA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'vera.paiva', '493137842cc15c7d8c93ccc78592efa9', '2019-07-25 08:36:21', 0),
(499, 'VERCILIA TACI DINIZ', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'vercilia.diniz', '9f6ea780773cb76994abeccd24e9d591', '2019-07-25 08:36:21', 0),
(500, 'VERONICA LUCIA DE CARVALHO NERINO', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'veronica.nerino', '1ab1ac93b08127ce5aba476690fcb07f', '2019-07-25 08:36:21', 0),
(501, 'VERONICA MARIA PINTO DE ARAUJO', 'CARGO REQUISITADO', NULL, 1, NULL, 'veronica.araujo', '22c59211836fbd4a6e58d15c0b13393d', '2019-07-25 08:36:21', 0),
(502, 'VERONICA MARQUES DE MENEZES', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'veronica.menezes', '9b1662c21cc82c5ac6b2be3abf68912a', '2019-07-25 08:36:21', 0),
(503, 'VICENTE NOGUEIRA NETO', 'LABORATORISTA I - CDM', NULL, 1, NULL, 'vicente.neto', 'a96a72c20f527bea4d8aa63b664cd54f', '2019-07-25 08:36:21', 0),
(504, 'VICTOR LEONARDO DE SOUSA NOGUEIRA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'victor.nogueira', 'e0076bb474e92396d3bc3beeaa8f23de', '2019-07-25 08:36:21', 0),
(505, 'VILMA MARIA ALVES DE LIMA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'vilma.lima', 'daa4b6369226b319c10f06432658888d', '2019-07-25 08:36:21', 0),
(506, 'VITAL LUIS CABRAL MACHADO', 'PERITO MEDICO LEGISTA (LCE 571/16)', NULL, 1, NULL, 'vital.machado', '3f3bee752cada2c6116e97d8da979785', '2019-07-25 08:36:21', 0),
(507, 'VITOR FERNANDES DIAS LOPES', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'vitor.lopes', '417db1009b96c5b8e5b06566d7438893', '2019-07-25 08:36:21', 0),
(508, 'VITORIO SOARES TORRES', 'AGENTE DE POLICIA ESPECIAL', NULL, 1, NULL, 'vitorio.torres', '64a0b91088f866711658d5ff810952aa', '2019-07-25 08:36:21', 0),
(509, 'WALTER CESAR RODRIGUES PESSOA', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'walter.pessoa', 'da846b0e0ab4d8ae0a5807a1f9272a18', '2019-07-25 08:36:21', 0),
(510, 'WANDERSON DE OLIVEIRA TOME', 'AGENTE TECNICO FORENSE (LCE 571/16)', NULL, 1, NULL, 'wanderson.tome', '98b4c97184674e8fa340cab2ff390cd1', '2019-07-25 08:36:21', 0),
(511, 'WBERLHANE PEREIR DA SILVA', 'SEM CARGO', NULL, 1, NULL, 'wberlhane.silva', '2799a8200c7b0a203dd36aeeb4726d13', '2019-07-25 08:36:21', 0),
(512, 'WELLINGTON OLIVEIRA CORREIA', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'wellington.correia', '901819465c2bbd59e162569eee02c11c', '2019-07-25 08:36:21', 0),
(513, 'WILLDMA FERNANDES COSTA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'willdma.costa', '37ce49843d03eae127492b2f32e741a1', '2019-07-25 08:36:21', 0),
(514, 'WSTANIA MARIA RODRIGUES FONSECA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'wstania.fonseca', 'c49382e956b13e62e9e64a41204a136d', '2019-07-25 08:36:21', 0),
(515, 'YSLA KAROLINA COSTA LEAL', 'AGENTE DE NECROPSIA (LCE 571/16)', NULL, 1, NULL, 'ysla.leal', '059a13126edc9a36ed859582998a85de', '2019-07-25 08:36:21', 0),
(516, 'YURI BOVI MORAIS CARVALHO', 'PERITO CRIMINAL (LCE 571/16)', NULL, 1, NULL, 'yuri.carvalho', 'aa5c2b6db563abd2fd1efbfda8918082', '2019-07-25 08:36:21', 0),
(517, 'ZILCA BARBALHO FREIRE', 'AUXILIAR TECNICO FORENSE', NULL, 1, NULL, 'zilca.freire', '4f59bb2bbf6126c4e956f69820430e66', '2019-07-25 08:36:21', 0),
(518, 'ZULEIDE DA CUNHA', 'AUXILIAR ADMINISTRATIVO', NULL, 1, NULL, 'zuleide.cunha', '7396c72691c3d6a11f4a17fb35e28d39', '2019-07-25 08:36:21', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fichas_tb`
--
ALTER TABLE `fichas_tb`
  ADD PRIMARY KEY (`ficha_id`);

--
-- Índices para tabela `logs_tb`
--
ALTER TABLE `logs_tb`
  ADD PRIMARY KEY (`log_id`);

--
-- Índices para tabela `mails_tb`
--
ALTER TABLE `mails_tb`
  ADD PRIMARY KEY (`mail_id`);

--
-- Índices para tabela `necropapiloscopia_tb`
--
ALTER TABLE `necropapiloscopia_tb`
  ADD PRIMARY KEY (`necropapiloscopia_id`);

--
-- Índices para tabela `painel_tb`
--
ALTER TABLE `painel_tb`
  ADD PRIMARY KEY (`painel_id`);

--
-- Índices para tabela `setores_tb`
--
ALTER TABLE `setores_tb`
  ADD PRIMARY KEY (`setor_id`);

--
-- Índices para tabela `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fichas_tb`
--
ALTER TABLE `fichas_tb`
  MODIFY `ficha_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logs_tb`
--
ALTER TABLE `logs_tb`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mails_tb`
--
ALTER TABLE `mails_tb`
  MODIFY `mail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `necropapiloscopia_tb`
--
ALTER TABLE `necropapiloscopia_tb`
  MODIFY `necropapiloscopia_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `painel_tb`
--
ALTER TABLE `painel_tb`
  MODIFY `painel_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `setores_tb`
--
ALTER TABLE `setores_tb`
  MODIFY `setor_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios_tb`
--
ALTER TABLE `usuarios_tb`
  MODIFY `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=519;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
