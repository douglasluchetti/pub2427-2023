<?php

include('../config.php');

// Inicia a sessão após a autenticação do usuário bem-sucedida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $query = "SELECT * FROM user WHERE (user_id=? OR email=?) AND password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    // $row = $result->fetch_assoc();
    // $username = $row['user_id'];

    if ($result->num_rows == 1) {
        session_start(); // Inicia a sessão após a autenticação bem-sucedida

        $user_data = $result->fetch_assoc();
        $query_user_info = "SELECT * FROM user WHERE user_id=? OR email=?";
        $stmt = $conn->prepare($query_user_info);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result_user_info = $stmt->get_result();
        $row = $result_user_info->fetch_assoc();
        $username = $row['user_id'];
        $_SESSION['username'] = $username;

        if ($user_data['user_type'] == 0) {
            header("Location: ../views/index_aluno.php");
            exit();
        } elseif ($user_data['user_type'] == 1) {
            $query_instance = "SELECT MAX(instance_id) AS max_instance_id FROM instance";
            $stmt_instance = $conn->prepare($query_instance);
            $stmt_instance->execute();
            $result_instance = $stmt_instance->get_result();
            $max_instance_id = $result_instance->fetch_assoc()['max_instance_id'];
            $_SESSION['instance_id'] = $max_instance_id;
            header("Location: ../views/index_master.php");
            exit();
        }
    } else {
        header("Location: ../views/senha_incorreta.php");
        exit();
    }

    $conn->close();
}
?>
