<?php include("../include/include-crud-header.php") ?>
<?php require_once("../../db.php")?>

<h2 class="text-center">CRUD Interface</h2>
<a href="/app/crud/create" class="btn btn-success">Create new article</a><br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Article Name:</th>
            <th scope="col">Article Content:</th>
            <th scope="col">Created At:</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $conn->execute_query("SELECT title, content, created_at FROM articles");
        $rows = $stmt->fetch_all();
        foreach ($rows as $row) {
            echo "<tr>\n\t";
            echo "<td>{$row[0]}</td>\n";
            echo "<td>{$row[1]}</td>\n";
            echo "<td>{$row[2]}</td>\n";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php include("../include/include-footer.php") ?>