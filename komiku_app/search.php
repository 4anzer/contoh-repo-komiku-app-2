<?php
require 'config.php';
require 'functions.php';

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    header('Location: index.php');
    exit;
}

$like = '%'.$q.'%';
$stmt = $pdo->prepare("
    SELECT DISTINCT c.*
    FROM comics c
    WHERE c.title LIKE ? OR c.synopsis LIKE ?
    ORDER BY c.created_at DESC
");
$stmt->execute([$like, $like]);
$comics = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Cari '<?php echo htmlspecialchars($q); ?>' - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="container search-page">
  <section class="search-panel">
    <div class="search-panel-header">
      <h1>Cari '<?php echo htmlspecialchars($q); ?>'</h1>
      <span class="small"><?php echo count($comics); ?> hasil</span>
    </div>

    <div class="search-panel-body">
      <?php if (empty($comics)): ?>
        <p class="small">Tidak ditemukan komik dengan kata kunci tersebut.</p>
      <?php else: ?>
        <div class="search-grid">
          <?php foreach($comics as $c): 
              $chapters = get_chapters($c['id']);
              $lastCh   = $chapters ? end($chapters) : null;
              $lastLabel = $lastCh ? $lastCh['chapter_number'] : '0';
              $avg = (float)average_rating($c['id']);
              $stars = (int)round($avg); // 0–5
          ?>
            <article class="search-card">
              <a class="search-thumb" href="view_comic.php?id=<?php echo $c['id']; ?>">
                <img src="<?php echo htmlspecialchars($c['cover'] ?: 'uploads/default-cover.png', ENT_QUOTES); ?>" alt="">
              </a>
              <div class="search-info">
                <h3 class="search-title">
                  <a href="view_comic.php?id=<?php echo $c['id']; ?>">
                    <?php echo htmlspecialchars($c['title']); ?>
                  </a>
                </h3>
                <p class="search-chapter small">
                  Chapter <?php echo htmlspecialchars($lastLabel); ?>
                </p>
                <div class="star-row">
                  <?php for($i=1;$i<=5;$i++): ?>
                    <span class="star <?php if($i <= $stars) echo 'fill'; ?>">★</span>
                  <?php endfor; ?>
                  <span class="rating-number"><?php echo number_format($avg,1); ?></span>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Komiku - Panzer Project</p>
  </div>
</footer>
</body>
</html>
