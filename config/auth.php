<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // Ghi nhớ URL hiện tại để quay lại sau khi login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    // Thay vì chuyển hướng, bật biến
    $showLoginPopup = true;
} else {
    $showLoginPopup = false;
}
