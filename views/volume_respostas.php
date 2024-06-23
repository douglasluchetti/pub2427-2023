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

$query_instance = "SELECT * FROM instance ORDER BY instance_id DESC";
$stmt_instance = $conn->prepare($query_instance);
$stmt_instance->execute();
$result_instance = $stmt_instance->get_result();

$instance_off = FALSE;

$instance_id = $_POST['instance_id'];
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
                <a class="logout" href="..\controllers\logout.php">
                    <img src="..\images\logout.svg" alt="Logout" class="logout">
                </a>
                </div>
                <div class="block" id="index">
                    <div class="survey_buttons">
                        <div class="survey_title">  
                            <h2>Volume de Respostas</h2>
                            <h3 class="survey"> Instância: <?php echo $instance_id; ?></h3>
                        </div>
                    </div>
                    <div class="master">
                        <h3>Ações sobre os questionários da instância selecionada:</h3>
                        <?php
                        $query = "SELECT * FROM `instance_questionnaire_class_relation` WHERE instance_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $instance_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $class_id = $row['class_id'];
                            $subject_id = $row['subject_id'];
                            $query_class_info = "SELECT * FROM class WHERE class_id = ? AND subject_id = ?";
                            $stmt_class_info = $conn->prepare($query_class_info);
                            $stmt_class_info->bind_param("ss", $class_id, $subject_id);
                            $stmt_class_info->execute();
                            $result_class_info = $stmt_class_info->get_result();
                            $class_row = $result_class_info->fetch_assoc();
                            $subject_name = $class_row['subject_name'];
                            $query_answer_count = "SELECT COUNT(DISTINCT user_id, class_id, subject_id, instance_id) 
                            AS unique_combinations FROM answer WHERE class_id = ? AND subject_id = ? AND instance_id = ?";
                            $stmt_answer_count = $conn->prepare($query_answer_count);
                            $stmt_answer_count->bind_param("sss", $class_id, $subject_id, $instance_id);
                            $stmt_answer_count->execute();
                            $result_answer_count = $stmt_answer_count->get_result();
                            $row_answer_count = $result_answer_count->fetch_assoc();
                            $unique_combinations = $row_answer_count['unique_combinations'];
                            echo '<div class="inline_content">';
                            echo "<li>$subject_id - $subject_name</li>";
                            echo '<div class="center">';
                            echo "<h3 class='instance_status' id='waiting'>$unique_combinations resposta(s).</h3>";
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    <div class="center">
                        <a class="button_negative" href='index_master.php' id="survey_negative">VOLTAR</a>
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
    var forms = document.getElementsByClassName('center');
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener('submit', function(event) {
            var confirmation = confirm('Tem certeza que deseja iniciar / encerrar a instância selecionada? Uma vez feita, essa ação não pode ser desfeita.');
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
