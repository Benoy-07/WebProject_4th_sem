<?php 
include('includes/header.php'); 
include('includes/db.php'); 
?>

<main class="publisher-page">
  <section class="page-title">
    <h1>🏢 Publishers</h1>
    <p>Discover the publishers behind your favorite books.</p>
  </section>

  <section class="publisher-list">
    <?php
    $result = $conn->query("SELECT name, logo FROM publishers");

    if ($result && $result->num_rows > 0):
      while ($publisher = $result->fetch_assoc()):
    ?>
      <div class="publisher-card">
        <!-- <img src="uploads/<?= htmlspecialchars($publisher['logo']) ?>" alt="<?= htmlspecialchars($publisher['name']) ?> Logo"> -->
        <h3><?= htmlspecialchars($publisher['name']) ?></h3>
      </div>
    <?php
      endwhile;
    else:
      echo "<p>No publishers found.</p>";
    endif;
    ?>
  </section>
</main>

<?php include('includes/footer.php'); ?>
