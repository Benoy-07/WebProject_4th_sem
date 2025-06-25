<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<?php
include('includes/admin_header.php');
include('../includes/db.php');

if (!isset($_GET['id'])) {
    echo "<p>Invalid book ID.</p>";
    exit;
}

$book_id = $_GET['id'];

// Fetch book info
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "<p>Book not found.</p>";
    exit;
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher_id = $_POST['publisher_id'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $description = $_POST['description'];

    // Optional image upload
    $cover = $book['cover'];
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $filename = time() . '_' . $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/uploads/" . $filename);
        $cover = $filename;
    }

    $update = $conn->prepare("UPDATE books SET title=?, author_id=?, category_id=?, publisher_id=?, price=?, old_price=?, description=?, cover=? WHERE id=?");
    $update->bind_param("siiiddssi", $title, $author_id, $category_id, $publisher_id, $price, $old_price, $description, $cover, $book_id);

    if ($update->execute()) {
        header("Location: manage_books.php?success=Book+updated+successfully");
        exit;
    } else {
        echo "<p>Update failed: " . $conn->error . "</p>";
    }
}
?>

<div class="admin-form-container">
  <h2>Edit Book</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

    <label>Writer ID</label>
    <input type="number" name="writer_id" value="<?= $book['writer_id'] ?>" required>

    <label>Category ID</label>
    <input type="number" name="category_id" value="<?= $book['category_id'] ?>" required>

    <label>Publisher ID</label>
    <input type="number" name="publisher_id" value="<?= $book['publisher_id'] ?>" required>

    <label>New Book Price</label>
    <input type="number" name="price" value="<?= $book['price'] ?>" required>

    <label>Old Book Price</label>
    <input type="number" name="old_book_price" value="<?= $book['old_book_price'] ?>" required>

    <label>Orginal Price</label>
    <input type="number" name="old_price" value="<?= $book['old_price'] ?>">

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($book['description']) ?></textarea>

    <label>Cover Image (Optional)</label>
    <input type="file" name="cover">
    <?php if ($book['cover']): ?>
      <img src="../assets/uploads/<?= $book['cover'] ?>" height="100" style="margin-top: 10px;" />
    <?php endif; ?>

    <button type="submit">Update Book</button>
  </form>
</div>

<?php include('includes/admin_footer.php'); ?>
