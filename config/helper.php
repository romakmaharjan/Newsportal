<?php

session_start();

function base_url($url = "")
{
    return "http://localhost/ittrainingnepalcourse/newswebsite1/$url";
}

function admin_url($url = "")
{
    return "http://localhost/ittrainingnepalcourse/newswebsite1/admin/$url";
}

function public_path($path = "")
{
    return dirname(__DIR__) . "/public/$path";
}

function public_url($url = "")
{
    return "http://localhost/ittrainingnepalcourse/newswebsite1/public/$url";
}


function redirect_back()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}


function message()
{
    if (isset($_SESSION['success'])) {
        echo "<div class='success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
}