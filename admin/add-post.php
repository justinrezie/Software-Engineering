<?php
session_start();
include 'partials/header.php';

// Fetch category from database
$query = "SELECT * FROM `category` ";
$category_result = mysqli_query($conn, $query);

//fetch back form data form was invaild
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

//delete
unset($_SESSION['add-post-data']);
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Add Post</h2>
        <div class="alert_message error">
            <p>This is an error message</p>
        </div>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title?>" placeholder="Title">
            <select name="category">
                <?php while($category_row = mysqli_fetch_assoc($category_result)) : ?>
                    <option value="<?= $category_row['id'] ?>"><?= $category_row['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" value="<?= $body?>"  placeholder="Body"></textarea>
            <?php if(isset($_SESSION['user_is_admin'])):?>
            <div class="form_control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            <div class="form_control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" value="Upload" class="btn">Add Post</button>
        </form>
    </div>
</section>

<?php
include 'partials/footer.php';
?>
<script src="../js/main.js"></script>
