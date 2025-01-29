<?php
session_start();
include 'partials/header.php';
require 'config/database.php';

// Fetch categories (if needed)
$query = "SELECT * FROM `category`";
$category_result = mysqli_query($conn, $query);

// Fetch previous form data (if any)
$title = $_SESSION['upload-data']['title'] ?? null;
$description = $_SESSION['upload-data']['description'] ?? null;
unset($_SESSION['upload-data']);
?>
<section class="form_section">
    <form action="add-post-logic.php" enctype="multipart/form-data" method="POST">
    <input type="text" name="title" placeholder="Title">
    <textarea name="description" placeholder="Description"></textarea>
    <input type="file" name="file_upload">
    <button type="submit" name="submit" class="btn">Upload</button>
    </form>
</section>

<!-- Display Error or Success Messages -->
<?php
if (isset($_SESSION['upload_errors'])) {
    echo "<p style='color:red'>" . $_SESSION['upload_errors'] . "</p>";
    unset($_SESSION['upload_errors']);
}

if (isset($_SESSION['upload_success'])) {
    echo "<p style='color:green'>" . $_SESSION['upload_success'] . "</p>";
    unset($_SESSION['upload_success']);
}
?>
<?php include 'partials/footer.php'; ?>
