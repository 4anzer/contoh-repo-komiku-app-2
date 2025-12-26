<?php
require 'config.php';
require 'functions.php';

// ambil semua komik (bisa dibatasi kalau nanti banyak banget)
$stmt = $pdo->query("SELECT * FROM comics ORDER BY created_at DESC");
$comics = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Komik - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="container">
  <section class="section-popular">
    <div class="section-head">
      <h2>Daftar Komik</h2>
      <span class="small"><?php echo count($comics); ?> komik</span>
    </div>

    <?php if (empty($comics)): ?>
      <p class="small">Belum ada komik di sistem.</p>
    <?php else: ?>
      <div class="cards">
        <?php foreach($comics as $c): ?>
          <article class="card">
            <a class="thumb" href="view_comic.php?id=<?php echo $c['id']; ?>">
              <img src="<?php echo htmlspecialchars($c['cover'] ?: 'uploads/default-cover.png', ENT_QUOTES); ?>" alt="">
            </a>
            <div class="card-body">
              <h3 class="title"><?php echo htmlspecialchars($c['title']); ?></h3>
              <p class="small">
                Rating: <?php echo average_rating($c['id']); ?> • 
                Chapters: <?php echo count(get_chapters($c['id'])); ?>
              </p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<footer class="site-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Komiku - Panzer Project</p>
  </div>
</footer>
</body>
</html>
