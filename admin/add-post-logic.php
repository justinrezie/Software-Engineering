<?php
require 'config/database.php';
session_start();

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Validate input data
    $errors = [];
    if (!$title) $errors[] = "Enter post title";
    if (!$category_id) $errors[] = "Select post category";
    if (!$body) $errors[] = "Enter post body";
    if (!isset($thumbnail['tmp_name']) || empty($thumbnail['tmp_name'])) $errors[] = "Choose a valid post thumbnail";

    // Validate and process thumbnail
    if (empty($errors)) {
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $thumbnail_name = time() . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_files)) {
            $errors[] = "Unsupported file type. Allowed types: png, jpg, jpeg.";
        } elseif ($thumbnail['size'] >= 2_000_000) {
            $errors[] = "File size too big. Should be less than 2MB.";
        } else {
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
        }
    }

    // Redirect if errors
    if (!empty($errors)) {
        $_SESSION['add-post'] = implode(", ", $errors);
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    // Update is_featured if needed
    if ($is_featured) {
        $conn->query("UPDATE posts SET is_featured=0");
    }

    // Insert post
    $stmt = $conn->prepare("INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiii", $title, $body, $thumbnail_name, $category_id, $author_id, $is_featured);
    $stmt->execute();

    if ($stmt->errno) {
        $_SESSION['add-post'] = "Failed to add the post. Please try again.";
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    $_SESSION['add-post-success'] = "New post added successfully";
    header('location:' . ROOT_URL . 'admin/');
    die();
}
