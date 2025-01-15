<?php
require 'config/constants.php';
session_start();

// Destroy the session
session_destroy();

// Redirect to the homepage or any page after logging out
header('location:' . ROOT_URL); // Redirects to the homepage or your desired page
exit;
?>
