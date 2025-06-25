<?php include('../includes/db.php'); include('../includes/header.php'); ?>

<div class="signin-wrapper">
  <div class="animated-elements">
    <span class="circle"></span>
    <span class="book-animation"></span>
    <span class="star"></span>
  </div>

  <div class="signin-container">
    <h2>Sign In</h2>

    <?php if (isset($_GET['error'])): ?>
      <p class="error-msg"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <p class="success-msg"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <p class="info-msg">Welcome back! Please enter your credentials.</p>

    <form action="signin_process.php" method="POST">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Sign In</button>
      <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </form>
  </div>
</div>

<?php include('../includes/footer.php'); ?>
