<?php
require 'config.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$comic_id = (int)($_POST['comic_id'] ?? 0);
$rating   = (int)($_POST['rating'] ?? 0);

if ($comic_id > 0 && $rating >= 1 && $rating <= 5) {
    $stmt = $pdo->prepare("
        INSERT INTO ratings (user_id, comic_id, rating)
        VALUES (?,?,?)
        ON DUPLICATE KEY UPDATE rating = VALUES(rating), created_at = NOW()
    ");
    $stmt->execute([$_SESSION['user']['id'], $comic_id, $rating]);
}

header('Location: view_comic.php?id='.$comic_id);
exit;
