<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DiptoShikha | Book Store</title>
  <link rel="stylesheet" href="/DiptoShikha/assets/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<!-- Header Section -->
<header class="main-header">
  <div class="logo">📚 DiptoShikha</div>

  <nav class="navbar">
    <a href="/DiptoShikha/index.php">Home</a>
    <a href="/DiptoShikha/category.php">Category</a>
    <a href="/DiptoShikha/writer.php">Writer</a>
    <a href="/DiptoShikha/publisher.php">Publisher</a>
    <a href="/DiptoShikha/about.php">About</a>
    <a href="/DiptoShikha/exchange_book.php">Exchange Book</a>

    <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin'): ?>
      <a href="/DiptoShikha/admin/admin_dashboard.php" class="admin-link">🔧 Admin Panel</a>
    <?php endif; ?>
  </nav>

  <div class="auth-section">
    <?php if (isset($_SESSION['user'])): ?>
      <a href="/DiptoShikha/favourites.php" class="icon">❤️</a>
      <a href="/DiptoShikha/cart.php" class="icon">🛒</a>
      <div class="dropdown">
        <img src="/DiptoShikha/uploads/<?= htmlspecialchars($_SESSION['avatar'] ?? 'default.png') ?>" class="avatar" onclick="toggleDropdown()" />
        <div class="dropdown-content" id="dropdownMenu">
          <a href="/DiptoShikha/profile/profile.php">👤 Profile</a>
          <a href="/DiptoShikha/profile/settings.php">⚙️ Settings</a>
          <a href="/DiptoShikha/auth/logout.php">🚪 Logout</a>
        </div>
      </div>
    <?php else: ?>
      <a href="/DiptoShikha/auth/signin.php" class="signin-btn">Sign In</a>
    <?php endif; ?>
  </div>
</header>

<script>
function toggleDropdown() {
  const menu = document.getElementById("dropdownMenu");
  menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

/* Hide dropdown when clicking outside */
window.onclick = function(event) {
  if (!event.target.matches('.avatar')) {
    const dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
      dropdowns[i].style.display = "none";
    }
  }
}
</script>
<!-- End of Header Section -->