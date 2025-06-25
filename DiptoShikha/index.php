<?php
include('includes/header.php');
include('includes/db.php');

// Fetch all categories
$categories = [];
$cat_stmt = $conn->prepare("SELECT id, name FROM categories");
$cat_stmt->execute();
$cat_result = $cat_stmt->get_result();

while ($row = $cat_result->fetch_assoc()) {
  $categories[] = $row;
}
?>

<!-- Background Image -->
<main>
  
  <section class="hero-banner">
    <div class="overlay">
      <div class="hero-text">
        <h1>Welcome to DiptoShikha</h1>
        <p>Discover a world of books to read, learn, and grow.</p>
      </div>
    </div>
  </section>

  <!-- Book Categories -->
  <?php foreach ($categories as $category): ?>
    <section class="featured">
      <h2><?= htmlspecialchars($category['name']) ?></h2>
      <div class="book-grid">
        <?php
        $stmt = $conn->prepare("SELECT b.*, w.name AS writer FROM books b 
                                LEFT JOIN writers w ON b.writer_id = w.id 
                                WHERE b.category_id = ?");
        $stmt->bind_param("i", $category['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
          while ($book = $result->fetch_assoc()):
        ?>


        <div class="book">
          <a href="book.php?id=<?= $book['id'] ?>">
            <img src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
          </a>
          <h3><?= htmlspecialchars($book['title']) ?></h3>
          <p><?= htmlspecialchars($book['writer']) ?></p>
          <div class="book-price">
            <?php if (!empty($book['old_price'])): ?>
              <span class="old-price">৳<?= $book['old_price'] ?></span>
            <?php endif; ?>
            <span class="new-price">৳<?= $book['price'] ?></span>
          </div>
          <div class="book-actions">
            <a href="add_to_cart.php?id=<?= $book['id'] ?>" class="btn">🛒</a>
            <a href="add_to_favourite.php?id=<?= $book['id'] ?>" class="btn">❤️</a>
          </div>
        </div>
        <?php endwhile; else: ?>
          <div class="book">
            <p>No books available in this category.</p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<?php include('includes/footer.php'); ?>