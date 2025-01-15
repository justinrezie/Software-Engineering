<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    ///Update category_id of post that belong to this category to id of uncategorized category

    $update_query = "UPDATE posts SET category_id=3 WHERE category_id=$id";
    $update_resultm = mysqli_query($conn, $query);

    if (!mysqli_errno($conn)){

    //delete category

    $query = "DELETE FROM category WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $_SESSION['delete-category-success'] = "Category deleted successfully";
    }
}
header('location:' . ROOT_URL . 'admin/manage-category.php');