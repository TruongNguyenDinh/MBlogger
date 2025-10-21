<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['pass'] ?? '';

$conn = Database::getConnection();
$service = new UserService($conn);
$result = $service->checkLogin($username, $password);

if ($result['success']) {
    $_SESSION['user'] = [
        'id' => $result['user']->getId(),
        'fullname' => $result['user']->getName(),
        'role' => $result['user']->getRole(),
        'email' => $result['user']->getEmail()
    ];

    // Nếu có lưu trang muốn quay lại
    $redirectUrl = $_SESSION['redirect_after_login'] ?? '/mblogger/views/home/home.php';
    unset($_SESSION['redirect_after_login']);

    echo json_encode([
        'success' => true,
        'redirect' => $redirectUrl
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $result['message'] ?? 'Sai thông tin đăng nhập.'
    ]);
}

