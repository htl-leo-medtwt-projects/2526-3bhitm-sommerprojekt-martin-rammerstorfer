<?php
require '../php/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT c.id, c.name, c.description, c.category, c.score, c.filepath, COALESCE((SELECT AVG(rating) FROM user_challenges uc WHERE uc.challenge_id = c.id AND uc.rating > 0), 0) AS avg_rating FROM challenge c WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$challenge = $result ? $result->fetch_assoc() : null;

if (!$challenge) {
  $conn->close();
  header('Location: challenges.php');
  exit;
}

define('ESC', ENT_QUOTES | ENT_SUBSTITUTE);
function esc($value): string {
  return htmlspecialchars((string)$value, ESC, 'UTF-8');
}

$userSolved = null;
if (!empty($_SESSION['login']) && $_SESSION['login'] === 1) {
  $userId = $_SESSION['user']['id'];
  $check = $conn->prepare("SELECT * FROM user_challenges WHERE user_id = ? AND challenge_id = ? LIMIT 1");
  $check->bind_param('ii', $userId, $id);
  $check->execute();
  $res = $check->get_result();
  $userSolved = $res ? $res->fetch_assoc() : null;
  $check->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($challenge['name']) ?> - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/challenge.css">
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

  <section class="challenge-page">
    <a href="challenges.php" class="back">← Back</a>

    <div class="challenge-box">
      <div class="challenge-header">
        <h1><?= esc($challenge['name']) ?></h1>
      </div>
      <div class="challenge-meta">
        <div>Category: <?= esc($challenge['category']) ?></div>
        <div>Points: <?= esc((string)$challenge['score']) ?></div>
        <div>Avg rating: <?= $challenge['avg_rating'] > 0 ? esc(number_format((float)$challenge['avg_rating'], 1)) . ' / 5' : '-' ?></div>
      </div>
      <p><?= nl2br(esc($challenge['description'])) ?></p>
      <?php if (!empty($challenge['filepath'])): ?>
        <div class="download-row">
          <a class="btn download-btn" href="../<?= esc($challenge['filepath']) ?>" download>Download file</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="challenge-box" id="challenge-flag">
      <h2>Submit Flag</h2>
      <?php if (!empty($_SESSION['login']) && $_SESSION['login'] === 1): ?>
        <?php if (!$userSolved): ?>
          <form method="POST" action="../php/submitFlag.php">
            <input type="hidden" name="challenge_id" value="<?= (int)$id ?>">
            <div class="flag-row">
              <input type="text" id="flagInput" name="flag" placeholder="Enter flag here">
              <button type="submit" class="btn">Submit</button>
            </div>
          </form>
        <?php else: ?>
          <p class="small-text">You already solved this challenge on <?= esc($userSolved['solve_date']) ?>.</p>
          <?php if (empty($userSolved['rating']) || empty($userSolved['comment'])): ?>
            <form method="POST" action="../php/submitComment.php">
              <input type="hidden" name="challenge_id" value="<?= (int)$id ?>">
              <label for="rating">Rating (1-5)</label>
              <select name="rating" id="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
              <label for="comment">Comment</label>
              <textarea id="comment" name="comment" rows="3" placeholder="Leave feedback..."></textarea>
              <button type="submit" class="btn">Submit feedback</button>
            </form>
          <?php else: ?>
            <p class="small-text">Your rating: <?= esc((string)$userSolved['rating']) ?></p>
            <p><?= nl2br(esc($userSolved['comment'])) ?></p>
          <?php endif; ?>
        <?php endif; ?>
      <?php else: ?>
        <p class="small-text">Please <a href="login.php">log in</a> to submit a flag.</p>
      <?php endif; ?>
    </div>
  </section>

</body>
</html>
