<?php

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sanitize_html($data)
{
    $data = trim($data);
    $data = strip_tags($data, "<p><h1><h2><h3><strong><ol><span><ll><ul><a><em><u>");
    return $data;
}

function view_article($conn)
{
    if (!isset($_GET["id"])) {
        die("ID is not set!");
    }

    $id = sanitize_input($_GET['id']);
    $stmt = $conn->prepare("SELECT title, content, created_at FROM articles WHERE id=?;");

    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if (!isset($result['title'])) {
        echo "<p>No result found. Click <a href='/app/crud'>here</a> to return to home.</p>";
        die();
    }

    echo "<p><strong>ID:</strong> $id</p>\n";
    echo "<p><strong>Title:</strong> {$result['title']}</p>\n";
    echo "<p><strong>Content:</strong> {$result['content']}</p>\n";
    echo "<p><strong>Created At:</strong> {$result['created_at']}</p>\n";
}
