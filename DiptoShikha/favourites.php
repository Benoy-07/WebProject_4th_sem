<?php
session_start();
include('includes/db.php');
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT books.* FROM favourites JOIN books ON books.id = favourites.book_id WHERE favourites.user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<main class="page-section">
  <h2>❤️ My Favourites</h2>
  <div class="book-grid">
    <?php while ($book = $result->fetch_assoc()): ?>
      <div class="book-card" id="fav-book-<?= $book['id'] ?>">
        <img src="uploads/<?= $book['cover_image'] ?>" alt="">
        <h3><?= $book['title'] ?></h3>
        <p>৳<?= $book['price'] ?></p>
        <button class="btn add-to-cart" data-id="<?= $book['id'] ?>">🛒 Add to Cart</button>
        <button class="btn remove-fav" data-id="<?= $book['id'] ?>">🗑 Remove</button>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<script>
document.querySelectorAll('.add-to-cart').forEach(btn => {
  btn.addEventListener('click', function () {
    const bookId = this.dataset.id;
    fetch(`add_to_cart.php?id=${bookId}`)
      .then(res => res.text())
      .then(data => {
        if (data.trim() === "success") {
          alert("Added to cart");
        }
      });
  });
});

document.querySelectorAll('.remove-fav').forEach(btn => {
  btn.addEventListener('click', function () {
    const bookId = this.dataset.id;
    fetch(`remove_from_favourite.php?id=${bookId}`)
      .then(res => res.text())
      .then(data => {
        if (data.trim() === "removed") {
          document.getElementById('fav-book-' + bookId).remove();
        }
      });
  });
});
</script>

<?php include('includes/footer.php'); ?>
