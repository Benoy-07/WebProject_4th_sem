
<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$result = $conn->query("SELECT * FROM publishers");
?>

<?php include('includes/admin_header.php'); ?>
<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<main class="admin-page">
  <div class="admin-header">
    <h2>📋 Manage Publishers</h2>
    <a class="btn-add" href="add_publisher.php">➕ Add Publisher</a>
  </div>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php include('includes/admin_footer.php'); ?>
