<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (!$name || !$email || !$password || !$confirm) {
        $error = 'Semua field wajib diisi.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok.';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
        try {
            $stmt->execute([$name,$email,$hash]);
            // auto login atau langsung arahkan ke login
            header('Location: login.php');
            exit;
        } catch (Exception $e) {
            $error = 'Email sudah terdaftar.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="auth-container">
  <div class="auth-card">
    <h2>Daftar</h2>
    <p class="text-muted auth-subtitle">Buat akun untuk menyimpan bookmark dan riwayat baca.</p>

    <?php if (!empty($error)): ?>
      <div class="auth-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post">
      <label>
        Nama
        <input type="text" name="name" required>
      </label>
      <label>
        Email
        <input type="email" name="email" required>
      </label>
      <label>
        Password
        <input type="password" name="password" required>
      </label>
      <label>
        Konfirmasi Password
        <input type="password" name="confirm" required>
      </label>
      <button class="btn btn-auth" type="submit">Daftar</button>
    </form>

    <div class="auth-link">
      Sudah punya akun? <a href="login.php">Masuk di sini</a>
    </div>
  </div>
</main>

</body>
</html>
