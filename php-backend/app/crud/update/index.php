<?php include("../../include/include-crud-header.php")?>
<?php require_once("../../../db.php")?>
<?php include("../../include/include-quill.php") ?>

<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);
//TODO: Update quill container with values from SQL API
?>

<?php include("../../include/include-footer.php") ?>