<?php include("../../include/include-crud-header.php") ?>
<?php require_once("../../../db.php") ?>

<?php
if (!isset($_GET["id"])) {
    die("ID is not set!");
}
?>

<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

<h1 class="text-center">Edit Article:</h1>
<!-- Create the editor container -->
<form class="mt-2" action="" method="post" onsubmit="return handleFormSubmit()">
    <label for="posttitle">Post Title:</label><br>
    <input id="posttitle" name="posttitle" required value=><br><br>
    <div id="editor" name="content" class="mt-2"></div>
    <input type="hidden" name="content" id="hidden-content">
    <input type="submit" class="btn btn-success mt-2" value="Submit">
</form>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    function handleFormSubmit() {
        var quillContent = quill.root.innerHTML;
        document.getElementById('hidden-content').value = quillContent;
        return true;
    }

    var baseUrl = "http://localhost:8888";
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    var getData = async function() {
        var url = baseUrl + `/articles/${id}`;

        await fetch(url)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                document.getElementById("posttitle").value = data.title;
                quill.root.innerHTML = data.content;
            });

        return false;
    };

    getData()
</script>

<?php
if (isset($_POST["content"]) && isset($_POST["posttitle"])) {

    extract($_POST);
    $content = sanitize_html($content);
    $title = sanitize_input($posttitle);
    $stmt = $conn->prepare("UPDATE articles SET title=?, content=? WHERE id=?");

    $stmt->bind_param("sss", $title, $content, $id);
    $stmt->execute();

    echo "Updated Successfully!\n";
    echo "Click <a href='/app/crud'>here</a> to return to the main page";
}
?>



<?php include("../../include/include-footer.php") ?>