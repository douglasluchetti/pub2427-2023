<?php
$host = "vhw3t8e71xdz9k14.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$dbusername = "eoiojon5sw94hlyz";
$dbpassword = "v3ed9noaeshmczlr";
$dbname = "u9mjwm4wg66017rf";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
