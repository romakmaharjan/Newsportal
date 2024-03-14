<?php
require_once "config/helper.php";
require_once "connection/database.php";

$uri =$_GET['uri'] ?? 'home';
$uri =str_replace('.php','',$uri);
$title =ucfirst($uri);
$uri = $uri.'.php';

$pagePath="pages/$uri";

require_once "header.php";
if(file_exists($pagePath) && is_file($pagePath)){
    include $pagePath;
}else{
    include 'pages/404.php';
}

require_once "footer.php";