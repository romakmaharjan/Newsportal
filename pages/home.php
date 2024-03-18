<?php
$sql="SELECT category.cid,category.name as category_name,users.id,users.name,
news.* FROM news
JOIN category ON category.cid=news.category_id
JOIN users ON users.id=news.created_by ORDER BY news.nid DESC";
$newsResult = mysqli_query($conn, $sql);


?>
<div class="news-list">
    <?php foreach ($newsResult as $news) { ?>
    <div class="news-box">

        <?php if($news['image']){ ?>
        <img src="<?=public_url('news/'.$news['image'])?>" alt="">
        <?php } ?>
        <h1><?=$news['title']; ?></h1>
        <p><?=$news['summary'];?></p>
        <a href="">Read More</a>
        <span>Category: <?=$news['category_name']?></span>
        <span>Published by: <?=$news['name']?></span>
    </div>
    <?php } ?>
</div>