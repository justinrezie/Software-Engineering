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

// Fetch 9 posts
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$post = mysqli_query($conn, $query);

function fetchCategory($conn, $category_id) {
    $category_query = "SELECT * FROM category WHERE id=$category_id";
    $category_result = mysqli_query($conn, $category_query);
    return mysqli_fetch_assoc($category_result);
}
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
<section class="posts">
    <div class="container posts_container">
        <?php while ($thumbnail = mysqli_fetch_assoc($post)) : ?>
        <article class="post">
            <div class="post_thumbnail">
                <img src="images/hero-css.png" alt="">
                <!-- <img src="images/<?= $thumbnail['thumbnail'] ?>" > -->
            </div>
            <div class="post_info">
                <?php $category = fetchCategory($conn, $thumbnail['category_id'])?>
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $thumbnail['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                <h2 class="post_title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $thumbnail['id'] ?>"><?= $thumbnail['title'] ?></a>
                </h2>
                <p class="post_body"><?= substr($thumbnail['body'], 0, 150) ?>...
                <div class="post_author">
                    <?php
                    $author_id = $thumbnail['author_id'];
                    $author_query = $conn->prepare("SELECT * FROM user WHERE id = ?");
                    $author_query->bind_param("i", $author_id);
                    $author_query->execute();
                    $author_result = $author_query->get_result();
                    $author = $author_result->fetch_assoc();
                    ?>
                    <div class="post_author-avatar">
                        <img src="images/<?= $author['avatar']?>">
                    </div>
                    <div class="post_author-info">
                        <h5>BY: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($thumbnail['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </article>
        <?php endwhile ?>
    </div>
</section>

<?php include './partials/footer.php'; ?>
<script src="./js/main.js"></script>