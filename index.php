<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/connection.php'); ?>

<?php
$query = "SELECT id , title , created_at FROM posts";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "No posts found in the database.";
}
?>



<?php if (!empty($_SESSION['success'])) { ?>
<div class="alert alert-danger">
    <?php echo $_SESSION['success']; ?>
</div>
<?php }
unset($_SESSION['success']);
?>


<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">

            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3>All Posts</h3>
                </div>
                <div>
                    <a href="create-post.php" class="btn btn-sm btn-success">Add New Post</a>
                </div>
            </div>


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Published At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['created_at']; ?></td>
                        <td>

                            <a href="show-post.php?id=<?php echo $post['id']; ?>"
                                class="btn btn-sm btn-primary">Show</a>
                            <a href="edit-post.php?id=<?php echo $post['id']; ?>"
                                class="btn btn-sm btn-warning">Edit</a>
                            <a href="handle/delete-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>

                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>