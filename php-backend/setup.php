<?php
$servername = "127.0.0.1";
$port = "3333";
$username = "root";
$password = "secret";
$dbname = "CMSDB";

$conn = new mysqli($servername, $username, $password, "", $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// User table for authentication
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
)";

if (!$conn->query($sql_users)) {
    die("Error creating users table: " . $conn->error);
}

// Articles table for Rich Text & Timestamp
$sql_articles = "CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql_articles)) {
    die("Error creating articles table: " . $conn->error);
}

// seed a test user
$adminUser = 'a@a.a';
$adminPass = 'P@$$w0rd'; 
$adminRole = 'admin';

$check = $conn->query("SELECT id FROM users WHERE username = '$adminUser'");
if ($check && $check->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $adminUser, $adminPass, $adminRole);
    $stmt->execute();
    echo "Mandatory admin account ($adminUser) seeded successfully!<br>";
}

echo "Setup Complete: CMSDB created and Admin seeded.";
$conn->close();
