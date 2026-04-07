<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secret Zone</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  require_once "auth_check.php";

  $username = htmlspecialchars($_SESSION["user"]["username"], ENT_QUOTES, 'UTF-8');
  ?>

  <h1>Secret Zone</h1>

  <p>Welcome, <?php echo $username; ?>!</p>

  <p>
    <a href="logout.php">Logout</a>
  </p>
</body>
</html>
