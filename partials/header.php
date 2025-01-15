<?php
require 'config/database.php';


if (isset($_SESSION['user-id'])) {
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT avatar FROM user WHERE id=$id";
  $result = mysqli_query($conn, $query);
  $avatar = mysqli_fetch_assoc($result);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="<?= ROOT_URL ?>./css/style.css">
  <title>Document</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
  <nav>
    <div class="container nav_container">
      <a href="<?= ROOT_URL ?>index.php" class="nav_logo">Norton</a>
      <ul class="nav_items">
        <!-- <li><a href="<?= ROOT_URL ?>content.php">សៀវភៅ</a></li> -->
        <li><a href="<?= ROOT_URL ?>about.php">ថ្នាក់</a></li>
        <li><a href="<?= ROOT_URL ?>content.php">Content</a></li>
        <!-- Show 'Signin' only if the user is not logged in -->
        <?php if (!isset($_SESSION['user-id'])): ?>
          <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
        <?php endif; ?>

        <!-- Display profile and logout if logged in -->
        <?php if (isset($_SESSION['user-id'])): ?>
          <li class="nav_profile"> 
            <div class="avatar">
              <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="User Avatar">
            </div>
            <ul>
            <?php if(isset($_SESSION['user_is_admin'])): ?>
              <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
              <?php endif?>
              <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
      <button id="open_nav-btn"><i class="uil uil-bars"></i></button>
      <button id="close_nav-btn"><i class="uil uil-times"></i></button>
    </div>
  </nav>
  <script src="../js/main.js"></script>
</body>
</html>