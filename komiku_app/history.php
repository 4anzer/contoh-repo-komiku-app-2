<?php
require 'config.php';
require 'functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("
    SELECT rh.*, c.title AS comic_title, ch.chapter_number
    FROM reading_history rh
    JOIN comics c ON rh.comic_id = c.id
    JOIN chapters ch ON rh.chapter_id = ch.id
    WHERE rh.user_id = ?
    ORDER BY rh.last_read_at DESC
    LIMIT 50
");
$stmt->execute([$user_id]);
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Riwayat Baca - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="container">
  <section class="section-popular">
    <div class="section-head">
      <h2>Riwayat Baca</h2>
      <span class="small"><?php echo count($rows); ?> entri</span>
    </div>

    <?php if (empty($rows)): ?>
      <p class="small">Belum ada riwayat baca. Mulai baca komik dulu 😁</p>
    <?php else: ?>
      <div class="chapter-list">
        <?php foreach($rows as $r): ?>
          <a class="chapter-item" href="reader.php?chapter_id=<?php echo $r['chapter_id']; ?>">
            <div>
              <div class="chapter-title">
                <?php echo htmlspecialchars($r['comic_title']); ?>
              </div>
              <div class="chapter-meta small">
                Terakhir baca: <?php echo htmlspecialchars($r['chapter_number']); ?> • 
                <?php echo $r['last_read_at']; ?>
              </div>
            </div>
            <span class="chapter-read">Lanjut ⟶</span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<footer class="site-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Komiku - Demo Project</p>
  </div>
</footer>
</body>
</html>
