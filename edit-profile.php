<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];

// Current user ka data fetch karte hain
$userEmail = $conn->real_escape_string($userEmail);
$query = "SELECT * FROM users WHERE email = '$userEmail'";
$result = $conn->query($query);
$user = $result ? $result->fetch_assoc() : null;

// Badges ko input field mein show karne ke liye prepare karte hain
$existingBadges = [];
if (!empty($user['badges'])) {
    // Comma-separated format handle karte hain
    if (strpos($user['badges'], '{') === 0) {
        // PostgreSQL style format
        $badges = trim($user['badges'], '{}');
        $existingBadges = array_map('trim', explode(',', $badges));
    } else {
        // Simple comma-separated format
        $existingBadges = array_map('trim', explode(',', $user['badges']));
    }
}
$badgesInputValue = implode(', ', $existingBadges);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $badgesInput = $_POST['badges'] ?? '';

    // Convert badges to simple comma-separated format (MySQL compatible)
    $badgesArray = array_filter(array_map('trim', explode(',', $badgesInput)));
    $badgesString = implode(',', $badgesArray);

    // Simple profile picture upload
    $profilePic = $user['profile_pic'] ?? 'default.jpg';
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $fileName = uniqid() . "_" . $_FILES['profile_pic']['name'];
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $profilePic = $targetFile;
        }
    }

    // Update user data
    $name = $conn->real_escape_string($name);
    $bio = $conn->real_escape_string($bio);
    $badgesString = $conn->real_escape_string($badgesString);
    $profilePic = $conn->real_escape_string($profilePic);
    $userEmail = $conn->real_escape_string($userEmail);
    
    $query = "UPDATE users SET name = '$name', bio = '$bio', badges = '$badgesString', profile_pic = '$profilePic' WHERE email = '$userEmail'";
    $conn->query($query);

    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profile - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: "Poppins", sans-serif; }
  </style>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm">
  <div class="container mx-auto px-4 py-4">
    <div class="flex justify-between items-center">
      
      <!-- Logo -->
      <a href="index.php" class="text-2xl font-bold text-orange-500 hover:text-orange-600 transition">
        TravelTales
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-6 font-medium">
        <a href="explore.php" class="nav-link hover:text-orange-500 transition">Explore</a>
        <a href="blogs.php" class="nav-link text-orange-500 font-semibold">Blog</a>
        <a href="trip-planner.php" class="nav-link hover:text-orange-500 transition">My Trips</a>
        <a href="profile.php" class="nav-link hover:text-orange-500 transition">Profile</a>
        <a href="about.php" class="nav-link hover:text-orange-500 transition">About</a>
        <a href="contact.php" class="nav-link hover:text-orange-500 transition">Contact</a>
      </div>

      <!-- Right Buttons -->
      <div class="hidden md:flex items-center space-x-4">
        <?php if (!empty($userEmail)): ?>
          <span class="text-sm text-gray-600"><?= htmlspecialchars($userEmail) ?></span>
          <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
            Logout
          </a>
        <?php else: ?>
          <a href="login.html" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition">
            Login
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-toggle" class="md:hidden">
        <i class="bi bi-list text-2xl"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden flex-col gap-4 px-4 py-6 mt-2 bg-white shadow-md rounded-lg">
      <a href="explore.php" class="nav-link text-gray-700">Explore</a>
      <a href="blogs.php" class="nav-link text-gray-700">Blog</a>
      <a href="trip-planner.php" class="nav-link text-gray-700">My Trips</a>
      <a href="profile.php" class="nav-link text-gray-700">Profile</a>
      <a href="about.php" class="nav-link text-gray-700">About</a>
      <a href="contact.php" class="nav-link text-gray-700">Contact</a>

      <?php if (!empty($userEmail)): ?>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition w-full text-center">
          Logout
        </a>
      <?php else: ?>
        <a href="login.html" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition w-full text-center">
          Login
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Edit Profile Form -->
<section class="container mx-auto px-4 py-32">
  <h2 class="text-3xl font-bold mb-8">Edit Profile</h2>
  <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6 max-w-xl mx-auto space-y-6">

    <!-- Profile Picture -->
    <div>
      <label class="block font-semibold mb-2">Profile Picture</label>
      <img src="<?= htmlspecialchars($user['profile_pic'] ?? 'https://via.placeholder.com/150') ?>" 
           alt="Profile Picture" class="h-24 w-24 rounded-full mb-3 object-cover border-4 border-orange-500"/>
      <input type="file" name="profile_pic" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/jpg,image/png,image/gif,image/webp" class="block w-full text-sm text-gray-600"/>
      <p class="text-xs text-gray-500 mt-1">Max 2MB. JPG, JPEG, PNG, GIF, WebP only.</p>
    </div>

    <!-- Name -->
    <div>
      <label class="block font-semibold mb-2">Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg"/>
    </div>

    <!-- Bio -->
    <div>
      <label class="block font-semibold mb-2">Bio</label>
      <textarea name="bio" rows="3" class="w-full px-4 py-2 border rounded-lg"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
    </div>

    <!-- Badges -->
    <div>
      <label class="block font-semibold mb-2">Badges (comma-separated)</label>
      <input type="text" name="badges" value="<?= htmlspecialchars($badgesInputValue) ?>" class="w-full px-4 py-2 border rounded-lg"/>
      <p class="text-xs text-gray-500 mt-1">Example: Explorer, Photographer, Foodie</p>
    </div>

    <!-- Buttons -->
    <div class="flex justify-between items-center">
      <div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
          Save Changes
        </button>
        <a href="profile.php" class="ml-4 text-gray-600 hover:underline">Back to Profile</a>
      </div>
      <a href="index.php" class="text-orange-500 hover:underline">Back to Home</a>
    </div>
  </form>
</section>

<script src="navigation.js"></script>

</body>
</html>