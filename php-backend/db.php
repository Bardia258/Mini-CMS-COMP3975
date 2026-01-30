<?php
$servername = "127.0.0.1";
$port = "3333";
$username = "root";
$password = "secret";
$dbname = "CMSDB";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>