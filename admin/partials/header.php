<?php
require '../config/database.php';

session_start(); // Add this if it's not already in the header
require '../partials/header.php';

if (!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}
?>
