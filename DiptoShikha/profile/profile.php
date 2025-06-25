<!-- profile.php -->
<?php include('../includes/header.php'); ?>
<?php session_start(); ?>
<div class="profile-container">
  <h2>Your Profile</h2>
  <div class="avatar-preview">
    <img src="/DiptoShikha/uploads/<?= $_SESSION['avatar'] ?? 'default.png' ?>" alt="Profile Picture" width="120" height="120">
  </div>

  <form action="upload_avatar.php" method="POST" enctype="multipart/form-data">
    <label for="avatar">Change Avatar:</label>
    <input type="file" name="avatar" accept="image/*" required>
    <button type="submit">Upload</button>
  </form>
</div>
<?php include('../includes/footer.php'); ?>
