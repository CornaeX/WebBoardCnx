<?php
session_start();
include 'firebase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $isLoggedIn = isset($_SESSION['username']);
    if (!$isLoggedIn) {
        header('Location: login.php');
        exit(); // Ensure script execution stops after redirection
    }
    
    $name = $_SESSION['username'];
    $message = $_POST['message'];
    $timestamp = time();

    $postData = [
        'name' => $name,
        'message' => $message,
        'timestamp' => $timestamp
    ];

    if (savePost($postData)) {
        header('Location: index.php');
    } else {
        echo "Error saving the post!";
    }
} else {
    header('Location: index.php');
}
