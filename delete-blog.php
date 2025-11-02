<?php
session_start();
require 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

// Check if blog_id is provided
if (!isset($_POST['blog_id'])) {
    header("Location: blogs.php?error=no_blog_id");
    exit();
}

$blogId = $_POST['blog_id'];
$userEmail = $_SESSION['user'];

// First, get the blog to check ownership and get image path
$query = "SELECT * FROM blogs WHERE id = '$blogId'";
$result = $pdo->query($query);
$blog = $result->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header("Location: blogs.php?error=blog_not_found");
    exit();
}

// Check if the current user is the author of the blog
if ($blog['author'] !== $userEmail) {
    header("Location: blogs.php?error=not_authorized");
    exit();
}

// Delete the image file if it exists and is a local upload
if ($blog['image'] && strpos($blog['image'], 'uploads/') === 0) {
    if (file_exists($blog['image'])) {
        unlink($blog['image']);
    }
}

// Delete the blog from database
$deleteQuery = "DELETE FROM blogs WHERE id = '$blogId' AND author = '$userEmail'";
$pdo->query($deleteQuery);

// Redirect back to blogs page with success message
header("Location: blogs.php?success=blog_deleted");
exit();
?>