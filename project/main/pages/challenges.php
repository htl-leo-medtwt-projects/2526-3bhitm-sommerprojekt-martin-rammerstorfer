<?php
require '../php/database.php';

$query = "SELECT c.id, c.name, c.description, c.category, c.score, c.filepath, COALESCE((SELECT AVG(rating) FROM user_challenges uc WHERE uc.challenge_id = c.id AND uc.rating > 0), 0) AS avg_rating FROM challenge c ORDER BY score DESC, name ASC";
$result = $conn->query($query);
$challenges = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
$conn->close();

function esc($value): string {
  return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function difficultyFromScore($score): string {
  $score = (int)$score;
  if ($score < 300) {
    return 'easy';
  }
  if ($score < 500) {
    return 'medium';
  }
  return 'hard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Challenges - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/challenges.css">
  <script src="../js/challenges.js" defer></script>
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

  <section class="challenges">
    <h1>Challenges</h1>

    <div class="filters">
      <h3>Filters</h3>
      <div class="filter-buttons">
        <button class="filter active" onclick="filter('all', this)">All</button>
        <button class="filter" onclick="filter('easy', this)">Easy</button>
        <button class="filter" onclick="filter('medium', this)">Medium</button>
        <button class="filter" onclick="filter('hard', this)">Hard</button>
      </div>
      <div class="filter-actions">
        <button type="button" id="sort-btn" class="btn" data-order="asc">▲ Ascending</button>
      </div>
    </div>

    <div id="challenge-container">
      <div class="challenges-container">
        <?php foreach ($challenges as $challenge): ?>
          <?php $difficulty = difficultyFromScore($challenge['score']); ?>
          <a href="challenge.php?id=<?= esc((string)$challenge['id']) ?>" class="challenge-card" data-difficulty="<?= esc($difficulty) ?>">
            <div class="challenge-header">
              <h2><?= esc($challenge['name']) ?></h2>
            </div>
            <p><?= esc($challenge['description']) ?></p>
            <p class="points">Points: <span><?= esc((string)$challenge['score']) ?></span></p>
            <p class="rating">Rating: <span><?= $challenge['avg_rating'] > 0 ? esc(number_format((float)$challenge['avg_rating'], 1)) . ' / 5' : '-' ?></span></p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

  </section>

</body>
</html>
