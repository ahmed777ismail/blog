<?php
require_once('inc/connection.php');

if (isset($_POST['submit'])) {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $title = trim(htmlspecialchars($_POST['title']));
        $body = trim(htmlspecialchars($_POST['body']));

        $errors = [];

        if (empty($title)) {
            $errors[] = "Title is required.";
        } else if (is_numeric($title)) {
            $errors[] = "Title must be a string.";
        }
        if (empty($body)) {
            $errors[] = "Body is required.";
        } else if (is_numeric($body)) {
            $errors[] = "Body must be a string.";
        }

        $query = "SELECT * FROM posts WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $post = mysqli_fetch_assoc($result);
            $old_name = $post['image']; // تم تصحيح هذا السطر
        }

        if ($_FILES && $_FILES['image']['name']) {
            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmp_name = $image['tmp_name'];
            $image_size = $image['size'];
            $image_sizeMB = $image['size'] / (1024 * 1024);
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            $newName = uniqid() . '.' . $ext;
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            if ($image_sizeMB > 1) {
                $errors[] = "Image size should not exceed 1MB.";
            } else if (!in_array($ext, $allowed_extensions)) {
                $errors[] = "Image should be jpg, jpeg or png.";
            }
        } else {
            $newName = $old_name;
        }

        if (empty($errors)) {
            $query = "UPDATE posts SET `title` = '$title', `body` = '$body', `image` = '$newName' WHERE id = $id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if ($_FILES && $_FILES['image']['name']) {
                    move_uploaded_file($image_tmp_name, "../uploads/$newName");
                    if ($old_name) {
                        unlink("../uploads/$old_name");
                    }
                }
                header('Location: ../show_posts.php?id=' . $id);
            } else {
                $_SESSION['errors'] = "Error updating post";
                header('Location: ../edit-post.php?id=' . $id);
            }
        }
    } else {
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}
