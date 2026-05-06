<?php
// Mithilfe von KI generiert

$baseDir = realpath(__DIR__ . '/../challenge_files');
if ($baseDir === false) {
    http_response_code(500);
    exit('Server configuration error.');
}

if (!isset($_GET['path'])) {
    http_response_code(400);
    exit('Missing file path.');
}

$requestedPath = rawurldecode($_GET['path']);
$requestedPath = str_replace(["\0", "\r", "\n"], '', $requestedPath);
$fullPath = realpath($baseDir . '/' . $requestedPath);

if ($fullPath === false || strpos($fullPath, $baseDir) !== 0 || !is_file($fullPath)) {
    http_response_code(404);
    exit('File not found.');
}

$fileName = basename($fullPath);
$fileName = str_replace('"', "'", $fileName);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($fullPath));
readfile($fullPath);
exit;
