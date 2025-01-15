<?php
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
<section class="search_bar">
        <form class="container search_bar-container" action="">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="" placeholder="Search">
            </div>
            <button type="submit" class="btn">GO</button>
        </form>
    </section>

<!-- POSTS -->
<section class="posts">
    <div class="container posts_container">
        <?php while ($row = mysqli_fetch_assoc($post)) : ?>
        <article class="post">
            <div class="post_thumbnail">
                <img src="images/Best-React-Courses-min.png.webp">
            </div>
            <div class="post_info">
                <?php $category = fetchCategory($conn, $row['category_id'])?>
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $row['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                <h2 class="post_title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a>
                </h2>
                <p class="post_body"><?= substr($row['body'], 0, 150) ?>...
                <div class="post_author">
                    <?php
                    $author_id = $row['author_id'];
                    $author_query = $conn->prepare("SELECT * FROM user WHERE id = ?");
                    $author_query->bind_param("i", $author_id);
                    $author_query->execute();
                    $author_result = $author_query->get_result();
                    $author = $author_result->fetch_assoc();
                    ?>
                    <div class="post_author-avatar">
                        <img src="./images/<?= $author['avatar']?>">
                    </div>
                    <div class="post_author-info">
                        <h5>BY: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($row['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </article>
        <?php endwhile ?>
    </div>
</section>

    <!------CATEGORY BUTTON----------->

    <section class="category_buttons">
    <div class="container category_button-container">
        <?php
        $all_categories_query = "SELECT * FROM category";
        $all_categories = mysqli_query($conn, $all_categories_query);
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?= ROOT_URL?>category-post.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
    </section>
<?php include './partials/footer.php'; ?>
<script src="./js/main.js"></script>