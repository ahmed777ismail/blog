<?php
require_once '../inc/connection.php';

if (isset($_POST['submit'])) {

    $title = htmlspecialchars(trim($_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));

    $errors = [];

    if (empty($title)) {
        $errors[] = "Title is required.";
    } else if (is_numeric($title)) {
        $errors[] = "Title must be a string.";
    }
    if (empty($body)) {
        $errors[] = "body is required.";
    } else if (is_numeric($body)) {
        $errors[] = "body must be a string.";
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
        $newName = "";
    }


    if (empty($errors)) {
        $query = "INSERT INTO posts (`title`, `body`, `image`,`user_id`) VALUES ('$title', '$body', '$newName',1)";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if ($_FILES && $_FILES['image']['name']) {
                move_uploaded_file($image_tmp_name, "../uploads/$newName");
                $_SESSION['success'] = "Post created successfully";
                header('location:../index.php');
            }
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header('location: ../create-post.php');
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        header('location: ../create-post.php');
    }
} else {
    header('Location: ../index.php');
}