<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<main class="category-page">
  <section class="page-title">
    <h1>📂 Book Categories</h1>
    <p>Explore books by different categories.</p>
  </section>

  <section class="category-list">
  <?php
  $result = $conn->query("SELECT * FROM categories");
  if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
      $cat_id = $row['id'];
      $cat_name = htmlspecialchars($row['name']);
  ?>
    <a href="books_by_category.php?id=<?= $cat_id ?>" class="category-card">
      <?= $cat_name ?>
    </a>
  <?php
    endwhile;
  else:
  ?>
    <p>No categories found.</p>
  <?php endif; ?>
  </section>
</main>

<?php include('includes/footer.php'); ?>
