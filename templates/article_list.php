<?php include './header.php' ?>
<?php foreach ($articles as $article): ?>
<div>
    <div><?=$article['created_at']?> - <?=$article['title']?></div>
    <div>
        <div><?=$article['text']?></div>
        <div><?=$article['image_url']?></div>
    </div>
    <div>Author: <?=$article['author_id']?> Kommentare: 0</div>
</div>
<?php endforeach; ?>
<?php include './footer.php' ?>
