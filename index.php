<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

$userName = $_SESSION['username'] ?? 'Guest';
$isAdmin = $_SESSION['isAdmin'] ?? false;

include 'firebase.php';

$posts = getPosts();
$isLoggedIn = isset($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webboard by CNX</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
      <!-- Top right buttons -->
      <div class="top-right-buttons">
          <?php if (!$isLoggedIn): ?>
              <a href="login.php" class="button">Login</a>
              <a href="register.php" class="button">Register</a>
          <?php else: ?>
              <a href="logout.php" class="button logout-button">Logout</a>
          <?php endif; ?>
      </div>
      
      <h1>Welcome, <?= htmlspecialchars($userName); ?>!</h1>

      <!-- Post form (if logged in) -->
      <?php if ($isLoggedIn): ?>
          <div class="form">
              <form action="process_post.php" method="POST">
                  <textarea name="message" rows="4" placeholder="Your Message" required style="resize: none;"></textarea>
                  <button type="submit">Post Message</button>
              </form>
          </div>
      <?php endif; ?>

      <!-- Display posts -->
      <div class="posts">
          <?php if (!empty($posts)): ?>
              <?php foreach ($posts as $post): ?>
                  <?php $postId = $post['id']; ?>
                  <div class="post">
                      <h3><?= htmlspecialchars($post['name']); ?></h3>
                      <p><?= htmlspecialchars($post['message']); ?></p>
                      <small><?= date("F j, Y, g:i a", $post['timestamp']); ?></small>

                      <!-- Post actions (if author or admin) -->
                      <?php if ($userName == $post['name'] || $isAdmin): ?>
                          <div class="post-actions">
                              <a href="edit_post.php?post_id=<?= urlencode($postId); ?>">Edit</a> | 
                              <a href="delete_post.php?post_id=<?= urlencode($postId); ?>" 
                                 onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                          </div>
                      <?php endif; ?>

                      <!-- Display replies -->
                      <div class="replies">
                          <?php $replies = getReplies($postId); ?>
                          <?php if (!empty($replies)): ?>
                              <?php foreach ($replies as $reply): ?>
                                  <div class="reply">
                                      <p><strong><?= htmlspecialchars($reply['username']); ?>:</strong> <?= htmlspecialchars($reply['message']); ?></p>
                                      <small><?= date("M j, Y, g:i a", $reply['timestamp']); ?></small>
                                  </div>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <p>No replies yet.</p>
                          <?php endif; ?>
                      </div>

                      <!-- Reply form (if logged in) -->
                      <?php if ($isLoggedIn): ?>
                          <div class="reply-section">
                              <button class="reply-toggle" data-post-id="<?= $postId; ?>">Reply</button>
                              <div id="reply-form-<?= $postId; ?>" class="reply-form hidden">
                                  <form action="process_reply.php" method="POST">
                                      <input type="hidden" name="post_id" value="<?= htmlspecialchars($postId); ?>">
                                      <textarea name="reply_message" rows="3" placeholder="Your reply..." required></textarea>
                                      <button type="submit">Submit Reply</button>
                                  </form>
                              </div>
                          </div>
                      <?php endif; ?>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <p>No posts available.</p>
          <?php endif; ?>
      </div>
    </div>
</body>
</html>
