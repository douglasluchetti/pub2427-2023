<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $file = $_POST['file'];

    $tables = [
        'alternative-temp',
        'class-temp',
        'instance_questionnaire_class_relation-temp',
        'question-temp',
        'questionnaire-temp',
        'questionnaire_question_relation-temp',
        'question_alternative_relation-temp',
        'user-temp',
        'user_class_relation-temp',
        'files'
    ];

    foreach ($tables as $table) {
        $stmt = $conn->prepare("DELETE FROM `$table` WHERE file = ?");
        $stmt->bind_param("s", $file);
        $stmt->execute();
    }

        header("Location: ../views/nova_instancia_1.php");
}
?>
