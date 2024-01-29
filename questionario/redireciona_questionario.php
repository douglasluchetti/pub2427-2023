<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
} 

else{
    $_SESSION['class_id'] = $_POST['class_id'];
    $_SESSION['subject_id'] = $_POST['subject_id'];
    $_SESSION['questionnaire_id'] = $_POST['questionnaire_id'];
    $_SESSION['instance_id'] = $_POST['instance_id'];
    header("Location: questionario.php");
}
?>
