<?php
session_start();
require 'config/db.php';

// Agar user login nahi hai toh login page pe bhej do
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html?error=login_required");
    exit();
}

// Jab form submit hota hai toh yahan process karte hain
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['user'];

    // Image upload ka simple process - zyada validation nahi hai
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $fileName = uniqid() . "_" . $_FILES['image']['name'];
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Database mein blog save karte hain - MySQLi use kar rahe hain
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $author = $conn->real_escape_string($author);
    $imagePath = $imagePath ? $conn->real_escape_string($imagePath) : 'NULL';
    
    $query = "INSERT INTO blogs (title, content, author, image, created_at) VALUES ('$title', '$content', '$author', " . ($imagePath === 'NULL' ? 'NULL' : "'$imagePath'") . ", NOW())";
    $conn->query($query);

    header("Location: blogs.php?success=posted");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Blog - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white p-8 rounded-2xl shadow-lg max-w-2xl w-full">
  <h2 class="text-3xl font-bold mb-6 text-center text-orange-500">📝 Publish a New Blog</h2>

  <!-- Back Button -->
  <div class="mb-6 text-left">
    <a href="blogs.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm transition">
      ← Back to Blogs
    </a>
  </div>

  <form method="POST" enctype="multipart/form-data" class="space-y-5">


    <div>
      <label class="block text-gray-700 font-medium mb-2">Title</label>
      <input type="text" name="title" required
        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"/>
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-2">Content</label>
      <textarea name="content" rows="6" required
        class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-2">Upload Image (optional)</label>
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/jpg,image/png,image/gif,image/webp" 
        class="w-full text-gray-600 border p-2 rounded-lg"/>
      <p class="text-sm text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF, WebP (Max 5MB)</p>
    </div>

    <!-- Publish Blog Button -->
    <button type="submit" 
      class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition">
      Publish Blog
    </button>

  </form>
</div>

</body>
</html>