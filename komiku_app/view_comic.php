<?php
require 'config.php';
require 'functions.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$comic = get_comic($id);
if (!$comic) {
    header('Location: index.php');
    exit;
}
$genres = get_comic_genres($comic['id']);
$genre_names = $genres ? implode(', ', array_column($genres, 'name')) : '-';

$chapters = get_chapters($id); // urut ASC
$rating   = average_rating($comic['id']);

$firstChapter  = $chapters ? $chapters[0] : null;
$latestChapter = $chapters ? end($chapters) : null;

// cek bookmark
$is_bookmarked = false;
if (is_logged_in()) {
    $stmt = $pdo->prepare("SELECT id FROM bookmarks WHERE user_id=? AND comic_id=?");
    $stmt->execute([$_SESSION['user']['id'], $comic['id']]);
    $is_bookmarked = (bool)$stmt->fetch();
}

// rating user
$user_rating = null;
if (is_logged_in()) {
    $stmt = $pdo->prepare("SELECT rating FROM ratings WHERE user_id=? AND comic_id=?");
    $stmt->execute([$_SESSION['user']['id'], $comic['id']]);
    $row = $stmt->fetch();
    if ($row) $user_rating = (int)$row['rating'];
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($comic['title']); ?> - Komiku</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="container">

  <!-- DETAIL KOMIK -->
  <section class="comic-detail">
    <div class="comic-detail-main">
      <div class="comic-cover">
        <img src="<?php echo htmlspecialchars($comic['cover'] ?: 'uploads/default-cover.png', ENT_QUOTES); ?>" alt="">
      </div>
      <div class="comic-info">
        <h1 class="comic-title"><?php echo htmlspecialchars($comic['title']); ?></h1>
        <p class="comic-meta">
         Status:
        <span class="badge"><?php echo htmlspecialchars($comic['status']); ?></span>
         &nbsp;•&nbsp;
         Genre: <?php echo htmlspecialchars($genre_names); ?>
         &nbsp;•&nbsp;
         Rating: <strong><?php echo $rating; ?></strong>
        </p>
        <p class="comic-synopsis">
          <?php echo nl2br(htmlspecialchars($comic['synopsis'] ?: 'Belum ada sinopsis.')); ?>
        </p>

        <div class="comic-actions">
          <?php if ($firstChapter): ?>
            <a class="btn primary" href="reader.php?chapter_id=<?php echo $firstChapter['id']; ?>">Baca dari Awal</a>
          <?php endif; ?>

          <?php if ($latestChapter && $latestChapter !== $firstChapter): ?>
            <a class="btn" href="reader.php?chapter_id=<?php echo $latestChapter['id']; ?>">Chapter Terbaru</a>
          <?php endif; ?>

          <?php if (is_logged_in()): ?>
            <!-- Bookmark -->
            <?php if ($is_bookmarked): ?>
              <a class="btn" href="bookmark_remove.php?comic_id=<?php echo $comic['id']; ?>">Hapus Bookmark</a>
            <?php else: ?>
              <a class="btn" href="bookmark_add.php?comic_id=<?php echo $comic['id']; ?>">Bookmark</a>
            <?php endif; ?>

            <!-- Rating -->
            <form action="rate_comic.php" method="post" class="rating-form">
              <input type="hidden" name="comic_id" value="<?php echo $comic['id']; ?>">
              <span class="small">Rating kamu:</span>
              <select name="rating" onchange="this.form.submit()">
                <option value="">-</option>
                <?php for($i=1;$i<=5;$i++): ?>
                  <option value="<?php echo $i; ?>" <?php if($user_rating === $i) echo 'selected'; ?>>
                    <?php echo $i; ?>
                  </option>
                <?php endfor; ?>
              </select>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- DAFTAR CHAPTER -->
  <section class="section-chapters">
    <div class="section-head">
      <h2>Daftar Chapter</h2>
      <span class="small"><?php echo count($chapters); ?> Chapter</span>
    </div>

    <?php if (!$chapters): ?>
      <p class="small">Belum ada chapter untuk komik ini.</p>
    <?php else: ?>
      <div class="chapter-list">
        <?php 
        $chaptersDesc = array_reverse($chapters); // terbaru di atas
        foreach ($chaptersDesc as $ch): 
        ?>
          <a class="chapter-item" href="reader.php?chapter_id=<?php echo $ch['id']; ?>">
            <div>
              <div class="chapter-title">
                <?php echo htmlspecialchars($ch['chapter_number']); ?>
                <?php if (!empty($ch['title'])): ?>
                  - <?php echo htmlspecialchars($ch['title']); ?>
                <?php endif; ?>
              </div>
              <div class="chapter-meta small">
                ID: <?php echo $ch['id']; ?> • Komik ID: <?php echo $ch['comic_id']; ?>
              </div>
            </div>
            <span class="chapter-read">Baca ⟶</span>
          </a>
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
