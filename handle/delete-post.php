<?php
require_once '../inc/connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "select * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $image = $post['image'];
        unlink("../uploads/$image");
        $query = "DELETE FROM posts WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['success'] = "Post deleted successfully";
            header('Location: ../index.php');
        } else {
            $_SESSION['errors'] = "Failed to delete post";
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['errors'] = "No post found";
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}