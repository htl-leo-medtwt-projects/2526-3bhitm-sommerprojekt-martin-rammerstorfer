<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (
  empty($_SESSION["login"]) ||
  $_SESSION["login"] !== 1 ||
  empty($_SESSION["user"])
) {
  header("Location: ../pages/login.php");
  exit;
}

session_regenerate_id(true);
?>
