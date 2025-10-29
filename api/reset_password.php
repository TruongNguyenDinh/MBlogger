<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email']);
$new = trim($data['password'] ?? '');
$confirm = trim($data['confirm-password'] ?? '');
if ($new !== $confirm) {
    echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
    exit;
}
try {
    // Initialize connection and service
    $conn = Database::getConnection();
    $userService = new UserService($conn);
    $user = $userService->fisExistedEmail($email);
    
    // Check if current password matches user's password input
    // Hash password and save it
    $hashed = password_hash($new, PASSWORD_BCRYPT);
    $updated = $userService->updatePassword($user->getId(), $hashed);

    // Return result 
    if ($updated) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}