<?php
include '../config/database.php';
session_start();

// Ensure the ID is set and is valid
if (isset($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $previous_file_name = $_POST['previous_file_name'];
    $previous_thumbnail_name = $_POST['previous_thumbnail_name'];

    // Handle file upload (if a new file is uploaded)
    $file_name = $previous_file_name;
    $thumbnail_name = $previous_thumbnail_name;

    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['file_upload']['tmp_name'];
        $file_name = $_FILES['file_upload']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = uniqid('file_', true) . '.' . $file_ext;
        $file_upload_path = '../uploads/' . $file_new_name;

        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($file_tmp_name, $file_upload_path)) {
            // Delete the old file if it's being replaced
            if (file_exists('../uploads/' . $previous_file_name)) {
                unlink('../uploads/' . $previous_file_name);
            }
        } else {
            $_SESSION['error'] = "File upload failed.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    // Handle thumbnail upload if needed
    if (isset($_FILES['thumbnail_upload']) && $_FILES['thumbnail_upload']['error'] === UPLOAD_ERR_OK) {
        $thumbnail_tmp_name = $_FILES['thumbnail_upload']['tmp_name'];
        $thumbnail_name = $_FILES['thumbnail_upload']['name'];
        $thumbnail_ext = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
        $thumbnail_new_name = uniqid('thumb_', true) . '.' . $thumbnail_ext;
        $thumbnail_upload_path = '../uploads/' . $thumbnail_new_name;

        // Move the uploaded thumbnail to the uploads folder
        if (move_uploaded_file($thumbnail_tmp_name, $thumbnail_upload_path)) {
            // Delete the old thumbnail if it's being replaced
            if (file_exists('../uploads/' . $previous_thumbnail_name)) {
                unlink('../uploads/' . $previous_thumbnail_name);
            }
        } else {
            $_SESSION['error'] = "Thumbnail upload failed.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    // Update the file information in the database
    $query = "UPDATE files SET 
            title = '$title', 
            description = '$description', 
            file_name = '$file_name', 
            thumbnail_name = '$thumbnail_name' 
            WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "File updated successfully.";
        header('Location: ' . ROOT_URL . 'admin/manage-files.php');
        exit();
    } else {
        $_SESSION['error'] = "Database update failed: " . mysqli_error($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid file ID.";
    header('Location: ' . ROOT_URL . 'admin/manage-files.php');
    exit();
}
?>
