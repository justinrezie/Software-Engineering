<?php
session_start();
require 'config/database.php';

// Get the file ID from the URL
$file_id = $_GET['id'] ?? null;
if (!$file_id) {
    $_SESSION['error'] = "No file selected to delete.";
    header("Location: manage-files.php");
    exit();
}

// Fetch the file from the database
$stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$file = $stmt->get_result()->fetch_assoc();

if (!$file) {
    $_SESSION['error'] = "File not found.";
    header("Location: manage-files.php");
    exit();
}

// Delete the file from the server
$file_path = "uploads/" . $file['file_name'];
if (file_exists($file_path)) {
    unlink($file_path); // Delete the file from the server
}

// If there is a thumbnail, delete it as well
if ($file['thumbnail_name']) {
    $thumbnail_path = "uploads/thumbnails/" . $file['thumbnail_name'];
    if (file_exists($thumbnail_path)) {
        unlink($thumbnail_path); // Delete the thumbnail
    }
}

// Delete the file record from the database
$stmt_delete = $conn->prepare("DELETE FROM files WHERE id = ?");
$stmt_delete->bind_param("i", $file_id);
if ($stmt_delete->execute()) {
    $_SESSION['success'] = "File deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting file: " . $stmt_delete->error;
}

header("Location: index.php");
exit();
