<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id']) || !isset($_POST['amount']) || !isset($_POST['method']) || !isset($_POST['mobile_number']) || !isset($_POST['name']) || !isset($_POST['address']) || !isset($_POST['country']) || !isset($_POST['country_code'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$amount = floatval($_POST['amount']);
$method = $_POST['method'];
$mobile_number = $_POST['mobile_number'];
$name = $_POST['name'];
$address = $_POST['address'];
$country = $_POST['country'];
$country_code = $_POST['country_code'];

// Fetch minimal user details (e.g., email if needed)
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
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

if (!$user) {
    die("User not found.");
}

$cus_email = $user['email'] ?? "test@test.com";
$cus_phone = preg_replace('/[^0-9]/', '', $mobile_number); // Sanitize mobile number

/* PHP */
$post_data = array();
$post_data['store_id'] = "benoy68558c80199b5";
$post_data['store_passwd'] = "benoy68558c80199b5@ssl";
$post_data['total_amount'] = $amount;
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
$post_data['success_url'] = "http://localhost/DiptoShikha/success.php";
$post_data['fail_url'] = "http://localhost/DiptoShikha/fail.php";
$post_data['cancel_url'] = "http://localhost/DiptoShikha/cancel.php";

// Enable mobile banking options
$post_data['multi_card_name'] = "bkash,nagad,visacard,mastercard,amexcard";
$post_data['allowed_channel'] = "wallet"; // Suggests preference for mobile wallets

// CUSTOMER INFORMATION
$post_data['cus_name'] = $name;
$post_data['cus_email'] = $cus_email;
$post_data['cus_add1'] = $address;
$post_data['cus_add2'] = "";
$post_data['cus_city'] = ""; // Optional, can be derived from address if needed
$post_data['cus_state'] = ""; // Optional
$post_data['cus_postcode'] = ""; // Optional
$post_data['cus_country'] = $country;
$post_data['cus_phone'] = $cus_phone;
$post_data['cus_fax'] = $cus_phone;
$post_data['cus_phone_code'] = $country_code; // Assuming SSLCOMMERZ accepts this

# SHIPMENT INFORMATION
$post_data['ship_name'] = $name;
$post_data['ship_add1'] = $address;
$post_data['ship_add2'] = "";
$post_data['ship_city'] = ""; // Optional
$post_data['ship_state'] = ""; // Optional
$post_data['ship_postcode'] = ""; // Optional
$post_data['ship_country'] = $country;

# CART PARAMETERS
$post_data['cart'] = json_encode(array(
    array("product" => "Order #$order_id", "amount" => $amount)
));
$post_data['product_amount'] = $amount;
$post_data['vat'] = "5";
$post_data['discount_amount'] = "0";
$post_data['convenience_fee'] = "0";

// Check if cURL is enabled
if (!function_exists('curl_init')) {
    die("cURL is not installed or enabled on your server.");
}

// REQUEST SEND TO SSLCOMMERZ
$direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $direct_api_url);
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); // Disable for local testing
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); // Disable for local testing

$content = curl_exec($handle);

if ($content === false) {
    $error = curl_error($handle);
    curl_close($handle);
    die("cURL Error: " . $error);
}

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);

if ($code != 200) {
    die("HTTP Error: Code $code");
}

# PARSE THE JSON RESPONSE
$sslcz = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Decode Error: " . json_last_error_msg() . " - Raw Response: " . $content);
}

if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
    echo "<meta http-equiv='refresh' content='0;url=" . htmlspecialchars($sslcz['GatewayPageURL']) . "'>";
    exit;
} else {
    die("No GatewayPageURL found in response: " . print_r($sslcz, true));
}
?>