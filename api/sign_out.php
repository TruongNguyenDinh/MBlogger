<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xoá tất cả biến session
$_SESSION = [];

// Huỷ session cookie nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Huỷ session
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc home
header("Location: ../views/form/form.php"); // sửa đường dẫn theo project của bạn
exit;
?>
