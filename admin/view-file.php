<?php
// view-file.php

// Ensure the file ID is passed through the URL
if (isset($_GET['id'])) {
    $file_id = $_GET['id'];

    // Fetch the file data from the database
    $stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();

    if ($file) {
        // Debugging: Check if file is found
        echo '<pre>';
        print_r($file);  // Check the fetched data
        echo '</pre>';
        
        // Set headers for the correct file type
        header('Content-Type: ' . $file['file_type']);
        header('Content-Disposition: inline; filename="' . $file['title'] . '"');

        // Output the file content (binary data)
        echo $file['file_data'];
        exit;
    } else {
        echo "File not found in the database.";
    }
} else {
    echo "No file ID provided.";
}
?>
