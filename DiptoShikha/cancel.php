<?php
session_start();
include('includes/db.php');

if (isset($_GET['tran_id'])) {
    $order_id = $_GET['tran_id'];
    $status = 'Cancelled';

    // Update payment status
    $stmt = $conn->prepare("UPDATE payments SET status = ?, payment_date = NOW() WHERE order_id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("si", $status, $order_id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();

    echo "Payment Cancelled! Order ID: $order_id";
}
?>