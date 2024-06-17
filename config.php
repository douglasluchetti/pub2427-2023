<?php
// Variáveis de conexão com o banco de dados
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pub2427";

// Define o fuso horário padrão
date_default_timezone_set('America/Sao_Paulo');

// Cria uma nova conexão com o banco de dados
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para obter informações do usuário
$query_user_info = "SELECT * FROM instance";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();

// Percorre o resultado e atualiza o status
while ($row = $result_user_info->fetch_assoc()) {
    // Verifica se o instance_date_beginning é menor ou igual à data e hora atual
    if (strtotime($row['instance_date_beginning']) <= strtotime(date('Y-m-d H:i'))) {
        if ($row['status'] != 2) {
            $instance_status = 1;
            $query_update_status = "UPDATE instance SET status = ? WHERE instance_id = ?";
            $stmt_update_status = $conn->prepare($query_update_status);
            $stmt_update_status->bind_param("ss", $instance_status, $row['instance_id']);
            $stmt_update_status->execute();
        }
    }

    // Verifica se o instance_date_end é menor ou igual à data e hora atual
    if (strtotime($row['instance_date_end']) <= strtotime(date('Y-m-d H:i'))) {
        $instance_status = 2;
        $query_update_status = "UPDATE instance SET status = ? WHERE instance_id = ?";
        $stmt_update_status = $conn->prepare($query_update_status);
        $stmt_update_status->bind_param("ss", $instance_status, $row['instance_id']);
        $stmt_update_status->execute();
    }
}
?>