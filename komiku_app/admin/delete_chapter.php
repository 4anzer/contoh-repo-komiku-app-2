<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }

$id       = $_GET['id'] ?? null;
$comic_id = $_GET['comic_id'] ?? null;

if ($id) {
    // hapus pages (file fisik opsional, di-skip biar simpel)
    $stmt = $pdo->prepare('DELETE FROM pages WHERE chapter_id = ?');
    $stmt->execute([$id]);

    // hapus chapter
    $stmt = $pdo->prepare('DELETE FROM chapters WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: chapters.php?comic_id='.$comic_id);
exit;
