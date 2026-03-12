<?php
session_start();
require_once("../../../db.php"); //

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php"); //
    exit();
}

// Logic for Search Bonus
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $stmt = $conn->prepare("SELECT id, title, created_at FROM articles WHERE title LIKE ? ORDER BY created_at DESC");
    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, title, created_at FROM articles ORDER BY created_at DESC");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Mini-CMS Admin</span>
            <a href="../signout/index.php" class="btn btn-outline-danger btn-sm">Sign Out</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Article Management</h2>
            <a href="create.php" class="btn btn-primary">+ Create New Article</a>
        </div>

        <form class="d-flex mb-4" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    <td class="text-end">
                                        <a href="read.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">View</a>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this article?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No articles found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include("../include/include-footer.php"); ?>
</body>

</html>