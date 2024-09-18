<?php
session_start();
include 'firebase.php'; // Include your database connection

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    if (deletePost($postId)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error deleting the post!";
    }
} else {
    echo "Invalid request.";
}
