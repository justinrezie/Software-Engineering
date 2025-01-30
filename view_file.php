<?php
include 'partials/header.php';

// // Check if a file path is provided
// if (!isset($_GET['file']) || empty($_GET['file'])) {
//     echo "Invalid file request.";
//     exit;
// }

// $filePath = urldecode($_GET['file']);

// Fetch only image title and description from the database
$query = $conn->prepare("SELECT title, description FROM files WHERE file_name = ? LIMIT 1");
$query->bind_param("s", $filePath);
$query->execute();
$result = $query->get_result();

// if ($result->num_rows === 0) {
//     echo "File not found.";
//     exit;
// }

$file = $result->fetch_assoc();
?>

    <section class="files_section">
        <h1>Image Details</h1>
        <div class="file_details_card">
        <h3><?= htmlspecialchars($file['title']) ?></h3>
                <p><?= substr ($file['description'], 0 , 10) ?>...</p>

                <?php 
                $fileDate = date("Y-m-d", strtotime($file['uploaded_at']));
                $today = date("Y-m-d");
                if ($fileDate === $today): ?>
                    <p>Uploaded Today at <?= date("g:i A", strtotime($file['uploaded_at'])) ?></p>
                <?php else: ?>
                    <p><?= date("F j, Y \a\\t g:i A", strtotime($file['uploaded_at'])) ?></p>
                <?php endif; ?>

            <a href="index.php" class="btn">Back to Files</a>
        </div>
    </section>
</body>
</html>
