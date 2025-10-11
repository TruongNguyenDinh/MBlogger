<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controls/HomeController.php';

// Tạo kết nối database
$conn = Database::getConnection();

// Khởi tạo controller
$controller = new HomeController($conn);

// Gọi hàm lấy dữ liệu
$data = $controller->renderHome();
$articles = $data['results'];  // lấy mảng kết quả ra
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>
<body>
    <header>
        <?php include("../header/header.html") ?>
    </header>
    <main>
        <div class="feeds-side-home">
            <?php 
                include("../components/post-card.php");
            ?>
        </div>
        <div class="news-side-home">
            <div class="title-news">News</div>
            <div class="content-news">
                <?php include("../components/news.php") ?>
            </div>
        </div>
        <div class="fcpContainer" id="fcpContainer" style="display:none;">
            <?php include("../components/flex-card-post.php")?>
        </div>
    </main>
    <script>
        const articles = <?php echo json_encode($articles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    </script>
    <script src="../../assets/js/home.js"></script>
    <script src="../../assets/js/article.js"></script>
</body>
</html>