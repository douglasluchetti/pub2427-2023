<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
} 

else{
    $_SESSION['instance_id'] = $_POST['instance_id'];
    header("Location: index_master.php");
}
?>
