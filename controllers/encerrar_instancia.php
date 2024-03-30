<?php

include('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $instance_id = $_POST['instance_id'];

    $stmt = $conn->prepare("UPDATE `instance` SET `status` = 2 WHERE `instance_id` = ?");
    $stmt->bind_param("s", $instance_id);
    $stmt->execute();

    header("Location: ../views/index_master.php");
}
?>
