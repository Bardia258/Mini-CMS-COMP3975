<?php include("../../include/include-crud-header.php") ?>
<?php require_once("../../../db.php") ?>
<?php #include("../../include/include-quill.php") 
?>

<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

<!-- Create the editor container -->
<form class="mt-2" action="" method="post" onsubmit="return handleFormSubmit()">
    <label for="posttitle">Post Title:</label><br>
    <input id="posttitle" name="posttitle" required><br><br>
    <div id="editor" name="content" class="mt-2"></div>
    <input type="hidden" name="content" id="hidden-content">
    <input type="submit" class="btn btn-success mt-2" value="Submit">
</form>

<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    function handleFormSubmit() {
        var quillContent = quill.root.innerHTML;

        document.getElementById('hidden-content').value = quillContent;

        return true;
    }
</script>

<?php

if (isset($_POST["content"]) && isset($_POST["posttitle"])) {

    extract($_POST);
    $content = sanitize_input($content);
    $title = sanitize_input($posttitle);
    $stmt = $conn->prepare("INSERT INTO articles (title, content)
                                        VALUES (?, ?);");

    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    echo "Inserted Successfully!\n";
    echo "Click <a href='/app/crud'>here</a> to return to the main page";
}
?>

<?php include("../../include/include-footer.php") ?>