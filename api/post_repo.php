<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/ArticleService.php';
require_once __DIR__ . '/../service/TopicService.php';

try {
    //Lấy dữ liệu từ POST
    $raw = file_get_contents('php://input');
    //Chuyển JSON thành mảng PHP
    $data = json_decode($raw, true);
    if (!$data) {
        echo json_encode([
            "status" => "error",
            "message" => "No valid data received."
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $conn = Database::getConnection();
    $articleService = new ArticleService($conn);
    $topicService = new TopicService($conn);

    $result = $articleService->addNewArticle($data);
    if ($result['status'] === 'success') {
        $articleId = $result['article_id']; // <-- đây là ID bài viết vừa thêm
        $topic = $topicService->removeVietnameseAccentsArray($data['topics']);
        $topicService->addTopicsForArticle($topic,$articleId);
    } else {
        echo "Lỗi: " . $result['message'];
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "System error: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
