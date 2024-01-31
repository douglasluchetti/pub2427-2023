<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
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
$class_id = $_SESSION['class_id'];
$subject_id = $_SESSION['subject_id'];
$questionnaire_id = $_SESSION['questionnaire_id'];

$query_user_info = "SELECT * FROM user WHERE user_id = ?";
$stmt_user_info = $conn->prepare($query_user_info);
$stmt_user_info->bind_param("s", $username);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();
$row = $result_user_info->fetch_assoc();
$name = $row['name'];
$course = $row['course'];
$welcome_message = "Olá, $name";
$course_info = "$course - $username";

$query_class_info = "SELECT * FROM class WHERE class_id = ? AND subject_id = ?";
$stmt_class_info = $conn->prepare($query_class_info);
$stmt_class_info->bind_param("ss", $class_id, $subject_id);
$stmt_class_info->execute();
$result_class_info = $stmt_class_info->get_result();
$class_row = $result_class_info->fetch_assoc();
$subject_name = $class_row['subject_name'];
$subject_message = "$subject_id - $subject_name";
$teacher_name = $class_row['teacher_name'];

$query_questions = "SELECT * FROM questionnaire_question_relation WHERE questionnaire_id = ?";
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
            <form class="block" id="survey" action="envia_questionario.php" method="POST">
                <div class="survey_title">  
                    <h2><?php echo $subject_message; ?></h2>
                    <h3 class="survey"><?php echo $teacher_name; ?></h3>
                </div>
                <?php
            while ($row = $result_questions->fetch_assoc()) {
                $question_id = $row['question_id'];

                $query_question = "SELECT * FROM question WHERE question_id = ?";
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
                        $query_questions = "SELECT * FROM question_alternative_relation WHERE question_id = ?";
                        $stmt_alternative = $conn->prepare($query_questions);
                        $stmt_alternative->bind_param("s", $question_id);
                        $stmt_alternative->execute();
                        $result_alternative = $stmt_alternative->get_result();

                        while ($row = $result_alternative->fetch_assoc()) {
                            $alternative_id = $row['alternative_id'];
                            $query_alternative = "SELECT * FROM alternative WHERE alternative_id = ?";
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
                        $query_questions = "SELECT * FROM question_alternative_relation WHERE question_id = ?";
                        $stmt_alternative = $conn->prepare($query_questions);
                        $stmt_alternative->bind_param("s", $question_id);
                        $stmt_alternative->execute();
                        $result_alternative = $stmt_alternative->get_result();

                        while ($row = $result_alternative->fetch_assoc()) {
                            $alternative_id = $row['alternative_id'];
                            $query_alternative = "SELECT * FROM alternative WHERE alternative_id = ?";
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
                        <script>
                        const textarea = document.getElementById('message');
                        textarea.addEventListener('input', function () {
                        this.style.height = '20px';
                        this.style.height = (this.scrollHeight) + 'px';
                        });
                        </script>
                    </div>
                <?php
                }
                $num_questions = $num_questions + 1; 
                }
                ?>
                <div class="survey_buttons">
                    <a class="button_negative" href="..\index\index_aluno.php" id="survey_negative">VOLTAR</a>
                    <button type="submit" id="survey_positive">ENVIAR</button>
                </div>
            </form>
        </div>
        <div class="footer">
            <div class="footer_content">
                <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer">Desenvolvedores</a>
                <a href="https://teste.123" class="footer">Termos de Uso</a>
            </div>
        </div>
        <script>
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
