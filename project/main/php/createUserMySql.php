<?php

require_once "database.php";

if (!empty($_POST["submit"])) {
  $_username = $conn->real_escape_string($_POST["username"]);
  $_password = $conn->real_escape_string($_POST["password1"]);
  if (strcmp($_password, $conn->real_escape_string($_POST["password2"])) != 0) {
    include("create_user_form.html");
    exit;
  }

  $_passwordHash = password_hash($_password, PASSWORD_BCRYPT);

  $insertStatement = "INSERT INTO login_username (username, password, user_deleted, last_login)
          VALUES ('$_username', '$_passwordHash', 0, NOW());";
  
  if ($_res = $conn->query($insertStatement)) {
    echo "<br>User $_username has been added to the database.<br>Try to log in.";
    include("login_form.html");
  } else {
    echo "<br>NO insertion. User could not be added. Maybe user $_username already exists.";
    include("create_user_form.html");
  }
} else {
  include("create_user_form.html");
}

$conn->close();

?>
