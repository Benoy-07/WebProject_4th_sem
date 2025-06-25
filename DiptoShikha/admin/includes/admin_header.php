<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel - DiptoShikha</title>
  <link rel="stylesheet" href="/DiptoShikha/admin/admin.css">
  <style>
    header {
      background-color: #2c3e50;
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header .logo {
      font-size: 22px;
      font-weight: bold;
      text-transform: uppercase;
    }

    header .logout-btn a {
      color: #fff;
      text-decoration: none;
      background-color: #e74c3c;
      padding: 8px 15px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    header .logout-btn a:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">DiptoShikha Admin</div>
  <div class="logout-btn">
    <!-- যদি logout.php থাকে admin ফোল্ডারে -->
<a href="/DiptoShikha/admin/logout.php">Logout</a>

  </div>
</header>
