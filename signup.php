<?php
require 'config/db.php';

// Validate input
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: signup.html?error=empty");
    exit();
}

// Validate email format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: signup.html?error=invalid_email");
    exit();
}

// Validate password strength
if (strlen($_POST['password']) < 6) {
    header("Location: signup.html?error=weak_password");
    exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check if user already exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    header("Location: templates/signup.html?error=exists");
    exit();
}

// Insert new user
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $password]);

header("Location: templates/login.html?signup=success");
exit();
?>