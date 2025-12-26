<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

$comic_id = $_GET['comic_id'] ?? null;
if (!$comic_id) {
    header('Location: comics.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM comics WHERE id = ?');
$stmt->execute([$comic_id]);
$comic = $stmt->fetch();
if (!$comic) {
    header('Location: comics.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM chapters WHERE comic_id = ? ORDER BY id ASC');
$stmt->execute([$comic_id]);
$chapters = $stmt->fetchAll();
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h2>Chapters - <?php echo htmlspecialchars($comic['title']); ?></h2>
      <p class="text-muted">Total <?php echo count($chapters); ?> chapter.</p>
    </div>
    <a class="btn btn-primary" href="add_chapter.php?comic_id=<?php echo $comic_id; ?>">+ Tambah Chapter</a>
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Chapter</th>
      <th>Judul</th>
      <th>Aksi</th>
    </tr>
    <?php foreach($chapters as $ch): ?>
      <tr>
        <td><?php echo $ch['id']; ?></td>
        <td><?php echo htmlspecialchars($ch['chapter_number']); ?></td>
        <td><?php echo htmlspecialchars($ch['title']); ?></td>
        <td class="actions">
          <a class="btn btn-secondary" href="../reader.php?chapter_id=<?php echo $ch['id']; ?>" target="_blank">Preview</a>
          <a class="btn btn-danger" href="delete_chapter.php?id=<?php echo $ch['id']; ?>&comic_id=<?php echo $comic_id; ?>" onclick="return confirm('Hapus chapter ini beserta halamannya?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include 'admin_footer.php'; ?>
