<?php

$sql="SELECT category.cid,category.name as category_name,users.id,users.name,
news.* FROM news
JOIN category ON category.cid=news.category_id
JOIN users ON users.id=news.created_by";
$result = mysqli_query($conn, $sql);


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
                    <a class="btn btn-success" href="">Edit</a>
                    <a class="btn btn-danger" href="">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>