<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
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

$user_id = $_SESSION['username'];
$class_id = $_SESSION['class_id'];
$subject_id = $_SESSION['subject_id'];
$questionnaire_id = $_SESSION['questionnaire_id'];
$instance_id = $_SESSION['instance_id'];

$query_questions = "SELECT * FROM questionnaire_question_relation WHERE questionnaire_id = ?";
$stmt_questions = $conn->prepare($query_questions);
$stmt_questions->bind_param("s", $questionnaire_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

while ($row = $result_questions->fetch_assoc()) {
    $question_id = $row['question_id'];
    if (isset($_POST[$question_id])) {
        $content = $_POST[$question_id];
        if (is_string($content)) {
            $stmt = $conn->prepare("INSERT INTO `answer` (`instance_id`, `user_id`, `question_id`, 
                `class_id`, `subject_id`, `content`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $instance_id, $user_id, $question_id, $class_id, $subject_id, $content);
            $stmt->execute();
        }
        else{
            foreach ($content as $option) {
                $stmt = $conn->prepare("INSERT INTO `answer` (`instance_id`, `user_id`, `question_id`, 
                    `class_id`, `subject_id`, `content`) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $instance_id, $user_id, $question_id, $class_id, $subject_id, $option);
                $stmt->execute();
            }
        }
    };
}

header("Location: ..\index\index_aluno.php");

?>