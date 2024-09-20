<?php
session_start();
include 'firebase.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $message = isset($_POST['message']) ? $_POST['message'] : null;

    if (!$postId || !$message) {
        echo "Missing post_id or message.";
        exit();
    }

    if (editPost($postId, $message)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error updating the post!";
    }
} else {
    $postId = isset($_GET['post_id']) ? $_GET['post_id'] : null;

    $post = getPost($postId);

    if (!$post) {
        echo "Post not found!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Post</title>
  <link rel="stylesheet" type="text/css" href="edit_post.css">
</head>
<body>
  <div class="edit-post-container">
    <h1>Edit Post</h1>
    <form action="edit_post.php" method="POST">
      <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($postId); ?>">
      <textarea name="message" rows="4" required><?php echo htmlspecialchars($post['message']); ?></textarea>
      <button type="submit">Update Post</button>
    </form>
    <a href="index.php">Back to Home</a>
  </div>
</body>
</html>

