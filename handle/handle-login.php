<?php
session_start();
require_once '../inc/connection.php';

if (isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];

    // التحقق من صحة البريد الإلكتروني وكلمة المرور
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
            $storedPassword = $user['password'];

            // إذا كان الباسورد غير مشفر، نقوم بتشفيره بعد أول تسجيل دخول ناجح
            if (!password_get_info($storedPassword)['algo']) {
                if ($password === $storedPassword) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
                    mysqli_stmt_execute($updateStmt);
                    $storedPassword = $hashedPassword;
                }
            }

            if (password_verify($password, $storedPassword)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = "Welcome back!";
                header('Location: ../index.php');
                exit;
            } else {
                $_SESSION['errors'] = ["Password is incorrect."];
            }
        } else {
            $_SESSION['errors'] = ["Email not found."];
        }
    } else {
        $_SESSION['errors'] = $errors;
    }

    $_SESSION['email'] = $email;
    header('Location: ../login.php');
    exit;
} else {
    header('Location: ../login.php');
    exit;
}