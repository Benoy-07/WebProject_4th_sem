<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if database connection is valid
if (!$conn) {
    die("Database connection failed: " . (isset($conn) ? $conn->connect_error : "Connection not established"));
}

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT books.*, cart.quantity FROM cart 
    JOIN books ON books.id = cart.book_id 
    WHERE cart.user_id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$query = $stmt->get_result();

$total = 0;
$cart_items = [];
while ($book = $query->fetch_assoc()) {
    $total += $book['price'] * $book['quantity'];
    $cart_items[] = $book;
}
$query->data_seek(0); // Reset pointer for display
?>

<?php include('includes/header.php'); ?>

<main class="page-section">
  <h2>🛒 My Cart</h2>
  <div class="book-grid">
    <?php if (count($cart_items) > 0): ?>
      <?php foreach ($cart_items as $book): ?>
        <div class="book">
          <img src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
          <h3><?= htmlspecialchars($book['title']) ?></h3>
          <p>৳<?= $book['price'] ?> x <?= $book['quantity'] ?> = <strong>৳<?= $book['price'] * $book['quantity'] ?></strong></p>

          <!-- ❌ Remove button -->
          <a href="remove_from_cart.php?book_id=<?= $book['id'] ?>" 
             onclick="return confirm('Are you sure you want to remove this book from cart?')"
             style="display: inline-block; margin-top: 10px; color: white; background-color: red; padding: 5px 10px; border-radius: 5px; text-decoration: none;">
            ❌ Remove
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Your cart is empty.</p>
    <?php endif; ?>
  </div>

  <div style="text-align:center; margin-top: 20px;">
    <?php if (count($cart_items) > 0): ?>
      <?php
      // Generate a temporary order_id (replace with real order creation logic)
      $order_id = uniqid("ORDER_");
      ?>
      <a href="payment.php?order_id=<?= urlencode($order_id) ?>&total=<?= urlencode($total) ?>" class="checkout-btn" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">Proceed to Checkout</a>
    <?php endif; ?>
  </div>
</main>

<?php include('includes/footer.php'); ?>