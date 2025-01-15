<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $createpassword = $_POST['createpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $avatar = $_FILES['avatar'];

    // Validate inputs
    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your User Name";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please enter a valid email";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password should be 8 characters";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please add an avatar";
    } else {
        // Check if passwords match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match";
        } else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check for existing username or email
            $user_check_query = "SELECT * FROM `user` WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($conn, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exists";
            } else {
                
                // Handle avatar upload
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                if ($avatar['error'] === UPLOAD_ERR_OK) {
                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

                    if (in_array($extension, $allowed_files)) {
                        if ($avatar['size'] < 1000000) {
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);

                            // Insert user into the database
                            $insert_user_query = "INSERT INTO `user` (firstname, lastname, username, email, password, avatar, is_admin)
                                VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
                            $insert_user_result = mysqli_query($conn, $insert_user_query);

                            if (!mysqli_errno($conn)) {
                                $_SESSION['signup-success'] = "Registration successful, please log in";
                                header('location: ' . ROOT_URL . 'signin.php');
                                die();
                            }
                        } else {
                            $_SESSION['signup'] = "File size too big";
                        }
                    } else {
                        $_SESSION['signup'] = "File should be png, jpg, or jpeg";
                    }
                } else {
                    $_SESSION['signup'] = "File upload error";
                }
            }
        }
    }

    // Redirect back to signup page if there was an issue
    if (isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }
}
?>
