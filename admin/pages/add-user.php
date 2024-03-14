<?php


if ($_SESSION['user']['role'] != 'admin') {
    header('location: ' . admin_url('show-users'));
    exit();
}

$errors = [
    'name' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'role' => ''
];

$old = [
    'name' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'role' => ''

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

    $email = $_POST['email'];
    $sql="SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = "Email already exists";
    }

    if(!array_filter($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $image = "";
        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = md5(uniqid()) . ".$ext";
            $tmpName = $_FILES['image']['tmp_name'];
            $uploadPath = public_path("users/$imageName");
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                die("File Upload Failed");
            } else {
                $image = $imageName;
            }

        }

        $sql = "INSERT INTO users (name, email, password,gender,role,image)
            VALUES ('$name', '$email', '$password','$gender','$role','$image')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Record added successfully";
            redirect_back();
        } else {
            $_SESSION['error'] = "Record not added";
            redirect_back();
        }
    }

}



?>


<div class="container">
    <h1>Add Users <a href="<?=admin_url('show-users')?>">Show users</a></h1>
    <?php message();?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:
                <a style="color: red;"><?= $errors['name']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $old['name']; ?>"
                   id="name" name="name">
        </div>
        <div class="form-group">
            <label for="email">Email:
                <a style="color: red;"><?= $errors['email']; ?></a>
            </label>
            <input type="email" value="<?= $old['email']; ?>"
                   class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Password:
                <a style="color: red;"><?= $errors['password']; ?></a>
            </label>
            <input type="password" value="<?= $old['password']; ?>"
                   class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="gender">Gender:
                <a style="color: red;"><?= $errors['gender']; ?></a>
            </label>
            <label><input type="radio"
                    <?= $old['gender'] == 'male' ? 'checked' : '' ?>
                          name="gender" value="male">Male</label>
            <label><input type="radio"
                    <?= $old['gender'] == 'female' ? 'checked' : '' ?>
                          name="gender" value="female">Female</label>
        </div>
        <div class="form-group">
            <label for="role">Role:
                <a style="color: red;"><?= $errors['role']; ?></a>
            </label>
            <select name="role" class="form-control" id="role">
                <option value="">Select Role</option>
                <option
                    <?= $old['role'] == 'admin' ? 'selected' : '' ?>
                        value="admin">Admin
                </option>
                <option
                    <?= $old['role'] == 'user' ? 'selected' : '' ?>
                        value="user">User
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="form-group">
            <button class="btn-success">Add Record</button>
        </div>
    </form>
</div>