<?php
$host = "sql10.freemysqlhosting.net";
$dbusername = "sql10692813";
$dbpassword = "njv3pTV5Rc";
$dbname = "sql10692813";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
