<?php

$sql="SELECT category.cid,category.name as category_name,users.id,users.name,
news.* FROM news
JOIN category ON category.cid=news.category_id
JOIN users ON users.id=news.created_by";
$result = mysqli_query($conn, $sql);

// Check if the delete button is clicked
if(isset($_GET['delete_id'])) {
    // Get the ID of the news item to be deleted
    $delete_id = $_GET['delete_id'];
    
    // Construct the delete query
    $delete_query = "DELETE FROM news WHERE nid='$delete_id'";
    
    // Execute the delete query
    $delete_result = mysqli_query($conn, $delete_query);
    
    if($delete_result) {
        // Redirect back to the same page after deletion
        $_SESSION['success'] = "Record deleted successfully";
        redirect_back();
    } else {
        // Display error message if deletion fails
        echo "Error deleting news item: " . mysqli_error($conn);
    }
}


?>
<div class="container">
    <h1>Show News</h1>
    <?php message(); ?>
    <table class="table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Category</th>
                <th>Created By</th>
                <th>Title</th>
                <th>Summary</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['category_name']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['title']; ?></td>
                <td><?= $row['summary']; ?></td>
                <td>
                    <img src="<?= public_url('news/' . $row['image']) ?>" alt="image" width="100">
                </td>
                <td><?= $row['created_at']; ?></td>
                <td><?= $row['updated_at']; ?></td>
                <td>
                    <a class="btn btn-success" href="edit-news.php?id=<?= $row['nid']; ?>">Edit</a>
                    <a class="btn btn-danger" href="?delete_id=<?= $row['nid']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>