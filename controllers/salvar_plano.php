<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $instance_id = $_POST['instance_id'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE `instance` SET `content` = ? WHERE `instance_id` = ?");
    if (!$stmt) {
        // Verifica se houve um erro na preparação da query
        echo "Erro na preparação: " . $conn->error;
        exit();
    }

    $stmt->bind_param("ss", $content, $instance_id);
    if (!$stmt->execute()) {
        // Verifica se houve um erro na execução da query
        echo "Erro na execução: " . $stmt->error;
        exit();
    } else {
        echo "Registro atualizado com sucesso.";
    }

    header("Location: ../views/index_master.php");
}
?>
