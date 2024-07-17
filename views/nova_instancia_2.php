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
    <meta name="description" content="Este é um projeto open source para avaliação de disciplinas. Contribua no GitHub.">
    <link rel="icon" href="images/logo.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="images/logo_dark.svg" media="(prefers-color-scheme: light)">
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
                <h3>Upload de arquivos:</h3>
                <h4 id="subtitle_index_admin_2">Importe listas de alunos e questionários na formatação adequada.</h4>
                <form id="upload-form" class="center" action="../controllers/import.php" method="POST" enctype="multipart/form-data">
                    <label for="file-upload" class="button_negative">
                        UPLOAD <img src="..\images\upload.svg" alt="Upload" class="button_image">
                    </label>
                    <input type="hidden" name="import">
                    <input name="file[]" id="file-upload" accept=".csv" type="file" multiple style="display: none;" onchange="this.form.submit()" required>
                </form>
                <h3>Questionário padrão:</h3>
                <h4 id="subtitle_index_admin_2">
                    Selecione o questionário padrão que será utilizado nas disciplinas. 
                    <br> 
                    Para selecionar um questionário personalizado em uma única disciplina, acesse abaixo as configurações da turma.
                </h4>
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
                <h3 class="list-tile">Questionários:</h3>
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
                        ?>
                        <div class='row_content'>
                            <li><?php echo "$file"?></li>
                            <div class="inline_buttons">
                                <form id="preview-form" class="center" action="visualizar_questionario.php" method="POST" enctype="multipart/form-data" target="_blank">
                                    <button class="button_negative"> VISUALIZAR </button>
                                    <input type='hidden' name='file' value='<?php echo "$file"?>'>
                                </form>
                                <form class='confirm' action='../controllers/excluir_arquivo.php' method='POST'>
                                    <input type='hidden' name='file' value='<?php echo "$file"?>'>
                                    <button class='image-button' type=submit>
                                        <img src='..\images\delete.svg' alt='Delete' class='close'>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>   
                <h3 class="list-tile">Turmas identificadas:</h3>
                <?php
                    $query = "SELECT * FROM `class-temp`";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows == 0){
                        echo "<h4>Nenhuma turma adicionada.</h4>";
                    }
                    while ($row = $result->fetch_assoc()) {
                        $row_text = $row['class_id'] . " - " . $row['subject_id'] . " - " . $row['subject_name'];
                        $class_id = $row['class_id'];
                        $subject_id = $row['subject_id'];
                        $file = $row['file'];
                        ?>
                        <div class='row_content'>
                            <li><?php echo $row_text?></li>
                            <div class="inline_buttons">
                                <form id="preview-form" class="center" action='nova_instancia_3.php' method="POST">
                                    <input type='hidden' name='class_id' value="<?php echo $class_id?>">
                                    <input type='hidden' name='subject_id' value="<?php echo $subject_id?>">
                                    <button class="button_negative"> CONFIGURAR </button>
                                </form>
                                <form class='confirm' action='../controllers/excluir_arquivo.php' method='POST'>
                                        <input type='hidden' name='file' value='<?php echo "$file"?>'>
                                        <button class='image-button' type=submit>
                                            <img src='..\images\delete.svg' alt='Delete' class='close'>
                                        </button>
                                </form>
                            </div>
                    </div>
                <?php
                    }
                ?>
                <div class="survey_buttons">
                    <a class="button_negative" href='index_master.php' id="survey_negative">VOLTAR</a>
                    <form>
                        <button type="submit" id="survey_positive" action="index_master.php" form="criar_instancia">ENVIAR</button>
                    <form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Este projeto é totalemtnte open source. Visite o <strong>repositório</strong> no GitHub para acessar o código-fonte, relatar problemas ou contribuir com melhorias.</a>
        </div>
    </div>
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Recuperar os valores salvos e preencher os campos
    if (localStorage.getItem('instance_id')) {
        document.getElementById('subject_name').value = localStorage.getItem('instance_id');
    }
    if (localStorage.getItem('instance_date_beginning')) {
        document.getElementById('instance_date_beginning').value = localStorage.getItem('instance_date_beginning');
    }
    if (localStorage.getItem('instance_date_end')) {
        document.getElementById('instance_date_end').value = localStorage.getItem('instance_date_end');
    }

    // Salvar os valores no LocalStorage quando o usuário alterar os inputs
    document.getElementById('subject_name').addEventListener('input', function() {
        localStorage.setItem('instance_id', this.value);
    });
    document.getElementById('instance_date_beginning').addEventListener('input', function() {
        localStorage.setItem('instance_date_beginning', this.value);
    });
    document.getElementById('instance_date_end').addEventListener('input', function() {
        localStorage.setItem('instance_date_end', this.value);
    });
});

    document.addEventListener('DOMContentLoaded', function() {
    const selectInstance = document.getElementById('instance');
    const previewButton = document.getElementById('preview-button');
    const selectedInstanceInput = document.getElementById('selected_instance');

    function updatePreviewButtonState() {
        if (!selectedInstanceInput.value) {
            previewButton.disabled = true;
            previewButton.classList.add('button_disabled');
        } else {
            previewButton.disabled = false;
            previewButton.classList.remove('button_disabled');
        }
    }

    // Adiciona o evento 'change' ao selectInstance para atualizar o estado do botão
    selectInstance.addEventListener('change', function() {
        selectedInstanceInput.value = this.value;
        updatePreviewButtonState();
    });

    // Chama updatePreviewButtonState() para definir o estado inicial do botão
    updatePreviewButtonState();
});

    document.getElementById('instance').addEventListener('change', function() {
    document.getElementById('selected_instance').value = this.value;
    });

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
