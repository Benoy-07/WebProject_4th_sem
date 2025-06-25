<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: signin.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'];
$total_amount = $_POST['total_amount'];
$order_date = date("Y-m-d H:i:s");

// Step 1: Insert into orders
$conn->query("INSERT INTO orders (user_id, total_amount, order_date, status) VALUES ($user_id, $total_amount, '$order_date', 'Pending')");
$order_id = $conn->insert_id;

// Step 2: Fetch items from cart
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");

while ($item = $cart_items->fetch_assoc()) {
  $book_id = $item['book_id'];
  $quantity = $item['quantity'];
  
  // Insert into order_items
  $conn->query("INSERT INTO order_items (order_id, book_id, quantity) VALUES ($order_id, $book_id, $quantity)");
}

// Step 3: Insert into payments table
$conn->query("INSERT INTO payments (order_id, payment_method, payment_status) VALUES ($order_id, '$payment_method', 'Pending')");

// Step 4: Clear cart
$conn->query("DELETE FROM cart WHERE user_id = $user_id");

// Step 5: Redirect
header("Location: order_success.php");
exit();
?>
