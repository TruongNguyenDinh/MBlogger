<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__ . '/../service/MakeAndSendCode.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Lấy dữ liệu JSON gửi lên
$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
// Kiểm tra email hợp lệ
if (empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email không được để trống.']);
    exit;
}

try {
    // Kết nối database và gọi service
    $conn = Database::getConnection();
    $userService = new UserService($conn);

    //
    $isExisted = $userService->fisExistedEmail($email);

    if ($isExisted) {
    $sendResult = MakeAndSendCode::sendCode($email);
        echo json_encode($sendResult); // ✅ Chỉ echo 1 lần
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Email không tồn tại trong hệ thống.']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
