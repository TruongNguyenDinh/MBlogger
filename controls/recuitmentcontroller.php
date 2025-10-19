<?php
require_once __DIR__ . '/../service/UploadService.php';
require_once __DIR__ . '/../service/NewsService.php';
require_once __DIR__ . '/../service/TopicService.php';
require_once __DIR__ . '/../repositories/TopicRepository.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Khởi tạo kết nối db
    $conn = Database::getConnection();
    // Lấy dữ liệu
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $rawtopic = $_POST['topic'] ?? '';
    $author_id = $_SESSION['user']['id'] ?? 0;
    //Khởi tạo service
    $newsService = new NewsService($conn);
    $topicService = new TopicService($conn);
    $topicRepo = new TopicRepository($conn);
    // Upload banner nếu có
    $thumbnail = null;
    if (!empty($_FILES['banner']['name'])) {
        $thumbnail = UploadService::uploadImgNews($_FILES['banner']);
    }
    $result = $newsService->createNews($title, $rawtopic, $content, $thumbnail, $author_id);   
    $news_id = $result['id'];
    $tmp = $topicService->removeVietnameseAccentsString($rawtopic);
    $topicRepo->insertTopicWithNews($tmp,$news_id);
    echo json_encode($result);
}
?>
