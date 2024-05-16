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
                <form id="criar_instancia" action="../controllers/criar_instancia.php" method="POST">
                    <h3>Insira um nome para a nova instância de avaliação (exemplo: 20241):</h3>
                    <input class="login" type="text" id="subject_name" name="instance_id" placeholder="Nome da Instância" required>
                    <h3>Insira as datas e horários de início e encerramento da instância:</h3>
                    <div class="survey_buttons">
                        <input class="login" type="datetime-local" id="instance_date_beginning" name="instance_date_beginning" required>
                        <h4>até</h4>
                        <input class="login" type="datetime-local" id="instance_date_end" name="instance_date_end" required>
                    </div>
                </form>
                <h3>Questionário:</h3>
                <h4 id="subtitle_index_admin_2">Selecione o questionário comum que será utilizado nas disciplinas. Para questionários específicos - por exemplo, utilizados em turmas de laboratório ou de trabalho de formatura - altere o questionário diretamente nas configurações da turma.</h4>
                <div class="center">
                    <form class="select" id="select_instance" method="POST">
                        <select class="select_instance" name="questionnaire_name" id="instance" required form="criar_instancia">
                        <option disabled selected value> -- Selecione um questionário -- </option>
                        <?php
                            $query = "SELECT * FROM `questionnaire-temp`";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $row_text = $row['questionnaire_name'];
                                echo "<option>$row_text</option>";
                            }
                        ?>
                        </select>
                    </form>
                </div>   
                <h3>Turmas identificadas:</h3>
                <?php
                    $query = "SELECT * FROM `class-temp`";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $row_text = $row['class_id'] . " - " . $row['subject_id'] . " - " . $row['subject_name'];
                        $class_id = $row['class_id'];
                        $subject_id = $row['subject_id'];
                        echo "<form class='inline_content' method='POST' action='nova_instancia_3.php'>";
                        echo "   <li>$row_text</li>";
                        echo "   <input type='hidden' name='class_id' value=$class_id>";
                        echo "   <input type='hidden' name='subject_id' value=$subject_id>";
                        echo "   <button class='image-button' type=submit';>";
                        echo "   <img src='..\images\config.svg' alt='Config' class='close'>";
                        echo "   </button>";
                        echo "</form>";
                    }
                ?>
                <div class="survey_buttons">
                    <a class="button_negative" href='nova_instancia_1.php' id="survey_negative">VOLTAR</a>
                    <form>
                        <button type="submit" id="survey_positive" action="index_master.php" form="criar_instancia">ENVIAR</button>
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
    document.getElementById('criar_instancia').addEventListener('submit', function(event) {
        var today = new Date();
        var todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0') + 'T' + String(today.getHours()).padStart(2, '0') + ':' + String(today.getMinutes()).padStart(2, '0');
        var beginningDateStr = document.getElementById("instance_date_beginning").value;
        var endDateStr = document.getElementById("instance_date_end").value;

        console.log('Today:', todayStr);
        console.log('Beginning:', beginningDateStr);
        console.log('End:', endDateStr);

        if (beginningDateStr < todayStr || endDateStr < todayStr) {
            console.log('A data deve ser maior que a data atual.');
            alert('A data deve ser maior que a data atual.');
            event.preventDefault();
            return;
        }

        if (endDateStr <= beginningDateStr) {
            console.log('A data de término deve ser maior que a data de início.');
            alert('A data de término deve ser maior que a data de início.');
            event.preventDefault();
            return;
        }

        var confirmation = confirm('Tem certeza de que deseja criar a nova intância de avaliação? Uma vez feita, a instância não poderá ser alterada.');
        if (!confirmation) {
            event.preventDefault();
        }
    });

    var today = new Date();
    var todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
    document.getElementById("instance_date_beginning").setAttribute('min', todayStr);
    document.getElementById("instance_date_end").setAttribute('min', todayStr);
});
</script>
<?php
$conn->close();
?>
