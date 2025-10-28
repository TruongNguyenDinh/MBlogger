<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="../../assets/css/flexcardpost.css">
<link rel="stylesheet" href="../../assets/css/commentcard.css">
<div class="fcp-container" data-current-id="">
    <div class="fcp-left-side">
        <div class="container-post">
            <div class="article-content">
            </div>
        </div>
    </div>
    <div class="fcp-right-side">
        <div class="fcp-comment">
            <?php include(__DIR__ . "/comment-card.php"); ?>
        </div>
        <div class="fcp-wcomment">
            <form method="POST" action="../../controls/commentcontroller.php">
                <input type="hidden" name="article_id" value="<?= $article_id ?>">  
                <textarea id="wcomment" name="wcomment" 
                placeholder="<?=
                    isset($_SESSION['user']['id']) 
                    ? 'Write your comment here ...' 
                    : 'You must log in to comment...'
                ?>" 
                <?= isset($_SESSION['user']['id']) ? '' : 'disabled' ?>></textarea>
            <button type="submit" <?= isset($_SESSION['user']['id']) ? '' : 'disabled' ?>>Send</button>
            </form>
        </div>
    </div>
</div>
