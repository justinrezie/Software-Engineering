<?php
$file_name = $_GET['file'];
$file_path = '../uploads/' . $file_name;

if (file_exists($file_path)) {
    header('Content-Type: ' . mime_content_type($file_path));
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
} else {
    echo "File not found!";
}
?>
