<?php
// Include Firebase functions
require 'firebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in Firebase
    $users = getUsers();  // You need to implement this function to get users from Firebase

    $userFound = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $userFound = true;
            break;
        }
    }

    if ($userFound) {
        // Successful login
        header("Location: main_page.php");
        exit();
    } else {
        // Login failed, redirect with an error
        header("Location: index.php?error=Invalid Username or Password");
        exit();
    }
} else {
    // Redirect to login page if the request method is not POST
    header("Location: index.php");
    exit();
}
