<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$host = "tvcpw8tpu4jvgnnq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$dbusername = "g3iwo7l2nhxhu3jj";
$dbpassword = "l2yt1z9ari3b7ivr";
$dbname = "e9hxtfiwq6fz1for";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

$query_user_info = "SELECT * FROM user WHERE user_id = ?";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->bind_param("s", $username);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();
$row = $result_user_info->fetch_assoc();
$name = $row['name'];
$course = $row['course'];
$welcome_message = "Olá, $name";
$course_info = "Administrador do Sistema - $username";

$query_user_class = "SELECT * FROM user_class_relation WHERE user_id = ?";
$stmt_user_rows = $conn->prepare($query_user_class);
$stmt_user_rows->bind_param("s", $username);
$stmt_user_rows->execute();
$result_user_rows = $stmt_user_rows->get_result();

$instance_off = FALSE;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Avaliação de Disciplinas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="..\css\styles.css" type="text/css">
</head>
<body>
    <div class="header">
        <div class="logo_name">
            <img src="..\images\logo.svg" alt="Logo" class="logo">
            <h1>Avaliação de Disciplinas</h1>
        </div>
        <div class="line"></div>
        <div class="line" id="standart"></div>
        <div class="line" id="darker"></div>
    </div>
    <div class="content">
        <div class="top_menu">
            <div class="user_info">
                <h3><?php echo $welcome_message; ?></h3>
                <h4><?php echo $course_info; ?></h4>
            </div>
            <a class="logout" href="..\login\logout.php">
                <img src="..\images\logout.svg" alt="Logout" class="logout">
            </a>
        </div>
        <div class="block" id="index">
             <div class="survey_buttons">  
                <h2>Aplicação de Questionário</h2>
                <a class="button_negative" href="https://teste.123">NOVA INSTÂNCIA DE AVALIAÇÃO</a>
            </div>
            <div class="master">
                <h3>Ações sobre os questionários da instância selecionada:</h3>
                <div class="center">
                    <form class="select" id="select_instance">
                        <select class="select_instance" name="instance" id="instance">
                            <option value="2023 - Segundo Semestre">2023 - Segundo Semestre</option>
                            <option value="2023 - Segundo Semestre">2023 - Segundo Semestre</option>
                            <option value="2023 - Segundo Semestre">2023 - Segundo Semestre</option>
                        </select>
                    </form>
                </div>
                <div class="inline_content">
                    <h3>Status da instância:</h3>
                    <h3 class="instance_status" id="waiting">Aguardando abertura. Questionários fechados</h3>
                </div>
                <div class="inline_content">
                    <li>Configurar questionários, disciplinas e alunos da instância</li>
                    <a class="logout" href="">
                        <img src="..\images\config.svg" alt="Config" class="close">
                    </a>
                </div>   
                <h3>Atulização de bases:</h3>
                <div class="inline_content">
                    <li>Emails_docentes.xlsx</li>
                    <a class="logout" href="">
                        <img src="..\images\upload.svg" alt="Upload" class="close">
                    </a>
                </div>
                <div class="center">
                    <button type="submit">INICIAR INSTÂNCIA DE AVALIAÇÃO</button>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_content">
            <a href="https://teste.123" class="footer">Desenvolvedores</a>
            <a href="https://teste.123" class="footer">Termos de Uso</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
