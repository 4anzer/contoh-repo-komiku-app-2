<?php
require '../config.php';
if(!is_admin()){ header('Location: ../login.php'); exit; }
$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare('DELETE FROM comics WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: comics.php');
