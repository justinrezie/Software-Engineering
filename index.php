<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user-id'])) {
    header('Location: signin.php');
    exit();
}
include 'partials/header.php';

// Fetch featured post
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// Fetch 5 posts
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 10";
$post = mysqli_query($conn, $query);

function fetchCategory($conn, $category_id) {
    $category_query = "SELECT * FROM category WHERE id=$category_id";
    $category_result = mysqli_query($conn, $category_query);
    return mysqli_fetch_assoc($category_result);
}
$query = "SELECT * FROM files ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!-- FEATURED POST -->
<?php if (mysqli_num_rows($featured_result) == 1) : ?>
<section class="featured">
    <div class="container featured_container">
        <div class="post_thumbnail">
            <img src="images/Information-Technology.jpg" alt="">
            <!-- <img src="images/<?= $featured['thumbnail'] ?>"> -->
        </div>
        <div class="post_info">
            <?php
            $category = fetchCategory($conn, $featured['category_id']);
            ?>
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $featured['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
            <h2 class="post_title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
            <p class="post_body"><?= substr($featured['body'], 0, 200) ?>...</p>
            <div class="post_author">
                <?php
                $author_id = $featured['author_id'];
                $author_query = $conn->prepare("SELECT * FROM user WHERE id = ?");
                $author_query->bind_param("i", $author_id);
                $author_query->execute();
                $author_result = $author_query->get_result();
                $author = $author_result->fetch_assoc();
                ?>
                <div class="post_author-info">
                    <h5>BY: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                    <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>
<!-- POSTS -->
<section class="files_section">
    <h1>Uploaded Files</h1>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="files_grid">
            <?php while ($file = mysqli_fetch_assoc($result)): ?>
                <div class="file_card">
                    <h3><?= htmlspecialchars($file['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($file['description'])) ?></p>
                    <p><strong>Uploaded At:</strong> <?= date("M d, Y - H:i", strtotime($file['created_at'])) ?></p>

                    <!-- View File Button -->
                    <!-- Download File Button -->
                    <!-- Download File Button -->
                    <a href="download_file.php?file=yourfile.pdf" class="btn">Download PDF</a>
                    </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No files found.</p>
    <?php endif; ?>
</section>


<?php include './partials/footer.php'; ?>
<script src="./js/main.js"></script>