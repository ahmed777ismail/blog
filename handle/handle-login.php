<?php
session_start();
require_once '../inc/connection.php';

if (isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];


    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is invalid.";
    }


    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password should be at least 6 characters.";
    }

    if (empty($errors)) {

        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $oldPassword = $user['password'];

            if (password_verify($password, $oldPassword)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = "Welcome back!";
                header('Location: ../index.php');
                exit;
            } else {
                $_SESSION['errors'] = ["Password is incorrect."];
                header('Location: ../login.php');
                exit;
            }
        } else {
            $_SESSION['errors'] = ["Email not found."];
            header('Location: ../login.php');
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['email'] = $email;
        header('Location: ../login.php');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}
