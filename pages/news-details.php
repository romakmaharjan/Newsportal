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