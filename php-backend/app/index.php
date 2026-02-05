<?php include("./include/include-header.php") ?>


<form class="text-center" action="" method="post">
  <h2>Log In:</h2>
  <input type="email" name="email" placeholder="Enter your email..." class="mt-2" required><br>
  <input type="password" name="password" placeholder="Enter your password..." class="mt-1" required><br>
  <input type="submit" class="btn btn-success" value="Log in" class="mt-4">
</form>

<?php
session_start();
require_once("../db.php");

if (isset($_SESSION["user_id"])) {
  header("Location: /app/crud");
} else if (isset($_POST["email"]) && isset($_POST["password"])) {
  extract($_POST);
  $email = sanitize_input($email);
  $password = sanitize_input($password);

  $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if ($password === $user['password']) {
      $_SESSION["user_id"] = $user['id'];
      $_SESSION["username"] = $user['username'];
      header("Location: ./app/crud");
      exit();
    } else {
      echo "<p style='color:red;'>Password mismatch.</p>";
    }
  } else {
    echo "<p style='color:red;'>User not found.</p>";
  }
}

?>


<?php include("./include/include-footer.php") ?>