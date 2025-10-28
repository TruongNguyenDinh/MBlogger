<?php
/*
============ API TO CHANGE PASSWORD FORM SETTING-> ACCOUNT================
This api will get data form the client(form changpass.js file) 
and Process the input data and then perform new password updates
if it is verified that it is the account owner.
==========================================================================
*/
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
// get data form client (JSON) | changepass.js-> this
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
    // Initialize connection and service
    $conn = Database::getConnection();
    $userService = new UserService($conn);
    // Call user
    $user = $userService->getUserById($_SESSION['user']['id']);

    // Check if current password matches user's password input
    if (!password_verify($current, $user->getPasswordHash())) {
        echo json_encode(['success' => false, 'message' => 'Incorrect current password.']);
        exit;
    }

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
?>
