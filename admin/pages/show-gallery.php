<?php
// Include database connection code here

// Retrieve gallery data
$sql = "SELECT category.name AS category_name, gallery.*, category.cid
        FROM gallery
        JOIN category ON category.cid = gallery.category_id";
$result = mysqli_query($conn, $sql);

// Check if the delete button is clicked
if (isset($_GET['delete_id'])) {
    // Get the ID of the gallery item to be deleted
    $delete_id = $_GET['delete_id'];
      // Construct the delete query
    $delete_query = "DELETE FROM gallery WHERE gid='$delete_id'";

    // Execute the delete query
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        // Redirect back to the same page after deletion
        $_SESSION['success'] = "Record deleted successfully";
        redirect_back();
    } else {
        // Display error message if deletion fails
        echo "Error deleting gallery item: " . mysqli_error($conn);
    }
}
?>
<div class="container">
    <h1>Show Gallery</h1>
    <?php message(); ?>
    <table class="table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Category</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
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
                <td><?= $row['title']; ?></td>
                <td><?= $row['description']; ?></td>
                <td>
                    <img src="<?= public_url('gallery-img/' . $row['image']) ?>" alt="image" width="100">
                </td>
                <td>
                    <a class="btn btn-success" href="edit-gallery.php?id=<?= $row['id']; ?>">Edit</a>
                    <a class="btn btn-danger" href="?delete_id=<?= $row['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>