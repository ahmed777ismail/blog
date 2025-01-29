<!DOCTYPE html>

<?php
require_once 'inc/connection.php';
if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
}
if ($lang == 'en') {
    require_once 'inc/message-en.php';
} else {
    require_once 'inc/message-ar.php';
}
?>



<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo $message['dir']; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $message['blog']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .blog-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        text-align: center;
    }

    .featured-post {
        background: #e9ecef;
        padding: 20px;
        border-radius: 10px;
    }

    .blog-post {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        background: #fff;
    }
    </style>
</head>