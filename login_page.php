<!DOCTYPE html>
<html>
<head>
    <title> LOGIN </title>
</head>
<body>
    <form action="login.php" method="post">
      <h2>LOGIN</h2>
      <?php if(isset($_GET['error'])) { ?>
        <p class="error"> <?php echo $_GET['error']; ?></p>
      <?php } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
