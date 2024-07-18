<?php

include('../config.php');

// Caminho para o arquivo local
$localFilePath = '../files/';

$files = scandir($localFilePath);

function insertIntoAlternative($conn, $alternative, $question_id, $file_name) {
    if(!empty($alternative)) {    
        $stmt = $conn->prepare("INSERT INTO `alternative-temp` (`content`, `file`) VALUES (?, ?)");
        $stmt->bind_param("ss", $alternative, $file_name);
        $stmt->execute();
        $query = "SELECT * FROM `alternative-temp` WHERE content=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $alternative);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $alternative_id = $result['alternative_id'];
        $stmt = $conn->prepare("INSERT INTO `question_alternative_relation-temp` (`question_id`, `alternative_id`, `file`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question_id, $alternative_id, $file_name);
        $stmt->execute();

    }
};

// Verifica se encontrou arquivos
if ($files !== false) {
    // Itera sobre cada arquivo no diretório
    foreach ($files as $file_name) {
        if ($file_name != "." && $file_name != "..") {
            // Constrói o caminho completo para o arquivo
            $filename = $localFilePath . $file_name;

        $file = fopen($filename, "r");
        $row = 1;

        while(($column = fgetcsv($file, 10000, ";")) !== FALSE){

            if($row == 1) { 
                $file_type = "";
            }

            // Verifica o tipo do arquivo (lista de alunos / questionário):
            if($row == 2) {
                $file_type = $column[1];
                if(empty($file_type)) {
                    $error = true;
                }
            }

            if($file_type == "Questionário"){

                // Verifica se o qeustionário tem o cabeçalho no formato correto e armazena as variáveis:
                if($row == 3) {
                    $questionnaire_name = $column[1];
                    if(empty($subject_id)) {
                        $error = true;
                    }

                    // Insere o questionário na tabela temporária:
                    if($file_type == "Questionário"){ 
                        $query = "SELECT * FROM `questionnaire-temp` WHERE questionnaire_name=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $questionnaire_name);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows == 0) {
                            $stmt = $conn->prepare("INSERT INTO `questionnaire-temp` (`questionnaire_name`, `file`) VALUES (?, ?)");
                            $stmt->bind_param("ss", $questionnaire_name, $file_name);
                            $stmt->execute();
                            $query = "SELECT * FROM `questionnaire-temp` WHERE questionnaire_name=?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $questionnaire_name);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $result = $result->fetch_assoc();
                            $questionnaire_id = $result['questionnaire_id'];
                        }
                    }
                }

                // Obtem informações de cada questão da lista:
                if($row > 4) {
                    $title = $column[2];
                    $question_type = $column[1];
                    if($question_type == "Texto") {
                        $question_type = 2;
                    } else if($question_type == "Múltipla") {
                        $question_type = 0;
                    }
                    else if($question_type == "Alternativa") {
                        $question_type = 1;
                    }
                    for ($i = 3; $i < count($column); $i++) {
                        $alternatives[] = $column[$i];
                    }
                    
                    // Verifica se a questão já é cadastrado e, caso negativo, cadastra:
                    
                    if(!empty($title)) {    
                        $stmt = $conn->prepare("INSERT INTO `question-temp` (`title`, `question_type`,
                            `file`) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $title, $question_type, $file_name);
                        $stmt->execute();
                        $query = "SELECT * FROM `question-temp` WHERE title=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $title);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $result = $result->fetch_assoc();
                        $question_id = $result['question_id'];
                        foreach ($alternatives as $alternative) {
                            insertIntoAlternative($conn, $alternative, $question_id, $file_name);
                        }
                        $stmt = $conn->prepare("INSERT INTO `questionnaire_question_relation-temp` (`questionnaire_id`, `question_id`, `file`) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $questionnaire_id, $question_id, $file_name);
                        $stmt->execute();

                    }

                    $alternatives = [];
                          
                }
            }

            $row++;
        }


            // Insere o arquivo na tabela temporária:
            $query = "SELECT * FROM `files` WHERE file=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $file_name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO files (`file`, `file_type`) VALUES (?, ?)");
                $stmt->bind_param("ss", $file_name, $file_type);
                $stmt->execute();
            }

        fclose($file);
    }}};

header("Location: ../views/index_master.php");
?>