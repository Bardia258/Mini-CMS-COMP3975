<?php include("../../include/include-crud-header.php") ?>
<?php require_once("../../../db.php") ?>

<?php
if (isset($_POST['delete'])) {
    $id = sanitize_input($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM articles WHERE id=?;");

    $stmt->bind_param("s", $id);
    $stmt->execute();

    header("Location: /app/crud");
    die();
}
?>

<?php
view_article($conn);
?>

<form action="" method="post">
    <input type="submit" class="btn btn-danger" value="Delete Article" name="delete">
</form>


<?php include("../../include/include-footer.php") ?>