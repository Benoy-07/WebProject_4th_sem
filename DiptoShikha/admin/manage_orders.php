<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$orders = $conn->query("SELECT orders.*, users.name, payments.payment_method, payments.payment_status
  FROM orders
  JOIN users ON users.id = orders.user_id
  JOIN payments ON payments.order_id = orders.id
  ORDER BY orders.order_date DESC");
?>

<?php include('includes/admin_header.php'); ?>

<main class="admin-page">
  <h1>📦 Manage Orders</h1>
  <table class="admin-table">
    <thead>
      <tr>
        <th>#OrderID</th>
        <th>User</th>
        <th>Total (৳)</th>
        <th>Date</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($order = $orders->fetch_assoc()): ?>
        <tr>
          <td>#<?= $order['id'] ?></td>
          <td><?= htmlspecialchars($order['name']) ?></td>
          <td><?= $order['total_amount'] ?></td>
          <td><?= $order['order_date'] ?></td>
          <td><?= $order['status'] ?></td>
          <td><?= $order['payment_method'] ?> (<?= $order['payment_status'] ?>)</td>
          <td>
            <a href="view_order.php?id=<?= $order['id'] ?>">👁 View</a> |
            <a href="update_order_status.php?id=<?= $order['id'] ?>&status=Delivered" onclick="return confirm('Mark as Delivered?')">✅</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php include('includes/admin_footer.php'); ?>
