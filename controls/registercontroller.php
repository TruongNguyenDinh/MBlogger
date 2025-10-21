<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

header('Content-Type: application/json');

$username   = trim($_POST['username'] ?? '');
$password   = trim($_POST['password'] ?? '');
$cpassword  = trim($_POST['password_confirm'] ?? '');
$email      = trim($_POST['email'] ?? '');

// ✅ Kiểm tra dữ liệu rỗng
if ($username === '' || $password === '' || $cpassword === '' || $email === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng điền đầy đủ thông tin trước khi đăng ký.'
    ]);
    exit;
}

if ($password !== $cpassword) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp.']);
    exit;
}

$conn = Database::getConnection();
$service = new UserService($conn);
$result = $service->checkRegister($username, $password, $email);

echo json_encode($result);
