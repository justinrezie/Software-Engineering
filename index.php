<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user-id'])) {
    header('Location: signin.php');
    exit();
}
include 'partials/header.php';

// //Fetch featured post
// $featured_query = "SELECT * FROM post WHERE is_featured=1";
// $featured_result = mysqli_query($conn, $featured_query);
// $featured = mysqli_fetch_assoc($featured_result);

// // Fetch 5 posts
// $query = "SELECT * FROM post ORDER BY date_time DESC LIMIT 10";
// $post = mysqli_query($conn, $query);

// function fetchCategory($conn, $category_id) {
//     $category_query = "SELECT * FROM category WHERE id=$category_id";
//     $category_result = mysqli_query($conn, $category_query);
//     return mysqli_fetch_assoc($category_result);
// }
$query = "SELECT * FROM files ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $query);
?>
<div class="container">
<!-- FEATURED POST -->
<section class="featured">
    <div class="container featured_container">
        <div class="post_thumbnail">
            <img src="images/hero-css.png" alt="">
        </div>
        <div class="post_info">
            <a href="category-post.html" class="category_button">Wild Life</a>
            <h2 class="post_title"><a href="about.html">Technology</a></h2>
            <p class="post_body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium mollitia amet esse magnam molestiae sequi cumque blanditiis fuga. Natus impedit cupiditate facilis ipsum rem voluptatum a, sint asperiores minus magnam!</p>
            <div class="post_author">
            
        </div>
        </div>
    </section>

<!-- POSTS -->

<section class="files_section">
<h1>Files</h1>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="files_grid">
        <?php while ($file = $result->fetch_assoc()): ?>
            <div class="file_card">
                <img src="images/Very Basic Image file.png" alt="File Image" style="width: 10%; height: auto;">
                <h3><?= htmlspecialchars($file['title']) ?></h3>
                <p><?= substr ($file['description'], 0 , 10) ?>...</p>

                <?php 
                $fileDate = date("Y-m-d", strtotime($file['uploaded_at']));
                $today = date("Y-m-d");
                if ($fileDate === $today): ?>
                    <p>Uploaded Today at <?= date("g:i A", strtotime($file['uploaded_at'])) ?></p>
                <?php else: ?>
                    <p><?= date("F j, Y \a\\t g:i A", strtotime($file['uploaded_at'])) ?></p>
                <?php endif; ?>

                <a href="view_file.php?file=<?= urlencode($file['file_path']) ?>" class="btn" target="_blank">View File</a>
                </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No files found.</p>
<?php endif; ?>
</section>


</div>
<?php include './partials/footer.php'; ?>
<script src="./js/main.js"></script>