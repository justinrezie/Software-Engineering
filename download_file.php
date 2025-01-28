<?php
// Check if the 'file' parameter is set in the URL
if (isset($_GET['file']) && !empty($_GET['file'])) {
    // Get the file path from the URL parameter
    $file_path = urldecode($_GET['file']);

    // Make sure the file exists
    if (file_exists($file_path)) {
        // Get the file info (such as the file name and mime type)
        $file_name = basename($file_path);
        $file_mime_type = mime_content_type($file_path);

        // Set headers for the download
        header('Content-Type: ' . $file_mime_type);
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));

        // Read the file and send it to the user
        readfile($file_path);
        exit;
    } else {
        // Handle the case where the file does not exist
        echo "File not found.";
    }
} else {
    // Handle the case where the 'file' parameter is missing
    echo "No file specified.";
}
?>
