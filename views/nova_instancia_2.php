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
                <h3 class="survey">Verifique as informações encontradas para cada disciplina</h3>
            </div>
            <div class="master">
                <h3>Insira um nome para a nova instância de avaliação (exemplo: 20241):</h3>
                <input class="login" type="text" id="suject_name" placeholder="Nome da Instância" required>
                <h3>Questionário padrão:</h3>
                <div class="inline_content">
                    <li>Questionário_padrão.xlsx</li>
                    <a class="logout" href="">
                        <img src="..\images\edit.svg" alt="edit" class="close">
                    </a>
                </div>   
                <h3>Turmas identificadas:</h3>
                <div class="inline_content">
                    <li>20241 - ABC1111 - Disciplina Exemplo 1</li>
                    <a class="logout" href="nova_instancia_3.php">
                        <img src="..\images\config.svg" alt="Config" class="close">
                    </a>
                </div>
                <div class="inline_content">
                    <li>20241 - ABC2222 - Disciplina Exemplo 2</li>
                    <a class="logout" href="nova_instancia_3.php">
                        <img src="..\images\config.svg" alt="Config" class="close">
                    </a>
                </div>
                <div class="inline_content">
                    <li>20242 - ABC2222 - Disciplina Exemplo 2</li>
                    <a class="logout" href="nova_instancia_3.php">
                        <img src="..\images\config.svg" alt="Config" class="close">
                    </a>
                </div>
                <div class="survey_buttons">
                    <a class="button_negative" href='nova_instancia_1.php' id="survey_negative">VOLTAR</a>
                    <form action="index_master.php">
                        <button type="submit" id="survey_positive" action="index_master.php">ENVIAR</button>
                    <form>
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
