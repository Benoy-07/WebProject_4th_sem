<?php
print_r("Payment Successful! Order ID: " . htmlspecialchars($_GET['tran_id'] ?? 'N/A'));
// You can add more logic here to handle the successful payment, like updating the database, sending confirmation emails, etc.
session_start();
include('includes/db.php');
if (isset($_GET['tran_id'])) {
    $order_id = $_GET['tran_id'];
    $status = 'Successful';

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

    echo "Payment Successful! Order ID: " . htmlspecialchars($order_id);
} else {
    echo "No transaction ID provided.";
}
include('includes/footer.php');
?>