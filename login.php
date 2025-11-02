<?php
session_start();
require 'config/db.php';

// Validate POST
if (empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: templates/login.html?error=empty");
    exit();
}

// Validate email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: templates/login.html?error=invalid_email");
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$userData = $stmt->fetch();

if ($userData && password_verify($password, $userData['password'])) {
    $_SESSION['user'] = $userData['email'];
    header("Location: index.php");
    exit();
} else {
    header("Location: templates/login.html?error=invalid");
    exit();
}
?>