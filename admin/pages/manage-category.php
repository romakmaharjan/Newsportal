<?php

$role = $_SESSION['user']['role'];
if ($role != 'admin') {
    $id = $_SESSION['user']['id'];
    $cSql = "SELECT users.id,users.name as user_name,category.* FROM
              category JOIN users ON category.created_by=users.id 
               WHERE category.created_by='$id'";
    $categoryResult = mysqli_query($conn, $cSql);
} else {
    $cSql = "SELECT users.id,users.name as user_name,category.* FROM
              category JOIN users ON category.created_by=users.id";
    $categoryResult = mysqli_query($conn, $cSql);

}


$errors = [
    'name' => '',
    'slug' => '',

];

$old = [
    'name' => '',
    'slug' => '',
    'cid' => '',
    'btn_name' => 'Add Category'
];



if (isset($_POST['add_category'])) {
    unset($_POST['add_category']);

    if(!empty($_POST['cid'])){
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errors[$key] = "This field is required";
            } else {
                $old[$key] = $value;
            }
        }

        if (!array_filter($errors)) {
            $id = $_POST['cid'];
            $catName = $_POST['name'];
            $slug = $_POST['slug'];
            $sql = "SELECT * FROM category WHERE name='$catName' AND cid!='$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $errors['name'] = "Category name already exists";
            }

            $sql = "SELECT * FROM category WHERE slug='$slug' AND cid!='$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $errors['slug'] = "Category slug already exists";
            }

            if (!array_filter($errors)) {
                $sql = "UPDATE category SET name='$catName',slug='$slug' WHERE cid='$id'";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['success'] = "Record updated successfully";
                    redirect_back();
                } else {
                    $_SESSION['error'] = "Record not updated";
                    redirect_back();
                }
            }
        }

    }else{
        unset($_POST['cid']);
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errors[$key] = "This field is required";
            } else {
                $old[$key] = $value;
            }
        }

        $catName = $_POST['name'];
        $slug = $_POST['slug'];
        $sql = "SELECT * FROM category WHERE name='$catName'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['name'] = "Category name already exists";
        }

        $sql = "SELECT * FROM category WHERE slug='$slug'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors['slug'] = "Category slug already exists";
        }

        if (!array_filter($errors)) {

            $createdBy = $_SESSION['user']['id'];
            $sql = "INSERT INTO category (created_by,name,slug)
            VALUES ('$createdBy','$catName','$slug')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Record added successfully";
                redirect_back();
            } else {
                $_SESSION['error'] = "Record not added";
                redirect_back();
            }
        }

    }



}



if (isset($_POST['delete_category'])) {
    $id = $_POST['criteria'];
    $sql = "DELETE FROM category WHERE cid='$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Record deleted successfully";
        redirect_back();
    } else {
        $_SESSION['error'] = "Record not deleted";
        redirect_back();
    }
}

if (isset($_POST['update_category'])) {
    $id = $_POST['criteria'];
    $sql = "SELECT * FROM category WHERE cid='$id'";
    $result = mysqli_query($conn, $sql);
    $cat = mysqli_fetch_assoc($result);
    $old['name'] = $cat['name'];
    $old['slug'] = $cat['slug'];
    $old['cid'] = $cat['cid'];
    $old['btn_name'] = 'Update Category';
}


?>


<div class="container">
    <h1>Manage Category</h1>
    <?php message(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cid" value="<?=$old['cid'];?>">
        <div class="form-group">
            <label for="name">Name:
                <a style="color: red;"><?= $errors['name']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $old['name']; ?>" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="slug">Slug:
                <a style="color: red;"><?= $errors['slug']; ?></a>
            </label>
            <input type="text" value="<?= $old['slug']; ?>" class="form-control" id="slug" name="slug">
        </div>

        <div class="form-group">
            <button name="add_category" class="btn-success">
                <?= $old['btn_name']; ?>
            </button>
        </div>
    </form>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>sn</th>
                <th>Name</th>
                <th>Slug</th>
                <?php if ($role == 'admin') { ?>
                <th>Posted By</th>
                <?php } ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoryResult as $key => $cat) { ?>
            <tr>
                <td><?= ++$key; ?></td>
                <td><?= $cat['name']; ?></td>
                <td><?= $cat['slug']; ?></td>
                <?php if ($role == 'admin') { ?>
                <td><?= $cat["user_name"]; ?></td>
                <?php } ?>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="criteria" value="<?= $cat['cid']; ?>">
                        <button name="update_category">Edit</button>
                        <button name="delete_category">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>