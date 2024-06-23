<?php
session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location: ..\index.php");
//     exit();
// }

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
            <form class="logout" action="..\controllers\logout.php" method="POST">
                <input type="submit" id="file-upload" style="display: none;">   
                <label for="file-upload" class="button_negative" id="logout">
                    Sair <img src="..\images\logout.svg" alt="logout" class="button_image">
                </label>
            </form>
        </div>
        <div class="block" id="index">
            <div class="survey_title">  
                <h2>Configurar instância de avaliação</h2>
                <h3 class="survey">Importe uma ou mais listas de alunos e questionários na formatação adequada</h3>
            </div>
            <form id="upload-form" class="center" action="../controllers/import.php" method="POST" enctype="multipart/form-data">
                <label for="file-upload" class="button_negative">
                    UPLOAD <img src="..\images\upload.svg" alt="Upload" class="button_image">
                </label>
                <input type="hidden" name="import">
                <input name="file[]" id="file-upload" accept=".csv" type="file" multiple style="display: none;" onchange="this.form.submit()" required>
            </form>

        

            <div class="master">
                <h3>Listas de Alunos:</h3>
                <?php
                    $query = "SELECT * FROM files WHERE file_type='Lista de Alunos'";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows == 0){
                        echo "<h4>Nenhuma lista adicionada.</h4>";
                    }
                    while ($row = $result->fetch_assoc()) {
                        $file = $row['file'];
                        echo "<form class='inline_content' action='../controllers/excluir_arquivo.php' method='POST'>";
                        echo "   <input type='hidden' name='file' value=$file>";
                        echo"    <li>$file</li>";
                        echo "   <button class='image-button' type=submit';>";
                        echo"        <img src='..\images\delete.svg' alt='Delete' class='close'>";
                        echo "   </button>";
                        echo"</form>";
                    }
                    
                ?>
                <h3>Questionários:</h3>
                <?php
                    $query = "SELECT * FROM files WHERE file_type='Questionário'";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows == 0){
                        echo "<h4>Nenhum questionário adicionado.</h4>";
                    }
                    while ($row = $result->fetch_assoc()) {
                        $file = $row['file'];
                        echo "<form class='inline_content' action='../controllers/excluir_arquivo.php' method='POST'>";
                        echo "   <input type='hidden' name='file' value=$file>";
                        echo"    <li>$file</li>";
                        echo "   <button class='image-button' type=submit';>";
                        echo"        <img src='..\images\delete.svg' alt='Delete' class='close'>";
                        echo "   </button>";
                        echo"</form>";
                    }
                ?>
                <div class="survey_buttons">
                    <a class="button_negative" href='index_master.php' id="survey_negative">VOLTAR</a>
                    <form action="nova_instancia_2.php">
                        <button type="submit" id="survey_positive">PROSSEGUIR</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    var forms = document.getElementsByClassName('inline_content');
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener('submit', function(event) {
            var confirmation = confirm('Tem certeza de que deseja remover o arquivo selecionado?');
            if (!confirmation) {
                event.preventDefault();
            }
        });
    }
});
</script>
<?php
$conn->close();
?>
