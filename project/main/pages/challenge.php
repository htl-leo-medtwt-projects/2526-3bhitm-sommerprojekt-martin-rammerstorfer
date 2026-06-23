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

$allComments = [];
if ($stmtComments = $conn->prepare(
  "SELECT uc.comment, uc.rating, uc.solve_date, u.name AS username, u.imgpath AS imgpath, uc.user_id FROM user_challenges uc JOIN `user` u ON u.id = uc.user_id WHERE uc.challenge_id = ? AND (uc.comment <> '' OR uc.rating > 0) ORDER BY uc.solve_date DESC"
)) {
  $stmtComments->bind_param('i', $id);
  $stmtComments->execute();
  $resComments = $stmtComments->get_result();
  $allComments = $resComments ? mysqli_fetch_all($resComments, MYSQLI_ASSOC) : [];
  $stmtComments->close();
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
        <div>Points: <span style="color: white;"><?= esc((string)$challenge['score']) ?></span></div>
        <div>Avg rating: <span style="color: white;"><?= $challenge['avg_rating'] > 0 ? esc(number_format((float)$challenge['avg_rating'], 1)) . ' / 5' : '-' ?></span></div>
        <div>Category: <span style="color: white;"><?= esc($challenge['category']) ?></span></div>
      </div>
      <p id="desc"><?= nl2br(esc($challenge['description'])) ?></p>
      <?php if (!empty($challenge['filepath'])): ?>
        <div class="download-row">
          <a class="btn download-btn" href="../<?= esc($challenge['filepath']) ?>" download>Download file</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="challenge-box" id="challenge-flag">
      <?php if (!empty($_SESSION['login']) && $_SESSION['login'] === 1): ?>
        <?php if (!$userSolved): ?>
          <h2>Submit Flag</h2>
          <form method="POST" action="../php/submitFlag.php">
            <input type="hidden" name="challenge_id" value="<?= (int)$id ?>">
            <div class="flag-row">
              <input type="text" id="flagInput" name="flag" placeholder="Enter flag here">
              <button type="submit" class="btn">Submit</button>
            </div>
          </form>
        <?php else: ?>
          <h2>Feedback</h2>
          <p class="small-text" id="solved-text">You solved this challenge on <?= esc($userSolved['solve_date']) ?>.</p>
          <?php if (empty($userSolved['rating']) || empty($userSolved['comment'])): ?>
            <form method="POST" action="../php/submitComment.php" class="feedback-form">
              <input type="hidden" name="challenge_id" value="<?= (int)$id ?>">

              <div class="form-row">
                <label for="rating">Rating</label>
                <select name="rating" id="rating" class="input-select">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>

              <div class="form-row">
                <label for="comment">Comment (optional)</label>
                <textarea id="comment" name="comment" rows="4" placeholder="Leave feedback..." class="input-textarea"></textarea>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn">Submit feedback</button>
              </div>
            </form>
          <?php endif; ?>
          <div class="feedback-list">
          <?php if (!empty($allComments)): ?>
            <?php foreach ($allComments as $c): ?>
              <div class="comment">
                <div class="comment-header">
                  <img class="comment-avatar" src="../<?= esc(!empty($c['imgpath']) ? $c['imgpath'] : 'img/default.png') ?>" alt="<?= esc($c['username']) ?>'s profile picture">
                  <p class="small-text"><strong><?= esc($c['username']) ?></strong> — <?= esc($c['solve_date']) ?><?php if (!empty($c['rating'])): ?> — Rating: <?= esc((string)$c['rating']) ?><?php endif; ?></p>
                </div>
                <?php if (!empty($c['comment'])): ?>
                  <p><?= nl2br(esc($c['comment'])) ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="small-text">No feedback yet.</p>
          <?php endif; ?>
        </div>
      </div>
        <?php endif; ?>
      <?php else: ?>
        <p class="small-text">Please <a href="login.php">log in</a> to submit a flag.</p>
      <?php endif; ?>
  </section>

</body>
</html>
