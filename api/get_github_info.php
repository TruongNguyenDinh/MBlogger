<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/GithubService.php';

header('Content-Type: application/json');

try {
    $conn = Database::getConnection();
    $service = new GithubService($conn);

    // Lấy query trên URL (nếu có)
    $query = $_GET['query'] ?? 'user_reference';

    // Xác định userId cần lấy
    if ($query === 'user_reference') {
        if (!isset($_SESSION['user']['id'])) {
            throw new Exception("Chưa đăng nhập");
        }
        $userId = $_SESSION['user']['id'];
    } else {
        $userId = intval($query); // query là id của người khác
    }

    // Lấy thông tin GitHub
    $github = $service->getGithubInfoByUserId($userId);

    if ($github) {
        echo json_encode([
            'username' => $github->getGithubUsername(),
            'token' => $github->getAccessToken(),
        ]);
    } else {
        echo json_encode([
            'username' => null,
            'token' => null,
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'username' => null,
        'token' => null,
    ]);
}
