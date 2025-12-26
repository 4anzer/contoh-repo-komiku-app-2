<?php
// config.php - update with your DB credentials
session_start();
$db_host = '127.0.0.1';
$db_name = 'komiku_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die('Database connection error: ' . $e->getMessage());
}

function is_logged_in(){
    return isset($_SESSION['user']);
}
function is_admin(){
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}
?>
