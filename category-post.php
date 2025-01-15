<?php
include 'partials/header.php';

// Fetch posts if ID is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch category
    $category_query = $conn->prepare("SELECT * FROM category WHERE id = ?");
    $category_query->bind_param("i", $id);
    $category_query->execute();
    $category_result = $category_query->get_result();
    $category = $category_result->fetch_assoc();

    if (!$category) {
        header('location: ' . ROOT_URL . 'cetegory-post.php');
        die();
    }

    // Fetch posts
    $query = $conn->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY date_time DESC");
    $query->bind_param("i", $id);
    $query->execute();
    $posts = $query->get_result();
} else {
    header('location: ' . ROOT_URL . 'category-post.php');
    die();
}
?>

<!------CATEGORY TITLE----------->
<header class="category_title">
    <h2><?= $category['title'] ?></h2>
</header>
<!------END OF CATEGORY TITLE----------->

<!------POST----------->
<section class="posts">
    <div class="container posts_container">
        <?php while ($row = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post_thumbnail">
                    <img src="./images/<?= $row['thumbnail'] ?>">
                </div>
                <div class="post_info">
                    <a href="<?= ROOT_URL ?>category-post.php?id=<?= $row['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                    <h2 class="post_title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a>
                    </h2>
                    <p class="post_body"><?= substr($row['body'], 0, 150) ?>...</p>
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
                            <img src="./images/<?= $author['avatar'] ?>">
                        </div>
                        <div class="post_author-info">
                            <h5>BY: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($row['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<!------END OF POST----------->

<!------CATEGORY BUTTON----------->

<!------END OF CATEGORY BUTTON----------->

<?php include 'partials/footer.php'; ?>
<script src="./main.js"></script>
</body>
</html>
