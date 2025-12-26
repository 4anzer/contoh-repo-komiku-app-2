<?php
require 'config.php';

session_destroy();
session_unset();

// setelah logout, langsung ke halaman register
header('Location: register.php');
exit;
