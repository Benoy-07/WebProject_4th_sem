<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // role যোগ করলাম
    $stmt = $conn->prepare("SELECT id, name, password, profile_pic, role FROM users WHERE email = ?");
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed, $profile_pic, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            $_SESSION['user'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['avatar'] = $profile_pic;
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            // Admin হলে admin panel এ পাঠাও
            if ($role === 'admin') {
                header("Location: /DiptoShikha/admin/admin_dashboard.php");
            } else {
                header("Location: /DiptoShikha/index.php");
            }
            exit;
        } else {
            header("Location: signin.php?error=Incorrect+Password");
            exit;
        }
    } else {
        header("Location: signin.php?error=User+not+found");
        exit;
    }
} else {
    header("Location: signin.php?error=Invalid+Request");
    exit;
}
?>
