<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

header('Content-Type: application/json; charset=utf-8');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Kiểm tra người dùng đăng nhập chưa
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

// Nhận dữ liệu từ client (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$current = trim($data['current'] ?? '');
$new = trim($data['new'] ?? '');
$confirm = trim($data['confirm'] ?? '');

if ($current === '' || $new === '' || $confirm === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
}

if ($new !== $confirm) {
    echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
    exit;
}

try {
    $conn = Database::getConnection();
    $userService = new UserService($conn);
    $user = $userService->getUserById($_SESSION['user']['id']);

    // Kiểm tra mật khẩu cũ
    if (!password_verify($current, $user->getPasswordHash())) {
        echo json_encode(['success' => false, 'message' => 'Incorrect current password.']);
        exit;
    }

    // Mã hoá mật khẩu mới và cập nhật
    $hashed = password_hash($new, PASSWORD_BCRYPT);
    $updated = $userService->updatePassword($user->getId(), $hashed);

    if ($updated) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
