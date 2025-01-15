<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    // Sanitize and validate the ID
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    if ($id) {
        // Fetch user from the database
        $query = "SELECT * FROM user WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Extract avatar details
            $avatar_name = $user['avatar'];
            $avatar_path = '../images/' . $avatar_name;

            // Delete the avatar if it exists
            if (file_exists($avatar_path) && !empty($avatar_name)) {
                unlink($avatar_path);
            }

            //fetch all thumbnail of user's post and delete them
            $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id=$id ";
            $thumbnail_result = mysqli_query($conn, $thumbnail_query);
            if(mysqli_num_rows($thumbnail_result) > 0 ){
                while($thumbnail = mysqli_fetch_assoc($thumbnail_result)){
                    $thumbnail_path = '../images' . $thumbnail['thumbnail'];
                    //delete thumbnail from images folder is exist
                    if($thumbnail_path){
                        unlink($thumbnail_path);
                    }
                }
            }

            // Delete user from the database
            $delete_user_query = "DELETE FROM user WHERE id=$id";
            $delete_user_result = mysqli_query($conn, $delete_user_query);

            // Check for errors during deletion
            if (mysqli_error($conn)) {
                $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']} {$user['lastname']}'";
            } else {
                $_SESSION['delete-user-success'] = "'{$user['firstname']} {$user['lastname']}' deleted successfully";
            }
        } else {
            $_SESSION['delete-user'] = "User not found.";
        }
    } else {
        $_SESSION['delete-user'] = "Invalid user ID.";
    }
} else {
    $_SESSION['delete-user'] = "No user ID provided.";
}

// Redirect to the manage user page
header('Location: ' . ROOT_URL . 'admin/manage-user.php');
die();
