<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<?php
include('includes/admin_header.php');
include('../includes/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher_id = $_POST['publisher_id'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $description = trim($_POST['description']);

    // Optional image upload
    $cover = '';
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $cover_name = time() . '_' . basename($_FILES['cover']['name']);
        $cover_tmp = $_FILES['cover']['tmp_name'];
        move_uploaded_file($cover_tmp, '../uploads/' . $cover_name); // ../uploads/ since this is inside admin folder
        $cover = $cover_name;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO books (title, writer_id, category_id, publisher_id, price, old_price, description, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiddss", $title, $author_id, $category_id, $publisher_id, $price, $old_price, $description, $cover);

    if ($stmt->execute()) {
        header("Location: manage_books.php?success=Book+added+successfully");
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<main class="admin-page">
  <div class="admin-header">
    <h2>➕ Add New Book</h2>
    <a class="btn-add" href="manage_books.php">← Back to Books</a>
  </div>

  <form class="admin-form" action="" method="POST" enctype="multipart/form-data">
    <label>Book Title</label>
    <input type="text" name="title" required>

    <label>Writer</label>
    <select name="author_id" required>
      <option value="">Select Writer</option>
      <?php
      $authors = $conn->query("SELECT id, name FROM writers");
      while ($a = $authors->fetch_assoc()) {
          echo "<option value='{$a['id']}'>{$a['name']}</option>";
      }
      ?>
    </select>

    <label>Category</label>
    <select name="category_id" required>
      <option value="">Select Category</option>
      <?php
      $categories = $conn->query("SELECT id, name FROM categories");
      while ($c = $categories->fetch_assoc()) {
          echo "<option value='{$c['id']}'>{$c['name']}</option>";
      }
      ?>
    </select>

    <label>Publisher</label>
    <select name="publisher_id" required>
      <option value="">Select Publisher</option>
      <?php
      $publishers = $conn->query("SELECT id, name FROM publishers");
      while ($p = $publishers->fetch_assoc()) {
          echo "<option value='{$p['id']}'>{$p['name']}</option>";
      }
      ?>
    </select>

    <label>New Book Price</label>
    <input type="number" name="price" step="0.01" required>
    
    <label>Old Book Price</label>
    <input type="number" name="old_book_price" step="0.01">

    <label>Orginal Price (optional)</label>
    <input type="number" name="old_price" step="0.01">

    <label>Description</label>
    <textarea name="description" rows="4"></textarea>

    <label>Book Cover (optional)</label>
    <input type="file" name="cover" accept="image/*">

    <button type="submit" class="btn-submit">Add Book</button>
  </form>
</main>

<?php include('includes/admin_footer.php'); ?>
