<?php
session_start();
include('../includes/db.php');

// Access control for admin only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php?error=Access+Denied");
  exit();
}

include('includes/admin_header.php');

// Fetch all users
$sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<main class="admin-dashboard">
  <div class="admin-header-row">
    <h2>👥 Manage Users</h2>
    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Joined</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars(ucfirst($row['role'])) ?></td>
              <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
              <td>
                <?php if ($row['role'] !== 'admin'): ?>
                  <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
                <?php else: ?>
                  <span class="admin-tag">Admin</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/admin_footer.php'); ?>
