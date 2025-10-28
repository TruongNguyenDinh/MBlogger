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
        'message' => 'Please fill in all information before registering.'
    ]);
    exit;
}

if ($password !== $cpassword) {
    echo json_encode(['success' => false, 'message' => 'Confirmation password does not match.']);
    exit;
}

$conn = Database::getConnection();
$service = new UserService($conn);
$result = $service->checkRegister($username, $password, $email);

echo json_encode($result);
