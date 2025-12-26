<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

// tambah genre
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO genres (name) VALUES (?)');
        try {
            $stmt->execute([$name]);
        } catch (Exception $e) {
            // ignore duplikat
        }
    }
}

$genres = $pdo->query('SELECT * FROM genres ORDER BY name ASC')->fetchAll();
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <h2>Genres</h2>
  <form method="post" style="margin-bottom:14px;">
    <label>
      Nama Genre Baru
      <input type="text" name="name" placeholder="Contoh: Action" required>
    </label>
    <button class="btn btn-primary" type="submit">Tambah</button>
  </form>

  <table class="table">
    <tr>
      <th>ID</th>
      <th>Nama Genre</th>
      <th>Aksi</th>
    </tr>
    <?php foreach($genres as $g): ?>
      <tr>
        <td><?php echo $g['id']; ?></td>
        <td><?php echo htmlspecialchars($g['name']); ?></td>
        <td>
          <a class="btn btn-danger" href="delete_genre.php?id=<?php echo $g['id']; ?>" onclick="return confirm('Hapus genre ini?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include 'admin_footer.php'; ?>
