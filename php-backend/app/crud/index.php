<?php include("../include/include-crud-header.php") ?>
<?php require_once("../../db.php") ?>

<h2 class="text-center">CRUD Interface</h2>
<form action="" method="get">
    <input type="text" name="title" placeholder="Search for an Article">
    <input type="submit" class="btn btn-info" value="Search">
</form>
<a href="/app/crud/create" class="btn btn-success mt-2">Create new article</a><br>
<p id="filter-text">Looking for article titles that contain <strong><span id="filter"></span></strong>.</p>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th scope="col">Article Name:</th>
            <th scope="col">Article Content:</th>
            <th scope="col">Created At:</th>
            <th scope="col">Options:</th>
        </tr>
    </thead>
    <tbody id="crud-info"></tbody>
</table>

<template id="article-template">
    <tr>
        <td class="title"></td>
        <td class="content"></td>
        <td class="created-at"></td>
        <td>
            <a class='btn btn-success mt-2 read' href='/app/crud/read?id={$row[3]}'>Read</a>
            <a class='btn btn-warning mt-2 update' href='/app/crud/update?id={$row[3]}'>Edit</a>
            <a class='btn btn-danger mt-2 delete' href='/app/crud/delete?id={$row[3]}'>Delete</a>
        </td>
    </tr>
</template>

<script>
    var crudInfo = document.getElementById("crud-info");
    var crudTemplate = document.getElementById("article-template");
    var baseUrl = "http://localhost:8888";


    var getData = async function() {
        var url = baseUrl + "/articles";
        const urlParams = new URLSearchParams(window.location.search);
        const title = urlParams.get('title');

        if (title) 
            document.getElementById("filter").innerHTML = title;
        else
            document.getElementById("filter-text").innerHTML = "No filter provided";

        await fetch(url)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                data.forEach(element => {
                    if (title && !element.title.toLowerCase().includes(title.toLowerCase())) {
                        return;
                    }
                    var newArticle = crudTemplate.content.cloneNode(true);
                    newArticle.querySelector(".title").innerHTML = element.title;
                    newArticle.querySelector(".content").innerHTML = element.content;
                    newArticle.querySelector(".created-at").innerHTML = element.created_at;
                    newArticle.querySelector(".read").href = `/app/crud/read?id=${element.id}`;
                    newArticle.querySelector(".update").href = `/app/crud/update?id=${element.id}`;
                    newArticle.querySelector(".delete").href = `/app/crud/delete?id=${element.id}`;
                    crudInfo.appendChild(newArticle);
                });
            });

        return false;
    };
    getData()
</script>

<?php include("../include/include-footer.php") ?>