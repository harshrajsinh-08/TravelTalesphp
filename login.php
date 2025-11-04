<?php
session_start();
require 'config/db.php';

// Pehle check karte hain ki email aur password diya hai ya nahi
if (empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: templates/login.html?error=empty");
    exit();
}

$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

// Database se user ka data fetch karte hain
$query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    
    // Password match karte hain - yahan plain text hai student project ke liye
    if ($password === $userData['password']) {
        $_SESSION['user'] = $userData['email'];
        header("Location: index.php");
        exit();
    }
}

// Agar kuch bhi galat hai toh login page pe wapas bhej do
header("Location: templates/login.html?error=invalid");
exit();
?>