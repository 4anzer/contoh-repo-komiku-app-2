<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: comics.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM comics WHERE id = ?');
$stmt->execute([$id]);
$comic = $stmt->fetch();
if (!$comic) { header('Location: comics.php'); exit; }

// Ambil semua genre & genre yang sudah terpilih
$genres = $pdo->query('SELECT * FROM genres ORDER BY name ASC')->fetchAll();
$stmt = $pdo->prepare('SELECT genre_id FROM comic_genres WHERE comic_id = ?');
$stmt->execute([$id]);
$selected = $stmt->fetchAll(PDO::FETCH_COLUMN);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title    = $_POST['title']    ?? '';
    $synopsis = $_POST['synopsis'] ?? '';
    $status   = $_POST['status']   ?? 'ongoing';
    $sel_gen  = $_POST['genres']   ?? [];

    // update cover jika ada file baru
    if (!empty($_FILES['cover']['tmp_name'])) {
        if (!is_dir('../uploads/covers')) {
            mkdir('../uploads/covers', 0777, true);
        }
        $ext  = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $name = time().rand(100,999).'.'.$ext;
        $cover_path = 'uploads/covers/'.$name;
        move_uploaded_file($_FILES['cover']['tmp_name'], '../'.$cover_path);

        $stmt = $pdo->prepare('UPDATE comics SET cover=? WHERE id=?');
        $stmt->execute([$cover_path, $id]);
    }

    $stmt = $pdo->prepare('UPDATE comics SET title=?, synopsis=?, status=? WHERE id=?');
    $stmt->execute([$title,$synopsis,$status,$id]);

    // reset genre
    $pdo->prepare('DELETE FROM comic_genres WHERE comic_id=?')->execute([$id]);
    if (!empty($sel_gen)) {
        $stmtg = $pdo->prepare('INSERT INTO comic_genres (comic_id, genre_id) VALUES (?,?)');
        foreach($sel_gen as $gid){
            $stmtg->execute([$id,$gid]);
        }
    }

    header('Location: comics.php');
    exit;
}
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <h2>Edit Comic</h2>
  <form method="post" enctype="multipart/form-data">
    <label>
      Judul
      <input type="text" name="title" value="<?php echo htmlspecialchars($comic['title']); ?>" required>
    </label>

    <label>
      Synopsis
      <textarea name="synopsis" rows="4"><?php echo htmlspecialchars($comic['synopsis']); ?></textarea>
    </label>

    <label>
      Cover (kosongkan jika tidak ganti)
      <input type="file" name="cover">
    </label>

    <label>
      Status
      <select name="status">
        <option value="ongoing" <?php if($comic['status']=='ongoing') echo 'selected'; ?>>Ongoing</option>
        <option value="completed" <?php if($comic['status']=='completed') echo 'selected'; ?>>Completed</option>
      </select>
    </label>

    <label>
      Genres
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;">
        <?php foreach($genres as $g): ?>
          <label style="font-size:13px;">
            <input type="checkbox" name="genres[]" value="<?php echo $g['id']; ?>"
              <?php if(in_array($g['id'], $selected)) echo 'checked'; ?>>
            <?php echo htmlspecialchars($g['name']); ?>
          </label>
        <?php endforeach; ?>
      </div>
    </label>

    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-secondary" href="comics.php">Batal</a>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
