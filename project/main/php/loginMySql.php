<?php

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $_username = trim($_POST["username"] ?? "");
  $_password = $_POST["password"] ?? "";

  $stmt = $conn->prepare(
    "SELECT * FROM user WHERE name = ? AND user_deleted = 0 LIMIT 1"
  );
  $stmt->bind_param("s", $_username);
  $stmt->execute();

  $res = $stmt->get_result();

  if ($res->num_rows === 1) {
    $user = $res->fetch_assoc();

    if (password_verify($_password, $user["password_hash"])) {
      session_regenerate_id(true);
      $_SESSION["login"] = 1;
      $_SESSION["user"] = [
        "id" => $user["id"],
        "name" => $user["name"]
      ];

      $stmt = $conn->prepare(
        "UPDATE user SET last_login = NOW() WHERE id = ?"
      );
      $stmt->bind_param("i", $user["id"]);
      $stmt->execute();

      header("Location: ../pages/user.php");
      exit;
    }

    header("Location: ../pages/login.php?error=wrong-password");
    exit;
  }

  header("Location: ../pages/login.php?error=user-not-found");
  exit;
}

$conn->close();

header("Location: ../pages/login.php");
exit;

?>
