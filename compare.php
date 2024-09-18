<?php
session_start();
include 'firebase.php'; // Include your Firebase functions

// Fetch posts
$posts = getPosts();

// Check if user is logged in
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fast Webboard</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <?php if (!isset($_SESSION['username'])): ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>

    <?php if (isset($_SESSION['username'])): ?>
      <div class="form">
        <form action="process_post.php" method="POST">
          <textarea name="message" rows="4" placeholder="Your Message" required></textarea>
          <button type="submit">Post Message</button>
        </form>
      </div>
    <?php endif; ?>

    <div class="posts">
      <?php
      if (!empty($posts)) {
        foreach ($posts as $post) {
          echo '<div class="post">';
          echo '<h3>' . htmlspecialchars($post['name']) . '</h3>';
          echo '<p>' . htmlspecialchars($post['message']) . '</p>';
          echo '<small>' . date("F j, Y, g:i a", $post['timestamp']) . '</small>';

          // Display "Edit" and "Delete" buttons if the user is the owner or an admin
          if ($userName == $post['name'] || $isAdmin) {
            $postId = $post['id']; // Get the post ID
            echo '<div class="post-actions">';
            echo '<a href="edit_post.php?post_id=' . urlencode($postId) . '">Edit</a> | ';
            echo '<a href="delete_post.php?post_id=' . urlencode($postId) . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a>';
            echo '</div>';
          }

          echo '</div>';
        }
      } else {
        echo '<p>No posts available.</p>';
      }
      ?>
    </div>
  </div>
  <?php if (isset($_SESSION['username'])): ?>
    <a href="logout.php">Logout</a>
  <?php endif; ?>
</body>
</html>
