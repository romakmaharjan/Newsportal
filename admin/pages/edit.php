<?php


$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$errors = [
    'name' => '',
    'gender' => '',

];

$old = [
    'name' => '',
    'gender' => '',


];

if (!empty($_POST)) {

    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = "This field is required";
        } else {
            $old[$key] = $value;
        }
    }
    if (!isset($_POST['gender'])) {
        $errors['gender'] = "This field is required";
    } else {
        $old['gender'] = $_POST['gender'];
    }


    if (!array_filter($errors)) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        if(!empty($_FILES['image']['name'])){
            $oImage=$user['image'];
            $path=public_path("users/$oImage");
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = md5(uniqid()) . ".$ext";
            $tmpName = $_FILES['image']['tmp_name'];
            $uploadPath = public_path("users/$imageName");
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                die("File Upload Failed");
            } else {
                $image = $imageName;
            }
            $sql = "UPDATE users SET name='$name',gender='$gender',image='$image' WHERE id='$id'";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                $_SESSION['success'] = "User updated successfully";
                redirect_back('show-users');
            } else {
                $_SESSION['error'] = "Failed to update user";
                redirect_back();
            }
        }
        $sql = "UPDATE users SET name='$name',gender='$gender' WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $_SESSION['success'] = "User updated successfully";
            redirect_back('show-users');
        } else {
            $_SESSION['error'] = "Failed to update user";
            redirect_back();
        }


    }

}


?>


<div class="container">
    <h1>Update Info<a href="<?= admin_url('show-users') ?>">Show users</a></h1>
    <?php message(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:
                <a style="color: red;"><?= $errors['name']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $user['name']; ?>" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" value="<?= $user['email']; ?>" class="form-control" disabled id="email" name="email">
        </div>

        <div class="form-group">
            <label for="gender">Gender:
                <a style="color: red;"><?= $errors['gender']; ?></a>
            </label>
            <label><input type="radio" <?= $user['gender'] == 'male' ? 'checked' : '' ?> name="gender"
                    value="male">Male</label>
            <label><input type="radio" <?= $user['gender'] == 'female' ? 'checked' : '' ?> name="gender"
                    value="female">Female</label>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="form-group">
            <?php if($user['image']): ?>
            <img src="<?= public_url('users/' . $user['image']); ?>" width="60" alt="">
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button class="btn-success">Update</button>
        </div>
    </form>
</div>