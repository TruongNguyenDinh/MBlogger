<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

$basePath = '/mblogger/views';

// Lấy dữ liệu từ form
$username = $_POST['username'] ?? '';
$password = $_POST['pass'] ?? '';

// Tạo kết nối
$conn = Database::getConnection();

// Truyền connection vào Service
$service = new UserService($conn);
$result = $service->checkLogin($username, $password);

if ($result['success']) {
    $_SESSION['user'] = [
        'id' => $result['user']->getId(),
        'fullname' => $result['user']->getName(),
        'role' => $result['user']->getRole()
    ];
    header("Location: $basePath/home/home.php");
    exit;
} else {
    $_SESSION['error'] = $result['message'];
    header("Location: $basePath/form/form.php");
    exit;
}
