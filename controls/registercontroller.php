<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

$basePath = '/mblogger/views';

// Lấy dữ liệu từ form (và trim tránh lỗi khoảng trắng)
$username   = trim($_POST['username'] ?? '');
$password   = trim($_POST['password'] ?? '');
$cpassword  = trim($_POST['password_confirm'] ?? '');
$email      = trim($_POST['email'] ?? '');

// Kiểm tra xác nhận mật khẩu
if ($password !== $cpassword) {
    $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
    header("Location: $basePath/form/form.php?page=register");
    exit;
}

// Kết nối DB
$conn = Database::getConnection();

// Truyền connection vào service
$service = new UserService($conn);
$result = $service->checkRegister($username, $password, $email);

if ($result['success']) {
    $_SESSION['success'] = 'Đăng ký thành công! Mời bạn đăng nhập.';
    header("Location: $basePath/form/form.php");
    exit;
} else {
    $_SESSION['error'] = $result['message'];
    header("Location: $basePath/form/form.php?page=register");
    exit;
}
