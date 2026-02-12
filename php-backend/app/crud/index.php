<?php include("../include/include-crud-header.php") ?>
<?php require_once("../../db.php")?>

<h2 class="text-center">CRUD Interface</h2>
<a href="/app/crud/create" class="btn btn-success">Create new article</a><br>
<table class="table table-bordered mt-2">
    <thead>
        <tr>
            <th scope="col">Article Name:</th>
            <th scope="col">Article Content:</th>
            <th scope="col">Created At:</th>
            <th scope="col">Options:</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $conn->execute_query("SELECT title, content, created_at, id FROM articles ORDER BY created_at DESC");
        $rows = $stmt->fetch_all();
        echo "\n";
        foreach ($rows as $row) {
            echo "\t\t<tr>\n";
            echo "\t\t\t<td>{$row[0]}</td>\n";
            echo "\t\t\t<td>{$row[1]}</td>\n";
            echo "\t\t\t<td>{$row[2]}</td>\n";
            echo "\t\t\t<td>\n";
            echo "\t\t\t\t<a class='btn btn-success mt-2' href='/app/crud/read?id={$row[3]}'>Read</a>\n";
            echo "\t\t\t\t<a class='btn btn-warning mt-2' href='/app/crud/update?id={$row[3]}'>Edit</a>\n";
            echo "\t\t\t\t<a class='btn btn-danger mt-2' href='/app/crud/delete?id={$row[3]}'>Delete</a>\n";
            echo "\t\t\t</td>\n";
            echo "\t\t</tr>\n";
        }
        ?>

    </tbody>
</table>

<?php include("../include/include-footer.php") ?>