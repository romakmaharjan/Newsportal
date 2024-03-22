<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-main">
        <div class="header">
            <div class="top-container">
                <div class="company-name">
                    <h1>News Website</h1>
                </div>
                <div class="top-menu">
                    <a href="<?= admin_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
        <div class="aside">
            <div class="header-container">
                <div class="profile">
                    <div class="image-box">
                        <img src="<?= public_url('users/' . $_SESSION['user']['image']) ?>" alt="profile">

                    </div>
                    <div class="name-box">
                        <h3><?= $_SESSION['user']['name'] ?></h3>
                    </div>

                </div>
                <ul>
                    <li><a href="<?= admin_url(); ?>">Dashboard</a></li>
                    <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                    <li><a href="<?= admin_url('add-user') ?>">Add User</a></li>
                    <li><a href="<?= admin_url('show-users') ?>">Show Users</a></li>
                    <?php } else { ?>
                    <li><a href="<?= admin_url('show-users') ?>">Show Profile</a></li>
                    <?php } ?>

                    <li><a href="<?= admin_url('manage-category') ?>">Manage Category</a></li>
                    <li><a href="<?= admin_url('add-news') ?>">Add News</a></li>
                    <li><a href="<?= admin_url('show-news') ?>">Show News</a></li>
                    <li><a href="<?= admin_url('add-gallery') ?>">Add Gallery</a></li>
                    <li><a href="<?= admin_url('show-gallery') ?>">Show Gallery</a></li>
                </ul>
            </div>
        </div>