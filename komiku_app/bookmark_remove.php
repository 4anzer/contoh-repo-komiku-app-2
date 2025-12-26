<?php
require 'config.php';
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$comic_id = isset($_GET['comic_id']) ? (int)$_GET['comic_id'] : 0;
if ($comic_id > 0) {
    $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id=? AND comic_id=?");
    $stmt->execute([$_SESSION['user']['id'], $comic_id]);
}

header('Location: view_comic.php?id='.$comic_id);
exit;
