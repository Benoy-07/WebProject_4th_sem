<?php include('includes/header.php'); 
include('includes/db.php');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
?>

<main class="book-details">
  <div class="details-container">
    <img src="uploads/<?= $book['cover_image'] ?>" class="details-img" alt="<?= $book['title'] ?>">
    <div class="details-info">
      <h2><?= $book['title'] ?></h2>
      <p><strong>Author_ID:</strong> <?= $book['writer_id'] ?></p>
      <p><strong>Category_ID:</strong> <?= $book['category_id'] ?></p>
      <p><strong>Description:</strong> <?= $book['description'] ?></p>

      <!-- Updated Price Section -->
      <div class="book-price-box">
        <p><strong>New Book Price:</strong> <span style="font-weight:bold;">৳<?= number_format($book['price'], 2) ?></span></p>

        <?php if (!empty($book['old_book_price']) && $book['old_book_price'] > 0): ?>
          <p><strong>Old Book Price:</strong> <span style="color:#8e44ad; font-weight:bold;">৳<?= number_format($book['old_book_price'], 2) ?></span></p>
        <?php endif; ?>
      </div>

      <div class="book-actions">
        <a href="add_to_cart.php?id=<?= $book['id'] ?>" class="btn">🛒 Add to Cart</a>
        <a href="add_to_favourite.php?id=<?= $book['id'] ?>" class="btn">❤️ Favourite</a>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
