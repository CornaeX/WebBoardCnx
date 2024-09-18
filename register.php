<?php
session_start();
require 'firebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $users = getUsers();  // Function to fetch users from Firebase

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            // Username already exists
            header("Location: register.php?error=Username already exists");
            exit();
        }
    }

    // Create a new user entry
    $data = [
        'username' => $username,
        'password' => $password,
        'isAdmin' => false
    ];

    if (saveUser($data)) {  // Function to save a new user to Firebase
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        header("Location: register.php?error=Registration failed. Please try again.");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        <h2>Register</h2>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <?php if(isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
