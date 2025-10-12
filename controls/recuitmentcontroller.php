<?php
require_once __DIR__ . '/../service/UploadService.php';
require_once __DIR__ . '/../service/NewsService.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getConnection();
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $topic = $_POST['topic'] ?? '';
    $author_id = $_SESSION['user']['id'] ?? 0;

    // Upload banner nếu có
    $thumbnail = null;
    if (!empty($_FILES['banner']['name'])) {
        $thumbnail = UploadService::uploadImgNews($_FILES['banner']);
    }
    $newsService = new NewsService($conn);
    $result = $newsService->createNews($title, $topic, $content, $thumbnail, $author_id);   
    echo json_encode($result);
}
?>
