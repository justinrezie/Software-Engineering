<?php
require 'config/database.php';
session_start(); // Ensure session is started
if (isset($_POST['submit'])) {
    // Data sanitization and initialization
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? 1 : 0;

    // Validate form data
    if(!$title) {
        $_SESSION['edit-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Enter post body";
    } else {
        // Handle thumbnail if a new one is uploaded
        if($thumbnail['name']) {
            $previous_thumbnail_name = '../images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_name)) {
                unlink($previous_thumbnail_name);
            }

            // Validate and move the uploaded thumbnail
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

            if (in_array($extension, $allowed_files)) {
                if ($thumbnail['size'] < 2000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "File size too big. Should be less than 2MB";
                }
            } else {
                $_SESSION['edit-post'] = "Invalid file type. Only PNG, JPG, and JPEG are allowed.";
            }
        }
    }

    // Redirect if there's an error
    if (isset($_SESSION['edit-post'])) {
        header('Location: ' . ROOT_URL . '/admin');
        unset($_SESSION['edit-post']);
        die();
    } else {
        // Reset other posts' is_featured to 0 if current post is featured
        if ($is_featured == 1) {
            $query = "UPDATE posts SET is_featured = 0 WHERE id != $id";
            mysqli_query($conn, $query);
        }

        // Insert thumbnail and update post
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        $query = "UPDATE posts SET title = ?, body = ?, thumbnail = ?, category_id = ?, is_featured = ? WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssiis', $title, $body, $thumbnail_to_insert, $category_id, $is_featured, $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION['edit-post-success'] = "Post edited successfully";
            header('Location: ' . ROOT_URL . '/admin');
            unset($_SESSION['edit-post']);
            die();
        }
    }
}
