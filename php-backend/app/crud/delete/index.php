<?php include("../../include/include-crud-header.php") ?>
<?php require_once("../../../db.php") ?>

<?php
if (!isset($_GET['id'])) {
    die("ID is not set!");
}
if (isset($_POST['delete'])) {
    $id = sanitize_input($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM articles WHERE id=?;");

    $stmt->bind_param("s", $id);
    $stmt->execute();

    header("Location: /app/crud");
    die();
}
?>
<p><strong>ID: </strong><span id="id"></span></p>
<p><strong>Title: </strong><span id="title"></span></p>
<p><strong>Content: </strong><span id="content"></span></p>
<p><strong>Created At: </strong><span id="created-at"></span></p>

<script>
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
                document.getElementById("id").innerHTML = data.id;
                document.getElementById("title").innerHTML = data.title;
                document.getElementById("content").innerHTML = data.content;
                document.getElementById("created-at").innerHTML = data.created_at;
            });

        return false;
    };

    getData()
</script>

<form action="" method="post">
    <input type="submit" class="btn btn-danger" value="Delete Article" name="delete">
</form>


<?php include("../../include/include-footer.php") ?>