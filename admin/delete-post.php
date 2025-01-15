<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch post from database in order to delete thumbnail from image folder
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);

    //make sure only 1 record/post was fetch
    if(mysqli_num_rows($result) == 1){
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;

        if($thumbnail_path){
            unlink($thumbnail_path);

            //delete post from database
            $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($conn, $delete_post_query);

            if(!mysqli_errno($conn)){
                $_SESSION['delete-post-success'] = "Post deleted successfuly";
            }
        }
    }
}
header('locattion:' . ROOT_URL . 'admin/');
die();