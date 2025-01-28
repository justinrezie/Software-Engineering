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
        <input type="text" name="title" placeholder="File Title" value="<?= htmlspecialchars($title) ?>">
        <textarea name="description" placeholder="Description"><?= htmlspecialchars($description) ?></textarea>
        <label for="file_upload">Choose File:</label>
        <input type="file" name="file_upload" id="file_upload">
        <button type="submit" name="submit" value="Upload" class="btn">Upload File</button>
    </form>
</section>

<!-- Display Error or Success Messages -->
<?php if (isset($_SESSION['upload_errors'])): ?>
    <p class="alert_message error"><?= $_SESSION['upload_errors'] ?></p>
    <?php unset($_SESSION['upload_errors']); ?>
<?php elseif (isset($_SESSION['upload_success'])): ?>
    <p class="alert_message success"><?= $_SESSION['upload_success'] ?></p>
    <?php unset($_SESSION['upload_success']); ?>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>
