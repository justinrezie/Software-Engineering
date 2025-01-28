<?php
// Start session
session_start();

// Include database connection
include 'config/database.php';

// Get the file parameter from the URL
if (isset($_GET['file'])) {
    // Get the file path from URL and sanitize it
    $file_path = $_GET['file'];
    $file_path = mysqli_real_escape_string($conn, $file_path); // Sanitize input

    // Query to fetch file from the database
    $query = "SELECT * FROM files WHERE file_path = '$file_path'";
    $result = mysqli_query($conn, $query);

    // Check if the file exists in the database
    if (mysqli_num_rows($result) > 0) {
        $file = mysqli_fetch_assoc($result);
        // Fetch file details
        $file_name = $file['file_name'];
        $file_description = $file['description'];
        $file_created_at = $file['created_at'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        
        // Full file path
        $full_file_path = "../uploads/" . $file_name; // Full server path
        if (!file_exists($full_file_path)) {
            die("Error: File does not exist on the server.");
        }
    } else {
        die("Error: File not found in the database.");
    }
} else {
    die("Error: No file specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File</title>
</head>
<body>

    <h1>View File: <?= htmlspecialchars($file_name) ?></h1>

    <div>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($file_description)) ?></p>
        <p><strong>Uploaded At:</strong> <?= date("M d, Y - H:i", strtotime($file_created_at)) ?></p>

        <?php
        // Check file type and display accordingly
        if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            // Image
            echo "<img src='$full_file_path' alt='File Image' style='max-width: 100%; height: auto;'>";
        } elseif ($file_type == 'pdf') {
            // PDF
            echo "<iframe src='$full_file_path' style='width: 100%; height: 500px;'></iframe>";
        } elseif ($file_type == 'docx') {
            // DOCX (you might need a viewer or convert to PDF)
            echo "<p>This file is a Word document, and cannot be displayed directly in the browser.</p>";
        } else {
            // Other file types (provide a download link)
            echo "<p>This file type cannot be viewed directly. <a href='$full_file_path' download>Click here to download</a>.</p>";
        }
        ?>
    </div>

</body>
</html>
