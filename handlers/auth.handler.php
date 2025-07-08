<?php
ob_start();
session_start(); 

require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header('Location: /login?error=empty_fields');
        exit;
    }

    $result = Auth::login($username, $password);

    if ($result['success']) {
        header('Location: /homepage');
        exit;
    } else {
        $message = urlencode($result['message']);
        header("Location: /login?error={$message}");
        exit;
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}
