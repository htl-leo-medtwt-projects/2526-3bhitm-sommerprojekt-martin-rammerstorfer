<?php
require_once '../php/auth_check.php';
require_once '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/challenges.php');
  exit;
}

$userId = $_SESSION['user']['id'];
$challengeId = isset($_POST['challenge_id']) ? intval($_POST['challenge_id']) : 0;
$submittedFlag = trim($_POST['flag'] ?? '');

if ($challengeId <= 0 || $submittedFlag === '') {
  header("Location: ../pages/challenge.php?id={$challengeId}&error=invalid");
  exit;
}

$stmt = $conn->prepare("SELECT flag, score FROM challenge WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $challengeId);
$stmt->execute();
$res = $stmt->get_result();
$challenge = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$challenge) {
  header('Location: ../pages/challenges.php');
  exit;
}

// Normalize comparison
if ($submittedFlag === $challenge['flag']) {
  // Correct flag
  // Check if already solved
  $check = $conn->prepare("SELECT * FROM user_challenges WHERE user_id = ? AND challenge_id = ? LIMIT 1");
  $check->bind_param('ii', $userId, $challengeId);
  $check->execute();
  $r = $check->get_result();
  $already = $r ? $r->fetch_assoc() : null;
  $check->close();

  if ($already) {
    header("Location: ../pages/challenge.php?id={$challengeId}&already=1");
    exit;
  }

  $ins = $conn->prepare("INSERT INTO user_challenges (user_id, challenge_id, solve_date, rating, comment) VALUES (?, ?, CURDATE(), 0, '')");
  $ins->bind_param('ii', $userId, $challengeId);
  $ok = $ins->execute();
  $ins->close();

  if ($ok) {
    $up = $conn->prepare("UPDATE user SET solved = solved + 1, score = score + ? WHERE id = ?");
    $up->bind_param('ii', $challenge['score'], $userId);
    $up->execute();
    $up->close();

    header("Location: ../pages/challenge.php?id={$challengeId}&solved=1");
    exit;
  } else {
    header("Location: ../pages/challenge.php?id={$challengeId}&error=save-failed");
    exit;
  }
} else {
  // Wrong flag: just redirect back with an error
  header("Location: ../pages/challenge.php?id={$challengeId}&error=wrong-flag");
  exit;
}
?>