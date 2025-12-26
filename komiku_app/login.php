<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, $u['password'])) {
            $_SESSION['user'] = $u;

            // kalau admin, masuk dashboard; kalau user biasa, ke home
            if ($u['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Email atau password salah.';
        }
    } else {
        $error = 'Lengkapi email dan password.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-dark">
<?php include 'partials/navbar.php'; ?>

<main class="auth-container">
  <div class="auth-card">
    <h2>Login</h2>
    <p class="text-muted auth-subtitle">Masuk untuk menyimpan bookmark dan lanjut baca.</p>

    <?php if (!empty($error)): ?>
      <div class="auth-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post">
      <label>
        Email
        <input type="email" name="email" required>
      </label>
      <label>
        Password
        <input type="password" name="password" required>
      </label>
      <button class="btn btn-auth" type="submit">Masuk</button>
    </form>

    <div class="auth-link">
      Belum punya akun? <a href="register.php">Daftar sekarang</a>
    </div>
  </div>
</main>

</body>
</html>
