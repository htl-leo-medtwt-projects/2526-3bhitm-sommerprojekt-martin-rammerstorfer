<?php
require '../php/auth_check.php';
require '../php/database.php';

$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare(
  "SELECT u.*, COALESCE(t.name, '-') AS team_name FROM user u
   LEFT JOIN team t ON u.team_id = t.id
   WHERE u.id = ? LIMIT 1"
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;

if (!$user) {
  header('Location: login.php');
  exit;
}

// Get available teams
$teamResult = $conn->query("SELECT * FROM team ORDER BY total_score DESC");
$teams = $teamResult ? mysqli_fetch_all($teamResult, MYSQLI_ASSOC) : [];

$conn->close();

function esc($value): string {
  return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($user['name']) ?> - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
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
      <a href="../php/logout.php">Logout</a>
    </div>
  </nav>

  <section class="profile">
    <a href="leaderboard.php" class="back">← Back</a>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'team-updated'): ?>
      <div class="success-message">Team updated successfully!</div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
      <div class="error-message">An error occurred: <?= esc($_GET['error']) ?></div>
    <?php endif; ?>

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

    <div class="box">
      <h2>Team</h2>
      <div class="team-section">
        <p>Current team: <strong><?= esc($user['team_name']) ?></strong></p>
        
        <form method="POST" action="../php/joinTeam.php">
          <label for="team-name">Join or create a team (leave empty to leave):</label>
          <input id="team-name" type="text" name="team_name" placeholder="Team name..." value="<?= $user['team_id'] > 0 ? esc($user['team_name']) : '' ?>">
          <button type="submit" class="btn">Update Team</button>
        </form>
      </div>
    </div>
  </section>

</body>
</html>
