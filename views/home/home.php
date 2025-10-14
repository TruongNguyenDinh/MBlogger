<?php
require_once __DIR__ . '/../../controls/HomeController.php';
require_once __DIR__ .'/../../controls/newscontroller.php';
// Dữ liệu ở news
$controller = new Newscontroller();
$thumbnails = $controller->getThumbnail();
$details = $controller->getDetail();
// tạo controller và lấy dữ liệu
$controller = new HomeController();
$articles = $controller->getArticles();

if (!$articles) {
    echo "<pre style='color:red'>Không có dữ liệu bài viết!</pre>";
}
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
                // Truy cập trực tiếp qua mảng $data
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
    <script src="../../assets/js/popup.js"></script>
    <script src="../../assets/js/renderRM.js"></script>
    <script src="../../assets/js/utilities.js"></script>
</body>
</html>