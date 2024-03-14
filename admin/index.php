<?php
require_once "../config/helper.php";
require_once "../connection/database.php";

if (!isset($_SESSION['user']) && !$_SESSION['is_login']) {
    header("Location:" . base_url());
    exit();
}

?>
<?php
require_once "header.php";
?>

<div class="main">
    <?php
    $uri = $_GET['uri'] ?? 'dashboard';
    $uri = str_replace('.php', '', $uri);
    $title = ucfirst($uri);
    $uri = $uri . '.php';
    $pagePath = "pages/$uri";
    if (file_exists($pagePath) && is_file($pagePath)) {
        include $pagePath;
    } else {
        include 'pages/404.php';
    }

    ?>

</div>

<?php
require_once "footer.php";
?>
