<?php
require_once __DIR__ . '/../service/UploadService.php';
require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__ . '/../config/db.php';
$conn = Database::getConnection();
$userService = new UserService($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $path = UploadService::uploadImgAvt($file);
    $userId = $_SESSION['user']['id']; // hoặc từ session
    $userService->changeAvatar($userId, $path); 
    echo json_encode(['success' => true, 'path' => $path]);
    }
?>
