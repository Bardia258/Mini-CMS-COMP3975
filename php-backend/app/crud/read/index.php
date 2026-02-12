<?php include("../../include/include-crud-header.php") ?>
<?php require_once("../../../db.php") ?>

<?php
view_article($conn);
?>

<a class="btn btn-success" href="/app/crud">Return Home</a>


<?php include("../../include/include-footer.php") ?>