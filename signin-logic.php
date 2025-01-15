<?php
session_start();
error_log('Session Data on signin-logic.php: ' . print_r($_SESSION, true));  // Debugging session data

if (isset($_POST['submit'])) {
    $username_or_email = filter_var($_POST['username_or_email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    error_log("Received username_or_email: $username_or_email");
    error_log("Received password: $password");

    if (empty($username_or_email) || empty($password)) {
        $_SESSION['signin'] = "Please provide both username/email and password.";
        header('Location: signin.php');
        exit();
    }
    
    require 'config/database.php';

    $sql = "SELECT * FROM `user` WHERE username=? OR email=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        $_SESSION['signin'] = "An error occurred. Please try again.";
        header('Location: signin.php');
        exit();
    }

    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        error_log("Error executing query: " . $stmt->error);
        $_SESSION['signin'] = "An error occurred. Please try again.";
        header('Location: signin.php');
        exit();
    }

    error_log("Number of rows found: " . $result->num_rows);

    if ($result->num_rows === 1) {
        $user_record = $result->fetch_assoc();
        error_log("User record found: " . print_r($user_record, true));

        $db_password = $user_record['password'];
        if (password_verify($password, $db_password)) {
            error_log("Password verified successfully.");

            $_SESSION['user-id'] = $user_record['id'];
            if ($user_record['is_admin'] == 1) {
                $_SESSION['user_is_admin'] = true;
            }

            header('Location: ' . ROOT_URL );
            exit();
        } else {
            error_log("Password verification failed.");
            $_SESSION['signin'] = "Incorrect password.";
        }
    } else {
        error_log("No user found with that username/email.");
        $_SESSION['signin'] = "No user found with that username/email.";
    }

    header('Location: signin.php');
    exit();
}
?>
