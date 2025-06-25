<?php 
include('includes/header.php'); 
include('includes/db.php');

// Fetch all writers from the database
$writers = $conn->query("SELECT * FROM writers");
?>

<main class="writer-page">
  <section class="page-title">
    <h1>✍️ Writers</h1>
    <p>Meet the brilliant minds behind the books.</p>
  </section>

  <section class="writer-list">
    <?php while ($writer = $writers->fetch_assoc()): ?>
      <div class="writer-card">
        <img src="uploads/<?= htmlspecialchars($writer['photo']) ?>" alt="<?= htmlspecialchars($writer['name']) ?>">
        <h3><?= htmlspecialchars($writer['name']) ?></h3>
      </div>
    <?php endwhile; ?>
  </section>
</main>

<?php include('includes/footer.php'); ?>
