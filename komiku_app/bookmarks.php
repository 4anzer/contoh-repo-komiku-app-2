<?php
require 'config.php';
require 'functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT c.* 
                       FROM bookmarks b 
                       JOIN comics c ON b.comic_id = c.id
                       WHERE b.user_id = ?
                       ORDER BY b.created_at DESC");
$stmt->execute([$user_id]);
$bookmarks = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Bookmark Saya - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="container">
  <section class="section-popular">
    <div class="section-head">
      <h2>Bookmark Saya</h2>
      <span class="small"><?php echo count($bookmarks); ?> komik</span>
    </div>

    <?php if (empty($bookmarks)): ?>
      <p class="small">Belum ada komik yang dibookmark. Mulai dari halaman detail komik untuk menambahkan bookmark.</p>
    <?php else: ?>
      <div class="cards">
        <?php foreach($bookmarks as $c): ?>
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
              <p class="small">
                <a href="bookmark_remove.php?comic_id=<?php echo $c['id']; ?>">Hapus Bookmark</a>
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
    <p>&copy; <?php echo date('Y'); ?> Komiku - Demo Project</p>
  </div>
</footer>
</body>
</html>
