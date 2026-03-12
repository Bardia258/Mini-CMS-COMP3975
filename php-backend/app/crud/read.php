<?php
session_start();
require_once("../../../db.php"); //

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php"); //
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT title, content, created_at FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $article = $stmt->get_result()->fetch_assoc();
    if (!$article) {
        die("Article not found.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <a href="index.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="display-4"><?php echo htmlspecialchars($article['title']); ?></h1>
                        <p class="text-muted small">Published on: <?php echo date('F j, Y, g:i a', strtotime($article['created_at'])); ?></p>
                        <hr>
                        <div class="article-content mt-4">
                            <?php echo $article['content']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../include/include-footer.php"); ?>
</body>

</html>