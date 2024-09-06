-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/09/2024 às 18:07
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
-- Banco de dados: `pub2427`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alternative`
--

CREATE TABLE `alternative` (
  `alternative_id` int(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alternative`
--

INSERT INTO `alternative` (`alternative_id`, `content`) VALUES
(1, 'Aprender procedimentos'),
(2, 'Entender teorias'),
(3, 'Realizar experimentos'),
(4, 'Escrever relatórios'),
(5, 'Trabalho em equipe'),
(6, 'Desenvolver técnicas de aplicação do estudo'),
(7, 'Outros'),
(8, 'Excelente'),
(9, 'Bom'),
(10, 'Regular'),
(11, 'Ruim'),
(12, 'Péssimo'),
(13, 'Não aplicável'),
(14, 'Sim'),
(15, 'Não'),
(16, 'Sim'),
(17, 'Não'),
(18, 'Sempre'),
(19, 'Frequentemente'),
(20, 'Às vezes'),
(21, 'Raramente'),
(22, 'Nunca'),
(23, 'Não se aplica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alternative-temp`
--

CREATE TABLE `alternative-temp` (
  `alternative_id` int(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `instance_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `class`
--

CREATE TABLE `class` (
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `class`
--

INSERT INTO `class` (`class_id`, `subject_id`, `subject_name`, `teacher_name`) VALUES
('2024', '1234', 'Disciplina 1', 'Professor 1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `class-temp`
--

CREATE TABLE `class-temp` (
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `files`
--

CREATE TABLE `files` (
  `file` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `instance`
--

CREATE TABLE `instance` (
  `instance_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `instance_date_beginning` datetime DEFAULT NULL,
  `instance_date_end` datetime DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `instance`
--

INSERT INTO `instance` (`instance_id`, `status`, `created_at`, `instance_date_beginning`, `instance_date_end`, `content`) VALUES
('20242', 1, '2024-09-06', '2024-09-06 13:01:00', '2024-09-26 12:36:00', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `instance_questionnaire_class_relation`
--

CREATE TABLE `instance_questionnaire_class_relation` (
  `instance_id` varchar(255) NOT NULL,
  `questionnaire_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `instance_questionnaire_class_relation`
--

INSERT INTO `instance_questionnaire_class_relation` (`instance_id`, `questionnaire_id`, `class_id`, `subject_id`) VALUES
('20242', '1', '2024', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `instance_questionnaire_class_relation-temp`
--

CREATE TABLE `instance_questionnaire_class_relation-temp` (
  `instance_id` varchar(255) NOT NULL,
  `questionnaire_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `question`
--

CREATE TABLE `question` (
  `question_id` int(255) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `question`
--

INSERT INTO `question` (`question_id`, `question_type`, `title`, `content`) VALUES
(1, '0', 'Qual é o principal objetivo do laboratório?', ''),
(2, '1', 'Como você classificaria a infraestrutura do laboratório?', ''),
(3, '1', 'O material disponibilizado foi suficiente para os experimentos?', ''),
(4, '1', 'O instrutor demonstrou domínio sobre os temas abordados?', ''),
(5, '1', 'Houve oportunidade para discussão e esclarecimento de dúvidas?', ''),
(6, '2', 'Descreva sua experiência geral no laboratório e como ela contribuiu para o seu aprendizado.', ''),
(7, '2', 'Quais foram os maiores desafios que você enfrentou durante as atividades de laboratório?', ''),
(8, '2', 'Como você aplicaria os conhecimentos adquiridos no laboratório em situações reais?', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `question-temp`
--

CREATE TABLE `question-temp` (
  `question_id` int(255) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `alternative_1` varchar(255) NOT NULL,
  `alternative_2` varchar(255) NOT NULL,
  `alternative_3` varchar(255) NOT NULL,
  `alternative_4` varchar(255) NOT NULL,
  `alternative_5` varchar(255) NOT NULL,
  `alternative_6` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionnaire`
--

CREATE TABLE `questionnaire` (
  `questionnaire_id` int(255) NOT NULL,
  `questionnaire_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questionnaire`
--

INSERT INTO `questionnaire` (`questionnaire_id`, `questionnaire_name`) VALUES
(1, 'Questionário de Laboratório');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionnaire-temp`
--

CREATE TABLE `questionnaire-temp` (
  `questionnaire_id` int(255) NOT NULL,
  `questionnaire_name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionnaire_question_relation`
--

CREATE TABLE `questionnaire_question_relation` (
  `questionnaire_id` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questionnaire_question_relation`
--

INSERT INTO `questionnaire_question_relation` (`questionnaire_id`, `question_id`) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('1', '7'),
('1', '8');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionnaire_question_relation-temp`
--

CREATE TABLE `questionnaire_question_relation-temp` (
  `questionnaire_id` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `question_alternative_relation`
--

CREATE TABLE `question_alternative_relation` (
  `question_id` varchar(255) NOT NULL,
  `alternative_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `question_alternative_relation`
--

INSERT INTO `question_alternative_relation` (`question_id`, `alternative_id`) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('1', '7'),
('2', '10'),
('2', '11'),
('2', '12'),
('2', '13'),
('2', '8'),
('2', '9'),
('3', '14'),
('3', '15'),
('4', '14'),
('4', '15'),
('5', '18'),
('5', '19'),
('5', '20'),
('5', '21'),
('5', '22'),
('5', '23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `question_alternative_relation-temp`
--

CREATE TABLE `question_alternative_relation-temp` (
  `question_id` varchar(255) NOT NULL,
  `alternative_id` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `user_id` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`user_id`, `user_type`, `name`, `password`, `email`, `course`) VALUES
('115212', '0', 'aluno3', '123456', 'aluno3@usp.br', ''),
('117848', '0', 'aluno6', '123456', 'aluno6@usp.br', ''),
('133583', '0', 'aluno8', '123456', 'aluno8@usp.br', ''),
('165488', '0', 'aluno5', '123456', 'aluno5@usp.br', ''),
('168978', '0', 'aluno2', '123456', 'aluno2@usp.br', ''),
('174700', '0', 'aluno1', '123456', 'aluno1@usp.br', ''),
('183927', '0', 'aluno9', '123456', 'aluno9@usp.br', ''),
('194550', '0', 'aluno10', '123456', 'aluno10@usp.br', ''),
('195348', '0', 'aluno4', '123456', 'aluno4@usp.br', ''),
('198736', '0', 'aluno7', '123456', 'aluno7@usp.br', ''),
('coordenador1', '1', 'Coordenador 1', '123456', 'coordenador1@usp.br', 'None'),
('mesquita', '1', 'Marco Aurélio de Mesquita', '123456', 'marco.mesquita@poli.usp.br', 'None');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user-temp`
--

CREATE TABLE `user-temp` (
  `user_id` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_class_relation`
--

CREATE TABLE `user_class_relation` (
  `user_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_class_relation`
--

INSERT INTO `user_class_relation` (`user_id`, `class_id`, `subject_id`) VALUES
('174700', '2024', '1234'),
('168978', '2024', '1234'),
('115212', '2024', '1234'),
('195348', '2024', '1234'),
('165488', '2024', '1234'),
('117848', '2024', '1234'),
('198736', '2024', '1234'),
('133583', '2024', '1234'),
('183927', '2024', '1234'),
('194550', '2024', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_class_relation-temp`
--

CREATE TABLE `user_class_relation-temp` (
  `user_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alternative`
--
ALTER TABLE `alternative`
  ADD PRIMARY KEY (`alternative_id`);

--
-- Índices de tabela `alternative-temp`
--
ALTER TABLE `alternative-temp`
  ADD PRIMARY KEY (`alternative_id`);

--
-- Índices de tabela `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`);

--
-- Índices de tabela `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file`);

--
-- Índices de tabela `instance`
--
ALTER TABLE `instance`
  ADD PRIMARY KEY (`instance_id`);

--
-- Índices de tabela `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Índices de tabela `question-temp`
--
ALTER TABLE `question-temp`
  ADD PRIMARY KEY (`question_id`);

--
-- Índices de tabela `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`questionnaire_id`);

--
-- Índices de tabela `questionnaire-temp`
--
ALTER TABLE `questionnaire-temp`
  ADD PRIMARY KEY (`questionnaire_id`);

--
-- Índices de tabela `question_alternative_relation`
--
ALTER TABLE `question_alternative_relation`
  ADD UNIQUE KEY `question_id` (`question_id`,`alternative_id`);

--
-- Índices de tabela `question_alternative_relation-temp`
--
ALTER TABLE `question_alternative_relation-temp`
  ADD UNIQUE KEY `question_id` (`question_id`,`alternative_id`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices de tabela `user-temp`
--
ALTER TABLE `user-temp`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alternative`
--
ALTER TABLE `alternative`
  MODIFY `alternative_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `alternative-temp`
--
ALTER TABLE `alternative-temp`
  MODIFY `alternative_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `question-temp`
--
ALTER TABLE `question-temp`
  MODIFY `question_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `questionnaire-temp`
--
ALTER TABLE `questionnaire-temp`
  MODIFY `questionnaire_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
