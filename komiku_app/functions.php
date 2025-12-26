<?php
require_once 'config.php';

// simple helper to escape
function e($str){ return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function get_comics($limit=50){
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM comics ORDER BY created_at DESC LIMIT '.(int)$limit);
    return $stmt->fetchAll();
}

function get_comic($id){
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM comics WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function get_chapters($comic_id){
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM chapters WHERE comic_id = ? ORDER BY id ASC');
    $stmt->execute([$comic_id]);
    return $stmt->fetchAll();
}

function average_rating($comic_id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT AVG(rating) AS avg_rating FROM ratings WHERE comic_id = ?");
    $stmt->execute([$comic_id]);
    $row = $stmt->fetch();
    return $row && $row['avg_rating'] !== null ? number_format($row['avg_rating'], 1) : '0';
}

function get_comic_genres($comic_id){
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT g.*
        FROM comic_genres cg
        JOIN genres g ON cg.genre_id = g.id
        WHERE cg.comic_id = ?
        ORDER BY g.name ASC
    ");
    $stmt->execute([$comic_id]);
    return $stmt->fetchAll();
}


?>
