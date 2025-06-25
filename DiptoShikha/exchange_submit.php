<?php
session_start();
include('includes/db.php');

$user_id = $_SESSION['user_id']; // ensure login required
$book = $_POST['book_name'];
$writer = $_POST['writer_name'];
$price = $_POST['buy_price'];
$phone = $_POST['phone'];

$sql = "INSERT INTO exchange_requests (user_id, book_name, writer_name, buy_price, phone)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issds", $user_id, $book, $writer, $price, $phone);
$stmt->execute();

header("Location: exchange_book.php?success=1");
?>
