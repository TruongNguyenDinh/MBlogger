<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__.'/../service/ArticleService.php';
require_once __DIR__.'/../service/GithubService.php';
$basePath = '/mblogger/views';
try {
    // Lấy connection
    $conn = Database::getConnection();
    $service = new UserService($conn);
    $artiService = new ArticleService($conn);
    $githubService = new GithubService($conn);
    $userId = $_SESSION['user']['id'];
    
    // Gọi service để lấy thông tin người dùng
    $user = $service->getUserById($userId);
    // Bài đăng cá nhân
    $articles = $artiService->indiviDualArti($user->getId());
    //
    $gitIf = $githubService->getGithubInfoByUserId($userId);
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}