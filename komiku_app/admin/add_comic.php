<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

// ambil semua genre
$genres = $pdo->query('SELECT * FROM genres ORDER BY name ASC')->fetchAll();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title    = $_POST['title']    ?? '';
    $synopsis = $_POST['synopsis'] ?? '';
    $status   = $_POST['status']   ?? 'ongoing';
    $selected_genres = $_POST['genres'] ?? [];

    $cover_path = '';
    if (!empty($_FILES['cover']['tmp_name'])) {
        if (!is_dir('../uploads/covers')) {
            mkdir('../uploads/covers', 0777, true);
        }
        $ext  = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $name = time().rand(100,999).'.'.$ext;
        $cover_path = 'uploads/covers/'.$name;
        move_uploaded_file($_FILES['cover']['tmp_name'], '../'.$cover_path);
    }

    $stmt = $pdo->prepare('INSERT INTO comics (title,synopsis,cover,status) VALUES (?,?,?,?)');
    $stmt->execute([$title,$synopsis,$cover_path,$status]);
    $comic_id = $pdo->lastInsertId();

    // simpan genre
    if (!empty($selected_genres)) {
        $stmtg = $pdo->prepare('INSERT INTO comic_genres (comic_id, genre_id) VALUES (?,?)');
        foreach ($selected_genres as $gid) {
            $stmtg->execute([$comic_id, $gid]);
        }
    }

    header('Location: comics.php');
    exit;
}
?>
<?php include 'admin_header.php'; ?>

<div class="admin-card">
  <h2>Tambah Comic</h2>
  <form method="post" enctype="multipart/form-data">
    <label>
      Judul
      <input type="text" name="title" required>
    </label>

    <label>
      Synopsis
      <textarea name="synopsis" rows="4"></textarea>
    </label>

    <label>
      Cover
      <input type="file" name="cover">
    </label>

    <label>
      Status
      <select name="status">
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
      </select>
    </label>

    <label>
      Genres
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;">
        <?php foreach($genres as $g): ?>
          <label style="font-size:13px;">
            <input type="checkbox" name="genres[]" value="<?php echo $g['id']; ?>"> 
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
