<?php
// Inicia a sessão após a autenticação do usuário bem-sucedida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $host = "tvcpw8tpu4jvgnnq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    $dbusername = "g3iwo7l2nhxhu3jj";
    $dbpassword = "l2yt1z9ari3b7ivr";
    $dbname = "e9hxtfiwq6fz1for";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM user WHERE (user_id=? OR email=?) AND password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        session_start(); // Inicia a sessão após a autenticação bem-sucedida

        $user_data = $result->fetch_assoc();
        $_SESSION['username'] = $username;

        if ($user_data['user_type'] == 0) {
            header("Location: ..\index\index_aluno.php");
            exit();
        } elseif ($user_data['user_type'] == 1) {
            header("Location: ..\index\index_master.php");
            exit();
        }
    } else {
        header("Location: login_error.html");
        exit();
    }

    $conn->close();
}
?>
