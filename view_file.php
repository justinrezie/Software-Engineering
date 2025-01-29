<?php
// Check if the 'file' parameter exists in the URL
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $file_name = urldecode($_GET['file']); // Decode the file name

    // Define the path to your files directory (ensure this is correct)
    $file_path = 'uploads/' . $file_name;

    // Check if the file exists
    if (file_exists($file_path)) {
        // Assuming the file is uploaded to Google Drive, create the Google Docs URL
        // Replace this with the actual Google Drive URL (ensure you have a valid file link)
        $google_file_url = "https://drive.google.com/file/d/YOUR_FILE_ID/view?usp=sharing";

        // Properly encode the Google Drive URL
        $encoded_google_file_url = urlencode($google_file_url);

        // Generate the Google Docs viewer link
        $google_docs_view_url = "https://docs.google.com/viewer?url=" . $encoded_google_file_url;

        echo '<a href="' . $google_docs_view_url . '" class="btn">View in Google Docs</a>';
    } else {
        echo "File not found: " . htmlspecialchars($file_name);
        exit;
    }
} else {
    echo "No file specified in the URL.";
    exit;
}
?>
