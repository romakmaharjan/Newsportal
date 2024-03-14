<?php
require_once "../config/helper.php";
require_once "../connection/database.php";

$sql = "SELECT * FROM users WHERE email='admin@gmail.com'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)==0){
    $password =md5('admin002');
    $insert ="INSERT INTO users (name, email, password,gender, role)
    VALUES('admin','admin@gmail.com','$password','male','admin')";
    mysqli_query($conn, $insert);
}

$errors = [
    'email' => '',
    'password' => ''
];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = $key . "field is required";
        }
    }

    if (!array_filter($errors)) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            unset($user['password']);
            $_SESSION['user'] = $user;
            $_SESSION['is_login'] = true;
            header("Location:" . admin_url());
        } else {
            $errors['email'] = "Email or password is incorrect";
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    * {
        box-sizing: border-box;
    }


    body {
        margin: 0;
        font-family: poppins, arial, helvetica, sans-serif;
        font-size: 16px;
        font-weight: 400;
        color: #666666;
        background: #eaeff4;
    }

    button,
    input,
    select,
    textarea {
        font: inherit;
    }

    a {
        color: inherit;
    }


    .wrapper {
        margin: 0 auto;
        width: 100%;
        max-width: 1140px;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .container {
        position: relative;
        width: 100%;
        max-width: 800px;
        height: auto;
        display: flex;
        background: #ffffff;
        box-shadow: 0 0 5px #999999;
    }

    .login .col-left,
    .login .col-right {
        padding: 30px;
        display: flex;
    }

    .login .col-left {
        width: 60%;
        clip-path: polygon(0 0, 0% 100%, 100% 0);
        background: #2aa15f;
    }

    .login .col-right {
        padding: 60px 30px;
        width: 50%;
        margin-left: -10%;
    }

    .login .login-text {
        position: relative;
        width: 100%;
        color: #ffffff;
    }

    .login .login-text h2 {
        margin: 0 0 15px 0;
        font-size: 30px;
        font-weight: 700;
    }

    .login .login-text p {
        margin: 0 0 20px 0;
        font-size: 16px;
        font-weight: 500;
        line-height: 22px;
    }

    .login .login-text .btn {
        display: inline block;
        font-family: poppins;
        font-size: 16px;
        padding: 7px 20px;
        letter-spacing: 1px;
        text-decoration: none;
        border-radius: 30px;
        color: #ffffff;
        outline: none;
        border: 1px solid #ffffff;
        box-shadow: inset 0 0 0 0 #ffffff;
        transition: .3s;
    }

    .login .login-text .btn:hover {
        color: #2aa15f;
        box-shadow: inset 150px 0 0 0 #ffffff;

    }

    .login .login-form {
        position: relative;
        width: 100;
    }

    .login .login-form h2 {
        margin: 0 0 15px 0;
        font-size: 22px;
        font-weight: 700;
    }

    .login .login-form p {
        margin: 0 0 10px 0;
        text-align: left;
        color: #666666;
        font-size: 15px;
    }

    .login .login-form p:last-child {
        margin: 0;
        padding-top: 3px;
    }

    .login .login-form p a {
        color: #2aa15f;
        font-size: 14px;
        text-decoration: none;
    }

    .login .login-form label {
        display: block;
        width: 100%;
        margin-bottom: 2px;
        letter-spacing: .5px;
    }

    .login .login-form p:last-child label {
        width: 60%;
        float: left;
    }

    .login .login-form label span {
        color: #ff574e;
        padding-left: 2px;
    }

    .login .login-form input {
        display: block;
        width: 100%;
        height: 35px;
        padding: 0 10px;
        outline: none;
        border: 1px solid #cccccc;
        border-radius: 5px;
    }

    .login .login-form input:focus {
        border-color: #ff574e;
    }

    .login .login-form button,
    .login .login-form [type=submit] {
        display: inline-block;
        width: 100%;
        margin-top: 5px;
        color: #2aa15f;
        font-size: 16px;
        letter-spacing: 1px;
        cursor: pointer;
        background: transparent;
        border: 1px solid #2aa15f;
        border-radius: 10px;
        box-shadow: inset 0 0 0 0 #2aa15f;
        transition: .3s;
    }

    .login .login-form [type=submit]:hover {
        color: #ffffff;
        box-shadow: inset 150px 0 0 0 #2aa15f;
    }
    </style>
</head>

<body>
    <div class="wrapper login">
        <div class="container">
            <div class="col-left">
                <div class="login-text">
                    <h2>welcome!</h2>
                    <p>News Website</p>
                </div>
            </div>

            <div class="col-right">
                <div class="login-form">
                    <h2>Login</h2>
                    <form action="" method="post">
                        <p>
                            <label id="email">Email<span>*</span>
                                <a style="color: red;"><?= $errors['email']; ?></a>
                            </label>
                            <input type="text" id="email" placeholder="email" name="email">
                        </p>
                        <p>
                            <label id="password">Password<span>*</span>
                                <a style="color: red;"><?= $errors['password']; ?></a>
                            </label>
                            <input type="password" name="password" id="password" placeholder="password">
                        </p>
                        <p>
                            <button id="btn1">Login</button>
                        </p>
                        <p>
                            <a href="">forget password?
                            </a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>