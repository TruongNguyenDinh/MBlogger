<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="../../assets/css/newspage.css">
    <script src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>
</head>
<body>
    <header>
        <?php include("../header/header.html") ?>
    </header>
    <main>
        <div class="news-card">
            <?php include('../components/news.php')?>
        </div>
        <div class="news-modal">
            <button id="backBtn">⬅ Back</button>
            <div id="who-post"></div>
            <div id="news-detail"></div>
        </div>
        <div class="recruitment-news" style="display: none;">
            <button id="backBtn_re">⬅ Back</button>
            <?php include("../components/recruitment.php") ?>
        </div>
        <div class="news-scene_more">
            <div class="news-scene_more_toglebtn" id = "more-btn">More</div>
            <div class="group_btns" style="display: none;">
                <div class="recruitment" id ="recruitment-btn">Recruitment</div>
            </div>
        </div>
    </main>
    <script src="../../assets/js/news.js"></script>
    <!-- 1. Thêm thư viện Markdown + Highlight -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>


</body>
</html>