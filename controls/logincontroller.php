<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    $user = $result['user'];
    $_SESSION['user'] = [
        'id' => $user->getId(),
        'fullname' => $user->getName(),
        'role' => $user->getRole(),
        'email' => $user->getEmail(),
        'phone' => $user->getPhone(),
        'birthday' => $user->getBirthday(),
        'work' => $user->getWork(),
        'address' => $user->getAddress()
    ];
    header("Location: $basePath/home/home.php");
    exit;
}
 else {
    $_SESSION['error'] = $result['message'];
    header("Location: $basePath/form/form.php");
    exit;
}
