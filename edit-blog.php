<?php
session_start();
require 'config/db.php';

// Pehle check karte hain ki user login hai ya nahi
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];
$blogId = $_GET['id'] ?? null;

if (!$blogId) {
    header("Location: blogs.php");
    exit();
}

// Blog ka data fetch karte hain database se
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

// Jab form submit hota hai toh yahan process karte hain
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // image upload handle kar rahe hai 
    $imagePath = $blog['image']; // existing image default hai 
    
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        
        // Create directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Get file extension
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        // Generate unique filename
        $fileName = uniqid() . '.' . $fileExtension;
        $targetFile = $targetDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Delete old image if it was a local upload
            if ($blog['image'] && strpos($blog['image'], 'uploads/') === 0 && file_exists($blog['image'])) {
                unlink($blog['image']);
            }
            $imagePath = $targetFile;
        }
    }

    // Update the blog
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $imagePath = $conn->real_escape_string($imagePath);
    $userEmail = $conn->real_escape_string($userEmail);
    
    $query = "UPDATE blogs SET title = '$title', content = '$content', image = '$imagePath' WHERE id = '$blogId' AND author = '$userEmail'";
    $conn->query($query);

    header("Location: view-blog.php?id=$blogId&success=updated");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Blog - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white p-8 rounded-2xl shadow-lg max-w-2xl w-full">
  <h2 class="text-3xl font-bold mb-6 text-center text-orange-500">✏️ Edit Blog</h2>

  <!-- Back Button -->
  <div class="mb-6 text-left">
    <a href="view-blog.php?id=<?= $blogId ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm transition">
      ← Back to Blog
    </a>
  </div>

  <form method="POST" enctype="multipart/form-data" class="space-y-5">
    <div>
      <label class="block text-gray-700 font-medium mb-2">Title</label>
      <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required
        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"/>
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-2">Content</label>
      <textarea name="content" rows="6" required
        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"><?= htmlspecialchars($blog['content']) ?></textarea>
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-2">Current Image</label>
      <?php if ($blog['image']): ?>
        <img src="<?= htmlspecialchars($blog['image']) ?>" alt="Current image" class="w-full max-w-xs h-32 object-cover rounded-lg mb-2">
      <?php else: ?>
        <p class="text-gray-500 mb-2">No image currently</p>
      <?php endif; ?>
      
      <label class="block text-gray-700 font-medium mb-2">Upload New Image (optional)</label>
      <input type="file" name="image" class="w-full text-gray-600 border p-2 rounded-lg"/>
      <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
    </div>

    <!-- Update Blog Button -->
    <button type="submit" 
      class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition">
      ✅ Update Blog
    </button>

  </form>
</div>

</body>
</html>