<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }
$comics = $pdo->query('SELECT * FROM comics ORDER BY id DESC')->fetchAll();
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;">
    <h2>Comics</h2>
    <a class="btn btn-primary" href="add_comic.php">+ Tambah Comic</a>
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Judul</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php foreach($comics as $c): ?>
      <tr>
        <td><?php echo $c['id']; ?></td>
        <td><?php echo htmlspecialchars($c['title']); ?></td>
        <td><?php echo htmlspecialchars($c['status']); ?></td>
        <td class="actions">
          <a class="btn btn-secondary" href="chapters.php?comic_id=<?php echo $c['id']; ?>">Chapters</a>
          <a class="btn btn-secondary" href="edit_comic.php?id=<?php echo $c['id']; ?>">Edit</a>
          <a class="btn btn-danger" href="delete_comic.php?id=<?php echo $c['id']; ?>" onclick="return confirm('Hapus comic ini?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include 'admin_footer.php'; ?>
