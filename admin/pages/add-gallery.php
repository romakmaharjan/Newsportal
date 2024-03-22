<?php
$catSql = "SELECT * FROM category";
$catData = mysqli_query($conn, $catSql);

$errors = [
    'category_id' => '',
    'title' => '',
    'image' => '',
    'description' => '',
];

$old = [
    'category_id' => '',
    'title' => '',
    'description' => '',
];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = 'This field is required';
        } else {
            $old[$key] = $value;
        }
    }
     if (!array_filter($errors)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        // Image upload logic
        $image = "";
        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = md5(uniqid()) . ".$ext";
            $tmpName = $_FILES['image']['tmp_name'];
            $uploadPath = public_path("gallery-img/$imageName");
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                die("File Upload Failed");
            } else {
                $image = $imageName;
            }
        }

        $category_id = $_POST['category_id']; // Fetch the category_id from the form

        $insertSql = "INSERT INTO gallery (category_id, title, image, description) 
                      VALUES ('$category_id', '$title', '$image', '$description')";

        if (mysqli_query($conn, $insertSql)) {
            $_SESSION['success'] = "Gallery added successfully";
            header("Location:" . admin_url('index')); // Redirect to home page
            exit();
        } else {
            $_SESSION['error'] = "Gallery not added";
            redirect_back();
        }
    }
}


    ?>
<div class="container">
    <h1>Add Gallery</h1>
    <?php message(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_id">Category:
                <a style="color: red;"><?= $errors['category_id']; ?></a>
            </label>
            <select name="category_id" class="form-control" id="category_id">
                <option value="">Select Category</option>
                <?php while ($row = mysqli_fetch_assoc($catData)) { ?>
                <option value="<?= $row['cid'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title:
                <a style="color: red;"><?= $errors['title']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $old['title']; ?>" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="image">Image:
                <a style="color: red;"><?= $errors['image']; ?></a>
            </label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="description">Description:
                <a style="color: red;"><?= $errors['description']; ?></a>
            </label>
            <textarea name="description" class="form-control" id="description"><?= $old['description']; ?></textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Add Gallery</button>
        </div>
    </form>
</div>