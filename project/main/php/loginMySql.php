<?php

require_once "database.php";

if (!empty($_POST["submit"])) {
  $_username = $_POST["username"];
  $_password = $_POST["password"];

  $stmt = $conn->prepare(
    "SELECT * FROM user WHERE name = ? AND user_deleted = 0 LIMIT 1"
  );
  $stmt->bind_param("s", $_username);
  $stmt->execute();

  $res = $stmt->get_result();

  if ($res->num_rows === 1) {
    $user = $res->fetch_assoc();

    if (password_verify($_password, $user["password"])) {

      $_SESSION["login"] = 1;
      $_SESSION["user"] = $user;

      $stmt = $conn->prepare(
        "UPDATE login_username SET last_login = NOW() WHERE id = ?"
      );
      $stmt->bind_param("i", $user["id"]);
      $stmt->execute();

    } else {
      echo "Wrong password.<br>";
      include("login_form.html");
    }
  } else {
    echo "User not found.<br>";
    include("login_form.html");
  }
}

$conn->close();

if (is_array($_SESSION) && isset($_SESSION["login"]) && $_SESSION["login"] == 1) {
  header("Location: secretContent.php");
}

?>
