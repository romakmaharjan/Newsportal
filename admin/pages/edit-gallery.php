<?php
// Include database connection code here

// Fetch gallery ID from URL
$id = $_GET['id'];

// Retrieve gallery data
$sql = "SELECT * FROM gallery WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$gallery = mysqli_fetch_assoc($result);

$errors = [
    'title' => '',
    'image' => '',
    // Add more fields if needed
];
$old = [
    'title' => '',
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
    $image = $gallery['image']; // Default to existing image
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = md5(uniqid()) . ".$ext";
        $tmpName = $_FILES['image']['tmp_name'];
        $uploadPath = public_path("gallery-img/$imageName");
        if (move_uploaded_file($tmpName, $uploadPath)) {
            // Delete the previous image file
            if (!empty($gallery['image'])) {
                unlink(public_path("gallery-img/" . $gallery['image']));
            }
            // Update image filename in database
            $image = $imageName;
        } else {
            $errors['image'] = "Failed to upload image";
        }
    }

     if (!array_filter($errors)) {
        $title = $_POST['title'];

        // Update gallery item in the database
        $update_sql = "UPDATE gallery SET title='$title', image='$image' WHERE id='$id'";
        $update_result = mysqli_query($conn, $update_sql);
        if ($update_result) {
            $_SESSION['success'] = "Gallery updated successfully";
            redirect_back(); // Redirect to the same page after updating
        } else {
            $_SESSION['error'] = "Failed to update gallery";
            redirect_back();
        }
    }
}
?>

<div class="container">
    <h1>Update Gallery</h1>
    <?php message(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:
                <a style="color: red;"><?= $errors['title']; ?></a>
            </label>
            <input type="text" class="form-control" value="<?= $gallery['title']; ?>" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($gallery['image']) { ?>
            <p>Current Image:</p>
            <img src="<?= public_url('gallery-img/' . $gallery['image']); ?>" alt="Current Image">
            <?php } ?>
            <?php if ($errors['image']) { ?>
            <p style="color: red;"><?= $errors['image']; ?></p>
            <?php } ?>
        </div>
        <!-- Add more fields for other attributes of gallery if needed -->
        <div class="form-group">
            <button class="btn btn-success">Update</button>
        </div>
    </form>
</div>