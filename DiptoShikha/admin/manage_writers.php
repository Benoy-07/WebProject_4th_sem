<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$writers = $conn->query("SELECT * FROM writers");
?>

<?php include('includes/admin_header.php'); ?>

<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<main class="admin-page">
  <div class="admin-header">
    <h2>🧾 Manage Writers</h2>
    <a class="btn-add" href="add_writer.php">+ Add New Writer</a>
  </div>

  <table class="admin-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Writer Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($writer = $writers->fetch_assoc()): ?>
    <tr>
      <td><?= $writer['id'] ?></td>
      <td><?= htmlspecialchars($writer['name']) ?></td>
      <td>
        <a href="edit_writer.php?id=<?= $writer['id'] ?>" class="btn-edit">✏️ Edit</a>
        <a href="delete_writer.php?id=<?= $writer['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this writer?');">🗑 Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</main>
<?php include('includes/admin_footer.php'); ?>
