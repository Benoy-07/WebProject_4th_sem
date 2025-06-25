<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$result = $conn->query("SELECT payments.*, users.name FROM payments JOIN users ON payments.user_id = users.id ORDER BY payment_date DESC");
?>

<?php include('includes/admin_header.php'); ?>

<main class="admin-page">
  <h2>💰 Manage Payments</h2>
  <table class="admin-table">
    <thead>
      <tr>
        <th>User</th>
        <th>Order ID</th>
        <th>Method</th>
        <th>Txn ID</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td>#<?= $row['order_id'] ?></td>
          <td><?= $row['method'] ?></td>
          <td><?= $row['transaction_id'] ?: 'N/A' ?></td>
          <td>৳<?= $row['amount'] ?></td>
          <td><?= $row['status'] ?></td>
          <td><?= $row['payment_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php include('includes/admin_footer.php'); ?>
