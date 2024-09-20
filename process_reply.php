<?php
session_start();
include 'firebase.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['post_id'], $_POST['reply_message'])) {
    $postId = htmlspecialchars($_POST['post_id']);
    $replyMessage = htmlspecialchars($_POST['reply_message']);
    $username = $_SESSION['username'];
    $timestamp = time();

    $replyData = [
        'username' => $username,
        'message' => $replyMessage,
        'timestamp' => $timestamp
    ];

    if (saveReply($replyData, $postId)) {
        header('Location: index.php');
    } else {
        echo "Error saving the post!";
    }
} else {
    header('Location: index.php?error=missing_data');
    exit();
}
