<?php
require 'config.php';
require 'functions.php';

$chapter_id = $_GET['chapter_id'] ?? null;
if (!$chapter_id) {
    header('Location: index.php');
    exit;
}

// Ambil data chapter + komik
$stmt = $pdo->prepare('SELECT c.*, cm.title as comic_title, cm.id as comic_id 
                       FROM chapters c 
                       JOIN comics cm ON c.comic_id = cm.id 
                       WHERE c.id = ?');
$stmt->execute([$chapter_id]);
$ch = $stmt->fetch();

if (!$ch) {
    header('Location: index.php');
    exit;
}

// simpan riwayat baca jika user login
if (is_logged_in()) {
    $stmt = $pdo->prepare("INSERT INTO reading_history (user_id, comic_id, chapter_id, last_read_at)
                           VALUES (?,?,?,NOW())
                           ON DUPLICATE KEY UPDATE last_read_at = VALUES(last_read_at), chapter_id = VALUES(chapter_id)");
    $stmt->execute([$_SESSION['user']['id'], $ch['comic_id'], $chapter_id]);
}

// Ambil halaman (pages)
$stmt = $pdo->prepare('SELECT * FROM pages WHERE chapter_id = ? ORDER BY `order` ASC');
$stmt->execute([$chapter_id]);
$pages = $stmt->fetchAll();

// Ambil semua chapter komik ini, untuk prev/next
$stmt = $pdo->prepare('SELECT * FROM chapters WHERE comic_id = ? ORDER BY id ASC');
$stmt->execute([$ch['comic_id']]);
$allCh = $stmt->fetchAll();

// cari posisi chapter sekarang
$currentIndex = null;
foreach ($allCh as $i => $c2) {
    if ($c2['id'] == $chapter_id) {
        $currentIndex = $i;
        break;
    }
}
$prevChapter = $nextChapter = null;
if ($currentIndex !== null) {
    if ($currentIndex > 0) {
        $prevChapter = $allCh[$currentIndex - 1];
    }
    if ($currentIndex < count($allCh) - 1) {
        $nextChapter = $allCh[$currentIndex + 1];
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($ch['comic_title'].' - '.$ch['chapter_number']); ?> - Komiku</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="reader-container">
  <header class="reader-header">
    <div>
      <a href="view_comic.php?id=<?php echo $ch['comic_id']; ?>" class="back-link">⟵ Kembali ke komik</a>
      <h1 class="reader-title">
        <?php echo htmlspecialchars($ch['comic_title']); ?>
      </h1>
      <p class="reader-meta">
        <?php echo htmlspecialchars($ch['chapter_number']); ?>
        <?php if (!empty($ch['title'])): ?>
          - <?php echo htmlspecialchars($ch['title']); ?>
        <?php endif; ?>
      </p>
    </div>
    <div class="reader-nav-buttons">
      <?php if ($prevChapter): ?>
        <a class="btn small" href="reader.php?chapter_id=<?php echo $prevChapter['id']; ?>">⟵ Sebelumnya</a>
      <?php endif; ?>
      <?php if ($nextChapter): ?>
        <a class="btn small" href="reader.php?chapter_id=<?php echo $nextChapter['id']; ?>">Berikutnya ⟶</a>
      <?php endif; ?>
    </div>
  </header>

  <section class="reader-pages">
    <?php if (!$pages): ?>
      <p class="small" style="text-align:center;margin:40px 0;">Belum ada halaman untuk chapter ini.</p>
    <?php else: ?>
      <?php foreach ($pages as $p): ?>
        <div class="reader-page">
          <img src="<?php echo htmlspecialchars($p['file'], ENT_QUOTES); ?>" alt="">
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>

  <footer class="reader-footer">
    <div class="reader-nav-buttons">
      <?php if ($prevChapter): ?>
        <a class="btn small" href="reader.php?chapter_id=<?php echo $prevChapter['id']; ?>">⟵ Sebelumnya</a>
      <?php endif; ?>
      <?php if ($nextChapter): ?>
        <a class="btn small" href="reader.php?chapter_id=<?php echo $nextChapter['id']; ?>">Berikutnya ⟶</a>
      <?php endif; ?>
    </div>
  </footer>
</main>

<footer class="site-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Komiku - Panzer Project</p>
  </div>
</footer>
</body>
</html>
