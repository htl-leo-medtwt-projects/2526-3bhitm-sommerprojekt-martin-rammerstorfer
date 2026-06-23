<?php
require '../php/auth_check.php';
require '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/user.php');
  exit;
}

$userId = $_SESSION['user']['id'];
$teamName = trim($_POST['team_name'] ?? '');

if (empty($teamName)) {
  $updateStmt = $conn->prepare("UPDATE user SET team_id = 0 WHERE id = ?");
  $updateStmt->bind_param('i', $userId);
  
  if ($updateStmt->execute()) {
    header('Location: ../pages/user.php?success=team-updated');
  } else {
    header('Location: ../pages/user.php?error=team-update-failed');
  }
  $conn->close();
  exit;
}

// Look up team by name
$checkStmt = $conn->prepare("SELECT id FROM team WHERE name = ?");
$checkStmt->bind_param('s', $teamName);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
  $team = $checkResult->fetch_assoc();
  $teamId = $team['id'];
} else {
  $insertStmt = $conn->prepare("INSERT INTO team (name, total_score) VALUES (?, 0)");
  $insertStmt->bind_param('s', $teamName);
  
  if (!$insertStmt->execute()) {
    header('Location: ../pages/user.php?error=team-create-failed');
    $conn->close();
    exit;
  }
  
  $teamId = $conn->insert_id;
}

$updateStmt = $conn->prepare("UPDATE user SET team_id = ? WHERE id = ?");
$updateStmt->bind_param('ii', $teamId, $userId);

if ($updateStmt->execute()) {
  header('Location: ../pages/user.php?success=team-updated');
} else {
  header('Location: ../pages/user.php?error=team-update-failed');
}

$conn->close();
exit;
?>
