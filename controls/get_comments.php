<?php
if (!isset($_GET['articleId'])) {
    echo "Bài viết không tồn tại.";
    exit;
}

$articleId = intval($_GET['articleId']);

// Hardcode comment cho từng bài viết
$allComments = [
    1 => [
        ["name" => "Alice", "content" => "Bài viết rất hay!"],
        ["name" => "Bob", "content" => "Mình học được nhiều điều từ project này."]
    ],
    2 => [
        ["name" => "Charlie", "content" => "Chatbot này thật tuyệt!"],
        ["name" => "Diana", "content" => "Rất hữu ích."]
    ]
];

$comments = $allComments[$articleId] ?? [];

// Gọi file comment_card.php để render
include "../views/components/comment-card.php";
