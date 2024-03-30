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

$class_id = $_POST['class_id'];
$subject_id = $_POST['subject_id'];

if (!isset($class_id)){
    $class_id = $_SESSION['class_id'];
    $subject_id = $_SESSION['subject_id'];
}

$query_class_info = "SELECT * FROM `class-temp` WHERE class_id = ? AND subject_id = ?";
$stmt_class_info = $conn->prepare($query_class_info);
$stmt_class_info->bind_param("ss", $class_id, $subject_id);
$stmt_class_info->execute();
$result_class_info = $stmt_class_info->get_result();
$class_row = $result_class_info->fetch_assoc();
$subject_name = $class_row['subject_name'];
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
                <h3>Insira turma, código da disciplina e nome da disciplina:</h3>
                <form class="inline_content" id="editar_classe" action="..\controllers\editar_classe.php" method="POST">
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    <input class="login" type="text" id="code" placeholder="Turma" name="class_id_new" value="<?php echo $class_id;?>" required>
                    <input class="login" type="text" id="code" placeholder="Disciplina" name="subject_id_new" value="<?php echo $subject_id;?>" required>
                    <input class="login" type="text" id="subject_name" placeholder="Nome da Disciplina" name="subject_name" value="<?php echo $subject_name;?>" required>
                </form>
                <h3>Questionário:</h3>
                <div class="center">
                    <form class="select" id="select_instance" method="POST">
                        <select class="select_instance" name="questionnaire_name" id="instance" required form="editar_classe">
                        
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM `instance_questionnaire_class_relation-temp`
                                WHERE `class_id` = ? AND `subject_id` = ?");
                                $stmt->bind_param("ss", $class_id, $subject_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $questionnaire_id = $row['questionnaire_id'];
                                if(empty($questionnaire_id)){
                                    echo "<option disabled selected value> -- Selecione um questionário -- </option>";
                                    $query = "SELECT * FROM `questionnaire-temp`";
                                    $stmt = $conn->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $row_text = $row['questionnaire_name'];
                                        echo "<option>$row_text</option>";
                                    }
                                }
                                else{
                                    $query = "SELECT * FROM `questionnaire-temp` WHERE `questionnaire_id` = ?";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("s", $questionnaire_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $questionnaire_name = $row['questionnaire_name'];
                                    echo "<option>$questionnaire_name</option>";
                                    $query = "SELECT * FROM `questionnaire-temp`";
                                    $stmt = $conn->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $row_text = $row['questionnaire_name'];
                                        if($row_text != $questionnaire_name){
                                            echo "<option>$row_text</option>";
                                        }
                                    }
                                }
                                
                            ?>
                        </select>
                    </form>
                </div>    
                <h3>E-mail dos participantes:</h3>
                <div class="center">
                    <div class="textarea-container">
                    <textarea class="alunos" readonly><?php
                        $stmt = $conn->prepare("SELECT * FROM `user_class_relation-temp` WHERE class_id = ? AND subject_id = ?");
                        $stmt->bind_param("ss", $class_id, $subject_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = [];
                        while ($row = $result->fetch_assoc()) {
                            $user_id = $row['user_id'];
                            $query_user_info = "SELECT * FROM `user-temp` WHERE user_id = ?";
                            $stmt_user_info = $conn->prepare($query_user_info);
                            $stmt_user_info->bind_param("s", $user_id);
                            $stmt_user_info->execute();
                            $result_user_info = $stmt_user_info->get_result();
                            $row = $result_user_info->fetch_assoc();
                            $email = $row['email'];
                            $rows[] = $email;
                        }
                        $text = implode("\n", $rows);
                        echo trim($text);
                        ?>
                    </textarea>
                    </div>
                </div>
                <div class="survey_buttons">
                    <a class="button_negative" href='nova_instancia_2.php' id="survey_negative">VOLTAR</a>
                    <button type="submit" id="survey_positive" form="editar_classe">PROSSEGUIR</button>
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
