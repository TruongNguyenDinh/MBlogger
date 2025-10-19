<?php
// ✅ Bắt buộc đặt ở đầu file, trước mọi output
header('Content-Type: application/json; charset=UTF-8');
mb_internal_encoding("UTF-8");

require_once __DIR__ . '/../../controls/newscontroller.php';
$controller = new Newscontroller();
$details = $controller->getDetail();

// ✅ Duyệt dữ liệu ra mảng gọn
$news = [];
foreach ($details as $the_news) {
    $news[$the_news['id']] = [
        'id'      => $the_news['id'],
        'author'  => $the_news['author'],
        'date'    => $the_news['created_at'],
        'title'   => $the_news['title'],
        'content' => $the_news['content']
    ];
}

// ✅ Lấy id trên URL (vd: news-detail.php?id=5)
$id = $_GET['id'] ?? null;

if ($id && isset($news[$id])) {
    // ✅ JSON_UNESCAPED_UNICODE: không escape tiếng Việt
    echo json_encode($news[$id], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Không tìm thấy bài viết"], JSON_UNESCAPED_UNICODE);
}
?>
