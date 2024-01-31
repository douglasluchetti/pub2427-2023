<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

include('config.php');

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
$course_info = "$course - $username";

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
            <?php
            while ($row = $result_user_rows->fetch_assoc()) {
                $class_id = $row['class_id'];
                $subject_id = $row['subject_id'];

                $query_instance = "SELECT * FROM instance_questionnaire_class_relation WHERE class_id = ? AND subject_id = ?";
                $stmt_instance = $conn->prepare($query_instance);
                $stmt_instance->bind_param("ss", $class_id, $subject_id);
                $stmt_instance->execute();
                $result_instance = $stmt_instance->get_result();
                $instance_row = $result_instance->fetch_assoc();
                $instance_id = $instance_row['instance_id'];
                $questionnaire_id = $instance_row['questionnaire_id'];

                $query_instance2 = "SELECT * FROM instance WHERE instance_id = ?";
                $stmt_instance2 = $conn->prepare($query_instance2);
                $stmt_instance2->bind_param("s", $instance_id);
                $stmt_instance2->execute();
                $result_instance = $stmt_instance2->get_result();
                $instance_row2 = $result_instance->fetch_assoc();

                if ($instance_row2['status'] == 0) {
                    if ($instance_off == FALSE) {
                    echo "<h3>Não há disciplinas a serem avaliadas / período de avaliação encerrado.</h3>";
                    };
                    $instance_off = True;
                } else {
                    $query_class_info = "SELECT * FROM class WHERE class_id = ? AND subject_id = ?";
                    $stmt_class_info = $conn->prepare($query_class_info);
                    $stmt_class_info->bind_param("ss", $class_id, $subject_id);
                    $stmt_class_info->execute();
                    $result_class_info = $stmt_class_info->get_result();
                    $class_row = $result_class_info->fetch_assoc();
                    $subject_name = $class_row['subject_name'];
                    $subject_message = "$subject_id - $subject_name";
                    $teacher_name = $class_row['teacher_name'];
                    ?>
                    <form class="subject" method="POST" action="../questionario/redireciona_questionario.php">
                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                        <input type="hidden" name="instance_id" value="<?php echo $instance_id; ?>">
                        <input type="hidden" name="questionnaire_id" value="<?php echo $questionnaire_id; ?>">
                        <div class="subject_info">
                            <h3><?php echo $subject_message; ?></h3>
                            <h4><?php echo $teacher_name; ?></h4>
                        </div>
                        <?php
                            $query = "SELECT * FROM answer WHERE instance_id = ? AND user_id = ? AND class_id = ? AND subject_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("ssss", $instance_id, $username, $class_id, $subject_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $class_row = $result->fetch_assoc();
                            if ($result->num_rows == 0) {
                                echo "<button type='submit'>AVALIAR</button>";
                            }
                            else{
                                echo "<a class='button_negative'>AVALIAÇÃO CONCLUÍDA</a>";
                            }
                        ?>
                    </form>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer">Desenvolvedores</a>
            <a href="https://teste.123" class="footer">Termos de Uso</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
