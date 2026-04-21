<?

// MYSQL DATABASE
$servername 0 "db_server";
$port = 3306;
$username = "stegoctf";
$password = "stegopassword";
$dbname = "stegoctf"

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
