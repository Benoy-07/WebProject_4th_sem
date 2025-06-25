<?php include('includes/header.php'); ?>
<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
    header("Location: /DiptoShikha/auth/signin.php");
    exit();
  }
?>

<main class="exchange-section">
  <div class="container">
    <h1>📦 Exchange Your Book</h1>
    <p>Want to exchange your old book? Fill out the form below. We'll contact you if your book meets our conditions.</p>

    <div class="conditions-box">
      <h3>📋 Exchange Conditions:</h3>
      <ul>
        <li>❌ Torn or damaged books are not accepted.</li>
        <li>❌ Burnt or incomplete books will be rejected.</li>
        <li>✅ Book must have clear title and publish year.</li>
        <li>✅ Must mention the price you bought it for and your phone number.</li>
      </ul>
    </div>

    <?php
    if (isset($_GET['success'])) {
      echo '<p style="color: green;">✔️ Exchange request submitted successfully!</p>';
    }
    if (isset($_GET['error'])) {
      echo '<p style="color: red;">❌ Error: ' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>

<form action="exchange_submit.php" method="POST" class="exchange-form">
  <h2>📖 Exchange Book Request</h2>
  
  <label>Book Name</label>
  <input type="text" name="book_name" required>

  <label>Writer Name</label>
  <input type="text" name="writer_name" required>

  <label>Publisher Name</label>
  <input type="text" name="publisher_name" required>

  <label>Buy Price (৳)</label>
  <input type="number" step="0.01" name="buy_price" required>

  <label>Your Phone Number</label>
  <input type="text" name="phone" required>

  <button type="submit">📩 Submit Request</button>
</form>

  </div>
</main>

<?php include('includes/footer.php'); ?>
