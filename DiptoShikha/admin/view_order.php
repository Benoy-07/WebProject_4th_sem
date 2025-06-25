<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$order_id = $_GET['id'];
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
$items = $conn->query("SELECT books.title, order_items.quantity 
  FROM order_items 
  JOIN books ON books.id = order_items.book_id 
  WHERE order_items.order_id = $order_id");
?>

<?php include('includes/admin_header.php'); ?>

<main class="admin-page">
  <h2>📦 Order #<?= $order_id ?> Details</h2>
  <p>Status: <strong><?= $order['status'] ?></strong></p>
  <ul>
    <?php while ($item = $items->fetch_assoc()): ?>
      <li><?= $item['title'] ?> — Qty: <?= $item['quantity'] ?></li>
    <?php endwhile; ?>
  </ul>
  <a href="manage_orders.php">🔙 Back to Orders</a>
</main>

<?php include('includes/admin_footer.php'); ?>
