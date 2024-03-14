<?php

$catSql = "SELECT * FROM category";
$catData = mysqli_query($conn, $catSql);


$errors = [
    'title' => '',
    'slug' => '',
    'category_id' => '',
    'summary' => '',
    'image' => '',
    'description' => '',
    'meta_title' => '',
    'meta_description' => '',

];

$old = [
    'title' => '',
    'slug' => '',
    'category_id' => '',
    'summary' => '',
    'description' => '',
    'meta_title' => '',
    'meta_description' => '',

];


if (!empty($_POST)) {

    $validationIgnoreFiles = [
        'image',
        'meta_description',
        'meta_title',
    ];

    foreach ($_POST as $key => $value) {
        if (!in_array($key, $validationIgnoreFiles)) {

            if (empty($value)) {
                $errors[$key] = 'This field is required';
            }else {
                $old[$key] = $value;
            }
        }else{
            $old[$key] = $value;
        }


    }

    $create_at = date('Y-m-d H:i:s');
    $category_id = $_POST['category_id'];

}


?>


<div class="container">
    <h1>Add News</h1>
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
            <label for="slug">Slug:
                <a style="color: red;"><?= $errors['slug']; ?></a>
            </label>
            <input type="text" value="<?= $old['slug']; ?>" class="form-control" id="slug" name="slug">
        </div>
        <div class="form-group">
            <label for="summary">Summary:
                <a style="color: red;"><?= $errors['summary']; ?></a>
            </label>
            <textarea name="summary" class="form-control" id="summary"><?= $old['summary']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description:
                <a style="color: red;"><?= $errors['description']; ?></a>
            </label>
            <textarea name="description" class="form-control" id="description"><?= $old['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:
                <a style="color: red;"><?= $errors['image']; ?></a>
            </label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="meta_title">Meta Title:
                <a style="color: red;"><?= $errors['meta_title']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $old['meta_title']; ?>" id="meta_title"
                name="meta_title">
        </div>
        <div class="form-group">
            <label for="meta_description">Meta Description:
                <a style="color: red;"><?= $errors['meta_description']; ?></a>
            </label>
            <textarea name="meta_description" class="form-control"
                id="meta_description"><?= $old['meta_description']; ?></textarea>
        </div>

        <div class="form-group">
            <button class="btn-success">
                Add News
            </button>
        </div>
    </form>


</div>