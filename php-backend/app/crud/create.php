<?php
session_start();
require_once("../../../db.php"); //

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php"); //
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raw_title = trim($_POST['posttitle']);
    $raw_content = trim($_POST['content']);

    // Fixes -2 Validation
    if (empty($raw_title) || empty($raw_content) || $raw_content === "<p><br></p>") {
        $error = "Title and Content cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $raw_title, $raw_content);
        if ($stmt->execute()) {
            header("Location: ./index.php"); //
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
    <title>Create Article</title>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Create New Article</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" onsubmit="return syncQuill()">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Article Title</label>
                                <input type="text" name="posttitle" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Body Content</label>
                                <div id="editor" style="height: 300px;"></div>
                                <input type="hidden" name="content" id="hidden-content">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success px-4">Publish Article</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        function syncQuill() {
            var content = document.getElementById('hidden-content');
            content.value = quill.root.innerHTML;
            return true;
        }
    </script>

    <?php include("../include/include-footer.php"); ?>
</body>

</html>