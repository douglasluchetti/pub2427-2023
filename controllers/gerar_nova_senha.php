<?php

// header("Location: ../views/nova_senha_gerada.php");

include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    $query = "SELECT * FROM user WHERE (user_id=? OR email=?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    echo $result
}

exit();
?>
