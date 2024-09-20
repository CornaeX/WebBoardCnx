<?php
define('FIREBASE_URL', 'https://entranceexam-a978d-default-rtdb.asia-southeast1.firebasedatabase.app/');
define('FIREBASE_AUTH', 'lgBwRWzTM6zV7vBGr63Zdcp5OFxdvrEgdaL2XSMn');

function savePost($data) {
    $url = FIREBASE_URL . 'posts.json?auth=' . FIREBASE_AUTH;
    
    $jsonData = json_encode($data);
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response ? true : false;
}

function saveReply($data, $id) {
  $url = FIREBASE_URL . 'posts/' . $id . '/replies.json?auth=' . FIREBASE_AUTH;

  // Initialize cURL
  $jsonData = json_encode($data);
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response ? true : false;
}

function getPosts() {
    $url = FIREBASE_URL . 'posts.json?auth=' . FIREBASE_AUTH;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return [];
    }
    curl_close($ch);
    
    $posts = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
        return [];
    }
    
    if ($posts) {
        $postsWithIds = [];
        foreach ($posts as $postId => $post) {
            $post['id'] = $postId;
            $postsWithIds[] = $post;
        }
        
        usort($postsWithIds, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
        
        return $postsWithIds;
    }

    return [];
}

function getPost($postId) {
    $url = FIREBASE_URL . 'posts/' . $postId . '.json?auth=' . FIREBASE_AUTH;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $post = json_decode($response, true);

    // Debugging output
    if ($post === null) {
        echo "Error decoding JSON: " . json_last_error_msg();
    }

    return $post;
}

function getReplies($postId) {
    $url = FIREBASE_URL . 'posts/' . $postId . '/replies.json?auth=' . FIREBASE_AUTH;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $reply = json_decode($response, true);

    return $reply;
}


function editPost($postId, $message) {
    $url = FIREBASE_URL . 'posts/' . $postId . '.json?auth=' . FIREBASE_AUTH;
    $data = json_encode(['message' => $message]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response ? true : false;
}

function deletePost($postId) {
    $url = FIREBASE_URL . 'posts/' . $postId . '.json?auth=' . FIREBASE_AUTH;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response ? true : false;
}

function getUsers() {
    $url = FIREBASE_URL . 'users.json?auth=' . FIREBASE_AUTH;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        die('Curl error: ' . $error);
    }

    curl_close($ch);
    
    $users = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('JSON decode error: ' . json_last_error_msg());
    }

    return $users ? $users : [];
}

function saveUser($data) {
    $url = FIREBASE_URL . 'users.json?auth=' . FIREBASE_AUTH;

    $jsonData = json_encode($data);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response ? true : false;
}