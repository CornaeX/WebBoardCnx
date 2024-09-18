<?php
session_start(); // Ensure this is at the top of the file

// Check if the user is logged in or set some default values
$userName = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$isAdmin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false;

include 'get_posts.php'; // Ensure this file returns $posts array

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
    <h1>Fast Webboard</h1>

    <div class="form">
      <form action="process_post.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <textarea name="message" rows="4" placeholder="Your Message" required></textarea>
        <button type="submit">Post Message</button>
      </form>
    </div>

    <div class="posts">
      <?php
      if (!empty($posts)) {
        foreach ($posts as $postId => $post) {
          echo '<div class="post">';
          echo '<h3>' . htmlspecialchars($post['name']) . '</h3>';
          echo '<p>' . htmlspecialchars($post['message']) . '</p>';
          echo '<small>' . date("F j, Y, g:i a", $post['timestamp']) . '</small>';

          // Display "Edit" and "Delete" buttons if the user is the owner or an admin
          echo 'user name : ' . $_SESSION['user'];
          if ($userName == $post['name'] || $isAdmin) {
            echo '<div class="post-actions">';
            echo '<a href="edit_post.php?post_id=' . $postId . '">Edit</a> | ';
            echo '<a href="delete_post.php?post_id=' . $postId . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a>';
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
</body>
</html>