<?php
require 'config.php';

$pass = password_hash('admin123', PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
$stmt->execute(['Admin', 'admin@example.com', $pass, 'admin']);

echo "Admin berhasil dibuat. Email: admin@example.com, Password: admin123";
