<?php
include 'partials/header.php';

// Fetch current user's posts from the database
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=? ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$posts = $stmt->get_result();
?>

<section class="dashboard">
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
                    <a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
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
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-category.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
    <h2>Manage Files</h2>
    <?php
    // Fetch all files from the database
    $stmt = $conn->prepare("SELECT * FROM files ORDER BY created_at DESC");
    $stmt->execute();
    $files = $stmt->get_result();
    ?>

    <?php if ($files->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($file = $files->fetch_assoc()) : ?>
                    <?php
                    // Fetch the category name
                    $current_id = $file['category_id'];
                    $stmt_category = $conn->prepare("SELECT title FROM category WHERE id=?");
                    $stmt_category->bind_param("i", $current_id);
                    $stmt_category->execute();
                    $category_result = $stmt_category->get_result();
                    $description = $category_result->fetch_assoc();
                    ?>
                    <tr>
                        <td><?= $file['title'] ?></td>
                        <td><?= $description['description'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-file.php?id=<?= $file['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-file.php?id=<?= $file['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert_message error">No files found</div>
    <?php endif ?>
</main>
    </div>
</section>

<?php include '../partials/footer.php'; ?>
<script src="../js/main.js"></script>
