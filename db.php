<?php
$servername = "127.0.0.1";
$port = "3333";
$username = "root";
$password = "secret";
$dbname = "CMSDB";

// Create connection without selecting a DB yet
$conn = new mysqli($servername, $username, $password, "", $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only select the DB if it is NOT the setup script running
// This prevents the "Unknown database" error
if (basename($_SERVER['PHP_SELF']) !== 'setup.php') {
    $conn->select_db($dbname);
}
