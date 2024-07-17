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
$welcome_message = "Olá, $name";
$course_info = "Administrador do Sistema - $username";


$instance_off = FALSE;

$instance_id = $_POST['instance_id'];

$query_user_info = "SELECT * FROM instance WHERE instance_id = ?";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->bind_param("s", $instance_id);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();
$row = $result_user_info->fetch_assoc();
$content = $row['content'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Avaliação de Disciplinas</title>
    <meta charset="utf-8">
    <meta name="description" content="Este é um projeto open source para avaliação de disciplinas. Contribua no GitHub.">
    <link rel="icon" href="images/logo.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="images/logo_dark.svg" media="(prefers-color-scheme: light)">
    <link rel="icon" href="images/logo_dark.svg" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="..\css\styles.css" type="text/css">
    <script src="../tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#plano_de_acao',
            branding: false,
            promotion: false,
            resize: false,
            statusbar: false,
            plugins: 'lists',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
        });
    </script>
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
        <form class="logout" action="..\controllers\logout.php" method="POST">
                <input type="submit" id="logout" style="display: none;">   
                <label for="logout" class="button_negative" id="logout">
                    Sair <img src="..\images\logout.svg" alt="logout" class="button_image">
                </label>
            </form>
        </div>
        <div class="block" id="index">
            <div class="survey_title">  
                <h2>Plano de Ação</h2>
                <h3 class="survey">Insira, edite e crie um plano de ação para a instância de avaliação selecionada</h3>
            </div>
            <div class="master">
                <h3>Instância selecionada: <?php echo $instance_id;?></h3>
                <div class="center">
                    <form class="text-editor" id="plano" action="..\controllers\salvar_plano.php" method="POST">
                        <input type="hidden" name="instance_id" value="<?php echo $instance_id;?>">
                        <textarea id="plano_de_acao" name="content"><?php echo $content;?></textarea>
                    </form>
                </div>
                <div class="survey_buttons">
                    <a class="button_negative" href='index_master.php' id="survey_negative">CANCELAR</a>
                    <button type="submit" id="survey_positive" form="plano">SALVAR</button>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Este projeto é totalemtnte open source. Visite o <strong>repositório</strong> no GitHub para acessar o código-fonte, relatar problemas ou contribuir com melhorias.</a>
        </div>
    </div>
</script>
  </body>
</html>


<?php
$conn->close();
?>
