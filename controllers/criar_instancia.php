<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $questionnaire_name = $_POST['questionnaire_name'];
    $instance_id = $_POST['instance_id'];
    $instance_date_beginning = $_POST['instance_date_beginning'];
    $instance_date_beginning = date('Y-m-d H:i:s', strtotime($instance_date_beginning));
    $instance_date_end = $_POST['instance_date_end'];
    $instance_date_end = date('Y-m-d H:i:s', strtotime($instance_date_end));

    //Verifica se o id já existe::
    $query = "SELECT * FROM `instance` WHERE `instance_id`=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $instance_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>
        alert('Já existe uma instancia com o mesmo nome criada. Por favor, utilize outro nome.');
        window.location.href = '../views/nova_instancia_2.php';
        </script>";
        exit();
    }

    //Verifica se existe alguma turma cadastrada:
    $query = "SELECT * FROM `class-temp`";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "<script>
        alert('É necessário cadastrar pelo menos uma turma na instância.');
        window.location.href = '../views/nova_instancia_2.php';
        </script>";
        exit();
    }

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
    $stmt = $conn->prepare("INSERT INTO `instance` (`instance_id`, `status`, `instance_date_beginning`, `instance_date_end`) VALUES (?, 0, ?, ?)");
    $stmt->bind_param("sss", $instance_id, $instance_date_beginning, $instance_date_end);
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
