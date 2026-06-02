<?php
require_once '../php/auth_check.php';
require_once '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/challenges.php');
  exit;
}

$userId = $_SESSION['user']['id'];
$challengeId = isset($_POST['challenge_id']) ? intval($_POST['challenge_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comment = trim($_POST['comment'] ?? '');

if ($challengeId <= 0) {
  header('Location: ../pages/challenge.php?id=' . $challengeId);
  exit;
}

// Validate user solved this challenge
$check = $conn->prepare("SELECT * FROM user_challenges WHERE user_id = ? AND challenge_id = ? LIMIT 1");
$check->bind_param('ii', $userId, $challengeId);
$check->execute();
$r = $check->get_result();
$row = $r ? $r->fetch_assoc() : null;
$check->close();

if (!$row) {
  header('Location: ../pages/challenge.php?id=' . $challengeId . '&error=not-solved');
  exit;
}

// Clamp rating
if ($rating < 0) $rating = 0;
if ($rating > 5) $rating = 5;

$update = $conn->prepare("UPDATE user_challenges SET rating = ?, comment = ? WHERE user_id = ? AND challenge_id = ?");
$update->bind_param('isii', $rating, $comment, $userId, $challengeId);
$ok = $update->execute();
$update->close();

$conn->close();
if ($ok) {
  header('Location: ../pages/challenge.php?id=' . $challengeId . '&commented=1');
} else {
  header('Location: ../pages/challenge.php?id=' . $challengeId . '&error=comment-failed');
}
exit;
?>