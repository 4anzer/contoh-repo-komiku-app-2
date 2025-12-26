<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }
$total_comics = $pdo->query('SELECT COUNT(*) AS c FROM comics')->fetch()['c'];
$total_users  = $pdo->query('SELECT COUNT(*) AS c FROM users')->fetch()['c'];
$total_genres = $pdo->query('SELECT COUNT(*) AS c FROM genres')->fetch()['c'];
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <h2>Dashboard</h2>
  <p class="text-muted">Ringkasan singkat data di sistem.</p>
  <ul>
    <li>Total Comics: <strong><?php echo $total_comics; ?></strong></li>
    <li>Total Users: <strong><?php echo $total_users; ?></strong></li>
    <li>Total Genres: <strong><?php echo $total_genres; ?></strong></li>
  </ul>
</div>

<?php include 'admin_footer.php'; ?>
