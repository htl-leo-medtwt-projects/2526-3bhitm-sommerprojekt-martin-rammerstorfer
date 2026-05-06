<?php

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $_username = trim($_POST["username"] ?? "");
  $_password = $_POST["password"] ?? "";
  $_passwordConfirm = $_POST["password2"] ?? "";

  if ($_password !== $_passwordConfirm) {
    header("Location: ../pages/register.php?error=password-mismatch");
    exit;
  }

  $_passwordHash = password_hash($_password, PASSWORD_BCRYPT);

  $stmt = $conn->prepare(
    "INSERT INTO user (name, password_hash, user_deleted, last_login, solved, score, team_id)
      VALUES (?, ?, 0, CURDATE(), 0, 0, 0)"
  );
  $stmt->bind_param("ss", $_username, $_passwordHash);

  if ($stmt->execute()) {
    header('Location: ../pages/login.php');
    exit;
  }

  header("Location: ../pages/register.php?error=create-failed");
  exit;
}

header("Location: ../pages/register.php");
exit;

?>
