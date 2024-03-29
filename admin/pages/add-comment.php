<?php
if (!empty($_POST['comment'])) {
    $news_id = $_POST['news_id']; // Assuming you have a hidden input field in the form to store the news_id
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    // Validate comment fields
    if (empty($name) || empty($email) || empty($comment)) {
        // Handle validation errors
        $comment_errors = "All fields are required for comment submission.";
    } else {
        // Insert comment into database
        $insertCommentSql = "INSERT INTO comments (news_id, name, email, comment) 
                             VALUES ('$news_id', '$name', '$email', '$comment')";

        if (mysqli_query($conn, $insertCommentSql)) {
            $_SESSION['success'] = "Comment added successfully";
            // Redirect back to the news page or wherever you want
            header("Location: news-details.php?id=$news_id");
            exit();
        } else {
             $_SESSION['error'] = "Failed to add comment";
            // Handle database error
        }
    }
}

?>