<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? null;
$total = $_GET['total'] ?? 0;

if (!$order_id || $total <= 0) {
    die("Invalid order or total amount.");
}

// For now, use the passed total; in a real app, fetch from orders table
$amount = floatval($total);

if ($amount <= 0) {
    die("Invalid amount.");
}

// Check if database connection is valid
if (!$conn) {
    die("Database connection failed: " . (isset($conn) ? $conn->connect_error : "Connection not established"));
}

// Fetch user details to pre-fill form
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$user_name = $user['name'] ?? "";
$user_address = $user['address'] ?? "";
$user_email = $user['email'] ?? "";
?>

<?php include('includes/header.php'); ?>

<main class="page-section">
  <h2>💳 Make Payment</h2>
  <form action="payment_process.php" method="POST" class="payment-form">
    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
    <input type="hidden" name="amount" value="<?= htmlspecialchars($amount) ?>">

    <label>Payment Method</label>
    <select name="method" required>
      <option value="">--Select Method--</option>
      <option value="Bkash">Bkash</option>
      <option value="Nagad">Nagad</option>
      <option value="COD">Cash on Delivery</option>
    </select>

    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user_name) ?>" placeholder="Enter your name" required>

    <label>Address</label>
    <input type="text" name="address" value="<?= htmlspecialchars($user_address) ?>" placeholder="Enter your address" required>

    <label>Country</label>
    <input type="text" name="country" value="Bangladesh" placeholder="Enter your country" required>

    <label>Country Code</label>
    <input type="text" name="country_code" value="+880" placeholder="Enter country code (e.g., +880)" required>

    <label>Mobile Number</label>
    <input type="tel" name="mobile_number" placeholder="Enter your mobile number (e.g., 017XXXXXXXX)" required>

    <label>Amount</label>
    <input type="number" step="0.01" name="amount_display" value="<?= htmlspecialchars($amount) ?>" placeholder="Amount Paid" required readonly>

    <button type="submit">✅ Pay</button>
  </form>
</main>

<?php include('includes/footer.php'); ?>