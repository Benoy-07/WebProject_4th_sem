<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

if (isset($_GET['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_GET['book_id']);

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}

header("Location: cart.php");
exit();
