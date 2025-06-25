<?php
session_start();
include('../includes/db.php');

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php?error=Access+Denied");
    exit();
}

// Validate and sanitize user ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int) $_GET['id'];

    // Prevent admin account deletion
    $stmt_check = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $stmt_check->bind_result($role);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($role === 'admin') {
        header("Location: manage_users.php?error=Cannot+delete+admin+account");
        exit();
    }

    // Proceed to delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: manage_users.php?success=User+deleted+successfully");
    } else {
        header("Location: manage_users.php?error=Failed+to+delete+user");
    }

    $stmt->close();
} else {
    header("Location: manage_users.php?error=Invalid+User+ID");
    exit();
}
