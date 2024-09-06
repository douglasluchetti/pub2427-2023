<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('../config.php');

$username = $_SESSION['username'];

if(isset($_POST['file'])) {
    $file = $_POST['file'];
    $questionnaire_name = "";
}
if(isset($_POST['questionnaire_name'])) {
    $questionnaire_name = $_POST['questionnaire_name'];
    $file = "";
}

$query_user_info = "SELECT * FROM user WHERE user_id = ?";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->bind_param("s", $username);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();
$row = $result_user_info->fetch_assoc();
$name = $row['name'];
$welcome_message = "Olá, $name";
$course_info = "$username";

$query_questions = "SELECT * FROM `questionnaire-temp` WHERE `file` = ? OR `questionnaire_name` = ?	";
$stmt_questions = $conn->prepare($query_questions);
$stmt_questions->bind_param("ss", $file, $questionnaire_name);
$stmt_questions->execute();
$result_questionnarie = $stmt_questions->get_result();
$questionnaire_row = $result_questionnarie->fetch_assoc();
$questionnaire_id = $questionnaire_row['questionnaire_id'];
$questionnaire_name = $questionnaire_row['questionnaire_name'];
$file = $questionnaire_row['file'];

$query_questions = "SELECT * FROM `questionnaire_question_relation-temp` WHERE questionnaire_id = ?";
$stmt_questions = $conn->prepare($query_questions);
$stmt_questions->bind_param("s", $questionnaire_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();


$num_questions = 1;


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
        <title>Avaliação de Disciplinas</title>
        <meta charset="utf-8">
    <meta name="description" content="Este é um projeto open source para avaliação de disciplinas. Contribua no GitHub.">
    <link rel="icon" href="../images/logo.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="../images/logo_dark.svg" media="(prefers-color-scheme: light)">
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
            </div>
            <form class="block" id="survey" action="..\controllers\envia_questionario.php" method="POST">
                <div class="survey_title">  
                    <h2><?php echo "Visualização: $questionnaire_name"; ?></h2>
                    <h3 class="survey"><?php echo $file; ?></h3>
                </div>
                <?php
            while ($row = $result_questions->fetch_assoc()) {
                $question_id = $row['question_id'];
                $query_question = "SELECT * FROM `question-temp` WHERE question_id = ?";
                $stmt_question = $conn->prepare($query_question);
                $stmt_question->bind_param("s", $question_id);
                $stmt_question->execute();
                $result_instance = $stmt_question->get_result();
                $instance_row = $result_instance->fetch_assoc();
                $question_type = $instance_row['question_type'];
                $title = $instance_row['title'];


                if ($question_type == 0) {
                    ?>
                    <div class="question_multiple_choice">
                        <h4 class="survey"><?php echo "$num_questions. $title"; ?></h4>
                        <?php
                        $query_questions = "SELECT * FROM `question_alternative_relation-temp` WHERE question_id = ?";
                        $stmt_alternative = $conn->prepare($query_questions);
                        $stmt_alternative->bind_param("s", $question_id);
                        $stmt_alternative->execute();
                        $result_alternative = $stmt_alternative->get_result();

                        while ($row = $result_alternative->fetch_assoc()) {
                            $alternative_id = $row['alternative_id'];
                            $query_alternative = "SELECT * FROM `alternative-temp` WHERE alternative_id = ?";
                            $stmt_alternative = $conn->prepare($query_alternative);
                            $stmt_alternative->bind_param("s", $alternative_id);
                            $stmt_alternative->execute();
                            $result_instance = $stmt_alternative->get_result();
                            $instance_row = $result_instance->fetch_assoc();
                            $content = $instance_row['content'];
                            ?>
                            <label>
                            <input class="question_multiple_choice" type="checkbox" 
                                name="<?php echo $question_id; ?>[]" value="<?php echo $content; ?>"/><h4 class="alternative"><?php echo "$content"; ?></h4>
                            </label>
                            <?php
                        }
                    ?>
                    </div>
                    <?php
                } elseif ($question_type == 1) {
                    ?>
                    <div class="question_multiple_choice">
                        <h4 class="survey"><?php echo "$num_questions. $title"; ?></h4>
                        <?php
                        $query_questions = "SELECT * FROM `question_alternative_relation-temp` WHERE question_id = ?";
                        $stmt_alternative = $conn->prepare($query_questions);
                        $stmt_alternative->bind_param("s", $question_id);
                        $stmt_alternative->execute();
                        $result_alternative = $stmt_alternative->get_result();

                        while ($row = $result_alternative->fetch_assoc()) {
                            $alternative_id = $row['alternative_id'];
                            $query_alternative = "SELECT * FROM `alternative-temp` WHERE alternative_id = ?";
                            $stmt_alternative = $conn->prepare($query_alternative);
                            $stmt_alternative->bind_param("s", $alternative_id);
                            $stmt_alternative->execute();
                            $result_instance = $stmt_alternative->get_result();
                            $instance_row = $result_instance->fetch_assoc();
                            $content = $instance_row['content'];
                            ?>
                            <label>
                            <input class="question_multiple_choice" type="radio" 
                                name=<?php echo "$question_id"; ?> value="<?php echo $content; ?>"/><h4 class="alternative"><?php echo "$content"; ?></h4>
                            </label>
                            <?php
                        }
                    ?>
                    </div>
                    <?php
                } elseif ($question_type == 2) {
                    ?>
                    <div class="question_multiple_choice">
                        <h4 class="survey"><?php echo "$num_questions. $title"; ?></h4>
                        <div class="form__group field">
                            <textarea class="form__field" name=<?php echo "$question_id"; ?> ></textarea>
                        </div>              
                    </div>
                <?php
                }
                $num_questions = $num_questions + 1; 
                }
                ?>
            <div class="center">
                <a class="button_negative" id="survey_negative" href="#" onclick="window.close(); return false;">VOLTAR</a>
            </div>
            </form>
        </div>
        <div class="footer">
            <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Este projeto é totalmente open source. Visite o <strong>repositório</strong> no GitHub para acessar o código-fonte, relatar problemas ou contribuir com melhorias.</a>
        </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                            const textareas = document.getElementsByClassName('form__field');
                            for (let i = 0; i < textareas.length; i++) {
                                textareas[i].addEventListener('input', function() {
                                    this.style.height = '20px'; // Reset the height
                                    this.style.height = this.scrollHeight + 'px'; // Set to the current scroll height
                                });
                                // Disparar manualmente o evento 'input' para cada textarea
                                textareas[i].dispatchEvent(new Event('input'));
                            }
                        });
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('survey').addEventListener('submit', function(event) {
                    var confirmation = confirm('Tem certeza de que deseja enviar o formulário?');
                    if (!confirmation) {
                        event.preventDefault();
                    }
                });
            });
        </script>
    </body>
</html>

<?php
$conn->close();
?>
