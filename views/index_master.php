<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
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

$query_instance = "SELECT * FROM instance";
$stmt_instance = $conn->prepare($query_instance);
$stmt_instance->execute();
$result_instance = $stmt_instance->get_result();

if ($result_instance->num_rows > 0 && empty($_SESSION['instance_id'])) {
    $row = $result_instance->fetch_assoc();
    $_SESSION['instance_id'] = $row['instance_id'];
}

$query_instance = "SELECT * FROM instance";
$stmt_instance = $conn->prepare($query_instance);
$stmt_instance->execute();
$result_instance = $stmt_instance->get_result();

$instance_off = FALSE;

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
            <form class="logout" action="..\controllers\logout.php" method="POST">
                <input type="submit" id="logout" style="display: none;">   
                <label for="logout" class="button_negative" id="logout">
                    Sair <img src="..\images\logout.svg" alt="logout" class="button_image">
                </label>
            </form>
        </div>
        <div class="block" id="index">
             <div class="survey_buttons">  
                <h2>Gerenciar Instâncias de Avaliação</h2>
                <a class="button_negative" href="nova_instancia_2.php">NOVA INSTÂNCIA DE AVALIAÇÃO</a>
            </div>
            <div class="master">
                <h3>Selecione a instância que deseja gerenciar:</h3>
                <?php
                 if ($result_instance->num_rows > 0) {
                    ?>
                <div class="center">
                    <form class="select" id="select_instance" action="../controllers/mudar_instancia.php" method="POST">
                    <select class="select_instance" name="instance_id" id="instance" onchange="this.form.submit()">
                        <?php
                            if (!empty($_SESSION['instance_id'])) {
                                    ?>
                                       <option value="<?php echo $_SESSION['instance_id']; ?>"><?php echo $_SESSION['instance_id']; ?></option>   
                                    <?php
                                }
                            while ($row = $result_instance->fetch_assoc()) {
                                if ($_SESSION['instance_id'] != $row['instance_id']) {
                                    ?>
                                    <option value="<?php echo $row['instance_id']; ?>"><?php echo $row['instance_id']; ?></option>
                                    <?php
                                };
                            }
                            ?>
                        </select>
                    </form>
                </div>
                <div class="inline_content">
                    <h3>Status da instância:</h3>
                    <?php
                        $instance_id = $_SESSION['instance_id'];
                        $query_user_info = "SELECT * FROM instance WHERE instance_id = ?";
                        $stmt_user_info = $conn->prepare($query_user_info);
                        $stmt_user_info->bind_param("s", $instance_id);
                        $stmt_user_info->execute();
                        $result_user_info = $stmt_user_info->get_result();
                        $row = $result_user_info->fetch_assoc();
                        $instance_status = $row['status'];
                        $instance_date_beginning = $row['instance_date_beginning'];
                        $instance_date_end = $row['instance_date_end'];

                            if ($instance_status == 0) {
                                ?>
                                <h3 class="instance_status" id="waiting">Aguardando abertura. Questionários fechados.</h3>
                                    </div>
                                <div class="inline_content">
                                    <h3>Programação:</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_beginning, 0, -3))); ?></h3>
                                    <h3>até</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_end, 0, -3))); ?></h3>
                                </div>
                                    <!-- <h3>Atulização de bases:</h3>
                                    <div class="inline_content">
                                        <li>Emails_docentes.xlsx</li>
                                        <a class="logout" href="">
                                            <img src="..\images\upload.svg" alt="Upload" class="close">
                                        </a>
                                    </div> -->
                                    <form class="center" action="..\controllers\iniciar_instancia.php" method="POST">
                                        <input type="hidden" name="instance_id" value="<?php echo $instance_id; ?>">
                                        <button type="submit">INICIAR INSTÂNCIA DE AVALIAÇÃO</button>
                                    </form>
                                <?php
                            } elseif ($instance_status == 1) {
                                ?>
                                <h3 class="instance_status" id="open">Iniciada. Questionários abertos.</h3>
                                    </div>
                                <div class="inline_content">
                                    <h3>Programação:</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_beginning, 0, -3))); ?></h3>
                                    <h3>até</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_end, 0, -3))); ?></h3>
                                </div>
                                    <form class="inline_content" method='POST' action='volume_respostas.php'>
                                        <li>Acompanhar volume de respostas</li>
                                        <input type='hidden' name='instance_id' value="<?php echo $instance_id; ?>">
                                        <button class='image-button' type='submit'>
                                                <img src='..\images\edit.svg' alt='edit' class='close'>
                                        </button>
                                    </form>   
                                    <!-- <h3>Atulização de bases:</h3>
                                    <div class="inline_content">
                                        <li>Emails_docentes.xlsx</li>
                                        <a class="logout" href="">
                                            <img src="..\images\upload.svg" alt="Upload" class="close">
                                        </a>
                                    </div> -->
                                    <form class="center" action="..\controllers\encerrar_instancia.php" method="POST">
                                        <input type="hidden" name="instance_id" value="<?php echo $instance_id; ?>">
                                        <button type="submit">ENCERRAR INSTÂNCIA DE AVALIAÇÃO</button>
                                    </form>
                                <?php
                            } elseif ($instance_status == 2) {
                                ?>
                                <h3 class="instance_status" id="closed">Encerrada. Questionários fechados.</h3>
                                    </div>
                                <div class="inline_content">
                                    <h3>Programação:</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_beginning, 0, -3))); ?></h3>
                                    <h3>até</h3>
                                    <h3 class="instance_status" id="waiting"><?php echo date('d/m/Y H:i', strtotime(substr($instance_date_end, 0, -3))); ?></h3>
                                </div>
                                    <!-- <div class="inline_content">
                                        <li>Enviar relatórios para os e-mails de docentes cadastrados</li>
                                        <a class="logout" href="">
                                            <img src="..\images\email.svg" alt="email" class="close">
                                        </a>
                                    </div>    -->
                                    <form class="inline_content" method='POST' action='../controllers/download_tabela.php' target="_blank">
                                        <li>Fazer download de todas as respostas da instância</li>
                                        <input type='hidden' name='instance_id' value="<?php echo $instance_id; ?>">
                                        <button class='image-button' type='submit'>
                                                <img src='..\images\download.svg' alt='download' class='close'>
                                        </button>
                                    </form>
                                    <form class="inline_content" method='POST' action='plano_de_acao.php'>
                                        <li>Editar um plano de ação para a instância:</li>
                                        <input type='hidden' name='instance_id' value="<?php echo $instance_id; ?>">
                                        <button class='image-button' type='submit'>
                                                <img src='..\images\edit.svg' alt='edit' class='close'>
                                        </button>
                                    </form>   
                                <?php

                            } 
                        } else {
                            echo "<h3>Nenhuma instância de avaliação encontrada.</h3>";
                        }
                       ?>
                </div> 
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Este projeto é totalmente open source. Visite o <strong>repositório</strong> no GitHub para acessar o código-fonte, relatar problemas ou contribuir com melhorias.</a>
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
