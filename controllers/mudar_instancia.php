<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\views\login.php");
    exit();
} 

else{
    $_SESSION['instance_id'] = $_POST['instance_id'];
    header("Location: ../views/index_master.php");
}
?>
