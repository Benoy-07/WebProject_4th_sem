<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../signin.php");
  exit();
}

$order_id = $_GET['id'];
$new_status = $_GET['status'];

$conn->query("UPDATE orders SET status = '$new_status' WHERE id = $order_id");

header("Location: manage_orders.php");
exit();
?>
