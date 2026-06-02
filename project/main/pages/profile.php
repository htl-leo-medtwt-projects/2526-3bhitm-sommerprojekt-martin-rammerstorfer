<?php
require '../php/database.php';

// Accept id or name
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$name = isset($_GET['name']) ? trim($_GET['name']) : '';

if ($id <= 0 && $name === '') {
  header('Location: leaderboard.php');
  exit;
}

if ($id > 0) {
  $stmt = $conn->prepare("SELECT u.*, COALESCE(t.name, '-') AS team_name FROM user u LEFT JOIN team t ON u.team_id = t.id WHERE u.id = ? LIMIT 1");
  $stmt->bind_param('i', $id);
} else {
  $stmt = $conn->prepare("SELECT u.*, COALESCE(t.name, '-') AS team_name FROM user u LEFT JOIN team t ON u.team_id = t.id WHERE u.name = ? LIMIT 1");
  $stmt->bind_param('s', $name);
}
$stmt->execute();
$res = $stmt->get_result();
$user = $res ? $res->fetch_assoc() : null;
$stmt->close();
$conn->close();

if (!$user) {
  header('Location: leaderboard.php');
  exit;
}

function esc($value): string {
  return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($user['name']) ?> - Profile</title>
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user.css">
</head>
<body>
  <nav id="navigation">
    <div id="nav-left">
      <span id="logo">StegoCTF</span>
      <a href="../index.php">Home</a>
      <a href="challenges.php">Challenges</a>
      <a href="leaderboard.php">Leaderboard</a>
    </div>
    <div id="nav-right">
      <?php if (!empty($_SESSION['login']) && $_SESSION['login'] === 1): ?>
        <a href="user.php">My Profile</a>
      <?php else: ?>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="profile">
    <div class="box" id="user-details">
      <h1><?= esc($user['name']) ?></h1>
      <p>Team: <?= esc($user['team_name']) ?></p>
      <p>Last login: <?= esc($user['last_login']) ?></p>
    </div>

    <div class="box stats">
      <h2>Stats</h2>
      <div class="stats-content">
        <p>Score: <strong><?= esc((string)$user['score']) ?></strong></p>
        <p>Solved: <strong><?= esc((string)$user['solved']) ?></strong></p>
      </div>
    </div>

  </section>
</body>
</html>
