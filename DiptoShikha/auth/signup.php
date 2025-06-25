<?php session_start(); include('../includes/header.php'); ?>
<div class="auth-wrapper">

<div class="signin-wrapper">
  <div class="animated-elements">
    <span class="circle"></span>
    <span class="book-animation"></span>
    <span class="star"></span>
  </div>

  <div class="signup-container">
    <h2>Create Account</h2>
    <?php if (isset($_GET['error'])): ?>
      <p class="error-msg"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="signup_process.php" method="POST">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      
      <!-- Role Selection -->
      <select name="role" id="role" onchange="toggleSecret()" required>
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
      </select>

      <!-- Secret Code Field -->
      <input type="text" name="secret_code" id="secret_code" placeholder="Secret Code (Admin Only)" style="display:none;">

      <button type="submit">Sign Up</button>
      <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </form>
  </div>
</div>

<script>
  function toggleSecret() {
    const roleSelect = document.getElementById('role');
    const secretInput = document.getElementById('secret_code');
    if (roleSelect.value === 'admin') {
      secretInput.style.display = 'block';
      secretInput.required = true;
    } else {
      secretInput.style.display = 'none';
      secretInput.required = false;
    }
  }
</script>

<?php include('../includes/footer.php'); ?>
