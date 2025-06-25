<?php
session_start();
include('../includes/db.php');

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $photo = $_FILES['photo'];

  if (!empty($name) && $photo['error'] === UPLOAD_ERR_OK) {
    $photoName = time() . '_' . basename($photo['name']);
    $uploadDir = '../uploads/';
    $uploadPath = $uploadDir . $photoName;

    if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
      $stmt = $conn->prepare("INSERT INTO writers (name, photo) VALUES (?, ?)");
      $stmt->bind_param("ss", $name, $photoName);
      if ($stmt->execute()) {
        header("Location: manage_writers.php?success=Writer+added+successfully");
        exit();
      } else {
        $error = "Something went wrong while saving to the database.";
      }
    } else {
      $error = "Failed to upload photo.";
    }
  } else {
    $error = "Writer name and photo are required.";
  }
}
?>

<?php include('includes/admin_header.php'); ?>
<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>
<main class="admin-page">
  <div class="admin-header">
    <h2>✍️ Add Writer</h2>
    <a class="btn-add" href="manage_writers.php">← Back to Writers</a>
  </div>

  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <form class="admin-form" method="POST" enctype="multipart/form-data">
    <label>Writer Name</label>
    <input type="text" name="name" required>

    <label>Writer Photo</label>
    <input type="file" name="photo" accept="image/*" required>

    <button type="submit" class="btn-submit">Add Writer</button>
  </form>
</main>
<?php include('includes/admin_footer.php'); ?>
