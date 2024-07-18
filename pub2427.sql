-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/07/2024 às 21:44
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

--
-- Despejando dados para a tabela `alternative-temp`
--

INSERT INTO `alternative-temp` (`alternative_id`, `content`, `file`) VALUES
(24, 'Produção', 'Questionário_TF.csv'),
(25, 'Organização do Trabalho', 'Questionário_TF.csv'),
(26, 'Estoques', 'Questionário_TF.csv'),
(27, 'Gestão de Projetos', 'Questionário_TF.csv'),
(28, 'Logística', 'Questionário_TF.csv'),
(29, 'Ruim', 'Questionário_TF.csv'),
(30, 'Médio', 'Questionário_TF.csv'),
(31, 'Bom', 'Questionário_TF.csv'),
(32, 'Ótimo', 'Questionário_TF.csv');

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

--
-- Despejando dados para a tabela `answer`
--

INSERT INTO `answer` (`answer_id`, `instance_id`, `user_id`, `question_id`, `class_id`, `subject_id`, `content`) VALUES
(1, '20241', '11111111', '1', '2026201', 'ABC2222', 'Realizar experimentos'),
(2, '20241', '11111111', '2', '2026201', 'ABC2222', 'Bom'),
(3, '20241', '11111111', '3', '2026201', 'ABC2222', 'Não'),
(4, '20241', '11111111', '4', '2026201', 'ABC2222', 'Não'),
(5, '20241', '11111111', '5', '2026201', 'ABC2222', 'Raramente'),
(6, '20241', '11111111', '6', '2026201', 'ABC2222', ''),
(7, '20241', '11111111', '7', '2026201', 'ABC2222', ''),
(8, '20241', '11111111', '8', '2026201', 'ABC2222', ''),
(9, '20241', '11111111', '1', '2027201', 'ABC4444', 'Realizar experimentos'),
(10, '20241', '11111111', '5', '2027201', 'ABC4444', 'Às vezes'),
(11, '20241', '11111111', '6', '2027201', 'ABC4444', ''),
(12, '20241', '11111111', '7', '2027201', 'ABC4444', ''),
(13, '20241', '11111111', '8', '2027201', 'ABC4444', ''),
(14, '20241', '12222222', '1', '2026201', 'ABC2222', 'Entender teorias'),
(15, '20241', '12222222', '3', '2026201', 'ABC2222', 'Sim'),
(16, '20241', '12222222', '5', '2026201', 'ABC2222', 'Raramente'),
(17, '20241', '12222222', '6', '2026201', 'ABC2222', ''),
(18, '20241', '12222222', '7', '2026201', 'ABC2222', ''),
(19, '20241', '12222222', '8', '2026201', 'ABC2222', ''),
(20, '20241', '16666666', '1', '2026201', 'ABC2222', 'Realizar experimentos'),
(21, '20241', '16666666', '2', '2026201', 'ABC2222', 'Bom'),
(22, '20241', '16666666', '5', '2026201', 'ABC2222', 'Frequentemente'),
(23, '20241', '16666666', '6', '2026201', 'ABC2222', ''),
(24, '20241', '16666666', '7', '2026201', 'ABC2222', ''),
(25, '20241', '16666666', '8', '2026201', 'ABC2222', '');

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
('2026201', 'ABC2222', 'Disciplina Exemplo 2', 'Professor Exemplo 2'),
('2027201', 'ABC4444', 'Disciplina Exemplo 3', 'Professor Exemplo 3');

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

--
-- Despejando dados para a tabela `files`
--

INSERT INTO `files` (`file`, `file_type`) VALUES
('Questionário_TF.csv', 'Questionário');

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
('20241', 2, '2024-05-16', '2024-05-16 16:25:00', '2024-05-17 16:24:00', '<p>Teste 123456</p>');

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
('20241', '1', '2026201', 'ABC2222'),
('20241', '1', '2027201', 'ABC4444');

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
(1, '0', 'Qual é o principal objetivo do laboratório de química?', ''),
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

--
-- Despejando dados para a tabela `question-temp`
--

INSERT INTO `question-temp` (`question_id`, `question_type`, `title`, `content`, `alternative_1`, `alternative_2`, `alternative_3`, `alternative_4`, `alternative_5`, `alternative_6`, `file`) VALUES
(9, '0', 'Quais os temas abordados no seu trabalho?', '', '', '', '', '', '', '', 'Questionário_TF.csv'),
(10, '1', 'Como você avalia seu desempenho no desenvolvimento do trabalho?', '', '', '', '', '', '', '', 'Questionário_TF.csv'),
(11, '2', 'Algum comentário adicional?', '', '', '', '', '', '', '', 'Questionário_TF.csv');

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
(1, 'Questionário de Laboratório de Física');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionnaire-temp`
--

CREATE TABLE `questionnaire-temp` (
  `questionnaire_id` int(255) NOT NULL,
  `questionnaire_name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questionnaire-temp`
--

INSERT INTO `questionnaire-temp` (`questionnaire_id`, `questionnaire_name`, `file`) VALUES
(2, 'Questionário de Trabalho de Formatura', 'Questionário_TF.csv');

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

--
-- Despejando dados para a tabela `questionnaire_question_relation-temp`
--

INSERT INTO `questionnaire_question_relation-temp` (`questionnaire_id`, `question_id`, `file`) VALUES
('2', '9', 'Questionário_TF.csv'),
('2', '10', 'Questionário_TF.csv'),
('2', '11', 'Questionário_TF.csv');

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

--
-- Despejando dados para a tabela `question_alternative_relation-temp`
--

INSERT INTO `question_alternative_relation-temp` (`question_id`, `alternative_id`, `file`) VALUES
('10', '29', 'Questionário_TF.csv'),
('10', '30', 'Questionário_TF.csv'),
('10', '31', 'Questionário_TF.csv'),
('10', '32', 'Questionário_TF.csv'),
('9', '24', 'Questionário_TF.csv'),
('9', '25', 'Questionário_TF.csv'),
('9', '26', 'Questionário_TF.csv'),
('9', '27', 'Questionário_TF.csv'),
('9', '28', 'Questionário_TF.csv');

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
('11111111', '0', 'Aluno Exemplo 1', '278307', 'aluno.exemplo.1@universidade.br', ''),
('12222222', '0', 'Aluno Exemplo 2', '156088', 'aluno.exemplo.2@universidade.br', ''),
('12345678', '1', 'Usuário coordenador', '123456', 'douglaslr@usp.br', 'None'),
('13333333', '0', 'Aluno Exemplo 3', '594140', 'aluno.exemplo.3@universidade.br', ''),
('14444444', '0', 'Aluno Exemplo 4', '174110', 'aluno.exemplo.4@universidade.br', ''),
('15555555', '0', 'Aluno Exemplo 5', '663616', 'aluno.exemplo.5@universidade.br', ''),
('16666666', '0', 'Aluno Exemplo 6', '946302', 'aluno.exemplo.6@universidade.br', '');

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
('11111111', '2026201', 'ABC2222'),
('12222222', '2026201', 'ABC2222'),
('13333333', '2026201', 'ABC2222'),
('14444444', '2026201', 'ABC2222'),
('15555555', '2026201', 'ABC2222'),
('16666666', '2026201', 'ABC2222'),
('11111111', '2027201', 'ABC4444'),
('12222222', '2027201', 'ABC4444'),
('13333333', '2027201', 'ABC4444'),
('14444444', '2027201', 'ABC4444'),
('15555555', '2027201', 'ABC4444'),
('16666666', '2027201', 'ABC4444');

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
  MODIFY `alternative_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `question-temp`
--
ALTER TABLE `question-temp`
  MODIFY `question_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `questionnaire-temp`
--
ALTER TABLE `questionnaire-temp`
  MODIFY `questionnaire_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
