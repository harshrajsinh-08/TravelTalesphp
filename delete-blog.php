<?php
session_start();
require 'config/db.php';

// Pehle check karte hain ki user login hai ya nahi
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

// Blog ID mila hai ya nahi check karte hain
if (!isset($_POST['blog_id'])) {
    header("Location: blogs.php?error=no_blog_id");
    exit();
}

$blogId = $_POST['blog_id'];
$userEmail = $_SESSION['user'];

// Pehle blog ka data fetch karte hain - ownership check karne ke liye
$blogId = $conn->real_escape_string($blogId);
$query = "SELECT * FROM blogs WHERE id = '$blogId'";
$result = $conn->query($query);
$blog = $result ? $result->fetch_assoc() : null;

if (!$blog) {
    header("Location: blogs.php?error=blog_not_found");
    exit();
}

// Check karte hain ki yeh blog isi user ka hai ya nahi
if ($blog['author'] !== $userEmail) {
    header("Location: blogs.php?error=not_authorized");
    exit();
}

// Agar image file hai toh usse bhi delete kar dete hain
if ($blog['image'] && strpos($blog['image'], 'uploads/') === 0) {
    if (file_exists($blog['image'])) {
        unlink($blog['image']);
    }
}

// Delete the blog from database
$userEmail = $conn->real_escape_string($userEmail);
$deleteQuery = "DELETE FROM blogs WHERE id = '$blogId' AND author = '$userEmail'";
$conn->query($deleteQuery);

// Redirect back to blogs page with success message
header("Location: blogs.php?success=blog_deleted");
exit();
?>