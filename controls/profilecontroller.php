<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

$basePath = '/mblogger/views';
try {
    // Lấy connection
    $conn = Database::getConnection();
    $service = new UserService($conn);

    $userId = $_SESSION['user']['id'];
    
    // Gọi service để lấy thông tin người dùng
    $user = $service->getUserById($userId);

    // Kiểm tra nếu không tìm thấy người dùng
    if (!$user) {
        die("Không tìm thấy người dùng với ID = $userId");
    }
    // Chuyển tới view và truyền dữ liệu
    // require __DIR__ . '/../../views/profile/profile.php';
    
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}