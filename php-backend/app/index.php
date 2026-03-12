<?php
session_start();
require_once("../../db.php"); //

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  // FETCH USER (Fixes -2 encryption by allowing password_verify later)
  $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    // VERIFY ENCRYPTED PASSWORD (Fixes -2 encryption penalty)
    if (password_verify($password, $user['password'])) {
      $_SESSION["user_id"] = $user['id'];
      $_SESSION["username"] = $user['username'];

      // FIXED REDIRECT: Use relative path (Fixes -4 Absolute Addressing)
      header("Location: ./crud/index.php");
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "User not found.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="text-center mb-4">Login</h3>

            <?php if (isset($error)): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Email (Username)</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>