<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

$id = $_GET['id'] ?? null;
if ($id) {
    // hapus relasi dulu
    $stmt = $pdo->prepare('DELETE FROM comic_genres WHERE genre_id = ?');
    $stmt->execute([$id]);

    $stmt = $pdo->prepare('DELETE FROM genres WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: genres.php');
exit;
