<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

include('../config.php');

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

?>

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
            <a class="logout" href="..\controllers\logout.php">
                <img src="..\images\logout.svg" alt="Logout" class="logout">
            </a>
        </div>
        <div class="block" id="index">
            <div class="survey_title">  
                <h2>Configurar instância de avaliação</h2>
                <h3 class="survey">Importe uma ou mais listas de alunos na formatação adequada</h3>
            </div>
            <div class="center">
                <a class="button_negative" href="https://teste.123">UPLOAD <img src="..\images\upload.svg" alt="Upload" class="button_image"> </a>
            </div>
            <div class="master">
                <h3>Arquivos selecionados:</h3>
                <div class="inline_content">
                    <li>Lista_de_alunos_formatada_1.xlsx</li>
                    <a class="logout" href="">
                        <img src="..\images\delete.svg" alt="Delete" class="close">
                    </a>
                </div>   
                <div class="inline_content">
                    <li>Lista_de_alunos_formatada_2.xlsx</li>
                    <a class="logout" href="">
                        <img src="..\images\delete.svg" alt="Delete" class="close">
                    </a>
                </div>  
                <div class="inline_content">
                    <li>Lista_de_alunos_formatada_3.xlsx</li>
                    <a class="logout" href="">
                        <img src="..\images\delete.svg" alt="Delete" class="close">
                    </a>
                </div>  
                <div class="survey_buttons">
                    <a class="button_negative" href='nova_instancia_1.php' id="survey_negative">VOLTAR</a>
                    <button type="submit" id="survey_positive" action="nova_instancia_2.php">PROSSEGUIR</button>
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
