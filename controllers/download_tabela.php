<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create a new zip object
    $zip = new ZipArchive();
    $filename = "./instancia_{$_POST['instance_id']}.zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    // Get unique subject_ids
    $stmt = $conn->prepare("SELECT DISTINCT subject_id FROM `answer` WHERE `instance_id` = ?");
    $stmt->bind_param("s", $_POST['instance_id']);
    $stmt->execute();

    $result = $stmt->get_result(); // Get mysqli_result object

    while ($subject = $result->fetch_assoc()) { // Use fetch_assoc on mysqli_result object
        $subject_id = $subject['subject_id'];

        // Prepare the statement for each subject_id
        $stmt = $conn->prepare("
            SELECT answer.*, question.title 
            FROM `answer` 
            INNER JOIN `question` ON answer.question_id = question.question_id 
            WHERE `instance_id` = ? AND `subject_id` = ?
        ");
        $stmt->bind_param("ss", $_POST['instance_id'], $subject_id);
        $stmt->execute();

        $result_subject = $stmt->get_result(); // Get mysqli_result object

        // Create CSV content for each subject
        $csv_content = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csv_content .= implode(";", ['instance_id', 'subject_id', 'class_id',  'question_id', 'enunciado', 'resposta']) . "\n";

        while ($row = $result_subject->fetch_assoc()) { // Use fetch_assoc on mysqli_result object
            $csv_content .= implode(";", [$row['instance_id'], $row['subject_id'], $row['class_id'], $row['question_id'], $row['title'], $row['content']]) . "\n";
        }

        // Add CSV content to zip
        $zip->addFromString("instancia_{$_POST['instance_id']}_subject_{$subject_id}.csv", $csv_content);
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