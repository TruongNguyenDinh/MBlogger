<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!$showLoginPopup) {
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../service/UserService.php';
    require_once __DIR__ . '/../service/ArticleService.php';
    require_once __DIR__ . '/../service/GithubService.php';

    $basePath = '/mblogger/views';

    try {
        $conn = Database::getConnection();
        $service = new UserService($conn);
        $artiService = new ArticleService($conn);
        $githubService = new GithubService($conn);

        // ---- LẤY THÔNG TIN USER ----
        $query = $_GET['query'] ?? 'user_reference';
        if ($query === 'user_reference') {
            $userId = $_SESSION['user']['id'];
        } else {
            $userId = intval($query);
        }

        $user = $service->getUserById($userId);
        $articles = $artiService->indiviDualArti($userId);
        $gitIf = $githubService->getGithubInfoByUserId($userId);

    } catch (Exception $e) {
        die("Lỗi: " . $e->getMessage());
    }
}
else {
    $user = null;
    $articles = [];
    $gitIf = null;
}

