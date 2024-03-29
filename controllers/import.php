<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $filename = $_FILES['file']['tmp_name'];

    $error = false;

    if($_FILES["file"]["size"] > 0){
        $file = fopen($filename, "r");

        $row = 1; 

        while(($column = fgetcsv($file, 10000, ";")) !== FALSE){

            // Verifica o tipo do arquivo (lista de alunos / questionário):
            if($row == 1) {
                $file_type = $column[1];
                if(empty($file_type)) {
                    $error = true;
                }
            }


            if($file_type == "Lista de Alunos"){

                // Verifica se a lista de alunos tem o cabeçalho no formato correto e armazena as variáveis:
                if($row == 2) {
                    $subject_id = $column[1];
                    if(empty($subject_id)) {
                        $error = true;
                    }
                }
                if($row == 3) {
                    $class_id = $column[1];
                    if(empty($class_id)) {
                        $error = true;
                    }
                }
                if($row == 4) {
                    $subject_name = $column[1];
                    if(empty($subject_name)) {
                        $error = true;
                    }
                }
                if($row == 5) {
                    $teacher_name = $column[1];
                    if(empty($teacher_name)) {
                        $error = true;
                    }
                }

                // Obtem informações de cada aluno da lista:
                if($row > 7) {
                    $user_id = $column[0];
                    $name = $column[3];
                    $user_type = 0;
                    $password = rand(100000, 999999);
                    $email = $column[4];
                    $course =$column[5];
                    
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
                            `password`, `email`, `course`) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssssss", $user_id, $name, $user_type, $password, $email, $course);
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
                        `subject_id`) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $user_id, $class_id, $subject_id);
                        $stmt->execute();
                    }


                }
            }

            $row++;
        }

        // Insere a disciplina na tabela temporária:
        $query = "SELECT * FROM `class-temp` WHERE class_id=? AND subject_id=? AND subject_name=? AND teacher_name=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $class_id, $subject_id, $subject_name, $teacher_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO `class-temp` (`class_id`, `subject_id`, `subject_name`, 
                `teacher_name`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $class_id, $subject_id, $subject_name, $teacher_name);
            $stmt->execute();
        }

        $query = "SELECT * FROM `files` WHERE file=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_FILES['file']['name']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO files (`file`, `file_type`) VALUES (?, ?)");
            $stmt->bind_param("ss", $_FILES['file']['name'], $file_type);
            $stmt->execute();
        }

        fclose($file);
    };
    // $username = $_POST['username'];
    // $password = $_POST['password'];


    // $query = "SELECT * FROM user WHERE (user_id=? OR email=?) AND password=?";
    // $stmt = $conn->prepare($query);
    // $stmt->bind_param("sss", $username, $username, $password);
    // $stmt->execute();
    // $result = $stmt->get_result();


    $conn->close();
}
?>
