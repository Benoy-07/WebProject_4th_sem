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

    $check = $conn->prepare("SELECT * FROM favourites WHERE user_id = ? AND book_id = ?");
    $check->bind_param("ii", $user_id, $book_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO favourites (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
    }

    header("Location: favourites.php");
    exit();
} else {
    echo "No book ID provided.";
}
?>
