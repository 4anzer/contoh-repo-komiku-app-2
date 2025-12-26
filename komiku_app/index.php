<?php
require 'config.php';
require 'functions.php';

// keyword search
$q = $_GET['q'] ?? '';

// filter genre (id)
$genre_id = isset($_GET['genre']) ? (int)$_GET['genre'] : 0;

// ambil semua genre untuk chip
$allGenres = $pdo->query("SELECT * FROM genres ORDER BY name ASC")->fetchAll();

// siapkan query comics
$sql        = "SELECT DISTINCT c.* FROM comics c";
$conds      = [];
$params     = [];

// join genre kalau filter genre aktif
if ($genre_id) {
    $sql   .= " JOIN comic_genres cg ON c.id = cg.comic_id";
    $conds[] = "cg.genre_id = ?";
    $params[] = $genre_id;
}

// search
if ($q !== '') {
    $conds[] = "(c.title LIKE ? OR c.synopsis LIKE ?)";
    $params[] = '%'.$q.'%';
    $params[] = '%'.$q.'%';
}

if ($conds) {
    $sql .= " WHERE ".implode(' AND ', $conds);
}

$sql .= " ORDER BY c.created_at DESC LIMIT 100";

$stmt   = $pdo->prepare($sql);
$stmt->execute($params);
$comics = $stmt->fetchAll();
?>


<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Komiku - Baca Komik Online</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<!-- Swiper CSS from CDN -->
<link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css"/>
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<header class="hero">
  <div class="hero-inner">
    <!-- Swiper -->
    <div class="swiper hero-swiper">
      <div class="swiper-wrapper">
        <?php foreach(array_slice($comics,0,5) as $c): ?>
        <div class="swiper-slide" style="background-image:url('<?php echo htmlspecialchars($c['cover']?:'uploads/default-cover.png', ENT_QUOTES); ?>')">
          <div class="hero-overlay">
            <div class="hero-content">
              <h1><?php echo htmlspecialchars($c['title']); ?></h1>
              <?php
               $glist  = get_comic_genres($c['id']);
               $gnames = $glist ? implode(', ', array_column($glist, 'name')) : '-';
               ?>
               <p class="meta">
               Type: Manhwa • Genre: <?php echo htmlspecialchars($gnames); ?> • 
               Rating: <?php echo average_rating($c['id']); ?>
               </p>
              <p class="synopsis"><?php echo htmlspecialchars(substr($c['synopsis'],0,220)); ?>...</p>
              <p><a class="btn" href="view_comic.php?id=<?php echo $c['id']; ?>">Baca Sekarang</a></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</header>

<main class="container">
  <nav class="chips">
  <?php
    // bangun query string untuk jaga search + genre
    $baseQ = '';
    if ($q !== '') {
        $baseQ = 'q='.urlencode($q);
    }
  ?>
  <!-- All Manga -->
  <a class="chip <?php if(!$genre_id) echo 'active'; ?>"
     href="index.php<?php echo $baseQ ? '?'.$baseQ : ''; ?>">
    All Manga
  </a>

  <!-- Genres dari database -->
  <?php foreach($allGenres as $g): 
        $url = 'index.php?genre='.$g['id'];
        if ($q !== '') $url .= '&q='.urlencode($q);
  ?>
    <a class="chip <?php if($genre_id == $g['id']) echo 'active'; ?>" href="<?php echo $url; ?>">
      <?php echo htmlspecialchars($g['name']); ?>
    </a>
  <?php endforeach; ?>
</nav>


  <section class="section-popular">
  <div class="section-head">
    <h2>Terpopuler Hari Ini</h2>
    <a class="seeall" href="comics_list.php">Lihat Semua</a>
  </div>

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
</section>
</main>

<footer class="site-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Komiku - Panzer Project</p>
  </div>
</footer>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
<script src="assets/js/hero.js"></script>
</body>
</html>
