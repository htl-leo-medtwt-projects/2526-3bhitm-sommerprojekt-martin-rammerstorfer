<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$_db_host = "db_server";
$_db_username = "stegoctf";
$_db_password = "stegopassword";
$_db_database = "stegoctf";

$conn = new mysqli($_db_host,
                   $_db_username,
                   $_db_password,
                   $_db_database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
