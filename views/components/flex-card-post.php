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
                <textarea id="wcomment" name="wcomment" placeholder="Write your comment here ..."></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
