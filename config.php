<?php
$host = "tvcpw8tpu4jvgnnq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$dbusername = "g3iwo7l2nhxhu3jj";
$dbpassword = "l2yt1z9ari3b7ivr";
$dbname = "e9hxtfiwq6fz1for";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
