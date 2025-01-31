<?php
require 'config/database.php';
session_start(); // Ensure session is started

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Check if category exists before attempting to update or delete
    $check_category_query = "SELECT id FROM category WHERE id = $id";
    $check_category_result = mysqli_query($conn, $check_category_query);

    if (mysqli_num_rows($check_category_result) > 0) {
        // Update category_id of posts belonging to this category
        $update_query = "UPDATE posts SET category_id = 3 WHERE category_id = $id";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Delete the category
            $delete_query = "DELETE FROM category WHERE id = $id LIMIT 1";
            $delete_result = mysqli_query($conn, $delete_query);

            if ($delete_result) {
                $_SESSION['delete-category-success'] = "Category deleted successfully.";
            } else {
                $_SESSION['delete-category-error'] = "Failed to delete category.";
            }
        } else {
            $_SESSION['delete-category-error'] = "Failed to update posts for the category.";
        }
    } else {
        $_SESSION['delete-category-error'] = "Category does not exist.";
    }
} else {
    $_SESSION['delete-category-error'] = "Invalid category ID.";
}

header('Location: ' . ROOT_URL . 'admin/manage-category.php');
exit;
