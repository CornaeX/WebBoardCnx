<?php
session_start(); // Ensure this is at the top of the file
require 'firebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in Firebase
    $users = getUsers();  // You need to implement this function to get users from Firebase

    $_SESSION['isAdmim'] = false;

    $userFound = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $userFound = true;
            $_SESSION['username'] = $username; // Store the username in the session
            // $_SESSION['isAdmin'] = isset($user['isAdmin']) && $user['isAdmin'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            break;
        }
    }

    if ($userFound) {
        // Successful login
        header("Location: index.php");
        exit();
    } else {
        // Login failed, redirect with an error
        header("Location: login.php?error=Invalid Username or Password");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> LOGIN </title>
</head>
<body>
    <form action="login.php" method="post">
      <h2>LOGIN</h2>
      <?php if(isset($_GET['error'])) { ?>
        <p class="error"> <?php echo ($_GET['error']); ?></p>
      <?php } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
