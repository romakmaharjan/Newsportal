<?php

if (!empty($_GET['search'])) {
    $id = $_SESSION['user']['id'];
    $search = $_GET['search'];
    $sql = "SELECT * FROM users WHERE id!='$id' AND name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

} else {
    if ($_SESSION['user']['role'] == 'admin') {
        $id = $_SESSION['user']['id'];
        $sql = "SELECT * FROM users WHERE id!='$id'";
        $result = mysqli_query($conn, $sql);
    } else {
        $id = $_SESSION['user']['id'];
        $mySql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $mySql);
    }

}


if (isset($_POST['admin_role'])) {
    $id = $_POST['criteria'];
    $sql = "UPDATE users SET role='user' WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        redirect_back();
    } else {
        $_SESSION['error'] = "Failed to update role";
        redirect_back();
    }
}
if (isset($_POST['user_role'])) {
    $id = $_POST['criteria'];
    $sql = "UPDATE users SET role='admin' WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        redirect_back();
    } else {
        $_SESSION['error'] = "Failed to update role";
        redirect_back();
    }
}


?>


<div class="container">
    <div class="main-box-section">
        <h1>User List
            <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                <a href="<?= admin_url('add-user') ?>">Add User</a>
            <?php } ?>
        </h1>

        <?php if ($_SESSION['user']['role'] == 'admin') { ?>
            <form action="">
                <input type="text" name="search" placeholder="Search">
                <button type="submit">Search</button>
            </form>
        <?php } ?>

        <table class="table">
            <thead>
            <tr>
                <th>sn</th>
                <th style="width: 10%;">Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $key => $user) { ?>
                <tr>
                    <td><?= ++$key; ?></td>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['gender']; ?></td>

                    <td>
                        <form action="" method="post">
                            <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                                <input type="hidden" name="criteria" value="<?= $user['id']; ?>">
                                <?php if ($user['role'] == 'admin') { ?>
                                    <button class="arole_btn" name="admin_role"><?= $user['role']; ?></button>
                                <?php } else { ?>
                                    <button class="urole_btn" name="user_role"><?= $user['role']; ?></button>

                                <?php } ?>

                            <?php } else { ?>
                                <?= $user['role']; ?>
                            <?php } ?>
                        </form>

                    </td>
                    <td>
                        <img src="<?= public_url('users/' . $user['image']); ?>" width="40" alt="">
                    </td>
                    <td>
                        <a href="<?= admin_url('edit?id=' . $user['id']) ?>" class="btn-success">Edit</a>
                        <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                            <a href="<?= admin_url('delete?id=' . $user['id']) ?>" class="btn-danger">
                                Delete</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>