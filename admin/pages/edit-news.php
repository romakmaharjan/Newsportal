<?php
$id = $_GET['id'];
$sql = "SELECT * FROM news WHERE nid='$id'";
$result = mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($result);

$errors = [
    'title' => '',
    'summary' => '',
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

    if (!array_filter($errors)) {
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        // Update news item in the database
        $update_sql = "UPDATE news SET title='$title', summary='$summary' WHERE nid='$id'";
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
    <form action="" method="post">
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
        <!-- Add more fields for other attributes of news if needed -->
        <div class="form-group">
            <button class="btn btn-success">Update</button>
        </div>
    </form>
</div>