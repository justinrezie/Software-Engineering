<?php
include 'partials/header.php';

// Fetch categories from the database
$category_query = "SELECT * FROM `category`";
$category_result = mysqli_query($conn, $category_query);

//fetch post data from database if id is set
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:' . ROOT_URL . 'admin/');
    die();
}
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" 
        method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">
            <select name="category">
    <?php while($category = mysqli_fetch_assoc($category_result)) : ?>
        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $post['category_id']) ? 'selected' : '' ?>>
            <?= $category['title'] ?>
        </option>
    <?php endwhile ?>
</select>

            <textarea name="body" rows="10" placeholder="Body"><?= $post['body'] ?></textarea>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>
<script src="../js/main.js"></script>
