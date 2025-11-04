<?php
session_start();
require 'config/db.php';
// URL se blog ID fetch karte hain
$blogId = $_GET['id'] ?? null;
if (!$blogId) {
    header("Location: blogs.php");
    exit();
}

$blogId = $conn->real_escape_string($blogId);
$query = "SELECT * FROM blogs WHERE id = '$blogId'";
$result = $conn->query($query);
$blog = $result ? $result->fetch_assoc() : null;

if (!$blog) {
    header("Location: blogs.php");
    exit();
}

$userEmail = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($blog['title']) ?> - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: "Poppins", sans-serif; scroll-behavior: smooth; }
    .nav-link:hover { color: #f97316; transition: color 0.3s ease; }
  </style>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<!-- Navbar -->
<nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm">
  <div class="container mx-auto px-4 py-4">
    <div class="flex justify-between items-center">
      <div class="text-2xl font-bold text-orange-500">TravelTales</div>
      <div class="hidden md:flex space-x-6">
        <a href="explore.php" class="nav-link">Explore</a>
        <a href="blogs.php" class="nav-link text-orange-500 font-semibold">Blog</a>
        <a href="trip-planner.php" class="nav-link">My Trips</a>
        <a href="profile.php" class="nav-link">Profile</a>
        <a href="about.php" class="nav-link">About</a>
        <a href="contact.php" class="nav-link">Contact</a>
      </div>
      <div class="flex items-center space-x-4">
        <?php if ($userEmail): ?>
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
      <button id="mobile-menu-toggle" class="md:hidden"><i class="bi bi-list text-2xl"></i></button>
      <div
        id="mobile-menu"
        class="md:hidden hidden opacity-0 -translate-y-5 transition-all duration-200 ease-in-out flex flex-col gap-4 px-4 py-6 absolute top-full left-0 w-full bg-white shadow-md z-50"
      >
        <a href="explore.php" class="nav-link text-gray-700">Explore</a>
        <a href="blogs.php" class="nav-link text-orange-500 font-semibold">Blog</a>
        <a href="trip-planner.php" class="nav-link text-gray-700">My Trips</a>
        <a href="profile.php" class="nav-link text-gray-700">Profile</a>
        <a href="about.php" class="nav-link text-gray-700">About</a>
        <a href="contact.php" class="nav-link text-gray-700">Contact</a>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition w-full text-center">
          Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Blog Content -->
<main class="pt-32 container mx-auto px-4 lg:px-20">
  <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <?php if ($blog['image']): ?>
      <img src="<?= htmlspecialchars($blog['image']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>" class="w-full h-80 object-cover"/>
    <?php endif; ?>
    <div class="p-8 lg:p-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($blog['title']) ?></h1>
      <p class="text-gray-500 text-sm mb-8">
        Published on <?= date('F j, Y', strtotime($blog['created_at'])) ?> 
        by <span class="font-semibold text-gray-700"><?= htmlspecialchars($blog['author']) ?></span>
      </p>
      <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
        <?= nl2br(htmlspecialchars($blog['content'])) ?>
      </div>

      <!-- Success Message -->
      <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
        <div class="bg-green-100 text-green-700 p-4 mt-6 rounded-lg">
          ✅ Blog updated successfully!
        </div>
      <?php endif; ?>

      <!-- Action Buttons -->
      <div class="mt-10 flex flex-wrap gap-4">
        <a href="javascript:history.back()" 
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
           ← Back
        </a>
        
        <?php if ($userEmail && $blog['author'] === $userEmail): ?>
          <a href="edit-blog.php?id=<?= $blog['id'] ?>" 
             class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
             <i class="bi bi-pencil"></i> Edit Blog
          </a>
          
          <form method="POST" action="delete-blog.php" class="inline" 
                onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
            <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition">
              <i class="bi bi-trash"></i> Delete Blog
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </article>
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12 mt-16">
  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
    <div>
      <h3 class="text-xl font-bold mb-4">TravelTales</h3>
      <p class="text-gray-400">Share your journey, inspire others.</p>
    </div>
    <div>
      <h4 class="font-bold mb-4">Quick Links</h4>
      <ul class="space-y-2">
        <li><a href="about.php" class="text-gray-400 hover:text-white">About Us</a></li>
        <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-bold mb-4">Follow Us</h4>
      <div class="flex space-x-4">
        <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-twitter"></i></a>
        <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-instagram"></i></a>
      </div>
    </div>
    <div>
      <h4 class="font-bold mb-4">Newsletter</h4>
      <form class="flex flex-col space-y-2">
        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-lg text-gray-800"/>
        <button class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg transition">Subscribe</button>
      </form>
    </div>
  </div>
</footer>

</body>
</html>