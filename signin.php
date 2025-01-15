<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Sign In</title>
  </head>
  <body>
    <section class="form_section">
      <div class="container form_section-container">
        <h2>Sign In</h2>
        <?php if (isset($_SESSION['signin'])): ?>
          <div class="alert_message error">
            <p><?php echo $_SESSION['signin']; ?></p>
          </div>
        <?php endif ?>
        <form action="signin-logic.php" method="POST">
          <input type="text" name="username_or_email" placeholder="Username or Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" name="submit" class="btn">Sign In</button>
        </form>
        <small>Don't has account? <a href="signup.php">Sign Up <a/></small>
      </div>
    </section>
  </body>
</html>
