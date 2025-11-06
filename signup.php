<?php
require 'config/db.php';

// Sabse pehle check karte hain ki saare fields bhare hain ya nahi
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: signup.html?error=empty");
    exit();
}

$name = $conn->real_escape_string(trim($_POST['name']));
$email = $conn->real_escape_string(trim($_POST['email']));
$password = $conn->real_escape_string($_POST['password']);

// Pehle check karte hain ki yeh email already registered hai ya nahi
$checkQuery = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($checkQuery);

if ($result && $result->num_rows > 0) {
    header("Location: templates/signup.html?error=exists");
    exit();
}

// Naya user database mein add karte hain
$insertQuery = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($insertQuery)) {
    header("Location: templates/login.html?signup=success");
} else {
    header("Location: templates/signup.html?error=database");
}

exit();
?>