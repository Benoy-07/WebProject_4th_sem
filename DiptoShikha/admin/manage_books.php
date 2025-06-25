<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<?php 
include('includes/admin_header.php'); 
include('../includes/db.php'); // DB connection

// Fetch all books with category, writer, publisher info
$sql = $sql = "SELECT 
            books.id, books.title, books.price, books.old_price, books.old_book_price,
            writers.name AS writer_name,
            categories.name AS category_name,
            publishers.name AS publisher_name
        FROM books
        LEFT JOIN writers ON books.writer_id = writers.id
        LEFT JOIN categories ON books.category_id = categories.id
        LEFT JOIN publishers ON books.publisher_id = publishers.id
        ORDER BY books.id DESC";


$result = $conn->query($sql);
?>

<main class="admin-page">
  <div class="admin-header">
    <h2>📚 Manage Books</h2>
    <a class="btn-add" href="add_book.php">+ Add New Book</a>
  </div>

  <div class="table-container">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Writer</th>
          <th>Category</th>
          <th>Publisher</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['writer_name']) ?></td>
              <td><?= htmlspecialchars($row['category_name']) ?></td>
              <td><?= htmlspecialchars($row['publisher_name']) ?></td>
              <td>
                <span class="price-new">৳<?= $row['price'] ?></span>
                <?php if ($row['old_price'] > $row['price']): ?>
                  <span class="price-old">৳<?= $row['old_price'] ?></span>
                <?php endif; ?>
              </td>
              <td>
                <a class="btn-edit" href="edit_book.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="btn-delete" href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6">No books found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/admin_footer.php'); ?>
