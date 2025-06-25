<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
}

if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Check if the book is already in the cart
    $check = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND book_id = ?");
    $check->bind_param("ii", $user_id, $book_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Book already in cart, increase quantity
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND book_id = $book_id");
    } else {
        // Add new entry to cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
    }

    header("Location: cart.php");
    exit();
} else {
    echo "No book ID provided.";
}
?>
