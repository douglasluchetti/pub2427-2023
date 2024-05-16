<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pub2427";

date_default_timezone_set('America/Sao_Paulo');

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query_user_info = "SELECT * FROM instance";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();

while ($row = $result_user_info->fetch_assoc()) {

    if (strtotime($row['instance_date_beginning']) <= strtotime(date('Y-m-d H:i'))) {
        if ($row['status'] != 2) {
            $instance_status = 1;
            $query_update_status = "UPDATE instance SET status = ? WHERE instance_id = ?";
            $stmt_update_status = $conn->prepare($query_update_status);
            $stmt_update_status->bind_param("ss", $instance_status, $row['instance_id']);
            $stmt_update_status->execute();
        };
    }; 

    if (strtotime($row['instance_date_end']) <= strtotime(date('Y-m-d H:i'))) {
        $instance_status = 2;
        echo "simm";
        $query_update_status = "UPDATE instance SET status = ? WHERE instance_id = ?";
        $stmt_update_status = $conn->prepare($query_update_status);
        $stmt_update_status->bind_param("ss", $instance_status, $row['instance_id']);
        $stmt_update_status->execute();
    };

}
