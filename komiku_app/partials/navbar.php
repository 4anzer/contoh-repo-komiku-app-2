<?php
// partial navbar
?>
<header class="site-header">
  <div class="container header-inner">
    <div class="brand">
      <a href="/komiku_app"><span class="logo-k">KOMIKU</span></a>
    </div>
    <nav class="main-nav">
  <a href="index.php">Beranda</a>
  <a href="comics_list.php">Daftar Komik</a>
  <?php if(is_logged_in()): ?>
    <a href="bookmarks.php">Bookmark Saya</a>
    <a href="history.php">Riwayat</a>
  <?php endif; ?>
</nav>
    <div class="search-login">
  <form action="search.php" method="get" class="search-form">
  <input name="q" placeholder="Cari" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
  <button type="submit" aria-label="Cari">🔍</button>
</form>


  <?php if(is_logged_in()): ?>
    <?php if(is_admin()): ?>
      <a class="btn small" href="admin/dashboard.php">Admin</a>
    <?php endif; ?>
    <a class="btn small" href="logout.php">Logout</a>
  <?php else: ?>
    <a class="btn small" href="login.php">Login</a>
  <?php endif; ?>
</div>
</div>
</header>
