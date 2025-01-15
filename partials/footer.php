
      <!------CATEGORY BUTTON----------->
<footer>
      <section class="category_buttons">
    <div class="container category_button-container">
        <?php
        $all_categories_query = "SELECT * FROM category";
        $all_categories = mysqli_query($conn, $all_categories_query);
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
        <a href="<?= ROOT_URL?>category-post.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
    <div class="footer_socials">
        <a href="" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="" target="_blank"><i class="uil uil-instagram"></i></a>
        <a href="" target="_blank"><i class="uil uil-telegram"></i></a>
      </div>
      <div class="footer_copyight">
        <small>Copyright &copy; 2025 PhoRn </small>
      </div>
      </section>
    </footer>
    <script src="./js/main.js"></script>
</body>
</html>
    </footer>
    <script src="./js/main.js"></script>
</body>
</html>