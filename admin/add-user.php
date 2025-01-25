<?php
include 'partials/header.php';
require 'config/constants.php';

// Get back form data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

// Delete signup data session
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Sign Up</title>

    <!-- IconScout -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Add User</h2>
        <?php if (isset($_SESSION['signup'])): ?> 
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['signup']; ?>
                    <?php unset($_SESSION['signup']); ?>
                </p>
            </div>
        <?php endif; ?>
        
        <form action="add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname) ?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname) ?>" placeholder="Last Name">
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Username">
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword) ?>" placeholder="Create Password">
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword) ?>" placeholder="Confirm Password">
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form_control">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
        </form>
    </div>
</section>
</body>
</html>
