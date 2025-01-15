<?php

include 'partials/header.php';

//fetch post from databse if id is set
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:' . ROOT_URL . 'category-post.php');
    die();
}
?>

<section class="singlepost">
<div class="container singlepost_container">
    <h2><?= $post['title'] ?></h2>
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
    <div class="singlepost_thumbnail">
        <img src="./images/<?= $post['thumbnail']?>" >
    </div>
    <p>
        <?= $post['body'] ?>
    </p>
</div>
</section>