<?php

include('../config.php');

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $files = $_FILES['file'];

    for ($i = 0; $i < count($_FILES["file"]['name']); $i++) {
        if ($_FILES["file"]['error'][$i] === 0) {
            $filename = $_FILES["file"]['tmp_name'][$i];
        }

            $file_name = $_FILES['file']['name'][$i];

        $error = false;

        if($_FILES["file"]["size"] > 0){
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
                


                if($file_type == "Lista de Alunos"){

                    // Verifica se a lista de alunos tem o cabeçalho no formato correto e armazena as variáveis:
                    if($row == 3) {
                        $subject_id = $column[1];
                        if(empty($subject_id)) {
                            $error = true;
                        }
                    }
                    if($row == 4) {
                        $class_id = $column[1];
                        if(empty($class_id)) {
                            $error = true;
                        }
                    }
                    if($row == 5) {
                        $subject_name = $column[1];
                        if(empty($subject_name)) {
                            $error = true;
                        }
                    }
                    if($row == 6) {
                        $teacher_name = $column[1];
                        if(empty($teacher_name)) {
                            $error = true;
                        }

                        // Insere a disciplina na tabela temporária:
                        if($file_type == "Lista de Alunos"){   
                            $query = "SELECT * FROM `class-temp` WHERE class_id=? AND subject_id=? AND subject_name=? AND teacher_name=?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("ssss", $class_id, $subject_id, $subject_name, $teacher_name);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows == 0) {
                                $stmt = $conn->prepare("INSERT INTO `class-temp` (`class_id`, `subject_id`, `subject_name`, 
                                    `teacher_name`, `file`) VALUES (?, ?, ?, ?, ?)");
                                $stmt->bind_param("sssss", $class_id, $subject_id, $subject_name, $teacher_name, $file_name);
                                $stmt->execute();
                                $stmt = $conn->prepare("INSERT INTO `instance_questionnaire_class_relation-temp` 
                                (`class_id`, `subject_id`, `file`) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss", $class_id, $subject_id, $file_name);
                                $stmt->execute();
                            }
                        }
                    }

                    // Obtem informações de cada aluno da lista:
                    if($row > 7) {
                        $user_id = $column[0];
                        $name = $column[3];
                        $user_type = 0;
                        $password = rand(100000, 999999);
                        $email = $column[4];
                        
                        //Verifica se o aluno já é cadastrado e, caso negativo, cadastra:
                        $query = "SELECT * FROM user WHERE user_id=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows == 0) {
                            $query = "SELECT * FROM `user-temp` WHERE user_id=?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows == 0) {
                                $stmt = $conn->prepare("INSERT INTO `user-temp` (`user_id`, `name`, `user_type`,
                                `password`, `email`, `file`) VALUES (?, ?, ?, ?, ?, ?)");
                                $stmt->bind_param("ssssss", $user_id, $name, $user_type, $password, $email, $file_name);
                                $stmt->execute();
                            }
                        }

                        // Insere a relação entre o aluno e a disciplina na tabela temporária:
                        $query = "SELECT * FROM `user_class_relation-temp` WHERE user_id=? AND class_id=? AND subject_id=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("sss", $user_id, $class_id, $subject_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows == 0) {
                            $stmt = $conn->prepare("INSERT INTO `user_class_relation-temp` (`user_id`, `class_id`, 
                            `subject_id`, `file`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $user_id, $class_id, $subject_id, $file_name);
                            $stmt->execute();
                        }


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
        };

    }
    // $username = $_POST['username'];
    // $password = $_POST['password'];


    // $query = "SELECT * FROM user WHERE (user_id=? OR email=?) AND password=?";
    // $stmt = $conn->prepare($query);
    // $stmt->bind_param("sss", $username, $username, $password);
    // $stmt->execute();
    // $result = $stmt->get_result();
    

    $conn->close();

    header("Location: ../views/nova_instancia_1.php");
}
?>
