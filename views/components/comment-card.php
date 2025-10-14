
<div class="comment-card-container">
    <div class="ccn-top">
        <div class="ccn-avt"><img src="<?php echo htmlspecialchars($comment['url_avt']) ?>" alt=""></div>
        <div class="ccn-name">
            <?php echo htmlspecialchars($comment['fullname']); ?>
        </div>
        <div class="cnn-date"><?php echo htmlspecialchars($comment['created_at']) ?></div>
    </div>
    <div class="ccn-content">
        <?= nl2br(htmlspecialchars($comment['content'])) ?>
    </div>
</div>