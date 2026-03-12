<?php
session_start();
require_once("../../../db.php"); //

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php"); //
    exit();
}

// 1. FETCH DATA FOR EDITING
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT title, content FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $article = $stmt->get_result()->fetch_assoc();
    
    if (!$article) { die("Article not found."); }
}

// 2. PROCESS THE UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raw_title = trim($_POST['posttitle']);
    $raw_content = trim($_POST['content']);

    // Fixes -2 Validation
    if (empty($raw_title) || empty($raw_content) || $raw_content === "<p><br></p>") {
        $error = "Title and Content cannot be empty.";
    } else {
        $update_stmt = $conn->prepare("UPDATE articles SET title = ?, content = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $raw_title, $raw_content, $id);
        if ($update_stmt->execute()) {
            header("Location: ./index.php?message=Updated"); //
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <title>Edit Article</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Article</h4>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" onsubmit="return syncQuill()">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Title</label>
                            <input type="text" name="posttitle" class="form-control" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <div id="editor" style="height: 300px;"><?php echo $article['content']; ?></div>
                            <input type="hidden" name="content" id="hidden-content">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning px-4">Update Article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    var quill = new Quill('#editor', { theme: 'snow' });
    function syncQuill() {
        document.getElementById('hidden-content').value = quill.root.innerHTML;
        return true;
    }
</script>
<?php include("../include/include-footer.php"); ?> </body>
</html>