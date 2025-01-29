<?php
include '../config/database.php';
session_start();

// Ensure the ID is set and is valid
if (isset($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Update the file information in the database without handling file uploads
    $query = "UPDATE files SET 
            title = '$title', 
            description = '$description' 
            WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "File updated successfully.";
        header('Location: ' . ROOT_URL . 'admin/');
        exit();
    } else {
        $_SESSION['error'] = "Database update failed: " . mysqli_error($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid file ID.";
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}
?>
