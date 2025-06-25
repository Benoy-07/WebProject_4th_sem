<?php
include('includes/header.php');
include('includes/db.php');

$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get category name
$stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$category_result = $stmt->get_result();
$category = $category_result->fetch_assoc();
$category_name = $category['name'] ?? "Unknown Category";
?>

<main class="category-books">
  <section class="page-title">
    <h1>📚 Books in <?= htmlspecialchars($category_name) ?></h1>
  </section>

  <section class="book-grid">
    <?php
    $stmt = $conn->prepare("SELECT * FROM books WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
      while ($book = $result->fetch_assoc()):
        $imagePath = 'assets/images/' . $book['cover_image'];
        if (!file_exists($imagePath) || empty($book['cover_image'])) {
            $imagePath = 'assets/images/default.png'; // ডিফল্ট ইমেজ
        }
    ?>
      <div class="book">
        <a href="book.php?id=<?= $book['id'] ?>">
          <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($book['title']) ?>">
        </a>
        <h3><?= htmlspecialchars($book['title']) ?></h3>
        <p>Writer ID: <?= $book['writer_id'] ?></p>
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
      <p>No books found in this category.</p>
    <?php endif; ?>
  </section>
</main>

<?php include('includes/footer.php'); ?>
