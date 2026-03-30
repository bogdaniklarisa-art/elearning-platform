<?php
require_once 'includes/auth.php';

if (!isset($_GET['file'])) {
    die("File nuk u gjet.");
}

$file = $_GET['file'];
$file = str_replace(['../', '..\\'], '', $file);
$full_path = __DIR__ . '/' . $file;

if (!file_exists($full_path)) {
    die("File nuk ekziston.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
header('Content-Length: ' . filesize($full_path));
readfile($full_path);
exit;