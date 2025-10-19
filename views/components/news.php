<link rel="stylesheet" href="../../assets/css/news.css">
<?php foreach ($thumbnails as $thumbnail): ?>
<div class="news-card_elem" data-id="<?php echo $thumbnail['data_id'] ?>">
    <a href ="#"><img src="<?php echo $thumbnail['thumbnail'] ?>" alt="news img"></a>
</div>
<?php endforeach; ?>