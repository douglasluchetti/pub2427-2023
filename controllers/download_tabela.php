<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include('../config.php');
$has_answers = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create a new zip object
    $zip = new ZipArchive();
    $filename = "./instancia_{$_POST['instance_id']}.zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    // Get unique subject_ids
    $stmt = $conn->prepare("SELECT DISTINCT subject_id, class_id FROM `answer` WHERE `instance_id` = ?");
    $stmt->bind_param("s", $_POST['instance_id']);
    $stmt->execute();

    $result = $stmt->get_result(); // Get mysqli_result object

    while ($subject = $result->fetch_assoc()) { // Use fetch_assoc on mysqli_result object
        $subject_id = $subject['subject_id'];
        $class_id = $subject['class_id'];
        $resposta_id = 0;

        // Prepare the statement for each subject_id
        $stmt = $conn->prepare("
            SELECT answer.*, question.title 
            FROM `answer` 
            INNER JOIN `question` ON answer.question_id = question.question_id 
            WHERE `instance_id` = ? AND `subject_id` = ? AND `class_id` = ?
        ");
        $stmt->bind_param("sss", $_POST['instance_id'], $subject_id, $class_id);
        $stmt->execute();

        $result_subject = $stmt->get_result(); // Get mysqli_result object
        if ($result_subject->num_rows != 0) {
            $has_answers = TRUE;
        }

        $unique_titles = ['Resposta']; // Primeira coluna para user_id
        $answersByUser = [];

        // Recoleta os dados para organizar as respostas por usuário
        $stmt->execute();
        $result_subject = $stmt->get_result();

        while ($row = $result_subject->fetch_assoc()) {
            $answersByUser[$row['user_id']][$row['title']] = $row['content'];
            if (!in_array($row['title'], $unique_titles)) {
                $unique_titles[] = $row['title'];
            }
        }

        // Create CSV content for each subject
        $csv_content = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csv_content .= implode(";", ['Instância', $_POST['instance_id']]) . "\n";
        $csv_content .= implode(";", ['Disciplina', $subject_id]) . "\n";
        $csv_content .= implode(";", ['Turma', $class_id]) . "\n";
        $csv_content .= "\n";
        $csv_content .= implode(";", $unique_titles) . "\n";
        // Escreve as respostas organizadas no CSV
        $user_count = 1;
        foreach ($answersByUser as $user_id => $answers) {
            $row = [$user_count]; // Inicia a linha com o user_id
            foreach ($unique_titles as $title) {
                if ($title != 'Resposta') { // Pula a primeira coluna 'user'
                    $row[] = isset($answers[$title]) ? $answers[$title] : "";
                }
            }
            $csv_content .= implode(";", $row) . "\n";
            $user_count++;
        }

        // Add CSV content to zip
        $zip->addFromString("instancia-{$_POST['instance_id']}_disciplina-{$subject_id}_turma-{$class_id}.csv", $csv_content);
    }

    if ($has_answers == FALSE) {
        // Não há respostas, redireciona com uma mensagem de alerta
        echo "<script>
        alert('Não há nenhuma resposta disponível para download nesta instância.');
        window.close(); // Tenta fechar a guia
        </script>";
        exit; // Encerra a execução do script
    }

    // Close the zip file
    $zip->close();

    // Set headers and send the file
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$filename);
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

    // Delete the zip file from the server
    unlink($filename);
}
?>