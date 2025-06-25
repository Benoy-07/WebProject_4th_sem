<?php
session_start();
include('includes/db.php');

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$method = $_POST['method'];
$transaction_id = $_POST['transaction_id'] ?? '';
$amount = $_POST['amount'];

$stmt = $conn->prepare("INSERT INTO payments (user_id, order_id, method, transaction_id, amount) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissd", $user_id, $order_id, $method, $transaction_id, $amount);
$stmt->execute();

header("Location: orders.php?success=Payment+Submitted");
exit();
