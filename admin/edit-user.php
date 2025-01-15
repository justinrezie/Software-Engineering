<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Validate that the user exists
    if(!$user){
        header('location:' . ROOT_URL . 'admin/manage-user.php');
        die();
    }
} else {
    header('location:' . ROOT_URL . 'admin/manage-user.php');
    die();
}
?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <!-- Corrected hidden input -->
            <input type="hidden" value="<?= $user['id'] ?>" name="id">
            <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name" required>
            <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name" required>
            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>
            <!-- Corrected submit button -->
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>
