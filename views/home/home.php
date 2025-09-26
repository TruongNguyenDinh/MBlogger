<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../assets/css/home.css">
</head>
<body>
    <header>
        <?php include("../header/header.html") ?>
    </header>
    <main>
        <div class="feeds-side-home">
                <?php include("../components/post-card.php")?>
        </div>
        <div class="news-side-home">
            <div class="title-news">News</div>
            <div class="content-news">
                <?php include("../components/news.php") ?>
            </div>
        </div>
    </main>
    <script src="../../assets/js/home.js"></script>
</body>
</html>