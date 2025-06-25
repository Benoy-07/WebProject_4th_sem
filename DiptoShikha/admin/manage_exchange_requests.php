<?php
include('includes/admin_header.php');
include('../includes/db.php');

$sql = "SELECT er.exchange_id, er.book_name, er.writer_name, er.buy_price, er.phone, er.status, er.created_at, u.name
        FROM exchange_requests er
        JOIN users u ON er.user_id = u.id
        ORDER BY er.created_at DESC";
$result = $conn->query($sql);
?>

<main class="admin-page">
  <div class="admin-header">
    <h2>🔁 Book Exchange Requests</h2>
  </div>

  <div class="table-container">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Book Name</th>
          <th>Writer</th>
          <th>Buy Price</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['book_name']) ?></td>
              <td><?= htmlspecialchars($row['writer_name']) ?></td>
              <td>$<?= $row['buy_price'] ?></td>
              <td><?= $row['phone'] ?></td>
              <td><?= ucfirst($row['status']) ?></td>
              <td>
                <?php if ($row['status'] === 'pending'): ?>
                  <a href="approve_exchange.php?exchange_id=<?= $row['exchange_id'] ?>">✅ Approve</a>
                  <a href="reject_exchange.php?exchange_id=<?= $row['exchange_id'] ?>">❌ Reject</a>
                <?php else: ?>
                  <span>N/A</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7">No exchange requests found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>
<?php include('includes/admin_footer.php'); ?>
