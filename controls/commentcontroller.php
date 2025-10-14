<?php
session_start();
require_once __DIR__ . '/../service/CommentService.php';
require_once __DIR__ . '/../config/db.php';

$conn = Database::getConnection();
$commentService = new CommentService($conn);

$article_id = intval($_GET['articleId'] ?? $_POST['article_id'] ?? 0);
if ($article_id === 0) {
    echo "Bài viết không tồn tại."; 
    exit;
}

// Nếu gửi comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wcomment'])) {
    $user_id = $_SESSION['user']['id'] ?? 0;
    $content = trim($_POST['wcomment']);
    $commentService->addCommentService($user_id, $article_id, $content);
}

// Lấy comment
$comments = array_reverse($commentService->getComments($article_id));
foreach ($comments as $comment) {
    include __DIR__ . '/../views/components/comment-card.php';
}
?>
