<?php
session_start();
require_once("../../../db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ./index.php?message=Article+Deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: ./index.php");
    exit();
}

include("../include/include-footer.php"); ?>