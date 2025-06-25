<?php
include('../includes/db.php');
$exchange_id = $_GET['exchange_id'];

$conn->query("UPDATE exchange_requests SET status = 'rejected' WHERE exchange_id = $exchange_id");
header("Location: manage_exchange_requests.php");
exit;
