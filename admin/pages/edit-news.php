<?php
$id = $_GET['id'];
$sql = "SELECT * FROM news WHERE nid='$id'";
$result = mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($result);

$errors = [
    'title' => '',
    'summary' => '',
    'image' => '',
    // Add more fields if needed
];

$old = [
    'title' => '',
    'summary' => '',
    // Add more fields if needed
];
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = "This field is required";
        } else {
            $old[$key] = $value;
        }
    }
     // Handle image upload
    $image = $news['image']; // Default to existing image
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = md5(uniqid()) . ".$ext";
        $tmpName = $_FILES['image']['tmp_name'];
        $uploadPath = public_path("news/$imageName");
        if (move_uploaded_file($tmpName, $uploadPath)) {
            // Delete the previous image file
            if (!empty($news['image'])) {
                unlink(public_path("news/" . $news['image']));
            }
            // Update image filename in database
            $image = $imageName;
        } else {
            $errors['image'] = "Failed to upload image";
        }
    }

    if (!array_filter($errors)) {
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        // Update news item in the database
        $update_sql = "UPDATE news SET title='$title', summary='$summary', image='$image' WHERE nid='$id'";
        $update_result = mysqli_query($conn, $update_sql);
        if ($update_result) {
            $_SESSION['success'] = "News updated successfully";
            redirect_back(); // Redirect to the same page after updating
        } else {
            $_SESSION['error'] = "Failed to update news";
            redirect_back();
        }
    }
}
?>

<div class="container">
    <h1>Update News</h1>
    <?php message(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:
                <a style="color: red;"><?= $errors['title']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $news['title']; ?>" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="summary">Summary:
                <a style="color: red;"><?= $errors['summary']; ?></a>
            </label>
            <textarea class="form-control" id="summary" name="summary"><?= $news['summary']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($news['image']) { ?>
            <p>Current Image:</p>
            <img src="<?= public_url('news/' . $news['image']); ?>" alt="Current Image">
            <?php } ?>
            <?php if ($errors['image']) { ?>
            <p style="color: red;"><?= $errors['image']; ?></p>
            <?php } ?>
        </div>
        <!-- Add more fields for other attributes of news if needed -->
        <div class="form-group">
            <button class="btn btn-success">Update</button>
        </div>
    </form>
</div>