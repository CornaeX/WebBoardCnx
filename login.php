<?php
session_start();
require 'firebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = getUsers();

    $_SESSION['isAdmim'] = false;

    $userFound = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $userFound = true;
            $_SESSION['username'] = $username;
            $_SESSION['isAdmin'] = $user['isAdmin'];
            break;
        }
    }

    if ($userFound) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid Username or Password");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> LOGIN </title>
    <link rel="stylesheet" type="text/css" href="auth_style.css">
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
