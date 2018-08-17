CREATE DATABASE `app_prestador` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabela_referencia` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `id_objeto` int(11) NOT NULL,
  `cep` varchar(9) COLLATE utf8_general_ci NOT NULL,
  `logradouro` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `numero` varchar(45) COLLATE utf8_general_ci NOT NULL,
  `complemento` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8_general_ci NOT NULL,
  `latlong` point NOT NULL,
  `latitude` varchar(45) COLLATE utf8_general_ci NOT NULL,
  `longitude` varchar(45) COLLATE utf8_general_ci NOT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_endereco` int(11) NOT NULL,
  `id_ponto_apoio` int(11) DEFAULT NULL,
  `nome` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8_general_ci NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_endereco` (`id_endereco`),
  KEY `fk_pessoa_pontoapoio1_idx` (`id_ponto_apoio`),
  CONSTRAINT `fk_pessoa_endereco1` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_pessoa_pontoapoio1` FOREIGN KEY (`id_ponto_apoio`) REFERENCES `ponto_apoio` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `ponto_apoio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_endereco` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `tipo_ponto_apoio` enum('P','M') COLLATE utf8_general_ci NOT NULL,
  `apelido` varchar(45) COLLATE utf8_general_ci NOT NULL,
  `nome_fantasia` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `contato` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `email_contato` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`id`,`id_endereco`,`id_prestador`),
  KEY `fk_ponto_apoio_endereco` (`id_endereco`),
  KEY `fk_ponto_apoio_prestador` (`id_prestador`),
  CONSTRAINT `fk_ponto_apoio_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_ponto_apoio_prestador` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `prestador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_fantasia` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `razao_social` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `cnpj` varchar(18) COLLATE utf8_general_ci NOT NULL,
  `inscricao_estadual` varchar(20) COLLATE utf8_general_ci DEFAULT NULL,
  `inscricao_municipal` varchar(20) COLLATE utf8_general_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) DEFAULT NULL,
  `id_prestador` int(11) DEFAULT NULL,
  `id_ponto_apoio` int(11) DEFAULT NULL,
  `ddd` varchar(3) COLLATE utf8_general_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_general_ci NOT NULL,
  `situacao` enum('A','I','E') COLLATE utf8_general_ci NOT NULL DEFAULT 'A',
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_telefone_pessoa1_idx` (`id_pessoa`),
  KEY `fk_telefone_prestador1_idx` (`id_prestador`),
  KEY `fk_telefone_pontoapoio1_idx` (`id_ponto_apoio`),
  CONSTRAINT `fk_telefone_pessoa1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_telefone_prestador1` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_telefone_pontoapoio1` FOREIGN KEY (`id_ponto_apoio`) REFERENCES `ponto_apoio` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `tipo_pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `nivel` enum('S','U') COLLATE utf8_general_ci NOT NULL DEFAULT 'U',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `tipo_pessoa_pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbtipopessoa_id` int(11) NOT NULL,
  `tbpessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`tbtipopessoa_id`,`tbpessoa_id`),
  KEY `fk_tbtipopessoa_tbpessoa_tbpessoa1` (`tbpessoa_id`),
  KEY `fk_tbtipopessoa_tbpessoa_tbtipopessoa` (`tbtipopessoa_id`),
  CONSTRAINT `fk_tbtipopessoa_tbpessoa_tbtipopessoa` FOREIGN KEY (`tbtipopessoa_id`) REFERENCES `tipo_pessoa` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_tbtipopessoa_tbpessoa_tbpessoa1` FOREIGN KEY (`tbpessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `usuario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `senha` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `celular` varchar(10) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_pessoa1_idx` (`id_pessoa`),
  CONSTRAINT `fk_usuario_pessoa1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


