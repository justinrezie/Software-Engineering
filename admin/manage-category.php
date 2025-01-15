<?php
include 'partials/header.php';

// Fetch categories from database
$query = "SELECT * FROM `category` ORDER BY title";
$category = mysqli_query($conn, $query);

if (!$category) {
    die('Query Failed: ' . mysqli_error($conn));
}
?>
<section class="dashboard">

<?php if (isset($_SESSION['add-category-success'])) : // Show if edit was successful ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-category'])) : // Show if edit was successful ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-category'])) : // Show if edit was successful ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-category'])) : // Show if edit was successful ?>
        <div class="alert_message succees container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['delete-category'])) : // Show if deleted was successful ?>
        <div class="alert_message succees container">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['edit-category'])) : // Show if edit was successful ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['delete-category'];
                unset($_SESSION['delete-category']);
                ?>
            </p>
        </div>
        <?php endif?>
        

    <div class="container dashboard_container">
        <button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-category.php" class="active"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if (mysqli_num_rows($category) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($category)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $row['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $row['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert_message error">No category found</div>
            <?php endif ?>
        </main>
    </div>
</section>
<script src="../js/main.js"></script>
