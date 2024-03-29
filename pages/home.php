<?php
$sql = "SELECT category.cid, category.name as category_name, users.id, users.name,
                news.*, COUNT(comments.id) AS comment_count
        FROM news
        JOIN category ON category.cid = news.category_id
        JOIN users ON users.id = news.created_by
        LEFT JOIN comments ON comments.news_id = news.nid
        GROUP BY news.nid
        ORDER BY news.nid DESC
        LIMIT 6";
$newsResult = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Cards</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .container {
        width: 100%;
        margin: auto;
    }

    body {
        margin: 0;
        padding: 0;
    }

    nav {
        margin: 0px 0 20px 0;
    }

    .news-list {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 20px;
        padding: 20px;
    }

    .news-box {
        width: 95%;
        background: lightgray;
        padding: 4px;
        height: 400px;
    }

    .news-box img {
        width: 100%;
        height: 200px;
    }
    </style>
</head>

<div class="news-list">
    <?php foreach ($newsResult as $news) { ?>
    <div class="news-box">

        <?php if($news['image']){ ?>
        <img src="<?=public_url('news/'.$news['image'])?>" alt="">
        <?php } ?>
        <h1><?=$news['title']; ?></h1>
        <p><?=$news['summary'];?></p>
        <a href="<?= base_url('news-details.php?id=' . $news['nid']) ?>">Read More</a>
        <span>Category: <?=$news['category_name']?></span>
        <span>Published by: <?=$news['name']?></span>
        <span>Comments: <?= $news['comment_count'] ?></span>

    </div>
    <?php } ?>
</div>