<?php
include "dbconfig.php";

// Get file path from query parameter
$file_param = isset($_GET['file']) ? trim($_GET['file']) : '';

if (empty($file_param)) {
    http_response_code(404);
    echo "File not found";
    exit;
}

// Decode URL-encoded filename
$file_param = urldecode($file_param);

// Sanitize the file path - remove any directory traversal attempts
$file_param = str_replace(['../', '..\\', '\\'], '', $file_param);

// Construct full file path - files should be in admin/img directory
$file_path = __DIR__ . '/admin/img/' . basename($file_param);

// Verify file exists and is readable
if (!file_exists($file_path) || !is_readable($file_path)) {
    http_response_code(404);
    echo "File not found or not accessible";
    exit;
}

// Get file info
$file_name = basename($file_path);
$file_size = filesize($file_path);

// Set headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . addslashes($file_name) . '"');
header('Content-Length: ' . $file_size);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Read and output file
if (($handle = fopen($file_path, 'rb')) !== false) {
    while (!feof($handle)) {
        echo fread($handle, 8192);
        flush();
    }
    fclose($handle);
} else {
    http_response_code(500);
    echo "Error reading file";
}
exit;
?>
