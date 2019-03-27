-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Out-2018 às 05:25
-- Versão do servidor: 10.1.35-MariaDB
-- versão do PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_livro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `autor`
--

CREATE TABLE `autor` (
  `aut_codigo` int(11) NOT NULL,
  `aut_nome` varchar(100) NOT NULL,
  `aut_ativo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `autor`
--

INSERT INTO `autor` (`aut_codigo`, `aut_nome`, `aut_ativo`) VALUES
(1, 'Dante', 'N'),
(2, 'Lovercraft', 'S'),
(3, 'Assis', 'S'),
(4, 'Outro', 'S'),
(5, 'Martin', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE `genero` (
  `gen_codigo` int(11) NOT NULL,
  `gen_descricao` varchar(100) NOT NULL,
  `gen_ativo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `genero`
--

INSERT INTO `genero` (`gen_codigo`, `gen_descricao`, `gen_ativo`) VALUES
(1, 'Terror', 'S'),
(2, 'Drama', 'N'),
(3, 'Romance', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE `livro` (
  `liv_codigo` int(11) NOT NULL,
  `liv_isbn` char(17) NOT NULL,
  `liv_titulo` varchar(200) NOT NULL,
  `gen_codigo` int(11) NOT NULL,
  `aut_codigo` int(11) NOT NULL,
  `liv_disponivel` char(1) NOT NULL,
  `liv_ativo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`liv_codigo`, `liv_isbn`, `liv_titulo`, `gen_codigo`, `aut_codigo`, `liv_disponivel`, `liv_ativo`) VALUES
(1, 'naoseioqÃ©isso,te', 'Romancesinhodramatico', 2, 3, 'N', 'S'),
(2, 'naosei', 'Aquele Polvo', 1, 2, 'N', 'S'),
(3, '...', 'Outra Coisa', 2, 1, 'N', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `locacao`
--

CREATE TABLE `locacao` (
  `loc_codigo` int(11) NOT NULL,
  `liv_codigo` int(11) NOT NULL,
  `usu_login` char(11) NOT NULL,
  `loc_data_locacao` datetime NOT NULL,
  `loc_data_previsao_retorno` datetime NOT NULL,
  `loc_data_devolucao` datetime NOT NULL,
  `loc_ativa` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `locacao`
--

INSERT INTO `locacao` (`loc_codigo`, `liv_codigo`, `usu_login`, `loc_data_locacao`, `loc_data_previsao_retorno`, `loc_data_devolucao`, `loc_ativa`) VALUES
(1, 2, 'admin', '2018-10-17 00:00:00', '2018-10-22 00:00:00', '2018-10-19 00:00:00', 'S'),
(2, 2, 'admin', '2018-10-23 00:00:00', '2018-10-26 00:00:00', '0000-00-00 00:00:00', 'N'),
(5, 1, 'user', '2018-10-25 20:33:15', '2018-11-26 20:33:15', '0000-00-00 00:00:00', 'S'),
(6, 3, 'user', '2018-10-22 00:00:00', '2018-10-31 00:00:00', '0000-00-00 00:00:00', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_login` char(11) NOT NULL,
  `usu_nome` varchar(100) NOT NULL,
  `usu_email` varchar(100) DEFAULT NULL,
  `usu_senha` varchar(60) NOT NULL,
  `usu_administrador` char(1) NOT NULL,
  `usu_ativo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usu_login`, `usu_nome`, `usu_email`, `usu_senha`, `usu_administrador`, `usu_ativo`) VALUES
('admin', 'admin', 'admin@admin', '$2y$10$3C0.XCPzHeLDa8XQ9SOGv.3FEvAr3xZvB1tnSlC24XY.7l/G2qNU.', 'A', 'S'),
('Big User', 'joao', 'j.ao@gmail.com', '$2y$10$wzfjzJNt2pGk.6JIoMu.7Of1C.Z3nWLGlac5f3m94tYL18nRKYxGu', 'U', 'N'),
('user', 'user', 'user@user.com', '$2y$10$zQ6Io3lWkpHYvJayVLK0u.AEjQ3qkv80hPxD.yf.l6cdKR3yNLt1.', 'U', 'S'),
('user2', 'user2', 'user@gmail.com', '$2y$10$nEMDJXhGgCPX41uLSDw4nu.yZMyk4kO2FohNgY.yudwB67AGMcgWC', 'U', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`aut_codigo`);

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`gen_codigo`);

--
-- Indexes for table `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`liv_codigo`),
  ADD UNIQUE KEY `liv_isbn_UNIQUE` (`liv_isbn`),
  ADD KEY `fk_gen_codigo_idx` (`gen_codigo`),
  ADD KEY `fk_LIVRO_AUTOR1_idx` (`aut_codigo`);

--
-- Indexes for table `locacao`
--
ALTER TABLE `locacao`
  ADD PRIMARY KEY (`loc_codigo`),
  ADD KEY `fk_LOCACAO_LIVRO1_idx` (`liv_codigo`),
  ADD KEY `fk_LOCACAO_USUARIO1_idx` (`usu_login`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_login`),
  ADD UNIQUE KEY `usu_email_UNIQUE` (`usu_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `aut_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genero`
--
ALTER TABLE `genero`
  MODIFY `gen_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `livro`
--
ALTER TABLE `livro`
  MODIFY `liv_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locacao`
--
ALTER TABLE `locacao`
  MODIFY `loc_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_LIVRO_AUTOR1` FOREIGN KEY (`aut_codigo`) REFERENCES `autor` (`aut_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gen_codigo` FOREIGN KEY (`gen_codigo`) REFERENCES `genero` (`gen_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `locacao`
--
ALTER TABLE `locacao`
  ADD CONSTRAINT `fk_LOCACAO_LIVRO1` FOREIGN KEY (`liv_codigo`) REFERENCES `livro` (`liv_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LOCACAO_USUARIO1` FOREIGN KEY (`usu_login`) REFERENCES `usuario` (`usu_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
