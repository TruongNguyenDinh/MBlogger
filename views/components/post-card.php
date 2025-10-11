<link rel="stylesheet" href="../../assets/css/article.css">

<?php foreach ($articles as $article): ?>
<div class="container-post">
    <div class="article-header">
        <div class="article-user_info">
            <div class="user-avt"></div>
            <div class="username"><?php echo ($article["username"]); ?></div>
        </div>
        <div class="source-repo">Repo: <?php echo ($article["repo"]); ?></div>
        <div class="source-branch">Branch: <?php echo ($article["branch"]); ?></div>
        <div class="btn-open">Open</div>
        <div class="article-id">ID: <?php echo $article["id"]; ?></div>
    </div>
    <div class="article-title">
        <?php echo ($article["title"]); ?>
    </div>
    <div class="article-content">
        <?php echo (htmlspecialchars($article["content"])); ?>
    </div>
    <button class="toggle-btn">Show more</button>
    <div class="article-comment" data-id="<?php echo $article["id"]; ?>">
        Comment: <?php echo $article["acomment"]; ?>
    </div>
</div>
<?php endforeach; ?>
