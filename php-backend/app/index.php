<?php include("./include/include-header.php") ?>


<form class="text-center" action="" method="post">
  <h2>Log In:</h2>
  <input type="email" name="email" placeholder="Enter your email..." class="mt-2" required><br>
  <input type="password" name="password" placeholder="Enter your password..." class="mt-1" required><br>
  <input type="submit" class="btn btn-success" value="Log in" class="mt-4">
</form>

<?php
session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: /app/crud");
} else if (isset($_POST["email"]) && isset($_POST["password"])) {
  extract($_POST);
  $email = sanitize_input($email);
  $password = sanitize_input($password);
  // TODO: add SQL authentication here
  $_SESSION["user_id"] = 1;
  header("Location: /app/crud");
}

?>


<?php include("./include/include-footer.php") ?>