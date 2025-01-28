<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $file = $_FILES['file_upload'];

    $errors = [];

    // Validate form fields
    if (!$title) $errors[] = "Enter a title for the file.";
    if (empty($file['name'])) $errors[] = "Please choose a file to upload.";

    if (!empty($file['name'])) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Invalid file type. Allowed types: jpg, jpeg, png, pdf, docx.";
        }

        if ($file['size'] > 2_000_000) {
            $errors[] = "File size too big. Must be less than 2MB.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['upload_errors'] = implode(', ', $errors);
        $_SESSION['upload-data'] = ['title' => $title, 'description' => $description];
        header("Location: add-post.php");
        exit();
    }

    // Handle file upload
    $file_name = time() . "_" . basename($file['name']);
    $upload_path = "uploads/" . $file_name;

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Insert file record into the database
        $stmt = $conn->prepare("INSERT INTO files (title, description, file_name) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $title, $description, $file_name);

            if ($stmt->execute()) {
                $_SESSION['upload_success'] = "File uploaded successfully!";
            } else {
                $_SESSION['upload_errors'] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['upload_errors'] = "Failed to prepare the database statement: " . $conn->error;
        }
    } else {
        $_SESSION['upload_errors'] = "Failed to move the uploaded file.";
    }

    header("Location: add-post.php");
    exit();
}
?>
