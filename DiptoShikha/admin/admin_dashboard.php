<?php
session_start();
include('../includes/db.php');

// Only allow access if admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php?error=Access+Denied");
  exit();
}
?>

<?php include('includes/admin_header.php'); ?>

<main class="admin-dashboard">
  <h1>📊 Admin Dashboard</h1>

  <div class="admin-cards">
    <a href="manage_books.php" class="admin-card">📚 Manage Books</a>
    <!-- <a href="add_book.php" class="admin-card">➕ Add New Book</a> -->
    <a href="manage_users.php" class="admin-card">👥 Manage Users</a>
    <a href="manage_categories.php" class="admin-card">🗂 Manage Categories</a>
    <a href="manage_writers.php" class="admin-card">🧾 Manage Writers</a>
    <!-- <a href="add_writer.php" class="admin-card">✍️ Add Writer</a> -->
    <a href="manage_publishers.php" class="admin-card">🏢 Manage Publishers</a>
    <a href="manage_orders.php" class="admin-card">🛒 Manage Orders</a>
   <!-- <a href="add_publisher.php" class="admin-card">➕ Add Publisher</a> -->
   <a href="manage_exchange_requests.php" class="admin-card">📦 Manage exchange Requests</a>
    <a href="../index.php" class="admin-card">🏠 Back to Site</a>
    <a 
  </div>
</main>

<?php include('includes/admin_footer.php'); ?>
