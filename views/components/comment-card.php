<link rel="stylesheet" href="../../assets/css/commentcard.css">
<?php foreach ($comments as $comment): ?>
<div class="comment-card-container">
    <div class="ccn-top">
        <div class="ccn-avt"></div>
        <div class="ccn-name">
            <?php echo htmlspecialchars($comment['name']); ?>
        </div>
    </div>
    <div class="ccn-content">
        <?php echo htmlspecialchars($comment['content']); ?>
    </div>
</div>
<?php endforeach; ?>