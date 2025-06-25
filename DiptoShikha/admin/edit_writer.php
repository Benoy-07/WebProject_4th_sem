<?php
session_start();
include('../includes/db.php');

// Admin Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

if (!isset($_GET['id'])) {
  header("Location: manage_writers.php");
  exit();
}

$id = intval($_GET['id']);
$writer = $conn->query("SELECT * FROM writers WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);

  if (!empty($name)) {
    $stmt = $conn->prepare("UPDATE writers SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    if ($stmt->execute()) {
      header("Location: manage_writers.php?success=Writer+updated+successfully");
      exit();
    } else {
      $error = "Something went wrong.";
    }
  } else {
    $error = "Writer name cannot be empty.";
  }
}
?>

<?php include('includes/admin_header.php'); ?>
<div style="margin: 20px;">
  <a href="manage_writers.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Writers</a>
</div>

<main class="admin-page">
  <div class="admin-header">
    <h2>✏️ Edit Writer</h2>
  </div>

  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <form class="admin-form" method="POST">
    <label>Writer Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($writer['name']) ?>" required>
    <button type="submit" class="btn-submit">Update Writer</button>
  </form>
</main>
<?php include('includes/admin_footer.php'); ?>
