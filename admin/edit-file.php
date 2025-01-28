<?php
include 'partials/header.php';
require 'config/database.php';

// Fetch categories from the database
$category_query = "SELECT * FROM `files`";
$category_result = mysqli_query($conn, $category_query);

// Fetch file data from the database if ID is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $file = mysqli_fetch_assoc($result);
} else {
    header('Location: ' . ROOT_URL . 'admin/manage-files.php');
    die();
}
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit File</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert_message error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert_message success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="<?= ROOT_URL ?>admin/edit-file-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $file['id'] ?>">
            <input type="hidden" name="previous_file_name" value="<?= $file['file_name'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $file['thumbnail_name'] ?>">

            <label for="title">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($file['title']) ?>" placeholder="Title" required>

            <label for="description">Description</label>
            <textarea name="description" rows="5" placeholder="Description" required><?= htmlspecialchars($file['description']) ?></textarea>


            <div class="form_control">
                <label for="file_upload">Change File</label>
                <input type="file" name="file_upload" id="file_upload">
            </div>
            <button type="submit" name="submit" class="btn">Update File</button>
        </form>
    </div>
</section>

<script src="../js/main.js"></script>
