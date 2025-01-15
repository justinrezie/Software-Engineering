<?php
define('ROOT_URL', 'http://localhost/Software%20Engineering/');
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Update with your username
define('DB_PASS', ''); // Update with your password
define('DB_NAME', 'blog'); // Update with your database name

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>

