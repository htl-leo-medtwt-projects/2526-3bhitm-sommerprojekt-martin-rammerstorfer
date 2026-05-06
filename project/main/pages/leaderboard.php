<?php
require '../php/database.php';

$query = "SELECT u.id, u.name AS username, u.score, u.solved, COALESCE(t.name, '-') AS team_name
          FROM user u
          LEFT JOIN team t ON u.team_id = t.id
          WHERE u.user_deleted = 0
          ORDER BY u.score DESC, u.solved DESC, u.name ASC";
$result = $conn->query($query);
$rows = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
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
  <title>Leaderboard - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/leaderboard.css">
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
        <a href="user.php">Profile</a>
      <?php else: ?>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="leaderboard">
    <h1>Leaderboard</h1>

    <table class="leaderboard-table">
      <thead>
        <tr>
          <th>Rank</th>
          <th>User</th>
          <th>Team</th>
          <th class="points">Points</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $index => $row): ?>
          <tr class="clickable-row" data-href="profile.php?id=<?= (int)$row['id'] ?>" style="cursor: pointer;">
            <td><?= $index + 1 ?></td>
            <td><?= esc($row['username']) ?></td>
            <td><?= esc($row['team_name']) ?></td>
            <td class="points"><?= esc((string)$row['score']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('tr.clickable-row').forEach(function(row) {
        row.addEventListener('click', function() {
          window.location.href = this.dataset.href;
        });
      });
    });
  </script>
</body>
</html>
