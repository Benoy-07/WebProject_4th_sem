<?php
session_start();
include('../includes/db.php');

// Admin Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  
  // Optional: check if writer exists first

  $stmt = $conn->prepare("DELETE FROM writers WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    header("Location: manage_writers.php?success=Writer+deleted+successfully");
    exit();
  } else {
    header("Location: manage_writers.php?error=Delete+failed");
    exit();
  }
} else {
  header("Location: manage_writers.php");
  exit();
}
