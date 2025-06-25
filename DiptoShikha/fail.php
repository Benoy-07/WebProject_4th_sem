<?php
session_start();
include('includes/db.php');
print_r("Payment Failed! Order ID: " . htmlspecialchars($_GET['tran_id'] ?? 'N/A'));            
?>