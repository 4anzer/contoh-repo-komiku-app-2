<?php
require_once '../config.php';
if (!is_admin()) {
    header('Location: ../login.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Admin Komiku</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<header class="admin-header">
  <div class="admin-header-inner">
    <div class="admin-brand">KOMIKU <span>Admin</span></div>
    <nav class="admin-nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="comics.php">Comics</a>
      <a href="genres.php">Genres</a>
      <a href="../index.php" target="_blank">Lihat Site</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </div>
</header>
<main class="admin-main">
  <div class="admin-main-inner">
