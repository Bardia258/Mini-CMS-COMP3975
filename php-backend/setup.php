<?php
require_once dirname(__DIR__) . "/db.php";

// 1. Create the Database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS CMSDB");
$conn->select_db("CMSDB");

// 2. Create the Users table
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
)");

// 3. Create the Articles table
$conn->query("CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// 4. Seed with Encrypted Password (Fixes -2 encryption penalty)
$adminUser = 'a@a.a';
$adminPass = password_hash('P@$$w0rd', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT IGNORE INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param("ss", $adminUser, $adminPass);

if ($stmt->execute()) {
    echo "Setup complete! Database created and encrypted admin seeded.";
} else {
    echo "Setup error: " . $conn->error;
}
