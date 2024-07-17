<?php
session_start();

include('../config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
} 

else{
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $class_id_new = $_POST['class_id_new'];
    $subject_id_new = $_POST['subject_id_new'];
    $subject_name = $_POST['subject_name'];
    $questionnaire_name = $_POST['questionnaire_name'];
    $query = "SELECT * FROM `questionnaire-temp` WHERE `questionnaire_name`=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $questionnaire_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $questionnaire_id = $row['questionnaire_id'];

    $_SESSION['class_id'] = $class_id_new;
    $_SESSION['subject_id'] = $subject_id_new;

    // // Atualiza a turma
    $stmt = $conn->prepare("UPDATE `class-temp` SET `class_id` = ?, 
    `subject_id` = ?, `subject_name` = ? 
    WHERE `class_id` = ? AND `subject_id` = ?");
    $stmt->bind_param("sssss", $class_id_new, $subject_id_new, $subject_name, $class_id, $subject_id);
    $stmt->execute();

    //Atualiza a relação de alunos e turmas
    $stmt = $conn->prepare("UPDATE `user_class_relation-temp` SET `class_id` = ?, 
    `subject_id` = ? 
    WHERE `class_id` = ? AND `subject_id` = ?");
    $stmt->bind_param("ssss", $class_id_new, $subject_id_new, $class_id, $subject_id);
    $stmt->execute();
    $stmt->execute();

    //Atualiza o questionario
    $stmt = $conn->prepare("UPDATE `instance_questionnaire_class_relation-temp` SET 
    `questionnaire_id` = ?, `class_id` = ?, `subject_id` = ?
    WHERE `class_id` = ? AND `subject_id` = ?");
    $stmt->bind_param("sssss", $questionnaire_id, $class_id_new, $subject_id_new, $class_id, $subject_id);
    $stmt->execute();

    header("Location: ../views/nova_instancia_2.php");
    exit();

}
?>
