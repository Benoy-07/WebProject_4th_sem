
<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO publishers (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $success = "Publisher added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $error = "Publisher name cannot be empty!";
    }
}
?>

<?php include('includes/admin_header.php'); ?>
<div style="margin: 20px;">
  <a href="admin_dashboard.php" style="text-decoration:none; color:#2980b9; font-weight: bold;">← Back to Dashboard</a>
</div>

<main class="admin-page">
  <div class="admin-header">
    <h2>➕ Add Publisher</h2>
    <a class="btn-add" href="manage_publishers.php">📋 Manage Publishers</a>
  </div>

  <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <form class="admin-form" method="POST">
    <label>Publisher Name</label>
    <input type="text" name="name" required>
    <button type="submit" class="btn-submit">Add Publisher</button>
  </form>
</main>

<?php include('includes/admin_footer.php'); ?>
