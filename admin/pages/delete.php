<?php

if ($_SESSION['user']['role'] != 'admin') {
    header('location: ' . admin_url('show-users'));
    exit();
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $image = $user['image'];
    $imagePath = public_path('users/' . $image);
    if (file_exists($imagePath) && is_file($imagePath)) {
        unlink($imagePath);
    }
    $sql = "DELETE FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location: ' . admin_url('show-users'));
    }
} else {
    header('location: ' . admin_url('show-users'));
}