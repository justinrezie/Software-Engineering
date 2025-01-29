<?php
// Ensure file parameter is set
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $file_name = basename($_GET['file']); // Sanitize the file name

    // Define the absolute path to your uploads directory
    $file_dir = $_SERVER['DOCUMENT_ROOT'] . '../uploads/'; // Adjust this if necessary
    $file_path = $file_dir . $file_name;

    // Output the file path for debugging
    echo 'Trying to access: ' . $file_path;

    // Check if file exists
    if (file_exists($file_path)) {
        // Set headers to force download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));

        // Output the file
        readfile($file_path);
        exit;
    } else {
        echo 'File not found on the server. Please check the file path.';
    }
} else {
    echo 'No file specified or the file parameter is empty.';
}
?>
