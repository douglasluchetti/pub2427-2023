<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $questionnaire_name = $_POST['questionnaire_name'];
    $instance_id = $_POST['instance_id'];

    //Obtem o id do questionário padrão:
    $query = "SELECT * FROM `questionnaire-temp` WHERE `questionnaire_name`=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $questionnaire_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $questionnaire_id = $row['questionnaire_id'];

    //Atualiza a tabela de relação de instância e classe
    $stmt = $conn->prepare("UPDATE `instance_questionnaire_class_relation-temp` SET `questionnaire_id` = ?
    WHERE `questionnaire_id` = ''");
    $stmt->bind_param("s", $questionnaire_id);
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE `instance_questionnaire_class_relation-temp` SET `instance_id` = ?
    WHERE `instance_id` = ''");
    $stmt->bind_param("s", $instance_id);
    $stmt->execute();

    //Cria a instância:
    $stmt = $conn->prepare("INSERT INTO `instance` (`instance_id`, `status`) VALUES (?, 0)");
            $stmt->bind_param("s", $instance_id);
            $stmt->execute();

    $tables = [
        'alternative' => ['alternative_id', 'content'],
        'class' => ['class_id', 'subject_id', 'subject_name', 'teacher_name'],
        'instance_questionnaire_class_relation' => ['instance_id', 'questionnaire_id', 'class_id', 'subject_id'],
        'question' => ['question_id', 'question_type', 'title', 'content'],
        'questionnaire'=> ['questionnaire_id', 'questionnaire_name'],
        'questionnaire_question_relation' => ['questionnaire_id', 'question_id'],
        'question_alternative_relation' => ['question_id', 'alternative_id'],
        'user' => ['user_id', 'user_type', 'name', 'password', 'email',],
        'user_class_relation' => ['user_id', 'class_id', 'subject_id'],
    ];
    
    foreach ($tables as $table => $columns) {
        $columns_str = implode(', ', $columns);
        $stmt = $conn->prepare("INSERT INTO `$table` ($columns_str) SELECT $columns_str FROM `{$table}-temp`");
        $stmt->execute();
        echo $stmt->error;
    
        // Esvazia a tabela temporária
        $stmt = $conn->prepare("DELETE FROM `{$table}-temp`");
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM `files`");
    $stmt->execute();

        header("Location: ../views/index_master.php");
}
?>
