<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

$comic_id = $_GET['comic_id'] ?? ($_POST['comic_id'] ?? null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comic_id       = $_POST['comic_id'];
    $chapter_number = $_POST['chapter_number'] ?? '';
    $title          = $_POST['title'] ?? '';

    // insert chapter
    $stmt = $pdo->prepare('INSERT INTO chapters (comic_id, chapter_number, title) VALUES (?,?,?)');
    $stmt->execute([$comic_id, $chapter_number, $title]);
    $chapter_id = $pdo->lastInsertId();

    // upload pages
    if (!empty($_FILES['pages']['tmp_name'][0])) {
        if (!is_dir('../uploads/pages')) {
            mkdir('../uploads/pages', 0777, true);
        }
        foreach($_FILES['pages']['tmp_name'] as $idx => $tmp){
            if (!$tmp) continue;
            $ext = pathinfo($_FILES['pages']['name'][$idx], PATHINFO_EXTENSION);
            $filename = time().rand(100,999).'_'.$idx.'.'.$ext;
            $relPath  = 'uploads/pages/'.$filename;
            $fullPath = '../'.$relPath;
            move_uploaded_file($tmp, $fullPath);

            $order = $idx + 1;
            $stmt2 = $pdo->prepare('INSERT INTO pages (chapter_id, `order`, file) VALUES (?,?,?)');
            $stmt2->execute([$chapter_id, $order, $relPath]);
        }
    }

    header('Location: chapters.php?comic_id='.$comic_id);
    exit;
}

// jika GET: butuh data komik untuk label
if ($comic_id) {
    $stmt = $pdo->prepare('SELECT * FROM comics WHERE id = ?');
    $stmt->execute([$comic_id]);
    $comic = $stmt->fetch();
}
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <h2>Tambah Chapter</h2>
  <?php if(!empty($comic)): ?>
    <p class="text-muted">Untuk komik: <strong><?php echo htmlspecialchars($comic['title']); ?></strong></p>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="comic_id" value="<?php echo htmlspecialchars($comic_id); ?>">

    <label>
      Nomor Chapter
      <input type="text" name="chapter_number" placeholder="Contoh: Chapter 1" required>
    </label>

    <label>
      Judul Chapter (opsional)
      <input type="text" name="title" placeholder="Contoh: Awal Perjalanan">
    </label>

    <label>
      Halaman (bisa pilih banyak)
      <input type="file" name="pages[]" multiple required>
      <span class="text-muted">Urutan halaman mengikuti urutan file yang kamu pilih (1,2,3,...).</span>
    </label>

    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-secondary" href="chapters.php?comic_id=<?php echo $comic_id; ?>">Batal</a>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
