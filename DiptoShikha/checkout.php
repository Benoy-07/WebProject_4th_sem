<?php
session_start();
include('includes/db.php');
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: signin.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$cart_query = $conn->query("SELECT books.*, cart.quantity FROM cart JOIN books ON books.id = cart.book_id WHERE cart.user_id = $user_id");

$total = 0;
?>

<main class="page-section">
  <div class="container">
    <h2>🛒 Checkout</h2>

    <form action="place_order.php" method="POST">
      <table class="checkout-table">
        <tr>
          <th>Book</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Total</th>
        </tr>

        <?php while ($item = $cart_query->fetch_assoc()):
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
        ?>
          <tr>
            <td><?= htmlspecialchars($item['title']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>৳<?= $item['price'] ?></td>
            <td>৳<?= $subtotal ?></td>
          </tr>
        <?php endwhile; ?>
        
        <tr>
          <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
          <td><strong>৳<?= $total ?></strong></td>
        </tr>
      </table>

      <div class="payment-section">
        <label><strong>Select Payment Method:</strong></label><br>
        <select name="payment_method" required>
          <option value="Cash on Delivery">Cash on Delivery</option>
          <option value="Bkash">Bkash</option>
        </select>
      </div>

      <input type="hidden" name="total_amount" value="<?= $total ?>">
      <button type="submit" class="checkout-btn">📦 Place Order</button>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
