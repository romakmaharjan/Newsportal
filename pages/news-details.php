<?php 

$id= $_GET['id'];

$sql="SELECT * FROM news WHERE nid=$id";
$newsResult= mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($newsResult);

?>
<h1><?=$news['title']?></h1>
<?php if($news['image']){ ?>
<img src="<?=public_url('news/'.$news['image'])?>" alt="">
<?php } ?>
<P><?=$news['description']?></P>
<!-- Comment Form -->
<form action="add_comment.php" method="post">
    <input type="hidden" name="news_id" value="<?= $news['nid'] ?>">
    <div class="form-group">
        <label for="name<?= $news['nid'] ?>">Name:</label>
        <input type="text" class="form-control" id="name<?= $news['nid'] ?>" name="name">
    </div>
    <div class="form-group">
        <label for="email<?= $news['nid'] ?>">Email:</label>
        <input type="email" class="form-control" id="email<?= $news['nid'] ?>" name="email">
    </div>
    <div class="form-group">
        <label for="comment<?= $news['nid'] ?>">Comment:</label>
        <textarea name="comment" class="form-control" id="comment<?= $news['nid'] ?>"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </div>
</form>