<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập thì chuyển đến trang login
    header("Location: /mblogger/views/home/home.php");
    exit;
}
