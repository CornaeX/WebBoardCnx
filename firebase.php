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

function getPosts() {
    $url = FIREBASE_URL . 'posts.json?auth=' . FIREBASE_AUTH;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $posts = json_decode($response, true);
    
    if ($posts) {
        // Sort posts by timestamp
        usort($posts, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
    }

    return $posts ? $posts : [];
}

function getPost($postId) {
    $url = FIREBASE_URL . 'posts/' . $postId . '.json?auth=' . FIREBASE_AUTH;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
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

// Function to delete a specific post
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