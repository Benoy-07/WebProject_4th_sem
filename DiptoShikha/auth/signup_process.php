<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $role     = $_POST['role']; // admin or customer
    $code     = isset($_POST['secret_code']) ? $_POST['secret_code'] : null;

    // Check if passwords match
    if ($password !== $confirm) {
        header("Location: signup.php?error=Passwords+do+not+match");
        exit();
    }

    // Check admin secret code
    if ($role === 'admin' && $code !== '###123') {
        header("Location: signup.php?error=Invalid+admin+secret+code");
        exit();
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: signup.php?error=Email+already+exists");
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $defaultAvatar = '/DiptoShikha/assets/img/default-avatar.png';

    // Insert user with role and default avatar
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, profile_pic) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed, $role, $defaultAvatar);

    if ($stmt->execute()) {
        // ✅ DO NOT auto-login after signup
        // ✅ Redirect to signin page with success message
        header("Location: signin.php?success=Signup+successful.+Please+login.");
        exit();
    } else {
        header("Location: signup.php?error=Signup+failed");
        exit();
    }
}
?>
