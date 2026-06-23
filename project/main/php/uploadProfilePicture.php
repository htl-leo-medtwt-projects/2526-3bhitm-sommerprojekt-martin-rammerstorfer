<?php
require 'auth_check.php';
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/user.php');
  exit;
}

if (empty($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
  header('Location: ../pages/profile.php?error=upload-failed');
  exit;
}

$file = $_FILES['profile_picture'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize = 2 * 1024 * 1024; // 2 MB

if ($file['size'] > $maxSize) {
  header('Location: ../pages/profile.php?error=file-too-large');
  exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);
if (!in_array($mimeType, $allowedMimeTypes, true)) {
  header('Location: ../pages/profile.php?error=invalid-file-type');
  exit;
}

$ext = match ($mimeType) {
  'image/jpeg' => 'jpg',
  'image/png' => 'png',
  'image/gif' => 'gif',
  'image/webp' => 'webp',
  default => null,
};

if ($ext === null) {
  header('Location: ../pages/profile.php?error=invalid-file-type');
  exit;
}

$userId = $_SESSION['user']['id'];
$uploadDir = __DIR__ . '/../img/profile/';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
  header('Location: ../pages/profile.php?error=upload-dir-failed');
  exit;
}

$basename = sprintf('user_%d_%s.%s', $userId, bin2hex(random_bytes(8)), $ext);
$destination = $uploadDir . $basename;
$relativePath = 'img/profile/' . $basename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
  header('Location: ../pages/profile.php?error=upload-failed');
  exit;
}

$stmt = $conn->prepare('UPDATE user SET imgpath = ? WHERE id = ?');
$stmt->bind_param('si', $relativePath, $userId);
if ($stmt->execute()) {
  header('Location: ../pages/user.php?success=upload');
} else {
  header('Location: ../pages/user.php?error=upload-failed');
}

$stmt->close();
$conn->close();
exit;
